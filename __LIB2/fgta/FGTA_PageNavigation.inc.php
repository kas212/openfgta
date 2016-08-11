<?php
if (!defined('__OPENFGTA__'))
	die('Cannot access file directly');


class FGTA_PageNavigation
{
	public static $__add_called;



	function __construct()
	{
		global $_SESSION;

		if (!array_key_exists('navis', $_SESSION))
			$_SESSION['navis'] = array();
	}


	public function Clear()
	{
		global $_SESSION;

		$_SESSION['navis'] = array();


	}


	public function Add($key, $link, $text)
	{
		global $_SESSION;

		self::$__add_called = true;


		$key = (int)$key;
		$navis = $_SESSION['navis'];

		if (!array_key_exists($key, $_SESSION['navis']))
		{
			$_SESSION['navis'][$key] = array('link'=>$link, 'text'=>$text);
		}
		else
		{
			/*
			print "<hr>";
			print "key: $key";
			print "</hr>";
			print "<pre>";
			print_r($_SESSION['navis']);

			print "<hr>";
			*/
			//$n = count($_SESSION['navis']);

			while (list($navkey, $nav) = each($_SESSION['navis']))
			{
				//print "navkey = $navkey, key=$key<br>";

				if ($navkey>$key)
				{
					//print "$navkey>$key : removing $navkey<br>";
					unset($_SESSION['navis'][$navkey]);
				}
				else if ($navkey==$key)
				{
					//print "$navkey==$key : updating $navkey<br>";
					$_SESSION['navis'][$navkey] = array('link'=>$link, 'text'=>$text);
				}
			}

			//print "</hr>";
			//print_r($_SESSION['navis']);

			//print "</pre>";
		}

	}


	public function GetNavigationPane()
	{
		global $_SESSION;

		$n = count($_SESSION['navis']);


		$i=0;
		if ($n==0)
		{
			$hrefs = "Home";
		}
		else
		{
			$hrefs = "<a href=\"?\">Home</a>";
		}

		foreach ($_SESSION['navis'] as $nav)
		{
			$text = $nav['text'];
			$link = $nav['link'];

			$i++;
			$hrefs .= " > ";
			if ($i==$n)
			{
				$hrefs .= $text;
			}
			else
			{
				$hrefs .= "<a href=\"?$link\">".$text."</a>";
			}

		}

		return $hrefs;
	}
}
