<?php
if (!defined('__OPENFGTA__'))
	die('Cannot access file directly');



class FGTA_SqlUtil
{

	public static $ObjectQuoteStart = '"';
	public static $ObjectQuoteEnd = '"';


	static function CreateSQLInsert($tablename, $obj) {
		if (!is_object($obj))
			throw new Exception("Parameter salah.");

		foreach ($obj as $name=>$value)
		{
			if (substr($name, 0, 1 )=="_")
				$fields[] = FGTA_SqlUtil::$ObjectQuoteStart . $name . FGTA_SqlUtil::$ObjectQuoteEnd;
			else
				$fields[] = $name;

			$values[] = ":" . $name;
			$params[":" . $name] = $value;
		}

		$stringfields = implode(", ", $fields);
		$stringvalues = implode(", ", $values);

		$sql  = " INSERT INTO $tablename \n";
		$sql .= " (" . $stringfields .") \n";
		$sql .= " VALUES \n";
		$sql .= " (" . $stringvalues .") \n";

		$ret = new stdClass;
		$ret->SQL    = $sql;
		$ret->Params = $params;

		return $ret;

	}


	static function CreateSQLUpdate($tablename, $obj, $key) {
		if (!is_object($obj))
			throw new Exception("Parameter object salah.");

		if (!is_object($key))
			throw new Exception("Parameter key salah.");

		$keyscount = 0;
		foreach ($key as $name=>$value)
		{
			if (substr($name, 0, 1 )=="_")
				$keys[] = FGTA_SqlUtil::$ObjectQuoteStart . $name . FGTA_SqlUtil::$ObjectQuoteEnd . ' = :' . $name;
			else
				$keys[] = $name . ' = :' . $name;

			$params[":" . $name] = $value;
			$keyscount++;
		}

		if ($keyscount == 0)
			throw new Exception("Parameter keys kosong, atau belum didefinisikan.");



		foreach ($obj as $name=>$value)
		{
			if (substr($name, 0, 1 )=="_")
				$updates[] = FGTA_SqlUtil::$ObjectQuoteStart . $name . FGTA_SqlUtil::$ObjectQuoteEnd . ' = :' . $name;
			else
				$updates[] = $name . ' = :' . $name;


			if (array_key_exists(":" . $name, $params))
				throw new Exception("Field '$name' sudah didefinisikan di keys, tidak bisa diset untuk diupdate.");

			$params[":" . $name] = $value;
		}

		$stringupdates = implode(",\n",  $updates);
		$stringkeys    = implode(" AND ", $keys);

		$sql  = "UPDATE $tablename \n";
		$sql .= "SET \n";
		$sql .= $stringupdates ."\n";
		$sql .= "WHERE \n";
		$sql .= $stringkeys;


		$ret = new stdClass;
		$ret->SQL    = $sql;
		$ret->Params = $params;

		return $ret;
	}

	static function CreateSQLDelete($tablename, $key) {
		if (!is_object($key))
			throw new Exception("Parameter key salah.");

		$keyscount = 0;
		foreach ($key as $name=>$value)
		{
			if (substr($name, 0, 1 )=="_")
				$keys[] = FGTA_SqlUtil::$ObjectQuoteStart . $name . FGTA_SqlUtil::$ObjectQuoteEnd . ' = :' . $name;
			else
				$keys[] = $name . ' = :' . $name;

			$params[":" . $name] = $value;
			$keyscount++;
		}

		if ($keyscount == 0)
			throw new Exception("Parameter keys kosong, atau belum didefinisikan.");



		$stringkeys    = implode(" AND ", $keys);

		$sql  = "DELETE FROM $tablename \n";
		$sql .= "WHERE \n";
		$sql .= $stringkeys;


		$ret = new stdClass;
		$ret->SQL    = $sql;
		$ret->Params = $params;

		return $ret;
	}



	static function PDO_Update($db, $cmd, &$stmt=null)
	{
		if ($stmt==null)
			$stmt = $db->prepare($cmd->SQL);


		//$stmt->execute($cmd->Params);
		while (list($key, $val) = each($cmd->Params)) {
			if (is_null($val)) {
				$stmt->bindValue($key, null, PDO::PARAM_NULL);
			} else {
				$stmt->bindValue($key, $val);
			}
		}
		$stmt->execute();


		return $stmt;
	}


	static function GetWhereCondition($CONDDATA, $param) {

		$SQL_PARAM = array();
		$SQL_PARAMVALUE = array();




		if (is_array($param)) {
			foreach ($param as $p) {
				if ($p['Checked']=='false') continue;

				$name = $p['Name'];
				$value = $p['Value'];

				if (!is_array($CONDDATA[$name])) {
					if (trim($CONDDATA[$name])=="") continue;
					$SQL_PARAM[] = "(" . sprintf($CONDDATA[$name], $name) . ")";
					$SQL_PARAMVALUE[$name] = $value;
				}  else {
					if (count($CONDDATA[$name])==0) continue;
					$i = 1;
					$SQL_PARAM_INNER = array();
					foreach ($CONDDATA[$name] as $cond) {
						$newname = $name . "_" . $i;
						$SQL_PARAM_INNER[] = sprintf($cond, $newname);
						$SQL_PARAMVALUE[$newname] = $value;
						$i++;
					}
					$SQL_PARAM[] = "(". implode(" OR ",  $SQL_PARAM_INNER)  .")";
				}
			}
		}



		$WHERE_STMT =  (count($SQL_PARAM) > 0) ? " WHERE " . implode(" AND ", $SQL_PARAM) : "";


		//echo $WHERE_STMT;

		return [
			"SQL" => $WHERE_STMT,
			"VALUE" => $SQL_PARAMVALUE,
		];
	}


	static function CreateGUID() {
		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}


	static function ToSQLDate($jsdate) {
		//js date: dd/mm/yyyy
		if (strlen($jsdate)<10)
			die("JS Date '$jsdate' Error . [SqlUtil::ToSQLDate]");

		$token = explode("/", substr($jsdate,0,10));
		if (count($token)!=3)
		 	die("JS Date '$jsdate' Error . [SqlUtil::ToSQLDate]");

		return $token[2] . "-" . $token[1] . "-" . $token[0];

	}


	static function ToJSDate($sqldate) {
		if ($sqldate==null)
			return null;


		if (strlen($sqldate)<10)
			die("SQL Date '$sqldate' Error . [SqlUtil::ToJSDate]");

		$token = explode("-", substr($sqldate,0,10));
		if (count($token)!=3)
		 	die("SQL Date '$sqldate' Error . [SqlUtil::ToJSDate]");
		return $token[2] . "/" . $token[1] . "/" . $token[0];
	}

	static function RowUpdateDeleted($db, $TABLE, $data, $id, $idmapping) {
		foreach ($data as $row) {
			$__STATE = $row['__STATE'];
			if ($__STATE=="delete") {
				$key = new stdClass;
				$key->{$idmapping} = $id;
				$key->_LINE =  $row['_LINE'];
				$cmd = FGTA_SqlUtil::CreateSQLDelete($TABLE, $key);
				FGTA_SqlUtil::PDO_Update($db, $cmd);
			}
		}
	}


}

?>
