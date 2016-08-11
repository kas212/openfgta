<?php
	if (!defined('__OPENFGTA__'))
		die('Cannot access file directly');


    class FGTA_Control_Textbox extends FGTA_Control
    {
        function __construct($opt) {
            $this->process_opt($opt);

            $this->maxlength = array_key_exists('maxlength', $opt) ? $opt['maxlength'] : '';
            $this->button = array_key_exists('button', $opt) ? $opt['button'] : null;
            $this->buttonlabel = array_key_exists('buttonlabel', $opt) ? $opt['buttonlabel'] : 'button';
            $this->buttonwidth = array_key_exists('buttonwidth', $opt) ? $opt['buttonwidth'] : '50';
            $this->suppress = array_key_exists('suppress', $opt) ? $opt['suppress'] : false;
            $this->password = array_key_exists('password', $opt) ? $opt['password'] : false;

            $param = array_key_exists('param', $opt) ? $opt['param'] : null;


            if ($this->directrender)
                $this->GenerateHtml($param);
        }

        public function GenerateHtml($param)
        {
            if ($this->suppress)
                return;

            $buttonhtml = "";
            if ($this->button!=null) {
                $buttonhtml = "<a href=\"#\" id=\"".$this->button."\" class=\"easyui-linkbutton c8\" style=\"width:$this->buttonwidth"."px; height:22px\">$this->buttonlabel</a>";
                $this->inputwidth = $this->inputwidth - ($this->buttonwidth + 5);
            }

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


            $input_type_password = "";
            if ($this->password) {
                $input_type_password = "type=\"password\"";
            }

            echo "
            <div id=\"c_".$this->name."\"  fgta-id=\"".$this->name."\" class=\"$htmlclass\" style=\"$devstyle top:".$this->top."px; left:".$this->left."px; width:".$this->width."px; \">
                <label class=\"fgta_label\" style=\"width: ".$this->labelwidth."px;\">".$this->label."</label>
                <input class=\"easyui-textbox\" id=\"".$this->name."\" $input_type_password style=\"width:".$this->inputwidth."px;\" $max data-options=\"".$data_options."\">
                $buttonhtml
            </div>
            ";

        }
    }
