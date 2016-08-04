<?php
require_once dirname(__FILE__)."/../../fgta/FGTA_Generator.inc.php";

$gen = new FGTA_Generator();
$gen->TARGET = dirname(__FILE__)."/../../apps";
$gen->Folder = "hr";
$gen->fileidentifier = "employee";
$gen->JSClassName = "EmployeeClass";


$gen->HEADER = array(
    'TABLE' => 'MST_EMPLOYEE',
    'PK' => 'EMPLOYEE_ID',
    'AUTOINCREMENT' => false,
    'FIELDS' => array(

		'EMPLOYEE_ID' =>['label'=>'ID', 'control'=>'textbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],
		'EMPLOYEE_NAME' =>['label'=>'NAME', 'control'=>'textbox','isList'=>1, 'isSearch'=>1, 'isForm'=>1],
        'EMPLOYEE_ISDISABLED' =>['label'=>'Disabled', 'control'=>'checkbox','isList'=>1, 'isSearch'=>0, 'isForm'=>1],


     )
);


$gen->Generate();

echo "\r\n\r\n";

?>
