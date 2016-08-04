<?php
require_once dirname(__FILE__)."/../../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../../apps";
$gen->Folder = "asset";
$gen->fileidentifier = "assetstatus";
$gen->JSClassName = "AssetstatusClass";


$gen->HEADER = array(
    'TABLE' => 'MST_ASSETSTATUS',
    'PK' => 'ASSETSTATUS_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
		'ASSETSTATUS_ID' => ['label'=>'ID', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],
		'ASSETSTATUS_NAME' =>['label'=>'NAME', 'control'=>'textbox','isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'ASSETSTATUS_ISDISABLED' =>['label'=>'Disabled', 'control'=>'checkbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ASSETSTATUS_DESCR' =>['label'=>'DESCR', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],
     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
