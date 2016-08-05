<?php

	class fgen extends FGTA_Content
	{

		public $FIELD_ID = "obj_txt_FGEN_ID";
		public $FIELD_ID_MAPPING = "FGEN_ID";
		public $FIELD_ID_ISAUTO = false;


		public function LoadPage() {
			global $_GET;

			$this->Scripts->load("fgen.js");

			$this->dgvList = new FGTA_Control_Datagrid([
				'name' => 'dgvList',
				'columnid'=> $this->FIELD_ID_MAPPING,
				'options'=> '
					pagination:true
				',
				'columns' => [
					['label'=>'ID', 'mapping'=>'FGEN_ID', 'options'=>'width:100'],
					['label'=>'ProgName', 'mapping'=>'FGEN_NAME', 'options'=>'width:100'],
					['label'=>'Folder', 'mapping'=>'FGEN_FOLDER', 'options'=>'width:100'],
					['label'=>'Ident', 'mapping'=>'FGEN_IDENT', 'options'=>'width:100'],
					['label'=>'Table', 'mapping'=>'FGEN_TABLE', 'options'=>'width:100']
				]
			]);


			$this->Search = array(
				new FGTA_Control_TextboxSearch(['name'=>':FGEN_NAME', 'label'=>'ProgName', 'checkbox'=>'src_chk_FGEN_NAME', 'textbox'=>'src_txt_FGEN_NAME' ])
			);


			$this->Editor = array(
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_ID', 'label'=>'ID',  'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_NAME', 'label'=>'ProgName',  'options'=>"" ]),
				new FGTA_Control_Combobox(['name'=>'obj_cbo_FGEN_PROGTYPE', 'label'=>'Type',  'options'=>"validType:'FGTA_CBO[ui.Editor.obj_cbo_FGEN_PROGTYPE]',editable:false,valueField:'id',textField:'text',data:DATA['TYPE']" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_FOLDER', 'label'=>'Folder',  'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_IDENT', 'label'=>'Ident', 'labelwidth'=> 35 , 'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_TABLE', 'label'=>'Table', 'buttonlabel'=>'...', 'buttonwidth'=>'30', 'button'=>'btn_H_Get', 'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_PK', 'label'=>'PK',  'options'=>"" ]),
				new FGTA_Control_Checkbox(['name'=>'obj_chk_FGEN_ISAUTO', 'label'=>'AutoID' ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D1NAME', 'label'=>'D.1.Name',  'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D1TABLE', 'label'=>'D.1.Tbl',  'buttonlabel'=>'...', 'buttonwidth'=>'30', 'button'=>'btn_D1_Get', 'button_onclick'=>'_btn_H_Get_Click', 'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D2NAME', 'label'=>'D.2.Name',  'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D2TABLE', 'label'=>'D.2.Tbl',  'buttonlabel'=>'...', 'buttonwidth'=>'30', 'button'=>'btn_D2_Get', 'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D3NAME', 'label'=>'D.3.Name',  'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D3TABLE', 'label'=>'D.3.Tbl',  'buttonlabel'=>'...', 'buttonwidth'=>'30', 'button'=>'btn_D3_Get', 'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D4NAME', 'label'=>'D.4.Name',  'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D4TABLE', 'label'=>'D.4.Tbl',  'buttonlabel'=>'...', 'buttonwidth'=>'30', 'button'=>'btn_D4_Get', 'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D5NAME', 'label'=>'D.5.Name',  'options'=>"" ]),
				new FGTA_Control_Textbox(['name'=>'obj_txt_FGEN_D5TABLE', 'label'=>'D.5.Tbl',  'buttonlabel'=>'...', 'buttonwidth'=>'30', 'button'=>'btn_D5_Get', 'options'=>"" ]),

				new FGTA_Control_Datagrid(['name'=>'dgv_H', 'label'=>'H',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_H_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_H, index) }
								',
					'columns' => [
						['label'=>'Field', 'mapping'=>'FGEND_FIELD', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Label', 'mapping'=>'FGEND_LABEL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Control', 'mapping'=>'FGEND_CONTROL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'List', 'mapping'=>'FGEND_ISLIST', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Search', 'mapping'=>'FGEND_ISSEARCH', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Form', 'mapping'=>'FGEND_ISFORM', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"]
					]
				]),


				new FGTA_Control_Datagrid(['name'=>'dgv_D1', 'label'=>'D1',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_D1_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_D1, index) }
								',
					'columns' => [
						['label'=>'Field', 'mapping'=>'FGEND_FIELD', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Label', 'mapping'=>'FGEND_LABEL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Control', 'mapping'=>'FGEND_CONTROL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"]
					]
				]),


				new FGTA_Control_Datagrid(['name'=>'dgv_D2', 'label'=>'D2',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_D2_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_D2, index) }
								',
					'columns' => [
						['label'=>'Field', 'mapping'=>'FGEND_FIELD', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Label', 'mapping'=>'FGEND_LABEL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Control', 'mapping'=>'FGEND_CONTROL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"]
					]
				]),


				new FGTA_Control_Datagrid(['name'=>'dgv_D3', 'label'=>'D3',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_D3_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_D3, index) }
								',
					'columns' => [
						['label'=>'Field', 'mapping'=>'FGEND_FIELD', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Label', 'mapping'=>'FGEND_LABEL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Control', 'mapping'=>'FGEND_CONTROL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"]
					]
				]),


				new FGTA_Control_Datagrid(['name'=>'dgv_D4', 'label'=>'D4',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_D4_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_D4, index) }
								',
					'columns' => [
						['label'=>'Field', 'mapping'=>'FGEND_FIELD', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Label', 'mapping'=>'FGEND_LABEL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Control', 'mapping'=>'FGEND_CONTROL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"]
					]
				]),


				new FGTA_Control_Datagrid(['name'=>'dgv_D5', 'label'=>'D5',
					'columnid'=>'group_id',
					'allowaddremove'=>true,
					'options'=>'
						onDblClickRow: function(index,row) { _dgv_D5_RowDblClick(ui,index,row) },
						onClickCell: function(index, field) { ui.dgv_ClickCell(ui, ui.dgv_D5, index) }
								',
					'columns' => [
						['label'=>'Field', 'mapping'=>'FGEND_FIELD', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Label', 'mapping'=>'FGEND_LABEL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"],
						['label'=>'Control', 'mapping'=>'FGEND_CONTROL', 'options'=>"width:100, editor:{type:'textbox', options:{readonly: false}}"]
					]
				]),


			);

		}


		public function LoadPage_PreloadData($dataid) {
			$F = null;

			switch($dataid) {
				case 'CONTROL' :
					$ctrls = ['textbox', 'combobox', 'datebox', 'numberbox'];
					$data = array();
					$i=0;
					foreach ($ctrls as $ctrl) {
						$i++;
						echo "{\"id\":\"".$ctrl."\",\"text\":\"".$ctrl."\"}";
						echo ($i<count($ctrls)) ? "," : "";
					}
					return;
			}

		}


		public function ListData($pageNumber, $pageSize, $param) {

			$CONDS = FGTA_SqlUtil::GetWhereCondition(array(
				":FGEN_NAME" => ["FGEN_NAME LIKE  '%%' || %s || '%%'"]
			), $param);

			$WHERE_STMT     = $CONDS["SQL"];
			$SQL_PARAMVALUE = $CONDS["VALUE"];

			$sql = "SELECT COUNT(*) AS N FROM FGT_FGEN $WHERE_STMT " ;
			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$row  = $stmt->fetch(PDO::FETCH_ASSOC);
			$total = (float) $row['N'];

			$offset = ($pageSize * ($pageNumber-1));

			$sql = "SELECT FIRST $pageSize SKIP $offset
					FGEN_ID, FGEN_NAME, FGEN_FOLDER, FGEN_IDENT, FGEN_TABLE
			        FROM FGT_FGEN
					$WHERE_STMT
					";

			$stmt = $this->db->prepare($sql);
			$stmt->execute($SQL_PARAMVALUE);
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$records = array();
			foreach ($rows as $row)
			{
				$records[] = array(
						'FGEN_ID' => $row['FGEN_ID'],
						'FGEN_NAME' => $row['FGEN_NAME'],
						'FGEN_FOLDER' => $row['FGEN_FOLDER'],
						'FGEN_IDENT' => $row['FGEN_IDENT'],
						'FGEN_TABLE' => $row['FGEN_TABLE']
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
				'H' => $this->OpenData_DetilH($id),
				'D1' => $this->OpenData_DetilD1($id),
				'D2' => $this->OpenData_DetilD2($id),
				'D3' => $this->OpenData_DetilD3($id),
				'D4' => $this->OpenData_DetilD4($id),
				'D5' => $this->OpenData_DetilD5($id)
			);

			return $obj;
		}

		public function OpenData_Header($id) {
			$sql = "SELECT
					FGEN_ID, FGEN_NAME, FGEN_PROGTYPE, FGEN_FOLDER, FGEN_IDENT, FGEN_TABLE, FGEN_PK, FGEN_ISAUTO, FGEN_D1NAME, FGEN_D1TABLE, FGEN_D2NAME, FGEN_D2TABLE, FGEN_D3NAME, FGEN_D3TABLE, FGEN_D4NAME, FGEN_D4TABLE, FGEN_D5NAME, FGEN_D5TABLE
					,\"_CREATEBY\", \"_CREATEDATE\", \"_MODIFYBY\", \"_MODIFYDATE\", \"_ROWID\"
			        FROM FGT_FGEN WHERE FGEN_ID = :FGEN_ID ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(
							':FGEN_ID' => $id
					));

			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($rows)==0)
				return null;

		 	$row = $rows[0];

			$PROGTYPE=array('MST'=>'MASTER','TRN'=>'TRANSAKSI','RPT'=>'REPORT');

			$obj = new stdClass;
			$obj->FGEN_ID = $row['FGEN_ID'];
			$obj->FGEN_NAME = $row['FGEN_NAME'];
			$obj->FGEN_PROGTYPE = $row['FGEN_PROGTYPE'];
			$obj->FGEN_PROGTYPENAME = $PROGTYPE[$row['FGEN_PROGTYPE']];
			$obj->FGEN_FOLDER = $row['FGEN_FOLDER'];
			$obj->FGEN_IDENT = $row['FGEN_IDENT'];
			$obj->FGEN_TABLE = $row['FGEN_TABLE'];
			$obj->FGEN_PK = $row['FGEN_PK'];
			$obj->FGEN_ISAUTO = $row['FGEN_ISAUTO'];
			$obj->FGEN_D1NAME = $row['FGEN_D1NAME'];
			$obj->FGEN_D1TABLE = $row['FGEN_D1TABLE'];
			$obj->FGEN_D2NAME = $row['FGEN_D2NAME'];
			$obj->FGEN_D2TABLE = $row['FGEN_D2TABLE'];
			$obj->FGEN_D3NAME = $row['FGEN_D3NAME'];
			$obj->FGEN_D3TABLE = $row['FGEN_D3TABLE'];
			$obj->FGEN_D4NAME = $row['FGEN_D4NAME'];
			$obj->FGEN_D4TABLE = $row['FGEN_D4TABLE'];
			$obj->FGEN_D5NAME = $row['FGEN_D5NAME'];
			$obj->FGEN_D5TABLE = $row['FGEN_D5TABLE'];

			$obj->_recordcreateby = $row["_CREATEBY"];
			$obj->_recordcreatedate = $row["_CREATEDATE"];
			$obj->_recordmodifyby = $row["_MODIFYBY"];
			$obj->_recordmodifydate = $row["_MODIFYDATE"];
			$obj->_recordrowid = $row["_ROWID"];

			return $obj;
		}



		public function OpenData_DetilH($id) {
			$sql = "SELECT FGEND_FIELD, FGEND_LABEL, FGEND_CONTROL, FGEND_ISLIST, FGEND_ISSEARCH, FGEND_ISFORM, \"_LINE\"
			        FROM FGT_FGEND
					WHERE
					FGEN_ID = :FGEN_ID AND FGEND_TAB=0
					ORDER BY \"_LINE\"
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':FGEN_ID'=>$id));
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$records = array();
			$line = 0;
			foreach ($rows as $row)
			{
				$line = $row['_LINE'];
				$records[] = array(
						'_LINE' => $line,
						'FGEND_FIELD' => $row['FGEND_FIELD'],
						'FGEND_LABEL' => $row['FGEND_LABEL'],
						'FGEND_CONTROL' => $row['FGEND_CONTROL'],
						'FGEND_ISLIST' => $row['FGEND_ISLIST'],
						'FGEND_ISSEARCH' => $row['FGEND_ISSEARCH'],
						'FGEND_ISFORM' => $row['FGEND_ISFORM']
				);
			}

			return ['records'=>$records, 'maxline'=>$line];

		}


		public function OpenData_DetilD1($id) {
			$sql = "SELECT FGEND_FIELD, FGEND_LABEL, FGEND_CONTROL, \"_LINE\"
			        FROM FGT_FGEND
					WHERE
					FGEN_ID = :FGEN_ID AND FGEND_TAB=1
					ORDER BY \"_LINE\"
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':FGEN_ID'=>$id));
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$records = array();
			$line = 0;
			foreach ($rows as $row)
			{
				$line = $row['_LINE'];
				$records[] = array(
						'_LINE' => $line,
						'FGEND_FIELD' => $row['FGEND_FIELD'],
						'FGEND_LABEL' => $row['FGEND_LABEL'],
						'FGEND_CONTROL' => $row['FGEND_CONTROL']
				);
			}

			return ['records'=>$records, 'maxline'=>$line];

		}


		public function OpenData_DetilD2($id) {
			$sql = "SELECT FGEND_FIELD, FGEND_LABEL, FGEND_CONTROL, \"_LINE\"
			        FROM FGT_FGEND
					WHERE
					FGEN_ID = :FGEN_ID AND FGEND_TAB=2
					ORDER BY \"_LINE\"
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':FGEN_ID'=>$id));
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$records = array();
			$line = 0;
			foreach ($rows as $row)
			{
				$line = $row['_LINE'];
				$records[] = array(
						'_LINE' => $line,
						'FGEND_FIELD' => $row['FGEND_FIELD'],
						'FGEND_LABEL' => $row['FGEND_LABEL'],
						'FGEND_CONTROL' => $row['FGEND_CONTROL']
				);
			}

			return ['records'=>$records, 'maxline'=>$line];

		}


		public function OpenData_DetilD3($id) {
			$sql = "SELECT FGEND_FIELD, FGEND_LABEL, FGEND_CONTROL, \"_LINE\"
			        FROM FGT_FGEND
					WHERE
					FGEN_ID = :FGEN_ID AND FGEND_TAB=3
					ORDER BY \"_LINE\"
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':FGEN_ID'=>$id));
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$records = array();
			$line = 0;
			foreach ($rows as $row)
			{
				$line = $row['_LINE'];
				$records[] = array(
						'_LINE' => $line,
						'FGEND_FIELD' => $row['FGEND_FIELD'],
						'FGEND_LABEL' => $row['FGEND_LABEL'],
						'FGEND_CONTROL' => $row['FGEND_CONTROL']
				);
			}

			return ['records'=>$records, 'maxline'=>$line];

		}


		public function OpenData_DetilD4($id) {
			$sql = "SELECT FGEND_FIELD, FGEND_LABEL, FGEND_CONTROL, \"_LINE\"
			        FROM FGT_FGEND
					WHERE
					FGEN_ID = :FGEN_ID AND FGEND_TAB=4
					ORDER BY \"_LINE\"
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':FGEN_ID'=>$id));
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$records = array();
			$line = 0;
			foreach ($rows as $row)
			{
				$line = $row['_LINE'];
				$records[] = array(
						'_LINE' => $line,
						'FGEND_FIELD' => $row['FGEND_FIELD'],
						'FGEND_LABEL' => $row['FGEND_LABEL'],
						'FGEND_CONTROL' => $row['FGEND_CONTROL']
				);
			}

			return ['records'=>$records, 'maxline'=>$line];

		}


		public function OpenData_DetilD5($id) {
			$sql = "SELECT FGEND_FIELD, FGEND_LABEL, FGEND_CONTROL, \"_LINE\"
			        FROM FGT_FGEND
					WHERE
					FGEN_ID = :FGEN_ID AND FGEND_TAB=5
					ORDER BY \"_LINE\"
			";

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':FGEN_ID'=>$id));
			$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$records = array();
			$line = 0;
			foreach ($rows as $row)
			{
				$line = $row['_LINE'];
				$records[] = array(
						'_LINE' => $line,
						'FGEND_FIELD' => $row['FGEND_FIELD'],
						'FGEND_LABEL' => $row['FGEND_LABEL'],
						'FGEND_CONTROL' => $row['FGEND_CONTROL']
				);
			}

			return ['records'=>$records, 'maxline'=>$line];

		}




		public function NewId($H) {
			return "testid";
		}

		public function Save($H, $D) {
			$db = $this->db;
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
			$db->beginTransaction();

			try {
				$id = $this->Save_Header($H);

				if(is_array($D)) {
					if (array_key_exists('H', $D)) $this->Save_Detil($id, $D['H'], 0);
					if (array_key_exists('D1', $D)) $this->Save_Detil($id, $D['D1'], 1);
					if (array_key_exists('D2', $D)) $this->Save_Detil($id, $D['D2'], 2);
					if (array_key_exists('D3', $D)) $this->Save_Detil($id, $D['D3'], 3);
					if (array_key_exists('D4', $D)) $this->Save_Detil($id, $D['D4'], 4);
					if (array_key_exists('D5', $D)) $this->Save_Detil($id, $D['D5'], 5);
				}

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
			$TABLE = "FGT_FGEN";

			$obj = new stdClass;
			$obj->FGEN_NAME = $H['FGEN_NAME'];
			$obj->FGEN_PROGTYPE = $H['FGEN_PROGTYPE'];
			$obj->FGEN_FOLDER = $H['FGEN_FOLDER'];
			$obj->FGEN_IDENT = $H['FGEN_IDENT'];
			$obj->FGEN_TABLE = $H['FGEN_TABLE'];
			$obj->FGEN_PK = $H['FGEN_PK'];
			$obj->FGEN_ISAUTO = $H['FGEN_ISAUTO'];
			$obj->FGEN_D1NAME = $H['FGEN_D1NAME'];
			$obj->FGEN_D1TABLE = $H['FGEN_D1TABLE'];
			$obj->FGEN_D2NAME = $H['FGEN_D2NAME'];
			$obj->FGEN_D2TABLE = $H['FGEN_D2TABLE'];
			$obj->FGEN_D3NAME = $H['FGEN_D3NAME'];
			$obj->FGEN_D3TABLE = $H['FGEN_D3TABLE'];
			$obj->FGEN_D4NAME = $H['FGEN_D4NAME'];
			$obj->FGEN_D4TABLE = $H['FGEN_D4TABLE'];
			$obj->FGEN_D5NAME = $H['FGEN_D5NAME'];
			$obj->FGEN_D5TABLE = $H['FGEN_D5TABLE'];


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


		public function Save_Detil($id, $d, $tab) {
			$TABLE = "FGT_FGEND";
			if (is_array($d))
			foreach ($d as $row) {
				$obj = new stdClass;
				$obj->FGEND_FIELD = $row['FGEND_FIELD'];
				$obj->FGEND_LABEL = $row['FGEND_LABEL'];
				$obj->FGEND_CONTROL = $row['FGEND_CONTROL'];

				if ($tab>0) {
					$obj->FGEND_ISLIST =0;
					$obj->FGEND_ISSEARCH = 0;
					$obj->FGEND_ISFORM = 0;
				} else {
					$obj->FGEND_ISLIST = $row['FGEND_ISLIST'];
					$obj->FGEND_ISSEARCH = $row['FGEND_ISSEARCH'];
					$obj->FGEND_ISFORM = $row['FGEND_ISFORM'];
				}

				$_LINE  = $row['_LINE'];
				$__STATE = $row['__STATE'];
				switch ($__STATE) {
					case "insert" :
						$obj->{$this->FIELD_ID_MAPPING} = $id;
						$obj->_LINE = $_LINE;
						$obj->FGEND_TAB = $tab;
						$cmd = FGTA_SqlUtil::CreateSQLInsert($TABLE, $obj);
						break;
					case "update" :
						$key = new stdClass;
						$key->{$this->FIELD_ID_MAPPING} = $id;
						$key->_LINE = $_LINE;
						$key->FGEND_TAB  = $tab;
						$cmd = FGTA_SqlUtil::CreateSQLUpdate($TABLE, $obj, $key);
						break;
					case "delete" :
						$key = new stdClass;
						$key->{$this->FIELD_ID_MAPPING} = $id;
						$key->_LINE = $_LINE;
						$key->FGEND_TAB  = $tab;
						$cmd = FGTA_SqlUtil::CreateSQLDelete($TABLE, $key);
						break;
				}

				FGTA_SqlUtil::PDO_Update($this->db, $cmd);
			}

		}


		public function Delete($id) {
			$db = $this->db;
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
			$db->beginTransaction();

			try {

				$TBL = ['FGT_FGEND','FGT_FGEN'];
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


		public function GetLabelName($field, $entity) {
			if (substr($field, 0, strlen($entity)+1) == $entity . '_' ) {
				$label = strtolower(str_replace($entity . '_', '', $field));
				return $label=='id' ? 'ID' : $label;
			} else {
				$t = explode("_", $field);
				return strtolower($t[0]);
			}
		}


		public function LoadTableField($tablename) {

			try {

				$table_prefix = substr($tablename, 0, 4);
				if ($table_prefix!='FGT_' && $table_prefix!='MST_' && $table_prefix!='TRN_' && $table_prefix!='RPT_')
					throw new Exception("Prefix table ($table_prefix) tidak sesuai dengan frmaework");

				$entityname = str_replace($table_prefix, '', $tablename);

				$SQL = "
					SELECT * FROM DEF_TABLE(:TABLE_NAME);
				";

				$stmt = $this->db->prepare($SQL);
				$stmt->execute(array(':TABLE_NAME' => $tablename));
				$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$data = array();
				$i=0;
				foreach ($rows as $row)
				{
					$i++;
					$S = trim($row['FIELD_SOURCE']);

					if (trim($row['FIELD_NAME'])=="_LINE")
						continue;

					$data[] = array(
						'FGEND_FIELD' => trim($row['FIELD_NAME']),
						'FGEND_LABEL' => $this->GetLabelName(trim($row['FIELD_NAME']), $entityname),
						'FGEND_CONTROL' => $S=='BOOLEAN' ? 'checkbox' : 'textbox',
						'FGEND_ISLIST' => 1,
						'FGEND_ISSEARCH' => ($i==1) ? 1 : 0,
						'FGEND_ISFORM' => 1
					);
				}

				$obj = new stdClass;
				$obj->records = $data;

				return $obj;

			} catch (Exception $e) {
				throw new Exception('Error in LoadTableField.\r\n' . $e->getMessage());
			}
		}


		public function Generate($id) {
			require_once "fgta/FGTA_Generator.inc.php";


			$sql = "SELECT
					FGEN_FOLDER, FGEN_IDENT, FGEN_TABLE, FGEN_PK, FGEN_ISAUTO, FGEN_NAME, FGEN_PROGTYPE,
					FGEN_D1NAME, FGEN_D1TABLE,
					FGEN_D2NAME, FGEN_D2TABLE,
					FGEN_D3NAME, FGEN_D3TABLE,
					FGEN_D4NAME, FGEN_D4TABLE,
					FGEN_D5NAME, FGEN_D5TABLE
					FROM FGT_FGEN WHERE FGEN_ID = :FGEN_ID
					";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':FGEN_ID'=>$id));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($rows)==0)
				throw new Exception('Data yang akan di generate tidak ditemukan!');

			$data = $rows[0];

			$det = array();
			$det[1] = array('name'=> $data['FGEN_D1NAME'] , 'table'=> $data['FGEN_D1TABLE']);
			$det[2] = array('name'=> $data['FGEN_D2NAME'] , 'table'=> $data['FGEN_D2TABLE']);
			$det[3] = array('name'=> $data['FGEN_D3NAME'] , 'table'=> $data['FGEN_D3TABLE']);
			$det[4] = array('name'=> $data['FGEN_D4NAME'] , 'table'=> $data['FGEN_D4TABLE']);
			$det[5] = array('name'=> $data['FGEN_D5NAME'] , 'table'=> $data['FGEN_D5TABLE']);


			$sql = "SELECT FGEND_FIELD, FGEND_LABEL, FGEND_CONTROL, FGEND_ISLIST, FGEND_ISSEARCH, FGEND_ISFORM FROM FGT_FGEND WHERE  FGEND_TAB=0 AND FGEN_ID = :FGEN_ID";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':FGEN_ID'=>$id));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$H_FIELDS = array();
			foreach ($rows as $row) {
				$FGEND_FIELD = $row['FGEND_FIELD'];
				$H_FIELDS[$FGEND_FIELD] = array(
					'label' => $row['FGEND_LABEL'],
					'control' => $row['FGEND_CONTROL'],
					'isList' => $row['FGEND_ISLIST'],
					'isSearch' => $row['FGEND_ISSEARCH'],
					'isForm' => $row['FGEND_ISFORM'],
				);
			}


			$gen = new FGTA_Generator();
			$gen->TARGET = __ROOT_DIR."/apps";
			$gen->Folder = $data['FGEN_FOLDER'];
			$gen->fileidentifier =  $data['FGEN_IDENT'];
			$gen->JSClassName =  $data['FGEN_IDENT'] . "Class";
			$gen->HEADER = array(
			    'TABLE' =>  $data['FGEN_TABLE'],
			    'PK' =>  $data['FGEN_PK'],
			    'AUTOINCREMENT' => $data['FGEN_ISAUTO']==1 ? true : false,
			    'FIELDS' => $H_FIELDS
			);


			//cek apakah punya DETIL
			$sql = "SELECT DISTINCT FGEND_TAB FROM FGT_FGEND WHERE  FGEN_ID = :FGEN_ID AND FGEND_TAB>0";
			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':FGEN_ID'=>$id));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($rows)>0) {
				$gen->DETIL = array();
				foreach ($rows as $row) {
					$FGEND_TAB = $row['FGEND_TAB'];
					$TABNAME = $det[$FGEND_TAB]['name'];
					$TABLE = $det[$FGEND_TAB]['table'];

					$sql = "SELECT FGEND_FIELD, FGEND_LABEL, FGEND_CONTROL FROM FGT_FGEND WHERE FGEN_ID = :FGEN_ID AND FGEND_TAB=:FGEND_TAB";
					$stmt = $this->db->prepare($sql);
					$stmt->execute(array(':FGEN_ID'=>$id, ':FGEND_TAB'=>$FGEND_TAB));
					$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$D_FIELDS = array();
					foreach ($rows as $row) {
						$FGEND_FIELD = $row['FGEND_FIELD'];
						$D_FIELDS[$FGEND_FIELD] = array(
							'label' => $row['FGEND_LABEL'],
							'control' => $row['FGEND_CONTROL'],
						);
					}

					$gen->DETIL[$TABNAME] = array(
						'LABEL' => $TABNAME,
						'TABLE' => $TABLE,
						'FIELDS' => $D_FIELDS
					);


				}
			}





			ob_start();
			$ret = $gen->Generate();
			$cntn = ob_get_contents();
			ob_end_clean();




			if (!$ret) {
				echo "_DEBUGTEXT:". nl2br($cntn);
			} else {

				// masukkan ke master Program
				$sql = "SELECT PROGRAM_ID FROM FGT_PROGRAM WHERE PROGRAM_ID = :PROGRAM_ID";
				$stmt = $this->db->prepare($sql);
				$stmt->execute(array(':PROGRAM_ID'=>$id));
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($rows)==0) {
					$prg = new stdClass;
					$prg->PROGRAM_ID = $id;
					$prg->PROGRAM_NAME = $data['FGEN_NAME'];
					$prg->PROGRAM_TYPE = $data['FGEN_PROGTYPE'];
					$prg->PROGRAM_ICON = "";
					$prg->PROGRAM_PATH = "";
					$prg->PROGRAM_NS = $data['FGEN_FOLDER'];
					$prg->PROGRAM_DLL = "";
					$prg->PROGRAM_INSTANCE = $data['FGEN_IDENT'];
					$prg->PROGRAM_DESCRIPTION = '';
					$prg->PROGRAM_ISDISABLED = 0;
					$prg->PROGRAM_ISSINGLEINSTANCE = 1;
					$prg->PROGRAM_ISWEBENABLED = 0;
					$prg->PROGRAM_ISMOBILEENABLED = 0;
					$prg->PROGRAM_ISSYSTEM =0;
					$prg->_CREATEBY = $_SESSION['username'];
					$prg->_CREATEDATE = date("Y-m-d H:i:s");
					$prg->_ROWID = FGTA_SqlUtil::CreateGUID();

					$cmd = FGTA_SqlUtil::CreateSQLInsert("FGT_PROGRAM", $prg);
					FGTA_SqlUtil::PDO_Update($this->db, $cmd);
				}

				$obj = new stdClass;
				$obj->result = 1;
				return $obj;
			}
		}



	}
