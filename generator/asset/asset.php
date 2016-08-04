<?php
require_once dirname(__FILE__)."/../../start.inc.php";
require_once "/fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = __ROOT_DIR."/apps";
$gen->Folder = "asset";
$gen->fileidentifier = "asset";
$gen->JSClassName = "assetClass";

$gen->HEADER = array(
    'TABLE' => 'MST_ASSET',
    'PK' => 'ASSET_ID',
    'AUTOINCREMENT' => true,
    'FIELDS' => array(
        'ASSET_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ASSET_DATE' => ['label'=>'Date', 'control'=>'datebox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'ASSET_NAME' => ['label'=>'Name', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'ASSET_DESCR' => ['label'=>'Descr', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'ASSET_ISWRITTENOFF' => ['label'=>'WrittenOff', 'control'=>'checkbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'ASSET_MODEL' => ['label'=>'Model', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ASSET_SN' => ['label'=>'S/N', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ASSET_ISGROUP' => ['label'=>'Group', 'control'=>'checkbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'ASSET_PARENT' => ['label'=>'Parent', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'ASSET_VALUEORI' => ['label'=>'Value', 'control'=>'numberbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'ASSETSTATUS_ID' => ['label'=>'Status', 'control'=>'combobox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'ITEMCLASS_ID' => ['label'=>'Class', 'control'=>'combobox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'MANUFACTURER_ID' => ['label'=>'Manufacturer', 'control'=>'combobox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'EMPLOYEE_ID' => ['label'=>'PIC', 'control'=>'combobox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'DEPT_ID' => ['label'=>'Dept', 'control'=>'combobox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'OWNER_DEPT_ID' => ['label'=>'Owner', 'control'=>'combobox', 'isList'=>0, 'isSearch'=>1, 'isForm'=>1],
        'PO_ID' => ['label'=>'PO', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
        'PORECV_ID' => ['label'=>'RV', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>1],
    ),
);


$gen->DETIL = array(
    'PROP' => array(
        'LABEL' => 'PROP',
        'TABLE' => 'MST_ASSETPROP',
        'FIELDS' => array(
            'ASSETPROPTYPE_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSETPROPTYPE_NAME' => ['label'=>'Properties', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSETPROP_VALUE' => ['label'=>'Value', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
        ),
    ),

    'MEMBER' => array(
        'LABEL' => 'MEMBER',
        'TABLE' => 'MST_ASSET',
        'FIELDS' => array(
            'ASSET_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSET_SN' => ['label'=>'SN', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSET_NAME' => ['label'=>'Name', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'MANUFACTURER_ID' => ['label'=>'Manufacturer', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSETSTATUS_ID' => ['label'=>'Status', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSET_ISWRITTENOFF' => ['label'=>'WO', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
        ),
    ),

    'MUTATION' => array(
        'LABEL' => 'MUTATION',
        'TABLE' => 'MST_ASSETMUTATION',
        'FIELDS' => array(
            'ASSETMUTATION_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSETMUTATION_DATE' => ['label'=>'Date', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSETPROP_DESCR' => ['label'=>'Descr', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
        ),
    ),

    'DEPRE' => array(
        'LABEL' => 'DEPRE',
        'TABLE' => 'MST_ASSETDEPRE',
        'FIELDS' => array(
            'ASSETDEPRE_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSETDEPRE_DATE' => ['label'=>'Date', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSETDEPRE_LASTVALUE' => ['label'=>'LastValue', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSETDEPRE_VALUE' => ['label'=>'DepreValue', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
            'ASSETDEPRE_CURRVALUE' => ['label'=>'CurrentValue', 'control'=>'textbox', 'isList'=>0, 'isSearch'=>0, 'isForm'=>0],
        ),
    ),

);



$gen->Generate();

echo "\r\n\r\n";
?>
