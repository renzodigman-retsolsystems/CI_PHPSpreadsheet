<?php
    class Myaccount_model extends CI_Model {
        public function __construct() {
             $this->load->database();
        }

        public function changePW($username = "", $old_pw = "", $new_pw = "", $conf_pw = "") {

            if ($new_pw != $conf_pw) { return "0005"; }


            $sql = "
                Select
                    a.username,
                    a.email,
                    a.first_name,
                    a.last_name,
                    a.pos_id,
                    b.description as pos_desc,
                    a.password,
                    a.status
                from
                    users a,
                    positions b
                where
                    a.pos_id = b.pos_id
                    and a.username = '$username'
                    OR a.email = '$username'
            ";

            $query = $this->db->query($sql);
            $results = $query->row_array();

            $is_valid = password_verify($old_pw,$results['password']);
            if ($is_valid) {

                if ($old_pw == $new_pw) {
                    return "0006";
                }

                $this->db->set('password', password_hash($new_pw, PASSWORD_DEFAULT));
                $this->db->where('username', $username);

                if ($this->db->update('users'))
                    return "9998";
                else
                    return "8888";
            } else {
                return "0004";
            }
        }
    }
?>
