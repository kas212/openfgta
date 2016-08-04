<?php
require_once dirname(__FILE__)."/../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../apps";
$gen->Folder = "_default";
$gen->fileidentifier = "user";
$gen->JSClassName = "UserClass";
$gen->HEADER = array(
    'TABLE' => 'FGT_USER',
    'PK' => 'USER_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'USER_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'USER_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'USER_EMAIL' => ['label'=>'EMAIL', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'USER_ISDISABLED' => ['label'=>'Disabled', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'USER_ISSYSTEM' => ['label'=>'System', 'control'=>'checkbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
    ),
);


$gen->DETIL = array(
    'GROUP' => array(
        'LABEL' => 'Group',
        'TABLE' => 'FGT_USERGROUP',
        'FIELDS' => array(
            'GROUP_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'GROUP_NAME' => ['label'=>'Group', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'GROUP_ISSYSTEM' => ['label'=>'Sys', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'GROUP_ISDISABLED' => ['label'=>'Dis', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'GROUP_ISSUSPEND' => ['label'=>'Sp', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
        ),
    ),

);



$gen->Generate();

echo "\r\n\r\n";
?>
