<?php
require_once dirname(__FILE__)."/../../start.inc.php";
require_once "/fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = __ROOT_DIR."/apps";
$gen->Folder = "testbrand";
$gen->fileidentifier = "brandtest";
$gen->JSClassName = "cityClass";


$gen->HEADER = array(
    'TABLE' => 'MST_BRAND',
    'PK' => 'BRAND_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'BRAND_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'BRAND_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'BRAND_NAMESHORT' => ['label'=>'NAMESHORT', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'BRAND_ISDISABLED' => ['label'=>'DISABLED', 'control'=>'checkbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
