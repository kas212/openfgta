<?php

	class devform extends FGTA_Content
	{
        public function SaveLayout($fields, $ns, $cl, $editormode) {
            $APP_DIR = $this->ROOT_DIR . "/apps";
            $TARGET_FOLDER = $APP_DIR . "/" .  $ns;

            if (!is_dir($TARGET_FOLDER))
                throw new Exception("Direktori '$TARGET_FOLDER' tidak ditemukan!");


            try {
				$layout = ($editormode=='search') ? 'layoutsearch' : 'layoutform';
                $LAYOUTFILE = $TARGET_FOLDER."/". $cl. ".".$layout.".php";
                $fp = fopen($LAYOUTFILE, "w");

                fputs($fp, "<?php\r\n");
                foreach ($fields as $field)
                {
                    $name = $field['name'];
                    $top = $field['top'];
                    $left = $field['left'];
                    $width = $field['width'];

                    fputs($fp, "\$dat['$name'] = [$top, $left, $width];\r\n");
                }

                fputs($fp, "\r\n");
                fclose($fp);

                return true;
            } catch (Exception $ex) {
                throw new $ex;
            }
        }

    }
