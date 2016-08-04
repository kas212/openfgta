<?php

	require_once "fgta/FGTA_DialogMember.inc.php";

	class user extends FGTA_Content
	{

		public $FIELD_ID = "obj_txt_USER_ID";
		public $FIELD_ID_MAPPING = "USER_ID";
		public $FIELD_ID_ISAUTO = false;


		public function LoadPage()
		{
			global $_GET;

			$this->Scripts->load("user.js");

			$this->dgvList = new FGTA_Control_Datagrid([
				'name' => 'dgvList',
				'columnid'=> $this->FIELD_ID_MAPPING,
				'options'=> '
					pagination:true
				',
				'columns' => [
					['label'=>'ID', 'mapping'=>'USER_ID', 'options'=>'width:100'],
					['label'=>'Name', 'mapping'=>'USER_NAME', 'options'=>'width:300'],
					['label'=>'Email', 'mapping'=>'USER_EMAIL', 'options'=>'width:200'],
					['label'=>'Dis', 'mapping'=>'USER_ISDISABLED', 'options'=>'width:30']
				]
			]);


			$this->Search = array(
				new FGTA_Control_TextboxSearch(['name'=>':SEARCH', 'label'=>'Search', 'checkbox'=>'src_chk_SEARCH', 'textbox'=>'src_txt_SEARCH', 'location'=>[10,0,200] ])
			);


			$this->Editor = array(
				new FGTA_Control_Textbox(['name'=>'obj_txt_USER_ID', 'label'=>'ID',  'maxlength'=>'30', 'options'=>"required:true,validType:['USER_ID','length[3,30]'],missingMessage:'ID harus diisi'" ]),
				new FGTA_Control_Checkbox(['name'=>'obj_chk_USER_ISDISABLED', 'label'=>'Disabled' ]),
				new FGTA_Control_Checkbox(['name'=>'obj_chk_USER_ISSYSTEM', 'label'=>'System' ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_USER_NAME', 'label'=>'Name', 'maxlength'=>'90', 'options'=>"required:true,validType:{length:[3,90]},missingMessage:'NAMA harus diisi'" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_USER_EMAIL', 'label'=>'Email', 'maxlength'=>'90', 'options'=>"required:true,validType:['email','length[5,90]'],missingMessage:'EMAIL harus diisi'" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_PASWORD', 'label'=>'New.Pwd',  'maxlength'=>'90', 'options'=>"type:'password'" ]),


				new FGTA_Control_Datagrid(['name'=>'dgv_GROUP', 'label'=>'Group',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_GROUP_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_GROUP, index) }
								',
					'columns' => [
						['label'=>'ID', 'mapping'=>'GROUP_ID', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: true}}"],
						['label'=>'Group', 'mapping'=>'GROUP_NAME', 'options'=>"width:300, editor:{type:'textbox', options:{readonly: true}}"],
						['label'=>'Sys', 'mapping'=>'GROUP_ISSYSTEM', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: true}}"],
						['label'=>'Dis', 'mapping'=>'GROUP_ISDISABLED', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: true}}"],
						['label'=>'Sp', 'mapping'=>'GROUP_ISSUSPEND', 'options'=>"width:30, editor:{type:'checkbox', options:{readonly: false, on:'1',off:'0'}}"],
					],
					'dialog' => new FGTA_DialogMember('Select Group', [
						['label'=>'ID', 'mapping'=>'GROUP_ID', 'return'=>'row.GROUP_ID', 'width'=>80],
						['label'=>'GROUP', 'mapping'=>'GROUP_NAME', 'return'=>'row.GROUP_NAME', 'width'=>300],
						['label'=>'ISSYSTEM', 'mapping'=>'GROUP_ISSYSTEM', 'return'=>'0', 'width'=>30],
						['label'=>'ISDISABLED', 'mapping'=>'GROUP_ISDISABLED', 'return'=>'0', 'width'=>30],
						['label'=>'ISSUSPEND', 'mapping'=>'GROUP_ISSUSPEND', 'return'=>'0', 'width'=>30],
					], 'GROUP_ID', "FGTA_ServiceUrl(ui.NS,'group','ListData')"),
				]),


			);

		}


		public function ListData($pageNumber, $pageSize, $param) {

			$CONDS = FGTA_SqlUtil::GetWhereCondition(array(
				":SEARCH" => ["USER_ID=%s","USER_ID LIKE  '%%' || %s || '%%'"]
			), $param);

			$WHERE_STMT     = $CONDS["SQL"];
			$SQL_PARAMVALUE = $CONDS["VALUE"];

			$sql = "SELECT COUNT(*) AS N FROM FGT_USER $WHERE_STMT " ;
			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$row  = $stmt->fetch(PDO::FETCH_ASSOC);
			$total = (float) $row['N'];

			$offset = ($pageSize * ($pageNumber-1));

			$sql = "SELECT FIRST $pageSize SKIP $offset
					USER_ID, USER_NAME, USER_EMAIL, USER_ISDISABLED
			        FROM FGT_USER
					$WHERE_STMT
					";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$records = array();
			foreach ($rows as $row)
			{
				$records[] = array(
						'USER_ID' => $row['USER_ID'],
						'USER_NAME' => $row['USER_NAME'],
						'USER_EMAIL' => $row['USER_EMAIL'],
						'USER_ISDISABLED' => $row['USER_ISDISABLED']
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
				'GROUP' => $this->OpenData_DetilGROUP($id)
			);

			return $obj;
		}

		public function OpenData_Header($id) {
			$sql = "SELECT
					USER_ID, USER_NAME, USER_EMAIL, USER_ISDISABLED, USER_ISSYSTEM
					,\"_CREATEBY\", \"_CREATEDATE\", \"_MODIFYBY\", \"_MODIFYDATE\", \"_ROWID\"
			        FROM FGT_USER WHERE USER_ID = :USER_ID ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(
							':USER_ID' => $id
					));

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$obj = new stdClass;
			$obj->USER_ID = $row['USER_ID'];
			$obj->USER_NAME = $row['USER_NAME'];
			$obj->USER_EMAIL = $row['USER_EMAIL'];
			$obj->USER_ISDISABLED = $row['USER_ISDISABLED'];
			$obj->USER_ISSYSTEM = $row['USER_ISSYSTEM'];

			$obj->_recordcreateby = $row["_CREATEBY"];
			$obj->_recordcreatedate = $row["_CREATEDATE"];
			$obj->_recordmodifyby = $row["_MODIFYBY"];
			$obj->_recordmodifydate = $row["_MODIFYDATE"];
			$obj->_recordrowid = $row["_ROWID"];

			return $obj;
		}



		public function OpenData_DetilGROUP($id) {

			$sql = "
				SELECT
					B.GROUP_ID, B.GROUP_NAME,
					B.GROUP_ISDISABLED AS GROUP_ISDISABLED,
					A.GROUPUSER_ISDISABLED AS GROUP_ISSUSPEND,
					A.GROUPUSER_ISSYSTEM AS GROUP_ISSYSTEM
				FROM FGT_GROUPUSER A INNER JOIN FGT_GROUP B
					ON A.GROUP_ID=B.GROUP_ID
				WHERE A.USER_ID = :USER_ID
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':USER_ID'=>$id));
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$records = array();
			$line = 0;
			foreach ($rows as $row)
			{
				$line++;
				$records[] = array(
						'_LINE' => $line,
						'GROUP_ID' => $row['GROUP_ID'],
						'GROUP_NAME' => $row['GROUP_NAME'],
						'GROUP_ISDISABLED' => $row['GROUP_ISDISABLED'],
						'GROUP_ISSUSPEND' => $row['GROUP_ISSUSPEND'],
						'GROUP_ISSYSTEM' => $row['GROUP_ISSYSTEM'],
				);
			}

			return ['records'=>$records, 'maxline'=>$line];

		}




		public function NewId($H) {
			return "testid";
		}

		public function Save($H, $D) {

			$db = $this->db;
			$db->beginTransaction();

			try {

				if (strtoupper($H[$this->FIELD_ID_MAPPING]) == strtoupper( __ROOT_USER))
					throw new Exception("UserId '". $H[$this->FIELD_ID_MAPPING]. "' tidak boleh digunakan!\r\n(System reserved)");

				$id = $this->Save_Header($H);
				$this->Save_DetilGROUP($id, $D['GROUP']);

				$db->commit();

				return $this->OpenData_Header($id);
			} catch (Exception $e) {
				$db->rollBack();
				throw new Exception('Error in Saving Data.\r\n' . $e->getMessage());
			}
		}

		public function Save_Header($H) {
			$TABLE = "FGT_USER";

			$obj = new stdClass;
			$obj->USER_NAME = $H['USER_NAME'];
			$obj->USER_EMAIL = $H['USER_EMAIL'];
			$obj->USER_ISDISABLED = $H['USER_ISDISABLED'];
			$obj->USER_ISSYSTEM = $H['USER_ISSYSTEM'];

			if ($H['USER_PASSWORD'] != '')
				$obj->USER_PASSWORD = md5($H['USER_PASSWORD']);


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


			return $id;
		}


		public function Save_DetilGROUP($id, $d) {
			$TABLE = "FGT_GROUPUSER";
			if (is_array($d))
			foreach ($d as $row) {
				$obj = new stdClass;
				$obj->GROUPUSER_ISDISABLED = $row['GROUP_ISSUSPEND'];

				$__STATE = $row['__STATE'];
				if ($__STATE=="insert" || $__STATE=="update") {
					$sql = "SELECT * FROM FGT_GROUPUSER WHERE GROUP_ID=:GROUP_ID AND USER_ID=:USER_ID";
					$stmt = $this->db->prepare($sql);
					$stmt->execute(array(':GROUP_ID'=> $row['GROUP_ID'], ':USER_ID'=>$id));
					$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if (count($rows)>0) {
						// update
						$key = new stdClass;
						$key->{$this->FIELD_ID_MAPPING} = $id;
						$key->GROUP_ID = $row['GROUP_ID'];
						$cmd = FGTA_SqlUtil::CreateSQLUpdate($TABLE, $obj, $key);
					} else {
						// insert
						$obj->{$this->FIELD_ID_MAPPING} = $id;
						$obj->GROUP_ID = $row['GROUP_ID'];
						$cmd = FGTA_SqlUtil::CreateSQLInsert($TABLE, $obj);
					}
				} else if ($__STATE=="delete") {
					$key = new stdClass;
					$key->{$this->FIELD_ID_MAPPING} = $id;
					$key->GROUP_ID = $row['GROUP_ID'];
					$cmd = FGTA_SqlUtil::CreateSQLDelete($TABLE, $key);
				}

				FGTA_SqlUtil::PDO_Update($this->db, $cmd);
			}

		}



		public function Delete($id) {
			$db = $this->db;
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
			$db->beginTransaction();

			try {

				$TBL = ['FGT_USER'];
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
