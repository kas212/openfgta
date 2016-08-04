<?php
require_once dirname(__FILE__)."/../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../apps";
$gen->Folder = "_default";
$gen->fileidentifier = "program";
$gen->JSClassName = "ProgramClass";
$gen->HEADER = array(
    'TABLE' => 'FGT_PROGRAM',
    'PK' => 'PROGRAM_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'PROGRAM_ID'                => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'PROGRAM_NAME'              => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'PROGRAM_ICON'              => ['label'=>'ICON', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'PROGRAM_PATH'              => ['label'=>'PATH', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'PROGRAM_NS'                => ['label'=>'NS', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'PROGRAM_DLL'               => ['label'=>'DLL', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'PROGRAM_INSTANCE'          => ['label'=>'INSTANCE', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'PROGRAM_DESCRIPTION'       => ['label'=>'DESCR', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'PROGRAM_ISDISABLED'        => ['label'=>'Disabled', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'PROGRAM_ISSINGLEINSTANCE'  => ['label'=>'SingleInstance', 'control'=>'checkbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'PROGRAM_ISWEBENABLED'      => ['label'=>'Web', 'control'=>'checkbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'PROGRAM_ISMOBILEENABLED'   => ['label'=>'Mobile', 'control'=>'checkbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'PROGRAM_ISSYSTEM'          => ['label'=>'System', 'control'=>'checkbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
    ),
);


$gen->DETIL = array(
    'GROUP' => array(
        'LABEL' => 'Group',
        'TABLE' => 'FGT_PROGRAMGROUP',
        'FIELDS' => array(
            'GROUP_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'GROUP_NAME' => ['label'=>'Group', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'GROUP_ISDISABLED' => ['label'=>'Dis', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'GROUPPROGRAM_ISSUSPEND' => ['label'=>'Sus', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
        ),
    ),

);




$gen->Generate();

echo "\r\n\r\n";
?>
