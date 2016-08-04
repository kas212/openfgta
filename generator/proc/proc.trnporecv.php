<?php
require_once dirname(__FILE__)."/../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../apps";
$gen->Folder = "proc";
$gen->fileidentifier = "trnporecv";
$gen->JSClassName = "TrnPOrecvClass";


$gen->HEADER = array(
    'TABLE' => 'TRN_PORECV',
    'PK' => 'PORECV_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(

		'PORECV_ID' =>['label'=>'ID', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],
		'PORECV_DATE' =>['label'=>'DATE', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],
		'PORECV_DESCR' =>['label'=>'DESCR', 'control'=>'textbox','isList'=>1, 'isSearch'=>1, 'isForm'=>1],
		'PO_ID' =>['label'=>'PO ID', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],


     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
