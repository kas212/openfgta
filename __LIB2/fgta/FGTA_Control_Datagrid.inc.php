<?php

    class FGTA_Control_Datagrid extends FGTA_Control
    {
        function __construct($opt) {
            $this->process_opt($opt);
            $this->columnid = array_key_exists('columnid', $opt) ? $opt['columnid'] : '';
            $this->columns = array_key_exists('columns', $opt) ? $opt['columns'] : array();
            $this->allowaddremove = array_key_exists('allowaddremove', $opt) ? $opt['allowaddremove'] : false;
            $this->dialog = array_key_exists('dialog', $opt) ? $opt['dialog'] : null;

            if ($this->directrender)
                $this->GenerateHtml();
        }

        public function GenerateHtml()
        {

            $dgoptions = "fit:true, singleSelect: true, onLoadSuccess: function(data){ if (data.total>0) ui.".$this->name.".datagrid('selectRow', 0); }";
            if (!empty($this->columnid)) $dgoptions .= ", idField:'".$this->columnid."'";
            if (!empty($this->options))  $dgoptions .= ", ".$this->options;

            echo "<table id=\"".$this->name."\"  class=\"easyui-datagrid\" data-options=\"$dgoptions\">";

            if (count($this->columns)>0)
            {
                echo "<thead><tr>";

                if ($this->name != "dgvList")
                    echo "<th field=\"_LINE\" width=\"50\" align=\"right\" data-options=\"styler: function(value,row,index){ return 'background-color:#dddddd; color: #000000' }\"><span style=\"font-size: 7.5pt\">Line</span></th>";

                foreach ($this->columns as $col) {
                    if (!array_key_exists('mapping', $col)) die ('Mapping untuk datagrid column belum didefinisikan');
                    $mapping = $col['mapping'];
                    $label = array_key_exists('label', $col) ? $col['label'] : $mapping;
                    $coloptions =  "field:'$mapping'";
                    if (array_key_exists('options', $col))
						if (!empty($col['options']))
							$coloptions .=  ", " . $col['options'];


                    echo "<th data-options=\"$coloptions\"><span style=\"font-size: 7.5pt\">$label</span></th>";
                }
                echo "</tr></thead>";
            }

            echo "</table>";
        }
    }
