<?php
define('__OPENFGTA__', 1);


header("QueryString: ". $_SERVER['QUERY_STRING']);
require_once dirname(__FILE__)."/main.inc.des.php";

FGTA_Main::Show();
