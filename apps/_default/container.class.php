<?php

	class container extends FGTA_Content
	{
		public function LoadPage()
		{
			global $_GET;

			$this->Styles->load("container.css");
			$this->Scripts->load("container.js");
		}

		public function LoadMobile() {
			global $_GET;

		}

		public function GetProgramInfo($program) {
			$obj = new stdClass;

			if (!$_SESSION['islogin'] || $_SESSION['username']=="" || $_SESSION['username']==null) 	{
				$obj->isLogin = 0;
			} else {
				$obj->isLogin = 1;
			}

			return $obj;
		}



	}
