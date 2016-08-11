<?php
	if (!defined('__OPENFGTA__'))
		die('Cannot access file directly');


    class FGTA_Control_Checkbox extends FGTA_Control
    {
        function __construct($opt) {
            $this->process_opt($opt);

            if ($this->directrender)
                $this->GenerateHtml();
        }

        public function GenerateHtml($param)
        {
            $htmlclass = "fgta_field";
            $devstyle = "";
            if (is_array($param)) {
                if (array_key_exists('devform', $param)) {
                    if ($param['devform']==true) {
                        $htmlclass .= ' easyui-draggable';
                        $devstyle = 'overflow: hidden;';
                    }
                }
            }

            echo "
            <div id=\"c_".$this->name."\"  fgta-id=\"".$this->name."\" class=\"$htmlclass\" style=\"$devstyle top:".$this->top."px; left:".$this->left."px; width:".$this->width."px; border-bottom: 0px\">
            	<table><tbody><tr><td>
            		<input id=\"".$this->name."\" class=\"css-checkbox-readonly\" type=\"checkbox\" isdisabled=\"false\">
            		<label for=\"".$this->name."\" class=\"css-label-readonly\" style=\"font-size: 8pt\">".$this->label."</label>
            	</td></tr></tbody></table>
            </div>
            ";

        }
    }
