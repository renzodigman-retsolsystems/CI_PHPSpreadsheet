<?php
    class Login_model extends CI_Model {
        public function __construct() {
             $this->load->database();
        }

        public function loadLogin($username,$password) {
            $return_val = $this->login_model->checkLogin($username,$password);

            return $return_val;
        }

        private function checkLogin($user,$password) {

            $is_valid = 0;

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
                    and a.username = '$user'
                    OR a.email = '$user'
            ";

            $query = $this->db->query($sql);
            $results = $query->row_array();

            if ($results) {
            $is_valid = password_verify($password,$results['password']);
                if ($is_valid) {
                    if ($results['status'] == 1) {
                        $sess_data = array(
                            'username' => $results['username'],
                            'email' => $results['email'],
                            'first_name' => $results['first_name'],
                            'last_name' => $results['last_name'],
                            'pos_id' => $results['pos_id'],
                            'pos_desc' => $results['pos_desc'],
                            'status' => $results['status'],
                        );

                        $this->session->set_userdata($sess_data);
                        return '9999';
                    } else {
                        return '0003';
                    }
                } else {
                    return '0002';
                }
            } else {
                return '0001';
            }

        }
    }
?>
