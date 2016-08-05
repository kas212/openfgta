<?php
//define('__SHOW_AS_MOBILE__', 1);  // enable ini apabila mengginakan mobile


require_once dirname(__FILE__)."/start.inc.php";


require_once "fgta/FGTA_Session.inc.php";
require_once "fgta/FGTA_Request.inc.php";
require_once "fgta/FGTA_Content.inc.php";
require_once "fgta/FGTA_FileLoader.inc.php";
require_once "fgta/FGTA_PageScripts.inc.php";
require_once "fgta/FGTA_PageStyles.inc.php";




class FGTA_Main extends FGTA_Request
{

	static $RedirectTo = "?";


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

			if (!static::IsLogin())
		    {

				$mode = "";
				if (array_key_exists("mode", $_GET))
					$mode = $_GET['mode'];


				if ($mode=='app') {
					// javascript cek apakah ada di container
					echo "<script>";
					echo "if (window.self !== window.top) { ";
					echo "parent.Relogin();";
					echo "} else { ";
					echo "location.href='container.des.php?'";
					echo "}";
					echo "</script>";
					die();
				} else {
			        require_once self::$_REQUEST['app_file_login'];
			        $TPLFILE = self::$_REQUEST['tpl_file_login'];
			        $CLASS = "login";
			        $PAGE_TITLE = __PAGE_TITLE . " - Login";
			        self::$_DEFAULT_DIR = self::$_ROOT_DIR . "/apps/" . self::$_DEFAULT_CLASS_NAME;
					self::$_REQUEST['param'] = array(
						'redirectto' => static::$RedirectTo,
					);
				}
		    }
		    else
		    {
				$mode = "";
				if (array_key_exists("fgtaprogid", $_GET)) {
					$mode = "app";
				} else {
					if (array_key_exists("mode", $_GET))
			            $mode = $_GET['mode'];
				}

		        switch ($mode)
		        {
		            case "app" :
						if (!self::$_REQUEST['allowaccess']) {
							die("WEBEXCEPTION: [AccessDenied] Access to '". self::$_REQUEST['class'] ."' is denied.");
						}

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

		                break;

		            case "logout" :
						FGTA_Session::RemoveSession(self::$db, session_id());
		                $_SESSION['islogin'] = false;
		                require_once self::$_REQUEST['app_file_login'];
		                $TPLFILE = self::$_REQUEST['tpl_file_login'];
		                $CLASS = "login";
		                $PAGE_TITLE = __PAGE_TITLE . " - Login";
						self::$_REQUEST['param'] = array(
							'redirectto' => static::$RedirectTo,
						);
		                break;

					case "welcome" :
						$user_1stpage = '_default/fgtatoday';

						$welcomepage_class = __ROOT_DIR.'/apps/'.$user_1stpage.'.class.php';
						$welcomepage_des = __ROOT_DIR.'/apps/'.$user_1stpage.'.html.des.php';
						if (!is_file($welcomepage_des))
							$welcomepage_des = __ROOT_DIR.'/apps/'.$user_1stpage.'.html.php';

						if (is_file($welcomepage_class) && is_file($welcomepage_des)) {
							require_once $welcomepage_class;
					        $TPLFILE = $welcomepage_des;
							$t = explode('/', $user_1stpage);
							$CLASS = $t[1];
						} else {

							$_SESSION['WELCOME_ERROR_MESSAGE'] = '';
							if (!empty($user_1stpage))
								 $_SESSION['WELCOME_ERROR_MESSAGE'] = "One or more First page program (class/html) '$user_1stpage' is not found!<br><ul><li>$welcomepage_class</li><li>$welcomepage_des</li></ul>";

							require_once self::$_ROOT_DIR . "/apps/_default/welcome.class.php";
					        $TPLFILE = self::$_ROOT_DIR . "/apps/_default/welcome.html.des.php";
					        $CLASS = "welcome";
						}

				        $PAGE_TITLE = __PAGE_TITLE . " - Welcome";
				        self::$_DEFAULT_DIR = self::$_ROOT_DIR . "/apps/" . self::$_DEFAULT_CLASS_NAME;
						break;

		            default:
		                $DEF = static::PrepareDefault();
						$TPLFILE    = $DEF['TPLFILE'];
						$CLASS      = $DEF['CLASS'];
						$PAGE_TITLE = $DEF['PAGE_TITLE'];
		                break;

		        }

		    }



			$refl = new ReflectionClass($CLASS);
			$objApp = $refl->newInstanceArgs(array(self::$_ROOT_DIR, self::$_DEFAULT_DIR));
			$objApp->TEMPLATE = $TPLFILE;
			$objApp->TEMPLATE_DIR = dirname($TPLFILE);
			$objApp->NS = array_key_exists('ns', $_GET) ? $_GET['ns'] : '';
			$objApp->CL = array_key_exists('cl', $_GET) ? $_GET['cl'] : '';
			$objApp->PARAM = self::$_REQUEST['param'];

			$objApp->ISLOGIN = array_key_exists('islogin', $_SESSION) ? $_SESSION['islogin'] : false;
			$objApp->USERNAME = array_key_exists('username', $_SESSION) ? $_SESSION['username'] : false;
			$objApp->USERFULLNAME = array_key_exists('userfullname', $_SESSION) ? $_SESSION['userfullname'] : false;
			$objApp->EMPLOOYE_ID = array_key_exists('EMPLOYEE_ID', $_SESSION) ? $_SESSION['EMPLOYEE_ID'] : false;


			$objApp->db = self::$db;
			if (empty($objApp->TITLE))
				$objApp->TITLE = $PAGE_TITLE;


			ob_start();
			$objApp->LoadPage();
			$dcon = ob_get_contents();
			ob_end_clean();

			$objApp->Render('_template.html.des.php', $dcon, $objApp);

		}
		catch (Exception $ex)
		{
			die("TemplateEngine ERROR: " . $ex->getMessage());
		}

	}


	public static function PrepareDefault() {
		require_once self::$_ROOT_DIR . "/apps/_default/container.class.php";;
		return array(
			'TPLFILE' => self::$_ROOT_DIR . "/apps/_default/container.html.des.php",
			'CLASS' => "container",
			'PAGE_TITLE' => __PAGE_TITLE . " - Container",
		);
	}

	public static function IsLogin() {
		if (!$_SESSION['islogin'] || $_SESSION['username']=="" || $_SESSION['username']==null)
			return false;
		else
			return true;
	}


}
