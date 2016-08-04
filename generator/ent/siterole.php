<?php
require_once dirname(__FILE__)."/../../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../../apps";
$gen->Folder = "ent";
$gen->fileidentifier = "siterole";
$gen->JSClassName = "SiteroleClass";


$gen->HEADER = array(
    'TABLE' => 'MST_SITEROLE',
    'PK' => 'SITEROLE_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'SITEROLE_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'SITEROLE_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'SITEROLE_ISDISABLED' => ['label'=>'DISABLED', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'SITEROLE_DESCR' => ['label'=>'DESCR', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
     )
);

$gen->DETIL = array(
    'PERMISSION' => array(
        'LABEL' => 'PERMISSION',
        'TABLE' => 'MST_SITEROLEPERM',
        'FIELDS' => array(
            'PERM_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'PERM_NAME' => ['label'=>'Permission', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
        ),
    ),


);



$gen->Generate();

echo "\r\n\r\n";

?>
