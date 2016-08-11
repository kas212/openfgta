<?php
if (!defined('__OPENFGTA__'))
	die('Cannot access file directly');


$DBCONF = [
	/* Main Database, menggunakan firebird */
	'MAIN' => [
		'host' => "localhost",
		'user' => "SYSDBA",
		'pass' => "masterkey",
		'dbname' => "/var/database/openfgta.fdb",
		'role' => ""
	],
];
