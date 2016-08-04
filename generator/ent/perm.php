<?php
require_once dirname(__FILE__)."/../../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../../apps";
$gen->Folder = "ent";
$gen->fileidentifier = "perm";
$gen->JSClassName = "PermClass";


$gen->HEADER = array(
    'TABLE' => 'MST_PERM',
    'PK' => 'PERM_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'PERM_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'PERM_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'PERM_DESCR' => ['label'=>'DESCR', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
