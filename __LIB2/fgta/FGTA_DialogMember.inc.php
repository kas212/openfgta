<?php
	if (!defined('__OPENFGTA__'))
		die('Cannot access file directly');


    class FGTA_DialogMember
    {
        function __construct($name, $columns, $idmapping, $webserviceurl, $options=null) {
            $this->prefixname = $name;
            $this->title = $name;
            $this->columns = $columns;
            $this->idmapping = $idmapping;
            $this->webserviceurl = $webserviceurl;

            $this->options = $options;
            if (is_array($options)) {
                $this->defaultsearchparam = array_key_exists('DefaultSearch', $options) ? $options['DefaultSearch'] : null;
                $this->webserviceparams = array_key_exists('Params', $options) ? $options['Params'] : null;
            }

        }

        function process_dialog($prefixname) {
            $this->prefixname = $prefixname;
            $this->dialog_id = $this->prefixname . "_dlg";  //"fdlg_Select_" . $name;
            $this->objSearchButtonName =  $this->prefixname . "_dlg_srcButton";   //"fdlg_src_btn_SEARCH" . $name;
            $this->objSearchChkName = $this->prefixname . "_dlg_srcChk";      //"fdlg_src_chk_SEARCH" . $name;
            $this->objSearchTextboxName = $this->prefixname . "_dlg_srcTextbox";      //"fdlg_src_txt_SEARCH" . $name;
            $this->objDgvSearchresult =   $this->prefixname . "_dlg_srcGridResult";  // "fdlg_dgv_SEARCH" . $name;
            $this->jsfn_Init = $this->prefixname . "_fn_Dialog_Init";
            $this->jsfn_DoSearch =  $this->prefixname . "_fn_Dialog_DoSearch";
            $this->jsfn_DialogSelect = $this->prefixname . "_fn_Dialog_Select";

            $this->objSearch = new FGTA_Control_TextboxSearch(['name'=>':SEARCH', 'label'=>'Search', 'button'=>$this->objSearchButtonName ,'checkbox'=>$this->objSearchChkName, 'textbox'=>$this->objSearchTextboxName, 'location'=>[5,0,300], 'mandatory'=>true ]);
        }


        public function JSInit() {
            echo $this->jsfn_Init . "(ui)\r\n";
        }

        public function GenerateHtml() {
            //{Name: ":SEARCH", Value: $('#{__DIALOG_SEARCH_TEXTBOX__}').textbox('getValue'), Checked: $('#{__DIALOG_SEARCH_CHK__}').is(':checked')},

            $tplfile = dirname(__FILE__)."/tpl/dialogmember.html";
            $fp = fopen($tplfile, "r");
            $tpl = fread($fp, filesize($tplfile));

            $tpl = str_replace('{__DIALOG_ID__}', $this->dialog_id, $tpl);
            $tpl = str_replace('{__DIALOG_TITLE__}', $this->title, $tpl);
            $tpl = str_replace('{__DIALOG_SEARCH__}', $this->objSearch->GetHtml(), $tpl);
            $tpl = str_replace('{__DIALOG_SEARCH_BUTTON__}', $this->objSearchButtonName, $tpl);
            $tpl = str_replace('{__DIALOG_SEARCH_CHK__}', $this->objSearchChkName, $tpl);
            $tpl = str_replace('{__DIALOG_SEARCH_TEXTBOX__}', $this->objSearchTextboxName, $tpl);
            $tpl = str_replace('{__DIALOG_SEARCH_DGV__}', $this->objDgvSearchresult, $tpl);
            $tpl = str_replace('{__FN_DIALOG_SELECT__}', $this->jsfn_DialogSelect, $tpl);
            $tpl = str_replace('{__FN_DIALOG_INIT__}', $this->jsfn_Init, $tpl);
            $tpl = str_replace('{__FN_DIALOG_DOSEARCH__}', $this->jsfn_DoSearch, $tpl);
            $tpl = str_replace('{__RETURN_DGV_NAME__}', $this->dgvname, $tpl);
            $tpl = str_replace('{__IDMAPPING__}', $this->idmapping, $tpl);
            $tpl = str_replace('{__WEBSERVICE_URL__}', $this->webserviceurl, $tpl);

            if (isset($this->defaultsearchparam)) {
                if (empty($this->defaultsearchparam)) {
                    $defaultparam = "";
                } else {
                    $defaultparam = "{Name: \"$this->defaultsearchparam\", Value: $('#$this->objSearchTextboxName').textbox('getValue'), Checked: $('#$this->objSearchChkName').is(':checked')},";
                }
            } else {
                $defaultparam = "{Name: \":SEARCH\", Value: $('#$this->objSearchTextboxName').textbox('getValue'), Checked: $('#$this->objSearchChkName').is(':checked')},";
            }

            $tpl = str_replace('{__WEBSERVICE_DEFAULT_PARAM__}', $defaultparam, $tpl);


            $params_string = "";
            if (isset($this->webserviceparams))
                if (is_array($this->webserviceparams)) {
                    foreach ($this->webserviceparams as $key=>$value) {
                        $params_string .= "{Name: \"$key\", Value: $value, Checked: true},\r\n";
                    }
                }


            $tpl = str_replace('{__WEBSERVICE_PARAM__}', $params_string, $tpl);


            $cols = $this->GetColumns();
            $tpl = str_replace('{__DGV_COLUMNS__}',$cols['COLUMNS'], $tpl);
            $tpl = str_replace('{__ROW_RETURN__}',$cols['RETURNS'], $tpl);


            echo $tpl;
        }


        private function GetColumns() {
            $th = "";
            $re = "";
            foreach ($this->columns as $co) {
                $label = $co['label'];
                $mapping = $co['mapping'];
                $width = array_key_exists('width', $co) ? $co['width'] : 100;
                if (array_key_exists('return', $co)) {
                    $return = $co['return'];
                    $re .= "$mapping: $return, \r\n";
                    if ($this->startsWith($return, "row.")) {
                        $th .= $this->CreateColumn($label, $mapping, $width);
                    }
                } else {
                    $th .= $this->CreateColumn($label, $mapping, $width);
                }
            }

            return [
                'COLUMNS' => $th,
                'RETURNS' => $re
            ];
        }

        private function CreateColumn($label, $mapping, $width) {
            return  "<th data-options=\"field:'$mapping', width:$width\"><span style=\"font-size: 7.5pt\">$label</span></th>\r\n";
        }

        function startsWith($haystack, $needle) {
            return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
        }

    }
