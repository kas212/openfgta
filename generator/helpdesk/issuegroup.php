<?php
require_once dirname(__FILE__)."/../../start.inc.php";
require_once "/fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = __ROOT_DIR."/apps";
$gen->Folder = "helpdesk";
$gen->fileidentifier = "issuegroup";
$gen->JSClassName = "issuegroupClass";


$gen->HEADER = array(
    'TABLE' => 'MST_ISSUEGROUP',
    'PK' => 'ISSUEGROUP',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(
        'ISSUEGROUP_ID' => ['label'=>'ID', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>0, 'isForm'=>1],
        'ISSUEGROUP_NAME' => ['label'=>'NAME', 'control'=>'textbox', 'isList'=>1, 'isSearch'=>1, 'isForm'=>1],
     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
