<?php

    class FGTA_Session
    {

        static function CreateSession($db, $session_id, $user_id) {
            $sql = "
            INSERT INTO FGT_SESS
            (SESS_ID, SESS_DATE, SESS_DATELAST, SESS_DATEEXP, SESS_IP, USER_ID)
            VALUES
            (:SESS_ID, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, DATEADD(30 MINUTE TO CURRENT_TIMESTAMP), :SESS_IP, :USER_ID)
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute(array(
                ':SESS_ID' => $session_id,
                ':SESS_IP' => $_SERVER["REMOTE_ADDR"],
                ':USER_ID' => $user_id
            ));

        }

        static function IsSessionExist($db, $session_id) {
            $sql = "SELECT SESS_ID FROM FGT_SESS WHERE SESS_ID=:SESS_ID";
            $stmt = $db->prepare($sql);
            $stmt->execute(array(
                ':SESS_ID' => $session_id
            ));

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows)>0)
                return true;
            else
                return false;
        }


        static function RemoveSession($db, $session_id) {
            $sql = "DELETE FROM FGT_SESS WHERE SESS_ID=:SESS_ID";
            $stmt = $db->prepare($sql);
            $stmt->execute(array(
                ':SESS_ID' => $session_id
            ));
        }

        static function RemoveExpiredSession($db) {
            $sql = "DELETE FROM FGT_SESS WHERE SESS_DATEEXP < CURRENT_TIMESTAMP";
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }


        static function UpdateSession($db, $session_id) {
            $sql = "
                UPDATE FGT_SESS
                SET
                SESS_DATELAST = CURRENT_TIMESTAMP,
                SESS_DATEEXP = DATEADD(30 MINUTE TO CURRENT_TIMESTAMP)
                WHERE
                SESS_ID=:SESS_ID
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute(array(
                ':SESS_ID' => $session_id
            ));            
        }


    }
