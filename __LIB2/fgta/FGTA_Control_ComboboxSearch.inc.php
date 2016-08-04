<?php

    class FGTA_Control_ComboboxSearch extends FGTA_Control
    {
        function __construct($opt) {
            $this->process_opt($opt);

            if (!array_key_exists('checkbox', $opt))
                die("property 'checkbox' harus didefinisikan pada Control ComboSearch.");

            if (!array_key_exists('textbox', $opt))
                die("property 'textbox' harus didefinisikan pada Control ComboSearch.");

            $this->values = array_key_exists('values', $opt) ? $opt['values'] : array();

            $this->checkbox = $opt['checkbox'];
            $this->textbox = $opt['textbox'];
            $this->button = array_key_exists('button', $opt) ? $opt['button'] : null;
            $this->mandatory = array_key_exists('mandatory', $opt) ? $opt['mandatory'] : false;


            if ($this->button != null)
                $this->inputwidth = $this->width - $this->labelwidth - 20 - 60 - 10;
            else
                $this->inputwidth = $this->width - $this->labelwidth - 20 - 10;

            if ($this->directrender)
                $this->GenerateHtml();

        }

        public function GenerateHtml($param=null)
        {
            $buttonhtml = "";
            if ($this->button!=null)
                $buttonhtml = "<td style=\"padding-left: 5px\"><a href=\"#\" id=\"".$this->button."\" class=\"easyui-linkbutton c8\" style=\"width:55px; height:22px\">Search</a></td>";

            $checkedvalue = $this->mandatory ? ' checked="true" ' : '';
            $checkboxdisabled =  $this->mandatory ? 'disabled' : '';
            $class_checkbox = $this->mandatory ? 'css-checkbox-disabled' : 'css-checkbox-readonly';
            $class_label = $this->mandatory ? 'css-label-disabled' : 'css-label-readonly';
            $text_disabled = $this->mandatory ? 'false' : 'true';


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
            <div fgta-id=\"".$this->textbox."\" class=\"$htmlclass\" style=\"$devstyle top:".$this->top."px; left:".$this->left."px; width:".$this->width."px; border-bottom: 0px\">
                <table cellpadding=\"0\" cellspacing=\"0\"><tr>
                <td width=\"".$this->labelwidth."\" align=\"right\" style=\"padding-right: 5px\"><label for=\"".$this->checkbox."\" style=\"font-size: 8pt; cursor: pointer\">".$this->label."</label></td>
                <td>
                    <input id=\"".$this->checkbox."\" class=\"$class_checkbox\" type=\"checkbox\" $checkedvalue $checkboxdisabled onclick=\"ui.CriteriaSelect(this, '".$this->textbox."', 'textbox')\">
                    <label for=\"".$this->checkbox."\" class=\"$class_label\" style=\"font-size: 8pt\"></label>
                </td>
                <td style=\"padding-left: 5px\"><select  id=\"".$this->textbox."\" class=\"easyui-combobox\" style=\"width:".$this->inputwidth."px;\" data-options=\"disabled: $text_disabled, $data_options\">";


            foreach ($this->values as $val)
            {
                $value = $val[0];
                $display = $val[1];
                echo "<option value=\"".$value."\">".$display."</option>";
            }

            echo "</td>
                $buttonhtml
                </tr></table>
            </div>
            ";
        }
    }
