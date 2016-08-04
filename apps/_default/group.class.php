<?php

	require_once "fgta/FGTA_DialogMember.inc.php";


	class group extends FGTA_Content
	{

		public $FIELD_ID = "obj_txt_GROUP_ID";
		public $FIELD_ID_MAPPING = "GROUP_ID";
		public $FIELD_ID_ISAUTO = false;


		public function LoadPage()
		{
			global $_GET;

			$this->Scripts->load("group.js");

			$this->dgvList = new FGTA_Control_Datagrid([
				'name' => 'dgvList',
				'columnid'=> $this->FIELD_ID_MAPPING,
				'options'=> '
					pagination:true
				',
				'columns' => [
					['label'=>'ID', 'mapping'=>'GROUP_ID', 'options'=>'width:100'],
					['label'=>'Group Name', 'mapping'=>'GROUP_NAME', 'options'=>'width:300'],
					['label'=>'Description', 'mapping'=>'GROUP_DESCRIPTION', 'options'=>'width:200'],
					['label'=>'Dis', 'mapping'=>'GROUP_ISDISABLED', 'options'=>'width:30']
				]
			]);


			$this->Search = array(
				new FGTA_Control_TextboxSearch(['name'=>':SEARCH', 'label'=>'Search', 'checkbox'=>'src_chk_SEARCH', 'textbox'=>'src_txt_SEARCH', 'location'=>[10,0,200] ])
			);


			$this->Editor = array(
				new FGTA_Control_Textbox(['name'=>'obj_txt_GROUP_ID', 'label'=>'ID',  'maxlength'=>'30', 'options'=>"required:true,validType:['FGTA_ID','length[3,30]'],missingMessage:'ID harus diisi'" ]),
				new FGTA_Control_Checkbox(['name'=>'obj_chk_GROUP_ISDISABLED', 'label'=>'Disabled' ]),
				new FGTA_Control_Checkbox(['name'=>'obj_chk_GROUP_ISSYSTEM', 'label'=>'System' ]),

				new FGTA_Control_Textbox(['name'=>'obj_txt_GROUP_NAME', 'label'=>'NAME',  'maxlength'=>'60', 'options'=>"required:true,validType:{length:[3,60]},missingMessage:'NAMA harus diisi'" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_GROUP_DESCRIPTION', 'label'=>'DESCR', 'maxlength'=>'255', 'options'=>"" ]),


				new FGTA_Control_Datagrid(['name'=>'dgv_USER', 'label'=>'USER',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_USER_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_USER, index) }
								',
					'columns' => [
						['label'=>'ID', 'mapping'=>'USER_ID', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'User', 'mapping'=>'USER_NAME', 'options'=>"width:300, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Sys', 'mapping'=>'USER_ISSYSTEM', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Dis', 'mapping'=>'USER_ISDISABLED', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Sp', 'mapping'=>'USER_ISSUSPEND', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: false}}"]
					],
					'dialog' => new FGTA_DialogMember('Select User', [
						['label'=>'ID', 'mapping'=>'USER_ID', 'return'=>'row.USER_ID', 'width'=>80],
						['label'=>'USER', 'mapping'=>'USER_NAME', 'return'=>'row.USER_NAME', 'width'=>300],
						['label'=>'ISSYSTEM', 'mapping'=>'USER_ISSYSTEM', 'return'=>'0', 'width'=>30],
						['label'=>'ISDISABLED', 'mapping'=>'USER_ISDISABLED', 'return'=>'0', 'width'=>30],
						['label'=>'ISSUSPEND', 'mapping'=>'USER_ISSUSPEND', 'return'=>'0', 'width'=>30],
					], 'USER_ID', "FGTA_ServiceUrl(ui.NS,'user','ListData')"),
				]),


				new FGTA_Control_Datagrid(['name'=>'dgv_PROGRAM', 'label'=>'PROGRAM',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_PROGRAM_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_PROGRAM, index) }
								',
					'columns' => [
						['label'=>'ID', 'mapping'=>'PROGRAM_ID', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Program', 'mapping'=>'PROGRAM_NAME', 'options'=>"width:300, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Sys', 'mapping'=>'PROGRAM_ISSYSTEM', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Dis', 'mapping'=>'PROGRAM_ISDISABLED', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Sp', 'mapping'=>'PROGRAM_ISSUSPEND', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: false}}"]
					],
					'dialog' => new FGTA_DialogMember('Select Program', [
						['label'=>'ID', 'mapping'=>'PROGRAM_ID', 'return'=>'row.PROGRAM_ID', 'width'=>80],
						['label'=>'PROGRAM', 'mapping'=>'PROGRAM_NAME', 'return'=>'row.PROGRAM_NAME', 'width'=>300],
						['label'=>'ISSYSTEM', 'mapping'=>'PROGRAM_ISSYSTEM', 'return'=>'0', 'width'=>30],
						['label'=>'ISDISABLED', 'mapping'=>'PROGRAM_ISDISABLED', 'return'=>'0', 'width'=>30],
						['label'=>'ISSUSPEND', 'mapping'=>'PROGRAM_ISSUSPEND', 'return'=>'0', 'width'=>30],
					], 'PROGRAM_ID', "FGTA_ServiceUrl(ui.NS,'program','ListData')"),
				]),


			);

		}


		public function ListData($pageNumber, $pageSize, $param) {

			$CONDS = FGTA_SqlUtil::GetWhereCondition(array(
				":SEARCH" => ["GROUP_ID=%s", "GROUP_NAME LIKE  '%%' || %s || '%%'"]
			), $param);

			$WHERE_STMT     = $CONDS["SQL"];
			$SQL_PARAMVALUE = $CONDS["VALUE"];

			$sql = "SELECT COUNT(*) AS N FROM FGT_GROUP $WHERE_STMT " ;
			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$row  = $stmt->fetch(PDO::FETCH_ASSOC);
			$total = (float) $row['N'];

			$offset = ($pageSize * ($pageNumber-1));

			$sql = "SELECT FIRST $pageSize SKIP $offset
					GROUP_ID, GROUP_NAME, GROUP_DESCRIPTION, GROUP_ISDISABLED
			        FROM FGT_GROUP
					$WHERE_STMT
					";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$records = array();
			foreach ($rows as $row)
			{
				$records[] = array(
						'GROUP_ID' => $row['GROUP_ID'],
						'GROUP_NAME' => $row['GROUP_NAME'],
						'GROUP_DESCRIPTION' => $row['GROUP_DESCRIPTION'],
						'GROUP_ISDISABLED' => $row['GROUP_ISDISABLED']
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
				'USER' => $this->OpenData_DetilUSER($id),
				'PROGRAM' => $this->OpenData_DetilPROGRAM($id)
			);

			return $obj;
		}

		public function OpenData_Header($id) {
			$sql = "SELECT
					GROUP_ID, GROUP_NAME, GROUP_DESCRIPTION, GROUP_ISDISABLED, GROUP_ISSYSTEM
					,\"_CREATEBY\", \"_CREATEDATE\", \"_MODIFYBY\", \"_MODIFYDATE\", \"_ROWID\"
			        FROM FGT_GROUP WHERE GROUP_ID = :GROUP_ID ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(
							':GROUP_ID' => $id
					));

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$obj = new stdClass;
			$obj->GROUP_ID = $row['GROUP_ID'];
			$obj->GROUP_NAME = $row['GROUP_NAME'];
			$obj->GROUP_DESCRIPTION = $row['GROUP_DESCRIPTION'];
			$obj->GROUP_ISDISABLED = $row['GROUP_ISDISABLED'];
			$obj->GROUP_ISSYSTEM = $row['GROUP_ISSYSTEM'];

			$obj->_recordcreateby = $row["_CREATEBY"];
			$obj->_recordcreatedate = $row["_CREATEDATE"];
			$obj->_recordmodifyby = $row["_MODIFYBY"];
			$obj->_recordmodifydate = $row["_MODIFYDATE"];
			$obj->_recordrowid = $row["_ROWID"];

			return $obj;
		}



		public function OpenData_DetilUSER($id) {

			$sql = "
				SELECT
					B.USER_ID, B.USER_NAME,
					B.USER_ISDISABLED AS USER_ISDISABLED,
					A.GROUPUSER_ISDISABLED AS USER_ISSUSPEND,
					A.GROUPUSER_ISSYSTEM AS USER_ISSYSTEM
				FROM FGT_GROUPUSER A INNER JOIN FGT_USER B
					ON A.USER_ID=B.USER_ID
				WHERE A.GROUP_ID = :GROUP_ID
				ORDER BY B.USER_NAME
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':GROUP_ID'=>$id));
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$records = array();
			$line = 0;
			foreach ($rows as $row)
			{
				$line++;
				$records[] = array(
						'_LINE' => $line,
						'USER_ID' => $row['USER_ID'],
						'USER_NAME' => $row['USER_NAME'],
						'USER_ISDISABLED' => $row['USER_ISDISABLED'],
						'USER_ISSUSPEND' => $row['USER_ISSUSPEND'],
						'USER_ISSYSTEM' => $row['USER_ISSYSTEM'],
				);
			}

			return ['records'=>$records, 'maxline'=>$line];

		}


		public function OpenData_DetilPROGRAM($id) {

			$sql = "
				SELECT
					B.PROGRAM_ID, B.PROGRAM_NAME,
					B.PROGRAM_ISDISABLED AS PROGRAM_ISDISABLED,
					A.GROUPPROGRAM_ISDISABLED AS PROGRAM_ISSUSPEND,
					A.GROUPPROGRAM_ISSYSTEM AS PROGRAM_ISSYSTEM
				FROM FGT_GROUPPROGRAM A INNER JOIN FGT_PROGRAM B
					ON A.PROGRAM_ID=B.PROGRAM_ID
				WHERE A.GROUP_ID = :GROUP_ID
				ORDER BY B.PROGRAM_PATH, B.PROGRAM_NAME
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':GROUP_ID'=>$id));
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$records = array();
			$line = 0;
			foreach ($rows as $row)
			{
				$line++;
				$records[] = array(
						'_LINE' => $line,
						'PROGRAM_ID' => $row['PROGRAM_ID'],
						'PROGRAM_NAME' => $row['PROGRAM_NAME'],
						'PROGRAM_ISDISABLED' => $row['PROGRAM_ISDISABLED'],
						'PROGRAM_ISSUSPEND' => $row['PROGRAM_ISSUSPEND'],
						'PROGRAM_ISSYSTEM' => $row['PROGRAM_ISSYSTEM'],
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

				$id = $this->Save_Header($H);

				if (is_array($D)) {
					if (array_key_exists('USER', $D)) $this->Save_DetilUSER($id, $D['USER']);
					if (array_key_exists('PROGRAM', $D)) $this->Save_DetilPROGRAM($id, $D['PROGRAM']);
				}

				$db->commit();

				return $this->OpenData_Header($id);
			} catch (Exception $e) {
				$db->rollBack();
				throw new Exception('Error in Saving Data.\r\n' . $e->getMessage());
			}
		}

		public function Save_Header($H) {
			$TABLE = "FGT_GROUP";

			$obj = new stdClass;
			$obj->GROUP_NAME = $H['GROUP_NAME'];
			$obj->GROUP_DESCRIPTION = $H['GROUP_DESCRIPTION'];
			$obj->GROUP_ISDISABLED = $H['GROUP_ISDISABLED'];
			$obj->GROUP_ISSYSTEM = $H['GROUP_ISSYSTEM'];


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


		public function Save_DetilUSER($id, $d) {
			$TABLE = "FGT_GROUPUSER";
			if (is_array($d))
			foreach ($d as $row) {
				$obj = new stdClass;
				$obj->GROUPUSER_ISDISABLED = $row['USER_ISSUSPEND'];

				$__STATE = $row['__STATE'];
				if ($__STATE=="insert" || $__STATE=="update") {
					$sql = "SELECT * FROM FGT_GROUPUSER WHERE GROUP_ID=:GROUP_ID AND USER_ID=:USER_ID";
					$stmt = $this->db->prepare($sql);
					$stmt->execute(array(':GROUP_ID'=> $id, ':USER_ID'=>$row['USER_ID']));
					$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if (count($rows)>0) {
						// update
						$key = new stdClass;
						$key->{$this->FIELD_ID_MAPPING} = $id;
						$key->USER_ID = $row['USER_ID'];
						$cmd = FGTA_SqlUtil::CreateSQLUpdate($TABLE, $obj, $key);
					} else {
						// insert
						$obj->{$this->FIELD_ID_MAPPING} = $id;
						$obj->USER_ID = $row['USER_ID'];
						$cmd = FGTA_SqlUtil::CreateSQLInsert($TABLE, $obj);
					}
				} else if ($__STATE=="delete") {
					$key = new stdClass;
					$key->{$this->FIELD_ID_MAPPING} = $id;
					$key->USER_ID = $row['USER_ID'];
					$cmd = FGTA_SqlUtil::CreateSQLDelete($TABLE, $key);
				}

				FGTA_SqlUtil::PDO_Update($this->db, $cmd);
			}

		}


		public function Save_DetilPROGRAM($id, $d) {
			$TABLE = "FGT_GROUPPROGRAM";
			if (is_array($d))
			foreach ($d as $row) {
				$obj = new stdClass;
				$obj->GROUPPROGRAM_ISDISABLED = $row['PROGRAM_ISSUSPEND'];

				$__STATE = $row['__STATE'];
				if ($__STATE=="insert" || $__STATE=="update") {
					$sql = "SELECT * FROM FGT_GROUPPROGRAM WHERE GROUP_ID=:GROUP_ID AND PROGRAM_ID=:PROGRAM_ID";
					$stmt = $this->db->prepare($sql);
					$stmt->execute(array(':GROUP_ID'=> $id, ':PROGRAM_ID'=>$row['PROGRAM_ID']));
					$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if (count($rows)>0) {
						// update
						$key = new stdClass;
						$key->{$this->FIELD_ID_MAPPING} = $id;
						$key->PROGRAM_ID = $row['PROGRAM_ID'];
						$cmd = FGTA_SqlUtil::CreateSQLUpdate($TABLE, $obj, $key);
					} else {
						// insert
						$obj->{$this->FIELD_ID_MAPPING} = $id;
						$obj->PROGRAM_ID = $row['PROGRAM_ID'];
						$cmd = FGTA_SqlUtil::CreateSQLInsert($TABLE, $obj);
					}
				} else if ($__STATE=="delete") {
					$key = new stdClass;
					$key->{$this->FIELD_ID_MAPPING} = $id;
					$key->PROGRAM_ID = $row['PROGRAM_ID'];
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

				$TBL = ['FGT_GROUPPROGRAM', 'FGT_GROUPUSER', 'FGT_GROUP'];
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
				throw new Exception('Error in Saving Data.<br>\r\n' . $e->getMessage());
			}
		}

		public function LoadGroup()
		{
			global $_SESSION;
			return $this->LoadGroupUser($_SESSION['username']);
		}

		public function LoadGroupMobile()
		{
			global $_SESSION;
			return $this->LoadGroupUserMobile($_SESSION['username']);
		}

		public function LoadGroupUser($username)
		{
			$sql = "
			SELECT
				B.GROUP_ID, B.GROUP_NAME
			FROM
			FGT_GROUPUSER A INNER JOIN FGT_GROUP B
				ON A.GROUP_ID=B.GROUP_ID
			WHERE A.USER_ID = :USER_ID
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':USER_ID'=>$username));
			$selected_group_rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$groups = array();
			if ($username==__ROOT_USER) {
				$groups[] = array('group_id'=>__ROOT_USER, 'group_name'=>__ROOT_USER);
			}

			foreach ($selected_group_rows as $row)
			{
				$groups[] = array(
					'group_id'=> $row['GROUP_ID'],
					'group_name'=> $row['GROUP_NAME'],
				);
			}

			$obj = new stdClass;
			$obj->groups = $groups;

			return $obj;
		}

		public function LoadGroupUserMobile($username) {
			$sql = "
				select
				a.GROUP_ID,
				(select group_name from fgt_group where group_id = a.group_id) as group_name
				from (
				    select
				    distinct
				    b.GROUP_ID
				    from FGT_PROGRAM a inner join FGT_GROUPPROGRAM b on a.PROGRAM_ID=b.PROGRAM_ID
				    where
				    a.program_isdisabled = 0
				    and a.program_ismobileenabled = 1
				) a
				inner join
				(
				    select distinct a.GROUP_ID
				    from FGT_GROUP a inner join FGT_GROUPUSER b on a.GROUP_ID = b.GROUP_ID and b.USER_ID = :USER_ID
				) b
				on a.GROUP_ID = b.GROUP_ID
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':USER_ID'=>$username));
			$selected_group_rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);


			$groups = array();
			foreach ($selected_group_rows as $row)
			{
				$groups[] = array(
					'group_id'=> $row['GROUP_ID'],
					'group_name'=> $row['GROUP_NAME'],
				);
			}

			$obj = new stdClass;
			$obj->groups = $groups;

			return $obj;

		}


	}
