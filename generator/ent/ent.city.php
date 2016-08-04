<?php
require_once dirname(__FILE__)."/../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../apps";
$gen->Folder = "ent";
$gen->fileidentifier = "city";
$gen->JSClassName = "cityClass";


$gen->HEADER = array(
    'TABLE' => 'MST_CITY',
    'PK' => 'CITY_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(

		'CITY_ID' =>['label'=>'ID', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],
		'CITY_DESCR' =>['label'=>'DESCR', 'control'=>'textbox','isList'=>1, 'isSearch'=>1, 'isForm'=>1],

     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
