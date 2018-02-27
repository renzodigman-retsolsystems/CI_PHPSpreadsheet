<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index() {
		$data['is_main_pages'] = 0;
		$data['title'] = "Unilever POS";
		$data['header'] = "Project ONE (POS)";
		$data2['errorMsg'] = "";

		if ($this->input->get('err') != '') {
			$errorData = $this->common_model->getError($this->input->get('err'));

			$data2['errorMsg'] = '
			<div class="chip ' . $errorData['color'] . '" style="padding: 10px; width: 100%; height: 50px;">
				<i class="close material-icons right white-text">close</i>
				<i class="material-icons white-text left" style="padding-top: 2px;">' . $errorData['icon'] . '</i>
				<h6 class="white-text"><b>' . $errorData['header'] . ' # ' . $errorData['error_code'] . ':</b> ' . $errorData['description'] . '.<h6>
			</div>
			';
		}

		$this->load->view('templates/header', $data);
		$this->load->view('login/index', $data2);
		$this->load->view('templates/footer');
	}

	public function userauth() {
		$user = $this->input->post('user');
		$password = $this->input->post('password');

		$userAuth = $this->login_model->loadLogin($user,$password);

		if ($userAuth) {
			if ($userAuth == '9999') {
				redirect('dashboard');
			} else {
				redirect('login?err=' . $userAuth);
			}
		} else {
			redirect('login?err=' . $userAuth);
		}
	}
}
