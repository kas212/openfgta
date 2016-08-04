<?php

    class testdlg extends FGTA_Content
    {
        public $FIELD_ID = "obj_txt_input";
		public $FIELD_ID_MAPPING = "obj_txt_input";
		public $FIELD_ID_ISAUTO = false;


        public function LoadPage() {

            $this->Scripts->load("testdlg.js");

            $this->Editor = array(
                new FGTA_Control_Textbox(['name'=>'obj_txt_input', 'label'=>'TestInput', 'buttonlabel'=>'...', 'buttonwidth'=>'30', 'button'=>'btn_input', 'options'=>"" ]),
            );

        }


    }
