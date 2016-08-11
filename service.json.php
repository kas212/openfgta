<?php
define('__OPENFGTA__', 1);


header("QueryString: ". $_SERVER['QUERY_STRING']);
define('FGTA_WebService', true);

require_once dirname(__FILE__)."/start.inc.php";

require_once "fgta/FGTA_Session.inc.php";
require_once "fgta/FGTA_Request.inc.php";
require_once "fgta/FGTA_Content.inc.php";
require_once "fgta/FGTA_FileLoader.inc.php";
require_once "fgta/FGTA_PageScripts.inc.php";
require_once "fgta/FGTA_PageStyles.inc.php";
require_once "fgta/FGTA_SqlUtil.inc.php";
require_once "fgta/FGTA_WebService.inc.php";
require_once "fgta/FGTA_WebResult.inc.php";


class FGTA_Service extends FGTA_Request
{

	static function main()
	{
		global $_GET, $_POST;

		self::LoadConfig(dirname(__FILE__)."/conf");
		self::PrepareDirectories(dirname(__FILE__));
		self::DbConnect();
		self::SessionStart();

		try
		{
			if (!$_SESSION['islogin'] || $_SESSION['username']=="" || $_SESSION['username']==null) {
				if (self::$_REQUEST['service_method']!='dologin') {
					echo "[SESSIONEND]";
					die();
				}
			}


			if (!is_file(self::$_REQUEST['service_file']))
				throw new Exception("[ServiceNotFoundException] Service '".self::$_REQUEST['service_file']."' doesn't exist!");

			require_once self::$_REQUEST['service_file'];

			$refl = new ReflectionClass(self::$_REQUEST['class_service']);
			$objService = $refl->newInstanceArgs(array(self::$_ROOT_DIR, self::$_DEFAULT_DIR));
			$objService->db = self::$db;
			$objService->_CONFIG = self::$_CONFIG;

			ob_start();


			$exceptionname = "";
			try
			{
				$exceptionname = "WebMethodNotFoundException";
				$servicemethod = $refl->getMethod(self::$_REQUEST['service_method']);

				$exceptionname = "WebParameterException";
				$methodparameters = $servicemethod->getParameters();
				$parameters = array();
				foreach($methodparameters as $methodparam)
				{
					$methodparamname = $methodparam->getName();

					if (array_key_exists($methodparamname, $_POST))
						$parameters[$methodparamname] = $_POST[$methodparamname];
					else
						$parameters[$methodparamname] = null;
				}

				$exceptionname = "WebMethodException";
				$retobj = $servicemethod->invokeArgs($objService, $parameters);
			}
			catch (Exception $ex)
			{
				throw new Exception("[$exceptionname] " . $ex->getMessage());
			}


			if ($_SESSION['islogin']) {
				FGTA_Session::UpdateSession(self::$db, session_id());
				FGTA_Session::RemoveExpiredSession(self::$db);
			}


			$dcon = ob_get_contents();
			ob_end_clean();


			//Service
			ob_start();

			$webresult = new FGTA_WebResult($retobj);

			$objService->_JsonService($dcon, $webresult);
			ob_end_flush();

		}
		catch (Exception $ex)
		{
			die("WEBEXCEPTION: " . $ex->getMessage());
		}

	}
}

FGTA_Service::main();
