<?php
    class Process_model extends CI_Model {
        public function __construct() {
             $this->load->database();
        }

        public function getAccountHeader($account_id) {
          $sql = "
            select * from account_headers where account_id = ".$account_id."
          ";

          $query = $this->db->query($sql);
          $results = $query->result_array();

          if ($results) {
              return $results;
          } else {
              return false;
          }
        }

        public function checkTableTrans($account_header, $transactions) {

            $account_id = $account_header[0]['account_id'];
            $year = $transactions['year'];
            $month = $transactions['month'];

            $table_name = $account_id."_transaction_".$year.$month;

            $table_not_exists = $this->common_model->checkTableNotExist($table_name);

            if($table_not_exists) {
              $sql = "
                  CREATE TABLE IF NOT EXISTS `".$table_name."` (
                  `transactionid` INT(11) NOT NULL AUTO_INCREMENT,"
                  ;

              foreach($account_header as $column_name => $value) {

                $sql .= "
                  `".
                  $value['description']."` ".$value['data_type']." ".($value['not_null'] = 1 ? 'NOT NULL': '').
                  ",";

              }

              $sql .= "
                  PRIMARY KEY (`transactionid`),
                  UNIQUE KEY `transactionid_UNIQUE` (`transactionid`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=159311 DEFAULT CHARSET=latin1;
                  ";


              $query = $this->db->query($sql);
            }

            return $table_name;

        }

        public function insertTrans($entry, $table_name) {

          $sql = "INSERT INTO `".$table_name."` (
          `year`, `month`, `storecode`, `skucode`, `quantity`, `retailsale`, `noofdayswithsales`, `percent`, `avgquantityperday`, `avgsalesperday`
          )";

          $sql .= "VALUES ";

          foreach($entry as $column_name) {
            $sql .= "(";

            foreach ($column_name as $value) {

              $sql .= "'".$value."',";

            }
            $sql = rtrim($sql, ",");

            $sql .= "),";
          }
          $sql = rtrim($sql, ",");

          $result = $this->db->query($sql);

          $result = ($result = true) ? $result : mysql_error($sql, $this->db);

          return $result;

//          $this->db->insert($table_name, $entry);

//          return ($this->db->affected_rows() != 1) ? false : true;
        }

        public function getAccountDet($account_id = "", $username = "") {
            $sql = "
                select
                    a.account_id,
                    a.description,
                    a.image,
                    a.height,
                    a.width
                from
                    accounts a,
                    user_accounts b,
                    users c
                where
                    a.account_id = b.account_id
                    and b.username = c.username
                    and a.status = 1
                    and a.is_processing = 1
                    and c.status = 1
                    and b.username = '$username'
                    and a.account_id = '$account_id';
            ";

            $query = $this->db->query($sql);
            $results = $query->row_array();

            if ($results) {
                return $results;
            } else {
                return false;
            }
        }
    }
?>
