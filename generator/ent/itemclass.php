<?php
require_once dirname(__FILE__)."/../../start.inc.php";
require_once "/fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = __ROOT_DIR."/apps";
$gen->Folder = "ent";
$gen->fileidentifier = "itemclass";
$gen->JSClassName = "itemclassClass";


$gen->HEADER = array(
    'TABLE' => 'MST_ITEMCLASS',
    'PK' => 'ITEMCLASS_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'ITEMCLASS_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ITEMCLASS_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'ITEMCLASS_ISDISABLED' => ['label'=>'Disabled', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ITEMCLASS_ISGROUP' => ['label'=>'Group', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ITEMCLASS_PARENT' => ['label'=>'Parent', 'control'=>'combobox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ITEMCLASS_DESCR' => ['label'=>'Descr', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ITEMCLASS_PATH' => ['label'=>'PATH', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ITEMGROUP_ID' => ['label'=>'ItemGroup', 'control'=>'combobox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'DEPT_ID' => ['label'=>'Dept', 'control'=>'combobox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
