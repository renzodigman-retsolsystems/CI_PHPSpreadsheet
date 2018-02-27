<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index() {
		$s = $this->session->all_userdata();

		if (empty($s['username'])) { show_404(); }
		if (empty($s['status'])) { show_404(); }
		else { if ($s['status'] != 1) { show_404(); }}

		$data['title'] = "Project One";
		$data2['full_name'] = $s['first_name'] . ' ' . $s['last_name'];
		$data['full_name'] = $data2['full_name'];
		$data['is_main_pages'] = 1;
		$data['pageChange'] = 'dashboard/accounts';
		// $data['pageChange'] = 'myaccount/index';

		$this->load->view('templates/header', $data);
		$this->load->view('dashboard/index', $data2);
		$this->load->view('templates/footer');
	}

	public function accounts() {
		$s = $this->session->all_userdata();

		if (empty($s['username'])) { show_404(); }
		if (empty($s['status'])) { show_404(); }
		else { if ($s['status'] != 1) { show_404(); }}

		$populateAccounts = $this->dashboard_model->populateAccount();
		if ($populateAccounts) {
			$html_append = '
			<br>
			<h4 class="center grey lighten-2 black-text" style="padding:5px;">Accounts available:</h4>
				<div class="row">
			';
			foreach($populateAccounts as $account) {

				if ($account['is_processing'] != 1) {
					$add_button = '<h6>No Actions Available</h6>';
				} else {
					$add_button = '<a href="#" class="btn indigo darker-5 changePage" name="process?acct=' . $account['account_id'] . '"><b>Process</b></a>';
				}

				$html_append .= '
					<div class="col s6 m4 l3">
						<div class="card small grey lighten-5">
							<div class="card-image">
								<center><img src="' . base_url() . $account['image'] . '" alt="sample" style="height:' . $account['height'] . '; width:' . $account['width'] . '; margin-top:20px;"></center>
							</div>
							<div class="card-content">
								<center><p>' . $account['description'] . '</p></center>
							</div>
							<div class="card-action center">
								<div class="row">
									<div class="col s12 m12 6">
										' . $add_button . '
									</div>
								</div>
							</div>
						</div>
					</div>
				';
			}
			$html_append .= '</div>';
		} else {
			$html_append = '<center><h3>No Available Accounts</h3></center>';
		}

		$output = json_encode(["error" => 0, "html_append" => $html_append]);
		echo $output;

	}

	public function signout() {
		$this->session->sess_destroy();
		redirect('login');
	}

}
