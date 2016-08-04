<?php
require_once dirname(__FILE__)."/../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../apps";
$gen->Folder = "ent";
$gen->fileidentifier = "location";
$gen->JSClassName = "LocationClass";


$gen->HEADER = array(
    'TABLE' => 'MST_LOCATION',
    'PK' => 'LOCATION_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(

		'LOCATION_ID' =>['label'=>'ID', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],
		'LOCATION_NAME' =>['label'=>'NAME', 'control'=>'textbox','isList'=>1, 'isSearch'=>1, 'isForm'=>1],
		'CITY_ID' =>['label'=>'CITY', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],


     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
