<?php
require_once dirname(__FILE__)."/../../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../../apps";
$gen->Folder = "ent";
$gen->fileidentifier = "site";
$gen->JSClassName = "SiteClass";


$gen->HEADER = array(
    'TABLE' => 'MST_SITE',
    'PK' => 'SITE_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'SITE_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'SITE_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'SITE_NAMESHORT' => ['label'=>'NAMESHORT', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'SITE_ISDISABLED' => ['label'=>'Disabled', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'SITE_ADDRESS' => ['label'=>'ADDRESS', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'SITE_PHONE' => ['label'=>'PHONE', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'SITE_EMAIL' => ['label'=>'EMAIL', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'SITE_SQM' => ['label'=>'SQM', 'control'=>'numberbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'SITEMODEL_ID' => ['label'=>'MODEL', 'control'=>'combobox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'LOCATION_ID' => ['label'=>'LOCATION', 'control'=>'combobox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
     )
);

$gen->DETIL = array(
    'BRAND' => array(
        'LABEL' => 'BRAND',
        'TABLE' => 'MST_SITEBRAND',
        'FIELDS' => array(
            'BRAND_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'BRAND_NAME' => ['label'=>'BRAND', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
            'BRAND_ISSUSPEND' => ['label'=>'SPN', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
        
    ),

    'USER' => array(
        'LABEL' => 'USER',
        'TABLE' => 'MST_SITEUSER',
        'FIELDS' => array(
            'USER_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'USER_NAME' => ['label'=>'USER', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
            'SITEROLE_ID' => ['label'=>'ROLE', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
            'USER_ISSUSPEND' => ['label'=>'SPN', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
    ),

    'MAPPING' => array(
        'LABEL' => 'MAPPING',
        'TABLE' => 'MST_SITEMAPPING',
        'FIELDS' => array(
            'REGION_ID' => ['label'=>'REGION', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'BRANCH_ID' => ['label'=>'BRANCH', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
    ),

    'PROP' => array(
        'LABEL' => 'MAPPING',
        'TABLE' => 'MST_SITEMAPPING',
        'FIELDS' => array(
            'SITEPROPTYPE_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
            'SITEPROPTYPE_NAME' => ['label'=>'PROP', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
            'SITEPROP_VALUE' => ['label'=>'VALUE', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        ),
    ),
);


$gen->DATA = array(
    'SITEMODEL_ID' => ['mode'=>'remote'],
);


$gen->Generate();

echo "\r\n\r\n";

?>
