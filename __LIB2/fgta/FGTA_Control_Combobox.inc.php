<?php

    class FGTA_Control_Combobox extends FGTA_Control
    {
        function __construct($opt) {
            $this->process_opt($opt);
            $this->values = array_key_exists('values', $opt) ? $opt['values'] : array();


            $param = array_key_exists('param', $opt) ? $opt['param'] : null;

            if ($this->directrender)
                $this->GenerateHtml($param);
        }

        public function GenerateHtml($param)
        {
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
            <div id=\"c_".$this->name."\" fgta-id=\"".$this->name."\"  class=\"$htmlclass\" style=\"$devstyle top:".$this->top."px; left:".$this->left."px; width:".$this->width."px; \">
                <label class=\"fgta_label\" style=\"width: ".$this->labelwidth."px;\">".$this->label."</label>
                <select id=\"".$this->name."\" class=\"easyui-combobox\" style=\"width:".$this->inputwidth."px;\" data-options=\"".$data_options."\">
            ";

            foreach ($this->values as $val)
            {
                $value = $val[0];
                $display = $val[1];
                echo "<option value=\"".$value."\">".$display."</option>";
            }

            echo "
                </select>
            </div>
            ";

        }

    }
