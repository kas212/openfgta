<?php
if (!defined('__OPENFGTA__'))
	die('Cannot access file directly');


    class FGTA_Sequencer
    {
        private $db;
        private $seqtable;
        private $param;

        function __construct($db, $seqtable, $param) {
            $this->db = $db;
            $this->seqtable = $seqtable;
            $this->param = $param;
        }

        public function get($paramkey) {
            return $this->param[$paramkey];
        }

        public function getseq($zerofillen) {
            try
            {
                $fields = array();
                $sqlparams = array();
                $paramvalues = array();
                $insertvalues = array();
                $updatevalues = array();
                foreach ($this->param as $key=>$value)
        		{
                    $fields[] = $key;
                    $sqlparams[] = "$key=:$key";
                    $paramvalues[":$key"] = $value;
                    $insertvalues[] = ":$key";
                }

                $stringfields = implode(", ", $fields);
                $stringsqlparams = implode(" AND ", $sqlparams);
                $stringinsertvalues = implode(", ", $insertvalues);


                $sql = "SELECT LASTID, $stringfields FROM $this->seqtable WHERE $stringsqlparams";
                $stmt = $this->db->prepare($sql);
				$stmt->execute($paramvalues);
				$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);


                if (count($rows)==0) {
                    $sql = "INSERT INTO $this->seqtable ($stringfields) VALUES ($stringinsertvalues) ";
                    $stmt = $this->db->prepare($sql);
    				$stmt->execute($paramvalues);
                    $LASTID = 0;
                } else {
                    $LASTID = $rows[0]['LASTID'];
                }

                $LASTID++;

                $paramvalues[":LASTID"] = $LASTID;
                $sql = "UPDATE $this->seqtable SET LASTID=:LASTID WHERE $stringsqlparams";
                $stmt = $this->db->prepare($sql);
				$stmt->execute($paramvalues);


                return str_pad($LASTID, $zerofillen, '0', STR_PAD_LEFT);
            }
            catch (Exception $ex)
            {
                throw new Exception("Sequencer Error\r\n" . $ex->getMessage());
            }
        }


        public function getseqformated($prefix, $zerofillen) {
            try
            {
                $seq = $prefix;
                foreach ($this->param as $key=>$value)
        		{
                    $seq .= "/" . $this->get($key);
                }
                $seq .=  "/" . $this->getseq($zerofillen);

                return $seq;
            }
            catch (Exception $ex)
            {
                throw new Exception("Formated Sequencer Error\r\n" . $ex->getMessage());
            }
        }

    }
