<?php

    class testdev extends FGTA_Content
    {

        public function LoadPage() {

            $this->Scripts->load("testdev.js");

			echo exec('whoami');

        }


        public function TestPrint() {
            require_once 'escpos-php-master/Escpos.php';

            //$connector = new WindowsPrintConnector("smb://localhost/BSC10");
            //$connector = new WindowsPrintConnector("Star-BSC10-(ESP-001)");
			$connector = new FilePrintConnector('/dev/usb/lp1');

            $printer = new Escpos($connector);

            try {

                //$tux = new EscposImage("D:\\AgungNugroho\\SkyDrive\WebDev\\__LIB\\escpos-php-master\\example\\resources\\tux.png");
                //$printer -> bitImage($tux);

				$tux = new EscposImage(dirname(__FILE__)."/tux.png");
				//$printer -> bitImage($tux);
                $printer -> text("GNU is not Unix.\n");
                $printer -> feed();

            } catch(Exception $e) {
            	/* Images not supported on your PHP, or image file not found */
            	$printer -> text($e -> getMessage() . "\n");
            }

            $printer->cut();
            $printer->close();

            return true;
        }


    }
