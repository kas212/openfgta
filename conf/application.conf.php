<?php
if (!defined('__OPENFGTA__'))
	die('Cannot access file directly');


// true:  boleh langsung akses ke folder apss ?
//        container.xxx.php?ns=ent&obj=DomainException
// false: tidak boleh langsung akses ke folder aps
//        container.xxx.php?id=2323423
define('__ALLOW_DIRRECT_ACCESS', true);


// Login developer
define('__LAYOUT_EDITOR_USER', 'root');
define('__ROOT_USER', 'root');
define('__ROOT_PASSWORD', '6e7fcdd6655c6d3249bfd06c7f9376d2');


// Data Folder
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	define('__DATA_FOLDER', __ROOT_DIR . "\\data");
} else {
	define('__DATA_FOLDER', __ROOT_DIR . '/data');
}
