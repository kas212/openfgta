<?php
	if (!defined('__OPENFGTA__'))
		die('Cannot access file directly');


    class FGTA_Control_File extends FGTA_Control
    {
        function __construct($opt) {
            $this->process_opt($opt);

            $this->suppress = array_key_exists('suppress', $opt) ? $opt['suppress'] : false;
            $param = array_key_exists('param', $opt) ? $opt['param'] : null;

            if ($this->directrender)
                $this->GenerateHtml($param);
        }

        public function GenerateHtml($param)
        {
            if ($this->suppress)
                return;

            //onChange: function(newValue,oldValue) { ui.Editor.dataChanges(newValue,oldValue) },
            $htmlclass = "fgta_field";
            $devstyle = "";
            $data_options = $this->options;
            if (is_array($param)) {
                if (array_key_exists('devform', $param)) {
                    if ($param['devform']==true) {
                        $htmlclass .= ' easyui-draggable';
                        $devstyle = 'overflow: hidden;';
                        $data_options = '';
                    }
                }
            }


            echo "
            <div id=\"c_".$this->name."\"  fgta-id=\"".$this->name."\" class=\"$htmlclass\" style=\"$devstyle top:".$this->top."px; left:".$this->left."px; width:".$this->width."px; \">
                <label class=\"fgta_label\" style=\"width: ".$this->labelwidth."px;\">".$this->label."</label>
                <input class=\"easyui-filebox c6\" id=\"".$this->name."\" style=\"width:".$this->inputwidth."px;\" data-options=\"".$data_options."\">
            </div>
            ";

        }
    }
