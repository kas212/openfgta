<?php
header("QueryString: ". $_SERVER['QUERY_STRING']);
require_once dirname(__FILE__)."/main.inc.des.php";

class FGTA_Pos extends FGTA_Main
{
    static $RedirectTo = "container.des.php?mode=app&ns=pos&cl=pos";

    public static function PrepareDefault() {
        self::$_DEFAULT_DIR = self::$_ROOT_DIR . "/apps/pos";

		require_once self::$_ROOT_DIR . "/apps/pos/pos.class.php";;
        return array(
			'TPLFILE' => self::$_ROOT_DIR . "/apps/pos/pos.html.php",
			'CLASS' => "pos",
			'PAGE_TITLE' => __PAGE_TITLE . " - Point of Sales",
		);
	}

}

FGTA_Pos::Show();
