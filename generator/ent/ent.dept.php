<?php
require_once dirname(__FILE__)."/../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../apps";
$gen->Folder = "ent";
$gen->fileidentifier = "dept";
$gen->JSClassName = "DeptClass";


$gen->HEADER = array(
    'TABLE' => 'MST_DEPT',
    'PK' => 'DEPT_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'DEPT_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'DEPT_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'DEPT_NAMESHORT' => ['label'=>'NAMESHORT', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'DEPT_ISDISABLED' => ['label'=>'DISABLED', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'DEPT_ISGROUP' => ['label'=>'GROUP', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'DEPT_PATH' => ['label'=>'PATH', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'PARENT_DEPT_ID' => ['label'=>'PARENT', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
