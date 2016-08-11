<?php


	class content extends FGTA_Content
	{

		public $FIELD_ID = "obj_txt_CONTENT_ID";
		public $FIELD_ID_MAPPING = "CONTENT_ID";
		public $FIELD_ID_ISAUTO = true;


		public function LoadPage() {
			global $_GET;

			$this->Scripts->load("content.js");

			$this->dgvList = new FGTA_Control_Datagrid([
				'name' => 'dgvList',
				'columnid'=> $this->FIELD_ID_MAPPING,
				'options'=> '
					pagination:true
				',
				'columns' => [
					['label'=>'ID', 'mapping'=>'CONTENT_ID', 'options'=>'width:100,hidden:true'],
					['label'=>'Title', 'mapping'=>'CONTENT_TITLE', 'options'=>'width:400'],
					['label'=>'Type', 'mapping'=>'CONTENTTYPE_ID', 'options'=>'width:100'],
					['label'=>'Publish', 'mapping'=>'CONTENT_PUBLISHDATE', 'options'=>'width:100'],
				]
			]);


			$this->Search = array(
				new FGTA_Control_TextboxSearch(['name'=>':CONTENT_TITLE', 'label'=>'Title', 'checkbox'=>'src_chk_CONTENT_TITLE', 'textbox'=>'src_txt_CONTENT_TITLE' ])
			);


			$this->Editor = array(
				new FGTA_Control_Textbox(['name'=>'obj_txt_CONTENT_ID', 'label'=>'ID',  'options'=>"" ]),
				new FGTA_Control_Datebox(['name'=>'obj_dt_CONTENT_PUBLISHDATE', 'label'=>'Publish',  'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_CONTENT_TITLE', 'label'=>'Title',  'maxlength'=>'60', 'options'=>"required:true,missingMessage:'Title harus diisi'" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_CONTENT_TEXT', 'label'=>'text',  'maxlength'=>'65535', 'suppress'=>true, 'options'=>"" ]),
				new FGTA_Control_Combobox(['name'=>'obj_txt_CONTENTTYPE_ID', 'label'=>'Type',  'options'=>"editable:false,valueField:'id',textField:'text',data:DATA['CONTENTTYPE']" ]),
				new FGTA_Control_File(['name'=>'obj_txt_CONTENT_FILE', 'label'=>'File',  'options'=>"" ]),
			);

		}




		public function ListData($pageNumber, $pageSize, $param) {

			$CONDS = FGTA_SqlUtil::GetWhereCondition(array(
				":CONTENT_TITLE" => ["CONTENT_TITLE LIKE  '%%' || %s || '%%'"]
			), $param);

			$WHERE_STMT     = $CONDS["SQL"];
			$SQL_PARAMVALUE = $CONDS["VALUE"];

			$sql = "SELECT COUNT(*) AS N FROM FGT_CONTENT $WHERE_STMT " ;
			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$row  = $stmt->fetch(PDO::FETCH_ASSOC);
			$total = (float) $row['N'];

			$offset = ($pageSize * ($pageNumber-1));

			$sql = "SELECT FIRST $pageSize SKIP $offset
					CONTENT_ID, CONTENT_PUBLISHDATE, CONTENT_TITLE, CONTENT_TEXT, CONTENTTYPE_ID
			        FROM FGT_CONTENT
					$WHERE_STMT
					";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$records = array();
			foreach ($rows as $row)
			{
				$records[] = array(
						'CONTENT_ID' => $row['CONTENT_ID'],
						'CONTENT_PUBLISHDATE' => FGTA_SqlUtil::ToJSDate($row['CONTENT_PUBLISHDATE']),
						'CONTENT_TITLE' => $row['CONTENT_TITLE'],
						'CONTENT_TEXT' => $row['CONTENT_TEXT'],
						'CONTENTTYPE_ID' => $row['CONTENTTYPE_ID']
				);
			}

			$obj = new stdClass;
			$obj->total = $total;
			$obj->records = $records;

			return $obj;
		}


		public function OpenData($id) {
			$obj = $this->OpenData_Header($id);
			$obj->DETIL = array(

			);

			return $obj;
		}

		public function OpenData_Header($id) {
			$sql = "SELECT
					CONTENT_ID, CONTENT_PUBLISHDATE, CONTENT_TITLE, CONTENT_TEXT, CONTENT_FILE, CONTENTTYPE_ID
					,\"_CREATEBY\", \"_CREATEDATE\", \"_MODIFYBY\", \"_MODIFYDATE\", \"_ROWID\"
			        FROM FGT_CONTENT WHERE CONTENT_ID = :CONTENT_ID ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(
							':CONTENT_ID' => $id
					));

			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($rows)==0)
				return null;

		 	$row = $rows[0];

			$obj = new stdClass;
			$obj->CONTENT_ID = $row['CONTENT_ID'];
			$obj->CONTENT_PUBLISHDATE = FGTA_SqlUtil::ToJSDate($row['CONTENT_PUBLISHDATE']);
			$obj->CONTENT_TITLE = $row['CONTENT_TITLE'];
			$obj->CONTENT_TEXT = $row['CONTENT_TEXT'];
			$obj->CONTENT_FILE = $row['CONTENT_FILE'];
			$obj->CONTENTTYPE_ID = $row['CONTENTTYPE_ID'];
			$obj->CONTENTTYPE_NAME = array('ARTICLE'=>'Article','EVENT'=>'Event','NEWS'=>'News')[$obj->CONTENTTYPE_ID];

			$obj->_recordcreateby = $row["_CREATEBY"];
			$obj->_recordcreatedate = $row["_CREATEDATE"];
			$obj->_recordmodifyby = $row["_MODIFYBY"];
			$obj->_recordmodifydate = $row["_MODIFYDATE"];
			$obj->_recordrowid = $row["_ROWID"];

			return $obj;
		}





		public function NewId($H) {
			return uniqid();
		}

		public function Save($H, $D) {
			$db = $this->db;
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
			$db->beginTransaction();

			try {
				$id = $this->Save_Header($H);


				$db->commit();
				$db->setAttribute(PDO::ATTR_AUTOCOMMIT,1);

				$obj = $this->OpenData_Header($id);
				if ($obj==null)
					throw new Exception('Data not saved correctly.');

				return $obj;
			} catch (Exception $e) {
				$db->rollBack();
				throw new Exception('Error in Saving Data.\r\n' . $e->getMessage());
			}
		}

		public function Save_Header($H) {
			$TABLE = "FGT_CONTENT";

			$obj = new stdClass;
			$obj->CONTENT_PUBLISHDATE = FGTA_SqlUtil::ToSQLDate($H['CONTENT_PUBLISHDATE']);
			$obj->CONTENT_TITLE = $H['CONTENT_TITLE'];
			$obj->CONTENT_FILE = $H['CONTENT_FILE'];
			$obj->CONTENTTYPE_ID = $H['CONTENTTYPE_ID'];


			$__STATE = $H['__STATE'];
			if ($__STATE=='insert') {
				$id = ($this->FIELD_ID_ISAUTO) ? $this->NewId($H) : $H[$this->FIELD_ID_MAPPING];
				$obj->{$this->FIELD_ID_MAPPING} = $id;
				$obj->_CREATEBY = $_SESSION['username'];
				$obj->_CREATEDATE = date("Y-m-d H:i:s");
				$obj->_ROWID = FGTA_SqlUtil::CreateGUID();
				$cmd = FGTA_SqlUtil::CreateSQLInsert($TABLE, $obj);
			} else if ($__STATE=='update' || $__STATE=='nochange') {
				$id = $H[$this->FIELD_ID_MAPPING];
				$key = new stdClass;
				$key->{$this->FIELD_ID_MAPPING} = $id;
				$obj = ($__STATE=='update') ? $obj : new stdClass;
				$obj->_MODIFYBY = $_SESSION['username'];
				$obj->_MODIFYDATE = date("Y-m-d H:i:s");
				$cmd = FGTA_SqlUtil::CreateSQLUpdate($TABLE, $obj, $key);
			}

			FGTA_SqlUtil::PDO_Update($this->db, $cmd);

			$sql = "UPDATE FGT_CONTENT SET CONTENT_TEXT=:CONTENT_TEXT WHERE CONTENT_ID='$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':CONTENT_TEXT', $H['CONTENT_TEXT'], PDO::PARAM_LOB);
			$stmt->execute();

			return $id;
		}




		public function Delete($id) {
			$db = $this->db;
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
			$db->beginTransaction();

			try {

				$TBL = ['FGT_CONTENT'];
				foreach ($TBL as $TABLE) {
					$key = new stdClass;
					$key->{$this->FIELD_ID_MAPPING} = $id;
					$cmd = FGTA_SqlUtil::CreateSQLDelete($TABLE, $key);
					FGTA_SqlUtil::PDO_Update($this->db, $cmd);
				}

				$db->commit();
				$db->setAttribute(PDO::ATTR_AUTOCOMMIT,1);

				return true;
			} catch (Exception $e) {
				$db->rollBack();
				throw new Exception('Error in Deleting Data.\r\n' . $e->getMessage());
			}
		}


	}
