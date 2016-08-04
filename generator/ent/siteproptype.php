<?php
require_once dirname(__FILE__)."/../../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../../apps";
$gen->Folder = "ent";
$gen->fileidentifier = "siteproptype";
$gen->JSClassName = "SiteproptypeClass";


$gen->HEADER = array(
    'TABLE' => 'MST_SITEPROPTYPE',
    'PK' => 'SITEPROPTYPE_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'SITEPROPTYPE_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'SITEPROPTYPE_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'SITEPROPTYPE_DESCR' => ['label'=>'DESCR', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
     )
);



$gen->Generate();

echo "\r\n\r\n";

?>
