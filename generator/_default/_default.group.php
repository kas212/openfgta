<?php
require_once dirname(__FILE__)."/../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../apps";
$gen->Folder = "_default";
$gen->fileidentifier = "group";
$gen->JSClassName = "GroupClass";
$gen->HEADER = array(
    'TABLE' => 'FGT_GROUP',
    'PK' => 'GROUP_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'GROUP_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'GROUP_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'GROUP_DESCRIPTION' => ['label'=>'DESCR', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'GROUP_ISDISABLED' => ['label'=>'Disabled', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'GROUP_ISSYSTEM' => ['label'=>'System', 'control'=>'checkbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
    ),
);


$gen->DETIL = array(
    'USER' => array(
        'LABEL' => 'USER',
        'TABLE' => 'FGT_USER',
        'FIELDS' => array(
            'USER_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'USER_NAME' => ['label'=>'User', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'USER_ISSYSTEM' => ['label'=>'Sys', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'USER_ISDISABLED' => ['label'=>'Dis', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'USER_ISSUSPEND' => ['label'=>'Sp', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
        ),
    ),

    'PROGRAM' => array(
        'LABEL' => 'PROGRAM',
        'TABLE' => 'FGT_PROGRAM',
        'FIELDS' => array(
            'PROGRAM_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'PROGRAM_NAME' => ['label'=>'Program', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'PROGRAM_ISSYSTEM' => ['label'=>'Sys', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'PROGRAM_ISDISABLED' => ['label'=>'Dis', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'PROGRAM_ISSUSPEND' => ['label'=>'Sp', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
        ),
    ),

);



$gen->Generate();

echo "\r\n\r\n";
?>
