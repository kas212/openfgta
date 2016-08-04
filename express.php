<?php
header("QueryString: ". $_SERVER['QUERY_STRING']);

require_once dirname(__FILE__)."/start.inc.php";

require_once "fgta/FGTA_Session.inc.php";
require_once "fgta/FGTA_Request.inc.php";
require_once "fgta/FGTA_Content.inc.php";
require_once "fgta/FGTA_FileLoader.inc.php";
require_once "fgta/FGTA_PageScripts.inc.php";
require_once "fgta/FGTA_PageStyles.inc.php";

class FGTA_Main extends FGTA_Request
{

	public static function Show()
	{
		global $_GET;

		self::LoadConfig(dirname(__FILE__)."/conf");
		self::DbConnect();
		self::PrepareDirectories(dirname(__FILE__));
		self::SessionStart();

		try
		{
			$PAGE_TITLE = __PAGE_TITLE;

			if (!array_key_exists('mode', $_GET))
				throw new Exception("QueryString URL 'mode' tidak didefinisikan");

			if ($_GET['mode']!='app')
				throw new Exception("QueryString URL 'mode=app' tidak didefinisikan");


			$_SESSION['islogin'] = 1;
			$_SESSION['username'] = "root";
			$_SESSION['USER_ID'] =  $_SESSION['username'];



			require_once 'fgta/FGTA_Control.inc.php';
			require_once 'fgta/FGTA_Control_Textbox.inc.php';
			require_once 'fgta/FGTA_Control_Numberbox.inc.php';
			require_once 'fgta/FGTA_Control_Checkbox.inc.php';
			require_once 'fgta/FGTA_Control_Combobox.inc.php';
			require_once 'fgta/FGTA_Control_Datebox.inc.php';
			require_once 'fgta/FGTA_Control_Datagrid.inc.php';
			require_once 'fgta/FGTA_Control_TextboxSearch.inc.php';
			require_once 'fgta/FGTA_Control_ComboboxSearch.inc.php';


			require_once self::$_REQUEST['app_file'];
			$CLASS = self::$_REQUEST['class'];
			$TPLFILE = self::$_REQUEST['tpl_file'];

			$PAGE_TITLE = __PAGE_TITLE . " - " . $CLASS;



			$refl = new ReflectionClass($CLASS);
			$objApp = $refl->newInstanceArgs(array(self::$_ROOT_DIR, self::$_DEFAULT_DIR));
			$objApp->TEMPLATE = $TPLFILE;
			$objApp->TEMPLATE_DIR = dirname($TPLFILE);
			$objApp->NS = array_key_exists('ns', $_GET) ? $_GET['ns'] : '';
			$objApp->CL = array_key_exists('cl', $_GET) ? $_GET['cl'] : '';

			$objApp->ISLOGIN = array_key_exists('islogin', $_SESSION) ? $_SESSION['islogin'] : false;
			$objApp->USERNAME = array_key_exists('username', $_SESSION) ? $_SESSION['username'] : false;
			$objApp->USERFULLNAME = array_key_exists('userfullname', $_SESSION) ? $_SESSION['userfullname'] : false;


			$objApp->db = self::$db;
			if (empty($objApp->TITLE))
				$objApp->TITLE = $PAGE_TITLE;


			ob_start();
			$objApp->LoadPage();
			$dcon = ob_get_contents();
			ob_end_clean();

			$objApp->Render('_template.html.php', $dcon, $objApp);

		}
		catch (Exception $ex)
		{
			die("TemplateEngine ERROR: " . $ex->getMessage());
		}

	}
}


FGTA_Main::Show();
