<?php
    class Common_model extends CI_Model {
        public function __construct() {
             $this->load->database();
        }

        public function getError($error) {
            $sql = "
                Select
                    *
                from
                    errors
                where
                    error_code = '$error'
                    and error_code != '9999'
            ";

            $query = $this->db->query($sql);
            $results = $query->row_array();

            if ($results) {
                return $results;
            } else {
                return false;
            }
        }

        public function boolNoCommitQuery($sql) {
            $query = $this->db->query($sql);
            $results = $query->row_array();

            if ($results) {
                return false;
            } else {
                return true;
            }
        }

        public function drop_account_month($account = null, $month = null, $year = null) {

            $sql = "
                select
                	a.month,c.description as month_desc
                from
                	account_data_summary a,
                    year b,
                    months c
                where
                    a.month = c.month
                    and a.year = b.year
                    and a.year = $year
                	and a.account_id = '$account'
                group by
                	c.month
            ";

            $query = $this->db->query($sql);
            $results = $query->result_array();

            $html_append = '
                <div class="input-field">
                    <select id="month_account">
                        <option value="-999" disabled selected>Select Month</option>';

            if ($results) {
                foreach($results as $result) {
                    if ($month == $result['month']) {
                        $html_append .= '<option value="'. $result['month'] . '" selected>' . $result['month_desc'] . '</option>';
                    } else {
                        $html_append .= '<option value="'. $result['month'] . '">' . $result['month_desc'] . '</option>';
                    }
                }
            } else {
                $html_append .= '<option value="-999" selected disable>No Records Found.</option>';
            }
            // echo $sql;
            $html_append .= '
                    </select>
                </div>';

            return $html_append;
        }
        public function drop_account_year($account = null, $year = null) {

            $sql = "
                select
                	a.year,b.description as year_desc
                from
                	account_data_summary a,
                    year b
                where
                    a.year = b.year
                    and a.account_id = '$account'
                group by
                	a.year
            ";

            $html_append = '
                <div class="input-field">
                    <select id="year_account">
                        <option value="" disabled selected>Select Year</option>';

            $query = $this->db->query($sql);
            $results = $query->result_array();

            foreach($results as $result) {
                if ($year == $result['year'])
                    $html_append .= '<option value="'. $result['year'] . '" selected>' . $result['year_desc'] . '</option>';
                else
                    $html_append .= '<option value="'. $result['year'] . '">' . $result['year_desc'] . '</option>';
            }

            $html_append .= '
                    </select>
                </div>';

            return $html_append;
        }
        public function drop_month($month = null) {
            $sql = "
                select
                	*
                from
                    months
            ";

            $html_append = '
                <div class="input-field">
                    <select id="month">
                        <option value="" disabled selected>Select Month</option>';

            $query = $this->db->query($sql);
            $results = $query->result_array();

            foreach($results as $result) {
                if ($month == $result['month'])
                    $html_append .= '<option value="'. $result['month'] . '" selected>' . $result['description'] . '</option>';
                else
                    $html_append .= '<option value="'. $result['month'] . '">' . $result['description'] . '</option>';
            }

            $html_append .= '
                    </select>
                </div>';

            return $html_append;
        }
        public function drop_year($year = null) {
            $sql = "
                select
                	*
                from
                    year
            ";

            $html_append = '
                <div class="input-field">
                    <select id="year">
                        <option value="" disabled selected>Select Year</option>';

            $query = $this->db->query($sql);
            $results = $query->result_array();

            foreach($results as $result) {
                if ($year == $result['year'])
                    $html_append .= '<option value="'. $result['year'] . '" selected>' . $result['description'] . '</option>';
                else
                    $html_append .= '<option value="'. $result['year'] . '">' . $result['description'] . '</option>';
            }

            $html_append .= '
                    </select>
                </div>';

            return $html_append;
        }
    }
?>
