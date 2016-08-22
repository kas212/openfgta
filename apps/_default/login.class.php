<?php

	class login extends FGTA_Content
	{
		public function LoadPage()
		{
			global $_GET;

			$this->Scripts->load("login.js");
			$this->RedirectTo = $this->PARAM['redirectto'];

		}

		public function LoadMobile() {
			global $_GET;

			$this->Scripts->load("login.js");
			$this->RedirectTo = $this->PARAM['redirectto'];

			$this->Test = "1234";

		}


		public function dologin($username, $password) {

			if ($username==__ROOT_USER && md5($password)==__ROOT_PASSWORD) {

				$_SESSION['islogin'] = true;
				$_SESSION['username'] = $username;
				$_SESSION['userfullname'] = $username;
				$_SESSION['firstpage'] = 'fgtadoday';
				$_SESSION['themecolor'] = '-gray';

				$objUser = new stdClass;
				$objUser->username = $username;
				$objUser->fullname = $username;
				return $objUser;
			}



			$db = $this->db;
			try {
				$sql = "SELECT
				        USER_ID, USER_NAME, USER_PASSWORD, USER_FIRSTPAGE, USER_THEMECOLOR
				        FROM FGT_USER WHERE USER_ID = :USER_ID ";
				$stmt = $db->prepare($sql);
				$stmt->execute(array(
								':USER_ID' => $username
						));

				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if (count($row)==0)
					return null;

				$USER_ID = $row['USER_ID'];
				$USER_NAME = $row['USER_NAME'];
				$USER_PASSWORD = $row['USER_PASSWORD'];
				$USER_FIRSTPAGE = $row['USER_FIRSTPAGE'];
				$USER_THEMECOLOR = $row['USER_THEMECOLOR'];


				if ($USER_PASSWORD != md5($password))
					return null;



				/* login berhasil simpan di session */
				if (!FGTA_Session::IsSessionExist($this->db, session_id())) {
					FGTA_Session::CreateSession($this->db, session_id(), $USER_ID);
				}


				$_SESSION['islogin'] = true;
				$_SESSION['USER_ID'] = $USER_ID;
				$_SESSION['username'] = $USER_ID;
				$_SESSION['userfullname'] = $USER_NAME;
				$_SESSION['firstpage'] = $USER_FIRSTPAGE;
				$_SESSION['themecolor'] = $USER_THEMECOLOR;

				$objUser = new stdClass;
				$objUser->username = $USER_ID;
				$objUser->fullname =  $USER_NAME;

				return $objUser;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}

		}




	}
