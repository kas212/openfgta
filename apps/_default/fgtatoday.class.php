<?php


    class fgtatoday extends FGTA_Content
    {

        public function LoadPage() {

        }

        public function LoadMobile() {

        }


        public function GetTodayContent($contenttype_id, $n=5) {

            $sql = "SELECT FIRST $n *
			        FROM FGT_CONTENT
					WHERE
					CONTENTTYPE_ID=:CONTENTTYPE_ID
					AND CONTENT_PUBLISHDATE <= cast('Now' as date)
					ORDER BY CONTENT_PUBLISHDATE DESC, \"_CREATEDATE\" DESC
					";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                'CONTENTTYPE_ID' => $contenttype_id
            ));
            $rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }



    }
