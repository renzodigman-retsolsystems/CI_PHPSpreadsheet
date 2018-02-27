<?php
    class Dashboard_model extends CI_Model {
        public function __construct() {
             $this->load->database();
        }

        public function populateAccount($keyword = "") {

            $add_sql = "";

            if ($keyword != "") {
                $add_sql = " and description like '%$keyword%' ";
            }

            $sql = "
                Select
                    a.account_id,
                    a.description,
                    a.image,
                    a.is_processing,
                    a.height,
                    a.width,
                    a.status
                from
                    accounts a,
                    user_accounts b,
                    users c
                where
                    a.account_id = b.account_id
                    and b.username = c.username
                    and a.account_id != ''
                    and a.status = 1
            ";
            $sql .= $add_sql;
            $sql .= "
                order by
                    a.description asc
            ";

            $query = $this->db->query($sql);
            $results = $query->result_array();

            if ($results) {
                return $results;
            } else {
                return false;
            }


        }
    }
?>
