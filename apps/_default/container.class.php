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

		public function GetBgColor() {
			switch ($this->THEME_COLOR) {
				case "-red":
					return "#F8c9c9";

				case "-green":
					return "#E0F892";

				case "-orange":
					return "#eadfb2";

				case "-blue":
					return "#91b8e3";

				case "-gray":
					return "#eee";

				default:
					return "#eee";
			}
		}

		public function GetBorderColor() {
			switch ($this->THEME_COLOR) {
				case "-red":
					return "#f6c1bc";

				case "-green":
					return "#B1C242";

				case "-orange":
					return "#d4a375";

				case "-blue":
					return "#6a88a9";

				case "-gray":
					return "#abafb8";	

				default:
					return "#ddd";

			}
		}

	}
