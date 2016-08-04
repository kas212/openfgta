<?php
require_once dirname(__FILE__)."/../../start.inc.php";
require_once "/fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = __ROOT_DIR."/apps";
$gen->Folder = "ent";
$gen->fileidentifier = "itemgroup";
$gen->JSClassName = "itemgroupClass";


$gen->HEADER = array(
    'TABLE' => 'MST_ITEMGROUP',
    'PK' => 'ITEMGROUP_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'ITEMGROUP_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ITEMGROUP_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'MODUL' => ['label'=>'MODUL', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
