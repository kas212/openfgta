<?php

class FGTA_Request
{
	protected static $db;
	protected static $_DEFAULT_DIR;
	protected static $_ROOT_DIR;
	protected static $_DEFAULT_CLASS_NAME = "_default";
	protected static $_REQUEST = array();
	protected static $_CONFIG = array();



	protected static function LoadConfig($CONFIG_DIR)
	{
		if (defined('__USERCONFIG_FOLDER'))
			if (is_dir(__USERCONFIG_FOLDER))
				$CONFIG_DIR = __USERCONFIG_FOLDER;

		require_once $CONFIG_DIR."/database.conf.php";
		require_once $CONFIG_DIR."/page.conf.php";
		require_once $CONFIG_DIR."/application.conf.php";

		self::$_CONFIG['DBCONF'] = $DBCONF;

		self::$_CONFIG['dbhost'] = $DBCONF['MAIN']['host'];
		self::$_CONFIG['dbuser'] = $DBCONF['MAIN']['user'];
		self::$_CONFIG['dbpass'] = $DBCONF['MAIN']['pass'];
		self::$_CONFIG['dbname'] = $DBCONF['MAIN']['dbname'];
		self::$_CONFIG['dbrole'] = $DBCONF['MAIN']['role'];

		self::$_CONFIG['default_tpl_file_ismandatory'] = true;

	}


	protected static function DbConnect()
	{
		$DSN = "firebird:dbname=".self::$_CONFIG['dbhost'].":".self::$_CONFIG['dbname'].";role=".self::$_CONFIG['dbrole'];
		self::$db = new PDO($DSN,
		                    self::$_CONFIG['dbuser'],
							self::$_CONFIG['dbpass'],
							array(
								PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
								PDO::ATTR_PERSISTENT=>true
							)
						);


	}


	protected static function GetRequestedClass()
	{
		global $_GET;

		if (array_key_exists('cl',  $_GET))
			$cl = empty($_GET['cl']) ? self::$_DEFAULT_CLASS_NAME : $_GET['cl'];
		else
			$cl = self::$_DEFAULT_CLASS_NAME;

		return $cl;
	}

	protected static function GetRequestedPage()
	{
		global $_GET;

		if (array_key_exists('page',  $_GET))
			$pg = $_GET['page'];
		else
			$pg = "";

		return $pg;
	}

	protected static function GetRequestedNs($cl)
	{
		global $_GET;

		if (array_key_exists('ns',  $_GET)) {
			$ns = empty($_GET['ns']) ? $cl : $_GET['ns'];
		} else {
			$ns = $cl;
		}

		return $ns;
	}

	protected static function GetRequestServiceMethodName()
	{
		global $_GET;

		if (array_key_exists('sm',  $_GET))
			$sm = empty($_GET['sm']) ? $cl : $_GET['sm'];
		else
			$sm = "_NotImplementedMethod";

		return $sm;
	}



	protected static function PrepareDirectories($ROOT_DIR)
	{
		self::$_REQUEST['param'] = "123";
		self::$_REQUEST['allowaccess'] = false;
		if (array_key_exists("id", $_GET)) {

			// akses database untuk cari data id


		} else {
			$cl = self::GetRequestedClass();
			$ns = self::GetRequestedNs($cl);

			if (defined('__ALLOW_DIRRECT_ACCESS'))
				if (__ALLOW_DIRRECT_ACCESS)
					self::$_REQUEST['allowaccess'] = true;
		}

		$pg = self::GetRequestedPage();
		$sm = self::GetRequestServiceMethodName();

		self::$_REQUEST['page'] = $pg;
		self::$_REQUEST['class'] = $cl;
		self::$_REQUEST['class_service'] = $cl;
		self::$_REQUEST['namespace'] = $ns;
		self::$_REQUEST['service_method'] = $sm;

		self::$_ROOT_DIR = $ROOT_DIR;
		self::$_DEFAULT_DIR = $ROOT_DIR . "/apps/$ns";


		self::$_REQUEST['app_file'] =  self::$_ROOT_DIR . "/apps/$ns/$cl.class.php";
		self::$_REQUEST['service_file'] =  self::$_ROOT_DIR . "/apps/$ns/$cl.class.php";

		if (!empty($pg)) {
			if (defined('__SHOW_AS_MOBILE__'))
				self::$_REQUEST['tpl_file'] =  self::$_ROOT_DIR . "/apps/$ns/$cl-$pg.html.mob.php";
			else
				self::$_REQUEST['tpl_file'] =  self::$_ROOT_DIR . "/apps/$ns/$cl-$pg.html.php";
		} else {
			if (defined('__SHOW_AS_MOBILE__'))
				self::$_REQUEST['tpl_file'] =  self::$_ROOT_DIR . "/apps/$ns/$cl.html.mob.php";
			else
				self::$_REQUEST['tpl_file'] =  self::$_ROOT_DIR . "/apps/$ns/$cl.html.php";
		}


		self::$_REQUEST['app_file_login'] =  self::$_ROOT_DIR . "/apps/_default/login.class.php";
		self::$_REQUEST['service_file_login'] =  self::$_ROOT_DIR . "/apps/_default/login.class.php";
		if (defined('__SHOW_AS_MOBILE__')) {
			self::$_REQUEST['tpl_file_login'] =  self::$_ROOT_DIR . "/apps/_default/login.html.mob.php";
		} else {
			self::$_REQUEST['tpl_file_login'] =  self::$_ROOT_DIR . "/apps/_default/login.html.des.php";
		}




		if (!is_file(self::$_REQUEST['app_file']))
			die("WEBEXCEPTION: [ClassNotFoundException] FGTA_Request: Class '".self::$_REQUEST['app_file']."' does not exist!");



		$html_desktop = str_replace(".html.php", ".html.des.php", self::$_REQUEST['tpl_file']);
		if (is_file($html_desktop))
			self::$_REQUEST['tpl_file'] = $html_desktop;

		if (!defined('FGTA_WebService'))
			if (array_key_exists('default_tpl_file_ismandatory', self::$_CONFIG))
				if (self::$_CONFIG['default_tpl_file_ismandatory'])
					if (!is_file(self::$_REQUEST['tpl_file']))
						die("WEBEXCEPTION: [TemplateNotFoundException] FGTA_Request: Template '".self::$_REQUEST['tpl_file']."' doesn't exist!");

		/*
		if (!defined('FGTA_WebService'))
			if (array_key_exists('default_tpl_file_ismandatory', self::$_CONFIG))
				if (self::$_CONFIG['default_tpl_file_ismandatory']) {

					$html_desktop = str_replace(".html.php", ".html.des.php", self::$_REQUEST['tpl_file']);
					if (is_file($html_desktop))



				}
		*/


	}

	protected static function SessionStart()
	{
		global $_SESSION;

		session_start();
		if (!array_key_exists('islogin', $_SESSION))
			$_SESSION['islogin'] = false;

		if (!array_key_exists('username', $_SESSION))
			$_SESSION['username'] = "";

	}




}
