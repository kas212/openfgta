<?php

class FGTA_FileLoader
{
	public $ROOT_DIR;
	public $DEFAULT_DIR;
	public $data;


	function __construct($ROOT_DIR, $DEFAULT_DIR)
	{
		$this->DEFAULT_DIR = $DEFAULT_DIR;
		$this->ROOT_DIR = $ROOT_DIR;

		$this->data = array();
	}

	public function load($filename, $dir=null)
	{
		if (empty($dir))
			$file = $this->DEFAULT_DIR . "/" . $filename;
		else
			$file = $this->ROOT_DIR . "/" . $dir . "/" . $filename;


		if (!is_file($file))
			throw new Exception("Require file '$file' is not found!");

		$this->data[] = $file;

	}
}
