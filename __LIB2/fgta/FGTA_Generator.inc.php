<?php
	if (!defined('__OPENFGTA__'))
		die('Cannot access file directly');


    define('__TPL_HTML', dirname(__FILE__)."/gentpl/html.txt");
    define('__TPL_JS', dirname(__FILE__)."/gentpl/js.txt");
    define('__TPL_JS_DGVDETIL_ROWDBLCLICK', dirname(__FILE__)."/gentpl/js_dgvDetil_RowDblClick.txt");
    define('__TPL_JS_BTNROWADD_CLICK', dirname(__FILE__)."/gentpl/js_btnRowAdd_Click.txt");
    define('__TPL_JS_BTNROWREMOVE_CLICK', dirname(__FILE__)."/gentpl/js_btnRowRemove_Click.txt");
    define('__TPL_CLASS', dirname(__FILE__)."/gentpl/class.txt");
    define('__TPL_CLASS_DGVDETIL_CONTRUCT', dirname(__FILE__)."/gentpl/class_dgvdetil_construct.txt");
    define('__TPL_CLASS_OPENDATADETIL_FN', dirname(__FILE__)."/gentpl/class_opendata_detil_fn.txt");
    define('__TPL_CLASS_SAVE_DETIL_FN', dirname(__FILE__)."/gentpl/class_save_detil_fn.txt");


    class FGTA_Generator
    {
		public $HAS_NUMBER_EDITOR = false;


        public $OBJPREFIX = array(
            'textbox' => 'obj_txt_',
            'numberbox' => 'obj_txt_',
            'checkbox' => 'obj_chk_',
            'combobox' => 'obj_cbo_',
            'comboboxremote' => 'obj_cbo_',
            'datebox' => 'obj_dt_',
        );


        public function Gen_HTML() {
            $fp = fopen(__TPL_HTML, "r");
            $tpl = fread($fp, filesize(__TPL_HTML));
            fclose($fp);

            $tpl = str_replace('{__CLASSNAME__}', $this->JSClassName, $tpl);
            $tpl = str_replace('{__DATA__}', $this->Gen_HTML_Data(), $tpl);

            return $tpl;
        }

        public function Gen_HTML_Data() {
            reset($this->HEADER['FIELDS']);

            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isForm = $dat['isForm'];
                $control =  $dat['control'];
                if ($isForm=="1")
                    if ($control=="combobox" || $control=="comboboxremote")
                        $FIELDS[$fieldname] = $dat;
            }

            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            $top = 10;
            while (list($fieldname, $dat) = each($FIELDS)) {
                $objname = $this->OBJPREFIX[$control] . $fieldname ;
                $loadername = $objname . "_Loader";
                $fn .= "'$fieldname': [<?=__SELECTION_DEFAULT?>, <?php \$this->LoadPage_PreloadData('$fieldname'); ?>],\r\n";
            }

            return $fn;
        }


        public function Gen_Class() {
            $fp = fopen(__TPL_CLASS, "r");
            $tpl = fread($fp, filesize(__TPL_CLASS));
            fclose($fp);

            $FIELD_ID = "obj_txt_" . $this->HEADER['PK'];
            $FIELD_ID_MAPPING = $this->HEADER['PK'];
            $FIELD_ID_ISAUTO = $this->HEADER['AUTOINCREMENT'] ? 'true' : 'false';

            $HEADER_TABLE = $this->HEADER['TABLE'];

            $tpl = str_replace('{__PHPCLASSNAME__}', $this->fileidentifier, $tpl);
            $tpl = str_replace('{__FIELD_ID__}', $FIELD_ID, $tpl);
            $tpl = str_replace('{__FIELD_ID_MAPPING__}', $FIELD_ID_MAPPING, $tpl);
            $tpl = str_replace('{__FIELD_ID_ISAUTO__}', $FIELD_ID_ISAUTO, $tpl);
            $tpl = str_replace('{__HEADER_TABLE__}', $HEADER_TABLE, $tpl);
            $tpl = str_replace('{__DGVLIST_COLUMNS__}', $this->Gen_Class_dgvList_Columns(), $tpl);
            $tpl = str_replace('{__DGVLIST_SEARCH__}', $this->Gen_Class_dgvList_Search(), $tpl);
            $tpl = str_replace('{__HEADERFORMOBJECT__}', $this->Gen_Class_HeaderFormObject(), $tpl);
            $tpl = str_replace('{__DGVDETIL_CONSTRUCT__}', $this->Gen_Class_DgvDetil_Construct(), $tpl);
            $tpl = str_replace('{__PRELOAD__}', $this->Gen_Class_PreloadData(), $tpl);
            $tpl = str_replace('{__LOAD_SEARCH__}', $this->Gen_Class_LoadSearch(), $tpl);
            $tpl = str_replace('{__LOAD_SQL_FIELD__}', $this->Gen_Class_LoadSqlField(), $tpl);
            $tpl = str_replace('{__LOAD_SQL_FIELDMAPPING__}', $this->Gen_Class_LoadSqlFieldMapping(), $tpl);
            $tpl = str_replace('{__OPEN_DATADETIL__}', $this->Gen_Class_OpenDataDetil(), $tpl);
            $tpl = str_replace('{__OPEN_DATAHEADERSQL__}', $this->Gen_Class_OpenDataHeaderSQL(), $tpl);
            $tpl = str_replace('{__OPEN_DATAHEADERSQLMAPPING__}', $this->Gen_Class_OpenDataHeaderSQLMapping(), $tpl);
            $tpl = str_replace('{__OPEN_DATADETIL_FN__}', $this->Gen_Class_OpenDataDetilFn(), $tpl);
            $tpl = str_replace('{__SAVE_DETIL__}', $this->Gen_Class_SaveDetil(), $tpl);
            $tpl = str_replace('{__SAVE_HEADER__}', $this->Gen_Class_SaveHeader(), $tpl);
            $tpl = str_replace('{__SAVE_DETIL_FN__}', $this->Gen_Class_SaveDetilFn(), $tpl);
            $tpl = str_replace('{__DELETE_TABLE_LIST__}', $this->Gen_Class_DeleteTable(), $tpl);
			$tpl = str_replace('{__JSMODULE_LOADER__}', $this->Gen_Class_JsModuleLoader(), $tpl);



            return $tpl;
        }

        public function Gen_Class_dgvList_Columns() {
            reset($this->HEADER['FIELDS']);

            $tpl = "['label'=>'{__LABEL__}', 'mapping'=>'{__MAPPING__}', 'options'=>'width:100']";



            //ambil header yang akan digunakan sebagai list data
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isList = $dat['isList'];
                if ($isList=="1")
                    $FIELDS[$fieldname] = $dat;
            }

            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            while (list($fieldname, $dat) = each($FIELDS)) {
                $label = $dat['label'];
                $fndetil = str_replace('{__LABEL__}', $label, $tpl);
                $fndetil = str_replace('{__MAPPING__}', $fieldname, $fndetil);
                $fn .= ($i>0 ? "\t\t\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? ",\r\n":"";
                $i++;
            }

            return $fn;
        }

        public function Gen_Class_PreloadData() {

            reset($this->HEADER['FIELDS']);

            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isForm = $dat['isForm'];
                $control =  $dat['control'];
                if ($isForm=="1")
                    if ($control=="combobox" || $control=="comboboxremote")
                        $FIELDS[$fieldname] = $dat;
            }

            $fn = "";
            if (count($FIELDS) > 0) {
                $fn  = "public function LoadPage_PreloadData(\$dataid) {\r\n";
                $fn .= "\t\t\t\$F = null;\r\n\r\n";
                $fn .= "\t\t\tswitch(\$dataid) {\r\n";
                $i = 0;
                $n = count($FIELDS) - 1;
                $top = 10;
                while (list($fieldname, $dat) = each($FIELDS)) {
                    //$objname = $this->OBJPREFIX[$control] . $fieldname ;
                    //$loadername = $objname . "_Loader";
                    $fn .= "\t\t\t\tcase '$fieldname' :\r\n";
                    $fn .= "\t\t\t\t\tbreak;\r\n\r\n";
                }
                $fn .= "\t\t\t}\r\n\r\n\t\t\t";
                $fn .= '$this->DoDefaultPreLoad($F);';
                $fn .= "\r\n";
                $fn .= "\t\t}\r\n";
            }



            return $fn;
        }


        public function Gen_Class_dgvList_Search() {
            reset($this->HEADER['FIELDS']);

            $tpl_text = "new FGTA_Control_TextboxSearch(['name'=>':{__MAPPING__}', 'label'=>'{__LABEL__}', 'checkbox'=>'{__CHECKBOXNAME__}', 'textbox'=>'{__TEXTBOXNAME__}' ])";
            $tpl_combo = "new FGTA_Control_ComboboxSearch(['name'=>':{__MAPPING__}', 'label'=>'{__LABEL__}', 'checkbox'=>'{__CHECKBOXNAME__}', 'textbox'=>'{__TEXTBOXNAME__}', 'options'=>\"editable:false,valueField:'id',textField:'text',data:DATA['{__NAME__}']\" ])";


            //ambil header yang akan digunakan sebagai list data
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isSearch = $dat['isSearch'];
                if ($isSearch=="1")
                    $FIELDS[$fieldname] = $dat;
            }

            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            $top = 10;
            while (list($fieldname, $dat) = each($FIELDS)) {
                $label = $dat['label'];
                $control =  $dat['control'];

                $obj_chkname = "src_chk_" . $fieldname;
                $obj_txtname = "src_txt_" . $fieldname;

                $tpl = ($control=='combobox' || $control=='comboboxremote') ? $tpl_combo : $tpl_text;

                $fndetil = str_replace('{__LABEL__}', $label, $tpl);
                $fndetil = str_replace('{__MAPPING__}', $fieldname, $fndetil);
                $fndetil = str_replace('{__CHECKBOXNAME__}', $obj_chkname, $fndetil);
                $fndetil = str_replace('{__TEXTBOXNAME__}', $obj_txtname, $fndetil);
                $fndetil = str_replace('{__TOP__}', $top, $fndetil);
                $fndetil = str_replace('{__NAME__}', $fieldname, $fndetil);

                $fn .= ($i>0 ? "\t\t\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? ",\r\n":"";
                $i++;

                $top += 27;
            }

            return $fn;
        }

        public function Gen_Class_HeaderFormObject() {
            reset($this->HEADER['FIELDS']);

            $tpl = array();
            $tpl['textbox']  = "new FGTA_Control_Textbox(['name'=>'{__OBJNAME__}', 'label'=>'{__LABEL__}',  'options'=>\"\" ]),";
            $tpl['checkbox'] = "new FGTA_Control_Checkbox(['name'=>'{__OBJNAME__}', 'label'=>'{__LABEL__}' ]),";
            $tpl['combobox'] = "new FGTA_Control_Combobox(['name'=>'{__OBJNAME__}', 'label'=>'{__LABEL__}', 'options'=>\"editable:false,valueField:'id',textField:'text',data:DATA['{__NAME__}']\" ]),";
            $tpl['comboboxremote'] = "new FGTA_Control_Combobox(['name'=>'{__OBJNAME__}', 'label'=>'{__LABEL__}', 'options'=>\"mode:'remote',valueField:'id',textField:'text',data:DATA['{__NAME__}'],loader:{__LOADER_NAME__}\" ]),";
            $tpl['numberbox']  = "new FGTA_Control_Numberbox(['name'=>'{__OBJNAME__}', 'label'=>'{__LABEL__}',  'options'=>\"align:'right', formatter:function(value, row){ return accounting.formatMoney(value, '', 0); }\" ]),";
            $tpl['datebox']  = "new FGTA_Control_Datebox(['name'=>'{__OBJNAME__}', 'label'=>'{__LABEL__}',  'options'=>\"\" ]),";


            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isForm = $dat['isForm'];
                if ($isForm=="1")
                    $FIELDS[$fieldname] = $dat;
            }


            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            $top = 10;
            while (list($fieldname, $dat) = each($FIELDS)) {
                $label = $dat['label'];
                $control =  $dat['control'];
                $objname = $this->OBJPREFIX[$control] . $fieldname ;
                $loadername = $objname . "_Loader";


				if ($control=='numberbox')
					$this->HAS_NUMBER_EDITOR = true;


                $fndetil = str_replace('{__LABEL__}', $label, $tpl[$control]);
                $fndetil = str_replace('{__OBJNAME__}', $objname, $fndetil);
                $fndetil = str_replace('{__TOP__}', $top, $fndetil);

                $fndetil = str_replace('{__NAME__}', $fieldname, $fndetil);
                $fndetil = str_replace('{__LOADER_NAME__}', $loadername, $fndetil);

                $fn .= ($i>0 ? "\t\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? "\r\n":"";
                $i++;

                $top += 27;
            }

            return $fn;
        }

        public function Gen_Class_DgvDetil_Construct() {

            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $fp = fopen(__TPL_CLASS_DGVDETIL_CONTRUCT, "r");
            $tpl = fread($fp, filesize(__TPL_CLASS_DGVDETIL_CONTRUCT));
            fclose($fp);

            $fn = "";
            while (list($key, $dat) = each($this->DETIL)) {
                $dgv_name = "dgv_$key";
                $label = $dat['LABEL'];
                $FIELDS = $dat['FIELDS'];

                $tpl_detil = "['label'=>'{__LABEL__}', 'mapping'=>'{__MAPPING__}', 'options'=>\"width:100, {__EDITOR__}\"]";
                $fn_column = "";
                $i = 0;
                $n = count($FIELDS) - 1;
                while (list($detid, $detdat) = each($FIELDS)) {
                    $labeldetil =  $detdat['label'];
					$controldetil = $detdat['control'];

					$editor = "";
					switch ($controldetil) {
						case 'numberbox' :
							$editor = "align:'right', editor:{type:'numberbox', options:{readonly: false, groupSeparator:','}}, formatter:function(value, row){ return accounting.formatMoney(value, '', 0); }";
							$this->HAS_NUMBER_EDITOR = true;
							break;
						case 'combobox' :
							$editor = "editor:{type:'combobox', options:{readonly:false, editable:false, valueField:'id', textField:'text'}}";
							break;
						default:
							$editor = "editor:{type:'textbox', options:{readonly: false}}";
					}

                    $fn_column_detil = str_replace('{__LABEL__}', $labeldetil, $tpl_detil);
                    $fn_column_detil = str_replace('{__MAPPING__}', $detid, $fn_column_detil);
					$fn_column_detil = str_replace('{__EDITOR__}', $editor, $fn_column_detil);
                    $fn_column .= ($i>0 ? "\t\t\t\t\t":""). "$fn_column_detil";
                    $fn_column .= ($i<$n) ? ",\r\n":"";
                    $i++;
                }

                $fndetil = str_replace('{__DGVDETIL__}', $dgv_name, $tpl);
                $fndetil = str_replace('{__LABEL__}', $label, $fndetil);
                $fndetil = str_replace('{__COLUMNS__}', $fn_column, $fndetil);

                $fn .= "$fndetil\r\n";
            }
            return $fn;
        }

        public function Gen_Class_LoadSearch() {
            reset($this->HEADER['FIELDS']);

            $tpl_text = "\":{__LOSEARCHMAPPING__}\" => [\"{__LOSEARCHMAPPING__} LIKE  '%%' || %s || '%%'\"]";
            $tpl_combo = "\":{__LOSEARCHMAPPING__}\" => [\"{__LOSEARCHMAPPING__} = %s\"]";

            //ambil header yang akan digunakan sebagai list data
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isSearch = $dat['isSearch'];
                if ($isSearch=="1")
                    $FIELDS[$fieldname] = $dat;
            }

            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            while (list($fieldname, $dat) = each($FIELDS)) {
                $control =  $dat['control'];

                $tpl = ($control=='combobox' || $control=='comboboxremote') ? $tpl_combo : $tpl_text;

                $fndetil = str_replace('{__LOSEARCHMAPPING__}', $fieldname, $tpl);
                $fn .= ($i>0 ? "\t\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? ",\r\n":"";
                $i++;
            }

            return $fn;
        }

        public function Gen_Class_LoadSqlField() {
            reset($this->HEADER['FIELDS']);

            //ambil header yang akan digunakan sebagai list data
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isList = $dat['isList'];
                if ($isList=="1")
                    $FIELDS[] = $fieldname;
            }

            $fn = implode(", ", $FIELDS);

            return $fn;
        }

        public function Gen_Class_LoadSqlFieldMapping() {
            reset($this->HEADER['FIELDS']);

            $tpl_text = "'{__MAPPING__}' => \$row['{__MAPPING__}']";
            $tpl_date = "'{__MAPPING__}' => FGTA_SqlUtil::ToJSDate(\$row['{__MAPPING__}'])";



            //ambil header yang akan digunakan sebagai list data
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isList = $dat['isList'];
                if ($isList=="1")
                    $FIELDS[$fieldname] = $dat;
            }

            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            while (list($fieldname, $dat) = each($FIELDS)) {

                $control =  $dat['control'];
                $tpl = ($control=='datebox') ? $tpl_date : $tpl_text;

                $fndetil = str_replace('{__MAPPING__}', $fieldname, $tpl);
                $fn .= ($i>0 ? "\t\t\t\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? ",\r\n":"";
                $i++;
            }

            return $fn;
        }

        public function Gen_Class_OpenDataDetil() {

            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $tpl = "'{__DETILNAME__}' => \$this->OpenData_Detil{__DETILNAME__}(\$id)";

            $fn = "";
            $i = 0;
            $n = count($this->DETIL) - 1;
            while (list($key, $dat) = each($this->DETIL)) {
                $fndetil = str_replace('{__DETILNAME__}', $key, $tpl);
                $fn .= ($i>0 ? "\t\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? ",\r\n":"";
                $i++;
            }

            return $fn;


        }

        public function Gen_Class_OpenDataHeaderSQL() {
            reset($this->HEADER['FIELDS']);

            //ambil header yang akan digunakan sebagai list data
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isForm = $dat['isForm'];
                if ($isForm=="1")
                    $FIELDS[] = $fieldname;
            }

            $fn = implode(", ", $FIELDS);

            return $fn;
        }

        public function Gen_Class_OpenDataHeaderSQLMapping() {
            reset($this->HEADER['FIELDS']);

            $tpl_text = "\$obj->{__MAPPING__} = \$row['{__MAPPING__}'];";
            $tpl_date = "\$obj->{__MAPPING__} = FGTA_SqlUtil::ToJSDate(\$row['{__MAPPING__}']);";


            //ambil header yang akan digunakan sebagai list data
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isForm = $dat['isForm'];
                if ($isForm=="1")
                    $FIELDS[$fieldname] = $dat;
            }

            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            while (list($fieldname, $dat) = each($FIELDS)) {

                $control =  $dat['control'];
                $tpl = ($control=='datebox') ? $tpl_date : $tpl_text;

                $fndetil = str_replace('{__MAPPING__}', $fieldname, $tpl);
                $fn .= ($i>0 ? "\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? "\r\n":"";
                $i++;
            }

            return $fn;
        }

        public function Gen_Class_OpenDataDetilFn() {

            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $FIELD_ID_MAPPING = $this->HEADER['PK'];

            $fp = fopen(__TPL_CLASS_OPENDATADETIL_FN, "r");
            $tpl = fread($fp, filesize(__TPL_CLASS_OPENDATADETIL_FN));
            fclose($fp);

            $fn = "";
            while (list($key, $dat) = each($this->DETIL)) {
                $FIELDS = $dat['FIELDS'];
                $TABLE = $dat['TABLE'];

                $cols = array();
                $tpl_detil = "'{__MAPPING__}' => \$row['{__MAPPING__}']";
                $fn_column = "";
                $i = 0;
                $n = count($FIELDS) - 1;
                while (list($detid, $detdat) = each($FIELDS)) {
                    $cols[] = $detid;
                    $fn_column_detil = str_replace('{__MAPPING__}', $detid, $tpl_detil);
                    $fn_column .= ($i>0 ? "\t\t\t\t\t\t":""). "$fn_column_detil";
                    $fn_column .= ($i<$n) ? ",\r\n":"";
                    $i++;
                }

                $fndetil = str_replace('{__DETILNAME__}', $key, $tpl);
                $fndetil = str_replace('{__DETIL_SQL__}', implode(", ", $cols), $fndetil);
                $fndetil = str_replace('{__DETILTABLE__}', $TABLE, $fndetil);
                $fndetil = str_replace('{__FIELD_ID_MAPPING__}', $FIELD_ID_MAPPING, $fndetil);
                $fndetil = str_replace('{__DETIL_SQL_MAPPING__}', $fn_column, $fndetil);




                $fn .= "$fndetil\r\n";
            }


            return $fn;
        }

        public function Gen_Class_SaveDetil() {

            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $tpl = "if (array_key_exists('{__DETILNAME__}', \$D)) \$this->Save_Detil{__DETILNAME__}(\$id, \$D['{__DETILNAME__}']);";

            $fn = "";
            $i = 0;
            $n = count($this->DETIL) - 1;
            while (list($key, $dat) = each($this->DETIL)) {
                $fndetil = str_replace('{__DETILNAME__}', $key, $tpl);
                //$fn .= ($i==0) ? "\t\t\tif (is_array(\$D)) {\r\n" : "";
                $fn .= (($i>0) ? "\t\t\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? "\r\n":"";
                //$fn .= ($i==$n) ? "\t\t\t\r\n}\r\n" : "";
                $i++;
            }


            if (count($this->DETIL)>0)
                return "\r\n\t\t\t\tif(is_array(\$D)) {\r\n\t\t\t\t\t" . $fn ."\r\n\t\t\t\t}\r\n";
            else
                return $fn;



        }

        public function Gen_Class_SaveHeader() {
            reset($this->HEADER['FIELDS']);

            $tpl_text = "\$obj->{__MAPPING__} = \$H['{__MAPPING__}'];";
            $tpl_date = "\$obj->{__MAPPING__} = FGTA_SqlUtil::ToSQLDate(\$H['{__MAPPING__}']);";



            //ambil header yang akan digunakan sebagai list data
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isForm = $dat['isForm'];
                if ($isForm=="1")
                    if ($fieldname!=$this->HEADER['PK'])
                        $FIELDS[$fieldname] = $dat;
            }

            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            while (list($fieldname, $dat) = each($FIELDS)) {

                $control =  $dat['control'];
                $tpl = ($control=='datebox') ? $tpl_date : $tpl_text;

                $fndetil = str_replace('{__MAPPING__}', $fieldname, $tpl);
                $fn .= ($i>0 ? "\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? "\r\n":"";
                $i++;
            }

            return $fn;
        }

        public function Gen_Class_SaveDetilFn() {
            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $fp = fopen(__TPL_CLASS_SAVE_DETIL_FN, "r");
            $tpl = fread($fp, filesize(__TPL_CLASS_SAVE_DETIL_FN));
            fclose($fp);

            $fn = "";
            while (list($key, $dat) = each($this->DETIL)) {
                $FIELDS = $dat['FIELDS'];
                $TABLE = $dat['TABLE'];


                $cols = array();
                $tpl_detil = "\$obj->{__MAPPING__} = {__CAST__}\$row['{__MAPPING__}'];";
                $fn_column = "";
                $i = 0;
                $n = count($FIELDS) - 1;
                while (list($detid, $detdat) = each($FIELDS)) {
                    $cols[] = $detid;
					$control = $detdat['control'];

					if ($control=='numberbox')
						$cast = "(float)";
					else
						$cast = "";


                    $fn_column_detil = str_replace('{__MAPPING__}', $detid, $tpl_detil);
					$fn_column_detil = str_replace('{__CAST__}', $cast, $fn_column_detil);
                    $fn_column .= ($i>0 ? "\t\t\t\t":""). "$fn_column_detil";
                    $fn_column .= ($i<$n) ? "\r\n":"";
                    $i++;
                }

                $fndetil = str_replace('{__DETILNAME__}', $key, $tpl);
                $fndetil = str_replace('{__DETIL_SQL_MAPPING__}', $fn_column, $fndetil);
                $fndetil = str_replace('{__DETILTABLE__}', $TABLE, $fndetil);


                $fn .= "$fndetil\r\n";
            }


            return $fn;
        }

        public function Gen_Class_DeleteTable() {
            $TABLES = array();
            if (property_exists($this, 'DETIL'))
                if (is_array($this->DETIL)) {
                    reset($this->DETIL);
                    while (list($key, $dat) = each($this->DETIL)) {
                        $TABLES[] = "'" . $dat['TABLE'] . "'";
                    }
                }

            $TABLES[] = "'" .  $this->HEADER['TABLE'] . "'";

            return implode(",", $TABLES);
        }

		public function Gen_Class_JsModuleLoader() {
			$jsmodules = "";
			if ($this->HAS_NUMBER_EDITOR) {
				$jsmodules .= "\$this->Scripts->load(\"accounting.min.js\", \"js\");\r\n";
			}

			return $jsmodules;
		}


        public function Gen_JS() {
            $fp = fopen(__TPL_JS, "r");
            $tpl = fread($fp, filesize(__TPL_JS));
            fclose($fp);

            $tpl = str_replace('{__CLASSNAME__}', $this->JSClassName, $tpl);
            $tpl = str_replace('{__NS__}', $this->Folder, $tpl);
            $tpl = str_replace('{__CL__}', $this->fileidentifier, $tpl);
            $tpl = str_replace('{__IDFIELD__}', "obj_txt_" . $this->HEADER['PK'], $tpl);
            $tpl = str_replace('{__DGVDETIL_ROWDBLCLICK__}', $this->Gen_JS_DGVDETIL_ROWDBLCLICK(), $tpl);
            $tpl = str_replace('{__DGVDETIL_SAVE__}', $this->Gen_JS_DGVDETIL_SAVE(), $tpl);
            $tpl = str_replace('{__BTNROWADD_CLICK__}', $this->Gen_JS_BTNROWADD_CLICK(), $tpl);
            $tpl = str_replace('{__BTNROWREMOVE_CLICK__}', $this->Gen_JS_BTNROWREMOVE_CLICK(), $tpl);
            $tpl = str_replace('{__OPENDATA_DETIL__}', $this->Gen_JS_OPENDATA_DETIL(), $tpl);
            $tpl = str_replace('{__HEADER_SAVE__}', $this->Gen_JS_HEADER_SAVE(), $tpl);
            $tpl = str_replace('{__OPENDATA_HEADER__}', $this->Gen_JS_OPENDATA_HEADER(), $tpl);




            return $tpl;
        }

        public function Gen_JS_DGVDETIL_ROWDBLCLICK() {

            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $fp = fopen(__TPL_JS_DGVDETIL_ROWDBLCLICK, "r");
            $tpl = fread($fp, filesize(__TPL_JS_DGVDETIL_ROWDBLCLICK));
            fclose($fp);

            $fn = "";
            while (list($key, $dat) = each($this->DETIL)) {
                $dgv_name = "dgv_$key";
                $fndetil = str_replace('{__DGVDETIL__}', $dgv_name, $tpl);
                $fn .= "$fndetil\r\n";
            }
            return $fn;
        }

        public function Gen_JS_HEADER_SAVE() {
            reset($this->HEADER['FIELDS']);

            $tpl = array();
            $tpl['textbox']  = "{__FIELDNAME__}: ui.Editor.{__OBJNAME__}.textbox('getValue'),";
            $tpl['checkbox'] = "{__FIELDNAME__}: (ui.Editor.{__OBJNAME__}.is(':checked')) ? 1 : 0,";
            $tpl['combobox']  = "{__FIELDNAME__}: ui.Editor.{__OBJNAME__}.combobox('getValue'),";
            $tpl['comboboxremote']  = "{__FIELDNAME__}: ui.Editor.{__OBJNAME__}.combobox('getValue'),";
            $tpl['numberbox']  = "{__FIELDNAME__}: ui.Editor.{__OBJNAME__}.numberbox('getValue'),";
            $tpl['datebox']  = "{__FIELDNAME__}: ui.Editor.{__OBJNAME__}.datebox('getValue'),";


            //ambil header yang akan digunakan sebagai list form
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isForm = $dat['isForm'];
                if ($isForm=="1")
                    $FIELDS[$fieldname] = $dat;
            }

            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            while (list($fieldname, $dat) = each($FIELDS)) {
                $label = $dat['label'];
                $control =  $dat['control'];
                $objname = $this->OBJPREFIX[$control] . $fieldname ;

                $fndetil = str_replace('{__FIELDNAME__}', $fieldname, $tpl[$control]);
                $fndetil = str_replace('{__OBJNAME__}', $objname, $fndetil);
                $fn .= ($i>0 ? "\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? "\r\n":"";
                $i++;
            }

            return $fn;
        }

        public function Gen_JS_DGVDETIL_SAVE() {

            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $tpl = "{__DETILNAME__}: ui.{__DGVDETIL__}.datagrid('getChanges')";
            $fn = "";
            $i = 0;
            $n = count($this->DETIL) - 1;
            while (list($key, $dat) = each($this->DETIL)) {
                $dgv_name = "dgv_$key";
                $fndetil = str_replace('{__DGVDETIL__}', $dgv_name, $tpl);
                $fndetil = str_replace('{__DETILNAME__}', $key, $fndetil);
                $fn .= ($i>0 ? "\t\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? ",\r\n":"";
                $i++;
            }

            return $fn;
        }

        public function Gen_JS_BTNROWADD_CLICK() {

            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $fp = fopen(__TPL_JS_BTNROWADD_CLICK, "r");
            $tpl = fread($fp, filesize(__TPL_JS_BTNROWADD_CLICK));
            fclose($fp);

            $fn = "";
            while (list($key, $dat) = each($this->DETIL)) {
                $dgv_name = "dgv_$key";
                $fndetil = str_replace('{__DGVDETIL__}', $dgv_name, $tpl);
                $fndetil = str_replace('{__DETILNAME__}', $key, $fndetil);
                $fn .= "$fndetil\r\n";
            }
            return $fn;

        }

        public function Gen_JS_BTNROWREMOVE_CLICK() {

            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $fp = fopen(__TPL_JS_BTNROWREMOVE_CLICK, "r");
            $tpl = fread($fp, filesize(__TPL_JS_BTNROWREMOVE_CLICK));
            fclose($fp);

            $fn = "";
            while (list($key, $dat) = each($this->DETIL)) {
                $dgv_name = "dgv_$key";
                $fndetil = str_replace('{__DGVDETIL__}', $dgv_name, $tpl);
                $fndetil = str_replace('{__DETILNAME__}', $key, $fndetil);
                $fn .= "$fndetil\r\n";
            }
            return $fn;

        }

        public function Gen_JS_OPENDATA_DETIL() {

            if (!property_exists($this, 'DETIL'))
                return "";

            if (!is_array($this->DETIL))
                return "";

            reset($this->DETIL);

            $tpl = "ui.{__DGVDETIL__}.datagrid('loadData', data.DETIL.{__DETILNAME__}.records);\r\n\t\t\t\t"
                 . "ui.{__DGVDETIL__}.maxline = data.DETIL.{__DETILNAME__}.maxline;\r\n";

            $fn = "";
            $i = 0;
            $n = count($this->DETIL) - 1;
            while (list($key, $dat) = each($this->DETIL)) {
                $dgv_name = "dgv_$key";
                $fndetil = str_replace('{__DGVDETIL__}', $dgv_name, $tpl);
                $fndetil = str_replace('{__DETILNAME__}', $key, $fndetil);
                $fn .= ($i>0 ? "\t\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? "\r\n":"";
                $i++;
            }

            return $fn;
        }

        public function Gen_JS_OPENDATA_HEADER() {
            reset($this->HEADER['FIELDS']);

            $tpl = array();
            $tpl['textbox']  = "ui.Editor.setValue(ui.Editor.{__OBJNAME__}, data.{__FIELDNAME__});";
            $tpl['checkbox'] = "ui.Editor.setValue(ui.Editor.{__OBJNAME__}, data.{__FIELDNAME__}==1 ? true : false);";
            $tpl['combobox']  = "ui.Editor.setValue(ui.Editor.{__OBJNAME__}, data.{__FIELDNAME__});";
            $tpl['comboboxremote']  = "ui.Editor.setValue(ui.Editor.{__OBJNAME__}, data.{__FIELDNAME__});";
            $tpl['numberbox']  = "ui.Editor.setValue(ui.Editor.{__OBJNAME__}, data.{__FIELDNAME__});";
            $tpl['datebox']  = "ui.Editor.setValue(ui.Editor.{__OBJNAME__}, data.{__FIELDNAME__});";


            //ambil header yang akan digunakan sebagai list form
            $FIELDS = array();
            while (list($fieldname, $dat) = each($this->HEADER['FIELDS'])) {
                $isForm = $dat['isForm'];
                if ($isForm=="1")
                    $FIELDS[$fieldname] = $dat;
            }


            $fn = "";
            $i = 0;
            $n = count($FIELDS) - 1;
            while (list($fieldname, $dat) = each($FIELDS)) {
                $label = $dat['label'];
                $control =  $dat['control'];
                $objname = $this->OBJPREFIX[$control] . $fieldname ;

                $fndetil = str_replace('{__FIELDNAME__}', $fieldname, $tpl[$control]);
                $fndetil = str_replace('{__OBJNAME__}', $objname, $fndetil);
                $fn .= ($i>0 ? "\t\t\t":""). "$fndetil";
                $fn .= ($i<$n) ? "\r\n":"";
                $i++;
            }

            return $fn;
        }



        public function Generate() {
            try {
                //cek apakah folder ada
                echo "Check Target Folder '".$this->TARGET."' ...";
                if (!is_dir($this->TARGET))
                    throw new Exception("Folder tidak ditemukan");
                echo "OK.\r\n";

                $NSFolder = $this->TARGET . "/" . $this->Folder;
                echo "Check NS Folder '".$this->Folder."' ...";
                if (!is_dir($NSFolder)) {
                    echo "\r\n";
                    echo "  => Folder not exist.\r\n";
                    echo "     Try creating new one... ";
                    mkdir($NSFolder);
                    echo "OK.\r\n";
                } else {
                    echo "OK.\r\n";
                }


                $files = [
                    $this->fileidentifier . ".html.php",
                    $this->fileidentifier . ".class.php",
                    $this->fileidentifier . ".js"
                ];



                $allowtimpa = [
                    'assettest.class.php'=>1,
                    'assettest.html.php'=>1,
                    'assettest.js'=>1
                ];



                foreach ($files as $filename)
                {
                    $file = $NSFolder . "/" . $filename;
                    echo "Check file '".$filename."' ...";

                    $timpa = 0;
                    if (isset($allowtimpa))
                        if (is_array($allowtimpa))
                            $timpa = array_key_exists($filename, $allowtimpa) ? $allowtimpa[$filename] : 0;


                    if (!$timpa)
                        if (is_file($file))
                            throw new Exception("File already exist.");


                    echo "OK.\r\n";
                }

                reset($files);

                $html = $this->Gen_HTML();
                $class = $this->Gen_Class();
                $js = $this->Gen_JS();



                echo "Creating HTML... ";
				$file = $NSFolder . "/" . $this->fileidentifier . ".html.php";
                $fp = fopen($file, "w");
                fwrite($fp, $html);
                fclose($fp);
				chmod($file, 0777);
                echo "OK\r\n";

                echo "Creating Class... ";
				$file = $NSFolder . "/" . $this->fileidentifier . ".class.php";
                $fp = fopen($file, "w");
                fwrite($fp, $class);
                fclose($fp);
				chmod($file, 0777);
                echo "OK\r\n";

                echo "Creating JS... ";
				$file = $NSFolder . "/" . $this->fileidentifier . ".js";
                $fp = fopen($NSFolder . "/" . $this->fileidentifier . ".js", "w");
                fwrite($fp, $js);
                fclose($fp);
				chmod($file, 0777);
                echo "OK\r\n";


                return true;

            } catch (Exception $ex) {
                echo $ex->getMessage()."\r\n\r\n\r\n";
            }

        }



    }
