<?php

    class FGTA_Control_Datebox extends FGTA_Control
    {
        function __construct($opt) {
            $this->process_opt($opt);

            if ($this->directrender)
                $this->GenerateHtml(null);
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
            <div fgta-id=\"".$this->name."\" class=\"$htmlclass\" style=\"$devstyle top:".$this->top."px; left:".$this->left."px; width:".$this->width."px; \">
                <label class=\"fgta_label\" style=\"width: ".$this->labelwidth."px;\">".$this->label."</label>
                <input class=\"easyui-datebox\" id=\"".$this->name."\" style=\"width:".$this->inputwidth."px;\" data-options=\"".$data_options."\">
            </div>
            ";

        }
    }
