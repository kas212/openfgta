<?php

    class FGTA_Control_Numberbox extends FGTA_Control
    {
        function __construct($opt) {
            $this->process_opt($opt);

            $this->maxlength = array_key_exists('maxlength', $opt) ? $opt['maxlength'] : '';

            if ($this->directrender)
                $this->GenerateHtml();
        }

        public function GenerateHtml($param)
        {
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

            if ($this->maxlength != '')
                $max = " maxlength=\"".$this->maxlength."\" ";
            else
                $max = "";

            echo "
            <div id=\"c_".$this->name."\"  fgta-id=\"".$this->name."\" class=\"$htmlclass\" style=\"$devstyle top:".$this->top."px; left:".$this->left."px; width:".$this->width."px; \">
                <label class=\"fgta_label\" style=\"width: ".$this->labelwidth."px;\">".$this->label."</label>
                <input class=\"easyui-numberbox\" id=\"".$this->name."\" style=\"width:".$this->inputwidth."px;\"  $max data-options=\"".$data_options."\">
            </div>
            ";

        }
    }
