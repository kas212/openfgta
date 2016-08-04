<?php
require_once dirname(__FILE__)."/../../start.inc.php";
require_once "/fgta/FGTA_Generator.inc.php";


$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../../apps";
$gen->Folder = "_default";
$gen->fileidentifier = "fgen";
$gen->JSClassName = "fgenClass";


$gen->HEADER = array(
    'TABLE' => 'FGT_FGEN',
    'PK' => 'FGEN_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'FGEN_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_NAME' => ['label'=>'ProgName', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'FGEN_FOLDER' => ['label'=>'Folder', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_IDENT' => ['label'=>'Ident', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_TABLE' => ['label'=>'Table', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_PK' => ['label'=>'PK', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_ISAUTO' => ['label'=>'AutoID', 'control'=>'checkbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D1NAME' => ['label'=>'D.1.Name', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D1TABLE' => ['label'=>'D.1.Tbl', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D2NAME' => ['label'=>'D.2.Name', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D2TABLE' => ['label'=>'D.2.Tbl', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D3NAME' => ['label'=>'D.3.Name', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D3TABLE' => ['label'=>'D.3.Tbl', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D4NAME' => ['label'=>'D.4.Name', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D4TABLE' => ['label'=>'D.4.Tbl', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D5NAME' => ['label'=>'D.5.Name', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'FGEN_D5TABLE' => ['label'=>'D.5.Tbl', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],

     )
);

$gen->DETIL = array(
    'H' => array(
        'LABEL' => 'H',
        'TABLE' => 'FGT_FGEND',
        'FIELDS' => array(
            'FGEND_LABEL' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'FGEND_CONTROL' => ['label'=>'Control', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
            'FGEND_ISLIST' => ['label'=>'List', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
            'FGEND_ISSEARCH' => ['label'=>'Search', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
            'FGEND_ISFORM' => ['label'=>'Form', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
    ),

    'D1' => array(
        'LABEL' => 'D1',
        'TABLE' => 'FGT_FGEND',
        'FIELDS' => array(
            'FGEND_LABEL' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'FGEND_CONTROL' => ['label'=>'Control', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
    ),

    'D2' => array(
        'LABEL' => 'D2',
        'TABLE' => 'FGT_FGEND',
        'FIELDS' => array(
            'FGEND_LABEL' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'FGEND_CONTROL' => ['label'=>'Control', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
    ),

    'D3' => array(
        'LABEL' => 'D3',
        'TABLE' => 'FGT_FGEND',
        'FIELDS' => array(
            'FGEND_LABEL' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'FGEND_CONTROL' => ['label'=>'Control', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
    ),

    'D4' => array(
        'LABEL' => 'D4',
        'TABLE' => 'FGT_FGEND',
        'FIELDS' => array(
            'FGEND_LABEL' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'FGEND_CONTROL' => ['label'=>'Control', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
    ),

    'D5' => array(
        'LABEL' => 'D5',
        'TABLE' => 'FGT_FGEND',
        'FIELDS' => array(
            'FGEND_LABEL' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'FGEND_CONTROL' => ['label'=>'Control', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
    ),
);





$gen->Generate();

echo "\r\n\r\n";

?>
