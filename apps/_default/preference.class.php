<?php

    class preference extends FGTA_Content
    {

        public function PageLoad() {

        }

        public function GetPrefData($username) {
			try {
            	if ($username != $_SESSION['username'])
					throw new Exception("Session is invalid for '$username'");

				$obj = new stdClass;
				$obj->fullname = $_SESSION['userfullname'];

				return $obj;
			} catch (Exception $e) {
				throw new Exception('Error in GetPrefData.\r\n' . $e->getMessage());
			}
        }

		public function SavePrefData($data) {
			try {

				$obj = new stdClass;
				$obj->success = false;

				return $obj;
			} catch (Exception $e) {
				throw new Exception('Error in SavePrefData.\r\n' . $e->getMessage());
			}
		}

    }
