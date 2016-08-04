<?php
require_once dirname(__FILE__)."/../../start.inc.php";
require_once "/fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = __ROOT_DIR."/apps";
$gen->Folder = "asset";
$gen->fileidentifier = "assetproptype";
$gen->JSClassName = "assetproptypeClass";


$gen->HEADER = array(
    'TABLE' => 'MST_ASSETPROPTYPE',
    'PK' => 'ASSETPROPTYPE_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
		'ASSETPROPTYPE_ID' =>['label'=>'ID', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],
		'ASSETPROPTYPE_NAME' =>['label'=>'NAME', 'control'=>'textbox','isList'=>1, 'isSearch'=>1, 'isForm'=>1],
     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
