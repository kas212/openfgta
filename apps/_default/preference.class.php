<?php

    class preference extends FGTA_Content
    {

        public function PageLoad() {

        }

        public function GetPrefData($username) {
			$db = $this->db;
			try {
            	if ($username != $_SESSION['username'])
					throw new Exception("Session is invalid for '$username'");


				$sql = "SELECT * FROM FGT_USER WHERE USER_ID = :USER_ID";
				$stmt = $db->prepare($sql);
				$stmt->execute(array(
						':USER_ID' => $username
					));

				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if (count($row)==0)
					throw new Exception("Username '$username' tidak ditemukan.");

				$obj = new stdClass;
				$obj->fullname = $_SESSION['userfullname'];
				$obj->themecolor = (empty($row['USER_THEMECOLOR'])) ? '' : $row['USER_THEMECOLOR'];
				$obj->firstpage =  (empty($row['USER_FIRSTPAGE']) || $row['USER_FIRSTPAGE']=='') ? '_default/fgtatoday' : $row['USER_FIRSTPAGE'];

				return $obj;
			} catch (Exception $e) {
				throw new Exception('Error in GetPrefData.\r\n' . $e->getMessage());
			}
        }

		public function SavePrefData($data) {

			$db = $this->db;
			try {
				$username = $data['username'];
				$passold = $data['passold'];
				$pass1 = $data['pass1'];
				$pass2 = $data['pass2'];

				if ($username != $_SESSION['username'])
					throw new Exception("Session is invalid for '$username'");

				if (!empty($passold)) {
					if (empty($pass1))
						throw new Exception("Password tidak boleh kosong");

					if ($pass2!=$pass1)
						throw new Exception("re entry password ke dua tidak cocok dengan password pertama.");


					$sql = "SELECT USER_ID, USER_NAME, USER_PASSWORD FROM FGT_USER WHERE USER_ID = :USER_ID ";
					$stmt = $db->prepare($sql);
					$stmt->execute(array(
							':USER_ID' => $username
						));

					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					if (count($row)==0)
						throw new Exception("Username '$username' tidak ditemukan.");

					$USER_PASSWORD = $row['USER_PASSWORD'];
					if ($USER_PASSWORD != md5($passold))
						throw new Exception("Password lama yang dimasukkan salah.");


					$sql = "UPDATE FGT_USER SET USER_PASSWORD=:NEWPASSWORD WHERE USER_ID = :USER_ID ";
					$stmt = $db->prepare($sql);
					$stmt->execute(array(
							':NEWPASSWORD' => md5($pass1),
							':USER_ID' => $username
						));

				}

				$_SESSION['new_themecolor'] = $data['themecolor'];

				$sql = "UPDATE FGT_USER
				        SET
						USER_FIRSTPAGE = :USER_FIRSTPAGE,
						USER_THEMECOLOR = :USER_THEMECOLOR
						WHERE USER_ID = :USER_ID ";
				$stmt = $db->prepare($sql);
				$stmt->execute(array(
						':USER_FIRSTPAGE' => $data['firstpage'],
						':USER_THEMECOLOR' => $data['themecolor'],
						':USER_ID' => $username
					));

				$obj = new stdClass;
				$obj->success = true;
				$obj->username = $data['username'];

				return $obj;
			} catch (Exception $e) {
				throw new Exception('Error in SavePrefData.\r\n' . $e->getMessage());
			}
		}

		public function UploadImage($username) {
			global $_FILES;

			if (isset($_FILES['file']) )  {
				try {
					if (!is_dir(__DATA_FOLDER))
						throw new Exception(__DATA_FOLDER . ' belum diset atau tidak ditemukan!');

					$target_dir = __DATA_FOLDER . '/profiles/';
					if (!is_dir($target_dir))
						throw new Exception($target_dir . ' belum diset atau tidak ditemukan!');

					$userprofiledir = $target_dir . $username . '/';
					if (!is_dir($userprofiledir))
						mkdir($userprofiledir);

					$target_file = $userprofiledir . basename($_FILES["file"]["name"]);
				    $uploadOk = 1;
				    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				    $newfilename = $userprofiledir . "profile."  . strtolower($imageFileType);

					$check = getimagesize($_FILES["file"]["tmp_name"]);
				    if($check !== false) {
				        //echo "File is an image (" . $check["mime"] . ")\r\n";
				        $uploadOk = 1;
				    } else {
				        echo "File is not an image.";
				        $uploadOk = 0;
				    }

					if(strtolower($imageFileType) != "jpg" ) {
				        echo "Sorry, only JPG, and your file is $imageFileType.\r\n";
				        $uploadOk = 0;
				    }

					if ($uploadOk == 0) {
				        echo "Sorry, your file was not uploaded.\r\n";
				    } else {
				        if (move_uploaded_file($_FILES["file"]["tmp_name"], $newfilename)) {
				            //echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.\r\n";
							echo "ok";
				        } else {
				            echo "Sorry, there was an error uploading your file.\r\n";
				    	}

					}

					return true;

				} catch (Exception $e) {
					throw new Exception("Error in UploadImage.\r\n" . $e->getMessage());
				}



			}
		}


		public function GetImage() {
			global $_GET;
			$username = $_GET['username'];

			$target_file = __DATA_FOLDER . '/profiles/' . $username  . "/profile.jpg";
			if (!is_file($target_file)) {
				//$target_file  = __DATA_FOLDER . '/HRMS/' . '/_default.jpg';
				$target_file = __ROOT_DIR . '/img/_default.jpg';
			}

			$type = 'image/jpeg';
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($target_file));
			readfile($target_file);
			die();
		}

    }
