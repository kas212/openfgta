<?php
if (defined('__FGTA_WebService__')) return;
define('__FGTA_WebService__', 1);


class FGTA_WebService
{
	public $ROOT_DIR;
	public $DEFAULT_DIR;
	public $USERNAME;
	public $db;

	function __construct($ROOT_DIR, $DEFAULT_DIR)
	{
		$this->DEFAULT_DIR = $DEFAULT_DIR;
		$this->ROOT_DIR = $ROOT_DIR;

	}

	public function debug($string)
	{
		echo "_DEBUGTEXT: \n" . $string;
	}


	function _JsonService($content, $obj)
	{
		if (!empty($content))
			echo $content;
		else
			echo json_encode($obj);
	}


	function _NotImplementedMethod()
	{
		echo "WEBEXCEPTION: Not implemented method";
	}
}
