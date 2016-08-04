<?php

	require_once 'fgta/FGTA_ProgramNode.inc.php';
	require_once "fgta/FGTA_DialogMember.inc.php";

	class program extends FGTA_Content
	{

		public $FIELD_ID = "obj_txt_PROGRAM_ID";
		public $FIELD_ID_MAPPING = "PROGRAM_ID";
		public $FIELD_ID_ISAUTO = false;


		public function LoadPage()
		{
			global $_GET;

			$this->Scripts->load("program.js");

			$this->dgvList = new FGTA_Control_Datagrid([
				'name' => 'dgvList',
				'columnid'=> $this->FIELD_ID_MAPPING,
				'options'=> '
					pagination:true
				',
				'columns' => [
					['label'=>'ID', 'mapping'=>'PROGRAM_ID', 'options'=>'width:100'],
					['label'=>'Program Name', 'mapping'=>'PROGRAM_NAME', 'options'=>'width:200'],
					['label'=>'Description', 'mapping'=>'PROGRAM_DESCRIPTION', 'options'=>'width:300'],
					['label'=>'Dis', 'mapping'=>'PROGRAM_ISDISABLED', 'options'=>'width:30']
				]
			]);


			$this->Search = array(
				new FGTA_Control_TextboxSearch(['name'=>':SEARCH', 'label'=>'Search', 'checkbox'=>'src_chk_SEARCH', 'textbox'=>'src_txt_SEARCH', 'location'=>[10,0,200] ]),
			);


			$this->Editor = array(
				new FGTA_Control_Textbox(['name'=>'obj_txt_PROGRAM_ID', 'label'=>'ID', 'maxlength'=>'30', 'options'=>"required:true,validType:['USER_ID','length[3,30]'],missingMessage:'ID harus diisi'" ]),
				new FGTA_Control_Checkbox(['name'=>'obj_chk_PROGRAM_ISDISABLED', 'label'=>'Disabled'  ]),
				new FGTA_Control_Checkbox(['name'=>'obj_chk_PROGRAM_ISSYSTEM', 'label'=>'System'  ]),
				new FGTA_Control_Checkbox(['name'=>'obj_chk_PROGRAM_ISSINGLEINSTANCE', 'label'=>'SingleInstance']),

				new FGTA_Control_Textbox(['name'=>'obj_txt_PROGRAM_NAME', 'label'=>'NAME',  'maxlength'=>'60', 'options'=>"required:true,validType:{length:[3,60]},missingMessage:'NAMA harus diisi'" ]),
				new FGTA_Control_Combobox(['name'=>'obj_txt_PROGRAM_TYPE', 'label'=>'TYPE',  'options'=>"editable:false,valueField:'id',textField:'text',data:DATA_PROGRAM_TYPE" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_PROGRAM_ICON', 'label'=>'ICON',  'options'=>"" ]),

				new FGTA_Control_Textbox(['name'=>'obj_txt_PROGRAM_DESCRIPTION', 'label'=>'DESCR', 'maxlength'=>'255', 'options'=>"" ]),

				new FGTA_Control_Textbox(['name'=>'obj_txt_PROGRAM_NS', 'label'=>'NS',  'maxlength'=>'90', 'options'=>"required:true,missingMessage:'NS harus diisi'" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_PROGRAM_INSTANCE', 'label'=>'INSTANCE',  'maxlength'=>'90', 'options'=>"required:true,missingMessage:'INSTANCE harus diisi'" ]),

				new FGTA_Control_Textbox(['name'=>'obj_txt_PROGRAM_PATH', 'label'=>'PATH',  'maxlength'=>'255', 'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_PROGRAM_DLL', 'label'=>'DLL',  'maxlength'=>'90', 'options'=>"" ]),

				new FGTA_Control_Checkbox(['name'=>'obj_chk_PROGRAM_ISWEBENABLED', 'label'=>'Web' ]),
				new FGTA_Control_Checkbox(['name'=>'obj_chk_PROGRAM_ISMOBILEENABLED', 'label'=>'Mobile' ]),


				new FGTA_Control_Datagrid(['name'=>'dgv_GROUP', 'label'=>'Group',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_GROUP_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_GROUP, index) }
								',
					'columns' => [
						['label'=>'ID', 'mapping'=>'GROUP_ID', 'options'=>"width:100, editor:{type:'textbox', options:{readonly:true}}"],
						['label'=>'Group', 'mapping'=>'GROUP_NAME', 'options'=>"width:350, editor:{type:'textbox', options:{readonly: true}}"],
						['label'=>'Sys', 'mapping'=>'GROUP_ISSYSTEM', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: true}}"],
						['label'=>'Dis', 'mapping'=>'GROUP_ISDISABLED', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: true}}"],
						['label'=>'Sp', 'mapping'=>'GROUP_ISSUSPEND', 'options'=>"width:30, editor:{type:'textbox', options:{readonly: false}}"],
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
				":SEARCH" => ["PROGRAM_ID=%s", "PROGRAM_ID LIKE  %s || '%%'", "PROGRAM_NAME LIKE  '%%' || %s || '%%'", "PROGRAM_DESCRIPTION LIKE  '%%' || %s || '%%'"]
			), $param);

			$WHERE_STMT     = $CONDS["SQL"];
			$SQL_PARAMVALUE = $CONDS["VALUE"];

			$sql = "SELECT COUNT(*) AS N FROM FGT_PROGRAM $WHERE_STMT " ;
			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$row  = $stmt->fetch(PDO::FETCH_ASSOC);
			$total = (float) $row['N'];

			$offset = ($pageSize * ($pageNumber-1));

			$sql = "SELECT FIRST $pageSize SKIP $offset
					PROGRAM_ID, PROGRAM_NAME, PROGRAM_NS, PROGRAM_DESCRIPTION, PROGRAM_ISDISABLED
			        FROM FGT_PROGRAM
					$WHERE_STMT
					";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$records = array();
			foreach ($rows as $row)
			{
				$records[] = array(
						'PROGRAM_ID' => $row['PROGRAM_ID'],
						'PROGRAM_NAME' => $row['PROGRAM_NAME'],
						'PROGRAM_NS' => $row['PROGRAM_NS'],
						'PROGRAM_DESCRIPTION' => $row['PROGRAM_DESCRIPTION'],
						'PROGRAM_ISDISABLED' => $row['PROGRAM_ISDISABLED']
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
			$DAT_TYPE = array();
			$DAT_TYPE['MST'] = 'Master';
			$DAT_TYPE['TRN'] = 'Transaksi';
			$DAT_TYPE['RPT'] = 'Report';
			$DAT_TYPE['DAS'] = 'Dashboard';


			$sql = "SELECT
					PROGRAM_ID, PROGRAM_NAME, PROGRAM_TYPE, PROGRAM_ICON, PROGRAM_PATH, PROGRAM_NS, PROGRAM_DLL, PROGRAM_INSTANCE, PROGRAM_DESCRIPTION, PROGRAM_ISDISABLED, PROGRAM_ISSINGLEINSTANCE, PROGRAM_ISWEBENABLED, PROGRAM_ISMOBILEENABLED, PROGRAM_ISSYSTEM
					,\"_CREATEBY\", \"_CREATEDATE\", \"_MODIFYBY\", \"_MODIFYDATE\", \"_ROWID\"
			        FROM FGT_PROGRAM WHERE PROGRAM_ID = :PROGRAM_ID ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(
							':PROGRAM_ID' => $id
					));

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$obj = new stdClass;
			$obj->PROGRAM_ID = $row['PROGRAM_ID'];
			$obj->PROGRAM_NAME = $row['PROGRAM_NAME'];
			$obj->PROGRAM_TYPE = $row['PROGRAM_TYPE'];
			$obj->PROGRAM_TYPENAME = array_key_exists($obj->PROGRAM_TYPE, $DAT_TYPE) ? $DAT_TYPE[$obj->PROGRAM_TYPE] : $obj->PROGRAM_TYPE;
			$obj->PROGRAM_ICON = $row['PROGRAM_ICON'];
			$obj->PROGRAM_PATH = $row['PROGRAM_PATH'];
			$obj->PROGRAM_NS = $row['PROGRAM_NS'];
			$obj->PROGRAM_DLL = $row['PROGRAM_DLL'];
			$obj->PROGRAM_INSTANCE = $row['PROGRAM_INSTANCE'];
			$obj->PROGRAM_DESCRIPTION = $row['PROGRAM_DESCRIPTION'];
			$obj->PROGRAM_ISDISABLED = $row['PROGRAM_ISDISABLED'];
			$obj->PROGRAM_ISSINGLEINSTANCE = $row['PROGRAM_ISSINGLEINSTANCE'];
			$obj->PROGRAM_ISWEBENABLED = $row['PROGRAM_ISWEBENABLED'];
			$obj->PROGRAM_ISMOBILEENABLED = $row['PROGRAM_ISMOBILEENABLED'];
			$obj->PROGRAM_ISSYSTEM = $row['PROGRAM_ISSYSTEM'];

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
					A.GROUPPROGRAM_ISDISABLED AS GROUP_ISSUSPEND,
					A.GROUPPROGRAM_ISSYSTEM AS GROUP_ISSYSTEM
				FROM FGT_GROUPPROGRAM A INNER JOIN FGT_GROUP B
					ON A.GROUP_ID=B.GROUP_ID
				WHERE A.PROGRAM_ID = :PROGRAM_ID
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':PROGRAM_ID'=>$id));
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
				$id = $this->Save_Header($H);
				$this->Save_DetilGROUP($id, $D['GROUP']);

				$db->commit();

				return $this->OpenData_Header($id);
			} catch (Exception $e) {
				$db->rollBack();
				throw new Exception('Error in Saving Data.<br>\r\n' . $e->getMessage());
			}
		}

		public function Save_Header($H) {
			$TABLE = "FGT_PROGRAM";

			$obj = new stdClass;
			$obj->PROGRAM_NAME = $H['PROGRAM_NAME'];
			$obj->PROGRAM_TYPE = $H['PROGRAM_TYPE'];
			$obj->PROGRAM_ICON = $H['PROGRAM_ICON'];
			$obj->PROGRAM_PATH = $H['PROGRAM_PATH'];
			$obj->PROGRAM_NS = $H['PROGRAM_NS'];
			$obj->PROGRAM_DLL = $H['PROGRAM_DLL'];
			$obj->PROGRAM_INSTANCE = $H['PROGRAM_INSTANCE'];
			$obj->PROGRAM_DESCRIPTION = $H['PROGRAM_DESCRIPTION'];
			$obj->PROGRAM_ISDISABLED = $H['PROGRAM_ISDISABLED'];
			$obj->PROGRAM_ISSINGLEINSTANCE = $H['PROGRAM_ISSINGLEINSTANCE'];
			$obj->PROGRAM_ISWEBENABLED = $H['PROGRAM_ISWEBENABLED'];
			$obj->PROGRAM_ISMOBILEENABLED = $H['PROGRAM_ISMOBILEENABLED'];
			$obj->PROGRAM_ISSYSTEM = $H['PROGRAM_ISSYSTEM'];


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
			$TABLE = "FGT_GROUPPROGRAM";
			if (is_array($d))
			foreach ($d as $row) {
				$obj = new stdClass;
				$obj->GROUPPROGRAM_ISDISABLED = $row['GROUP_ISSUSPEND'];

				$__STATE = $row['__STATE'];
				if ($__STATE=="insert" || $__STATE=="update") {
					$sql = "SELECT * FROM FGT_GROUPPROGRAM WHERE GROUP_ID=:GROUP_ID AND PROGRAM_ID=:PROGRAM_ID";
					$stmt = $this->db->prepare($sql);
					$stmt->execute(array(':GROUP_ID'=> $row['GROUP_ID'], ':PROGRAM_ID'=>$id));
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

				$TBL = ['FGT_GROUPPROGRAM', 'FGT_PROGRAM'];
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


		public function LoadGroupProgramMobile($group_id) {
			$sql = "
				SELECT
					B.PROGRAM_ID, B.PROGRAM_TYPE, B.PROGRAM_NAME, B.PROGRAM_PATH, B.PROGRAM_NS, B.PROGRAM_INSTANCE, B.PROGRAM_ICON
				FROM
				FGT_GROUPPROGRAM A INNER JOIN FGT_PROGRAM B
					ON A.PROGRAM_ID=B.PROGRAM_ID
				WHERE
				A.GROUP_ID = :GROUP_ID
				AND B.PROGRAM_ISMOBILEENABLED=1
				AND B.PROGRAM_ISDISABLED=0
				ORDER BY B.PROGRAM_TYPE, B.PROGRAM_PATH, B.PROGRAM_NAME
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':GROUP_ID'=>$group_id));
			$selected_program_rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$programs = array();
			foreach ($selected_program_rows as $row)
			{
				$program_id = $row['PROGRAM_ID'];
				$ns = $row['PROGRAM_NS'];
				$cl = $row['PROGRAM_INSTANCE'];
				$title = $row['PROGRAM_NAME'];

				$url = "container.mob.php?mode=app&ns=$ns&cl=$cl";
				$programs[] = array(
					'title'=> $title,
					'url'=> $url,
				);
			}

			$obj = new stdClass;
			$obj->programs = $programs;

			return $obj;

		}


		public function LoadGroupProgram($group_id)
		{

			$sql = "
			SELECT
				B.PROGRAM_ID, B.PROGRAM_TYPE, B.PROGRAM_NAME, B.PROGRAM_PATH, B.PROGRAM_NS, B.PROGRAM_INSTANCE, B.PROGRAM_ICON
			FROM
			FGT_GROUPPROGRAM A INNER JOIN FGT_PROGRAM B
				ON A.PROGRAM_ID=B.PROGRAM_ID
			WHERE
			A.GROUP_ID = :GROUP_ID
			AND (B.PROGRAM_ISMOBILEENABLED=0 OR (B.PROGRAM_ISMOBILEENABLED=1 AND B.PROGRAM_ISWEBENABLED=1))
			ORDER BY B.PROGRAM_TYPE, B.PROGRAM_PATH, B.PROGRAM_NAME
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':GROUP_ID'=>$group_id));
			$selected_program_rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if ($group_id==__ROOT_USER) {
				$selected_program_rows[] = array('PROGRAM_ID'=>'USER', 'PROGRAM_TYPE'=>'MST', 'PROGRAM_NAME'=>'User','PROGRAM_PATH'=>'Framework','PROGRAM_NS'=>'_default','PROGRAM_INSTANCE'=>'user', 'PROGRAM_ICON'=>'');
				$selected_program_rows[] = array('PROGRAM_ID'=>'GROUP', 'PROGRAM_TYPE'=>'MST', 'PROGRAM_NAME'=>'Group','PROGRAM_PATH'=>'Framework','PROGRAM_NS'=>'_default','PROGRAM_INSTANCE'=>'group', 'PROGRAM_ICON'=>'');
				$selected_program_rows[] = array('PROGRAM_ID'=>'PROGRAM', 'PROGRAM_TYPE'=>'MST', 'PROGRAM_NAME'=>'Program','PROGRAM_PATH'=>'Framework','PROGRAM_NS'=>'_default','PROGRAM_INSTANCE'=>'program', 'PROGRAM_ICON'=>'');
				$selected_program_rows[] = array('PROGRAM_ID'=>'FGEN', 'PROGRAM_TYPE'=>'MST', 'PROGRAM_NAME'=>'Generator','PROGRAM_PATH'=>'Framework','PROGRAM_NS'=>'_default','PROGRAM_INSTANCE'=>'fgen', 'PROGRAM_ICON'=>'');
				//$selected_program_rows[] = array('PROGRAM_ID'=>'TESTDEV', 'PROGRAM_TYPE'=>'MST', 'PROGRAM_NAME'=>'Test Device','PROGRAM_PATH'=>'Framework','PROGRAM_NS'=>'_default','PROGRAM_INSTANCE'=>'testdev', 'PROGRAM_ICON'=>'');
			}


			$nodes = array();
			foreach ($selected_program_rows as $row)
			{
				$ns = $row['PROGRAM_NS'];
				$cl = $row['PROGRAM_INSTANCE'];

				$prg = new stdClass;
				$prg->program_id = $row['PROGRAM_ID'];
				$prg->program_type = $row['PROGRAM_TYPE'];
				$prg->program_url = "?mode=app&ns=$ns&cl=$cl";
				$prg->program_name = $row['PROGRAM_NAME'];
				$prg->program_path = $row['PROGRAM_TYPE']."/".$row['PROGRAM_PATH'];
				$prg->program_icon = $row['PROGRAM_ICON'];


				$current_node = &$nodes;
				$paths = explode("/", $prg->program_path);
				while ($path_folder = array_shift($paths))
				{
					if (!array_key_exists($path_folder, $current_node))
					{
						$node = new FGTA_ProgramNode();
						$node->id = 0;
						$node->text = $path_folder;
						$node->type = "group";
						$node->state = "open";
						$node->iconCls = '';
						$node->children = array();

						$current_node[$path_folder] = $node;
					}

					$current_node = &$current_node[$path_folder]->children;
				}

				$node = new FGTA_ProgramNode();
				$node->id = $prg->program_id;
				$node->text = $prg->program_name;
				$node->url = $prg->program_url;
				$node->iconCls = "icon-mnutree-".$prg->program_icon;
				$node->type = "item";
				$current_node[] = $node;
			}


			$programs = $this->GetProgramTree($nodes);




			$obj = new stdClass;
			$obj->programs = $programs;


			return $obj;
		}

		public function GetProgramTree($nodes)
		{
			$program = array();
			foreach ($nodes as $node)
			{
				$obj = new FGTA_ProgramNode();
				$obj->id = $node->id;
				$obj->text = $node->text;
				$obj->url = $node->url;
				$obj->type = $node->type;
				$obj->iconCls = $node->iconCls;
				//$obj->iconCls = 'icon-mnutree-calendar-01';

				if (is_array($node->children))
					$obj->children = $this->GetProgramTree($node->children);

				$program[] = $obj;
			}

			return $program;
		}



	}
