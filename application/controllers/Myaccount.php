<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount extends CI_Controller {
	public function userchangepw() {
		$s = $this->session->all_userdata();

		if (empty($s['username'])) { show_404(); }
		if (empty($s['status'])) { show_404(); }
		else { if ($s['status'] != 1) { show_404(); }}

		// $data['title'] = "Project One";
		// $data2['full_name'] = $s['first_name'] . ' ' . $s['last_name'];
		// $data['full_name'] = $data2['full_name'];
		// $data['is_main_pages'] = 1;
		$valid = 1;

		if (empty($this->input->post('old-pw'))) { $valid = 0; } else { $old_pw = $this->input->post('old-pw'); }
		if (empty($this->input->post('new-pw'))) { $valid = 0; } else { $new_pw = $this->input->post('new-pw'); }
		if (empty($this->input->post('conf-pw'))) { $valid = 0; } else { $conf_pw = $this->input->post('conf-pw'); }

		if ($valid) {
			$changePWStatus = $this->myaccount_model->changePW($s['username'],$old_pw,$new_pw,$conf_pw);
			// $data['pageChange'] = 'myaccount?err='.$changePWStatus;
		} else {
			// $data['pageChange'] = 'myaccount?err='.'0002';
			$changePWStatus = "0002";
		}

		$output = json_encode(["error" => $changePWStatus]);
		echo $output;

		// $this->load->view('templates/header', $data);
		// $this->load->view('dashboard/index', $data2);
		// $this->load->view('templates/footer');
	}

	public function index() {
		$s = $this->session->all_userdata();

		if (empty($s['username'])) { show_404(); }
		if (empty($s['status'])) { show_404(); }
		else { if ($s['status'] != 1) { show_404(); }}
		$pw_modal = "";

		if (empty($this->input->get("err"))) {
			$err_display = '';
		} else {
			$err = $this->input->get("err");
			$pw_modal = "$('#pw-modal').modal('close');";
			$pw_modal .= "$('#pw-modal').modal('open');";
			$errorData = $this->common_model->getError($this->input->get('err'));
			$err_display = '
			<div class="err-cont chip ' . $errorData['color'] . '" style="padding: 10px; width: 100%; height: 50px;">
				<i class="err-icon material-icons white-text left" style="padding-top: 2px;">' . $errorData['icon'] . '</i>
				<h6 class="white-text">
					<span id="err-hdr" style="font-weight:bold;">
						' . $errorData['header'] . ' # ' . $errorData['error_code'] . '
					</span>:
					<span id="err-msg">
						' . $errorData['description'] . '
					</span>.
				<h6>
			</div>
			';
		}

		$html_append = '
			<br>
			<h4 class="center grey lighten-2 black-text" style="padding:5px;">User Information</h4>
			<div class="row">
				<div class="col s12 m8 offset-m2 l6 offset-l3">
					<div class="card grey lighten-5">
						<div class="card-content">
							<div class="row">
								<div class="col s12 center">
									<b>Personal Information</b>
								</div>
								<div class="input-field col s10 offset-s1">
									<input id="username" name="username" type="text" class="validate" value="' . $s['username']. '">
									<label for="username">Username</label>
								</div>
								<div class="input-field col s10 offset-s1">
									<input id="email" name="email" type="email" class="validate" value="' . $s['email']. '">
									<label for="email">Email</label>
								</div>
								<div class="input-field col s10 offset-s1">
									<input id="fname" name="fname" type="text" class="validate" value="' . $s['first_name']. '">
									<label for="fname">First Name</label>
								</div>
								<div class="input-field col s10 offset-s1">
									<input id="lname" name="lname" type="text" class="validate" value="' . $s['last_name']. '">
									<label for="lname">Last Name</label>
								</div>
								<div class="input-field col s10 offset-s1 center">
									<div class="chip lime">
									Position: [<b>' . $s['pos_desc']. '</b>]
									</div>
								</div>
							</div>
						</div>
						<div class="card-action center">
							<div class="row">
								<div class="input-field col s6">
									<a href="#conf-modal" class="modal-trigger btn indigo darker-5"><b>Save Information</b></a>
								</div>
								<div class="input-field col s6">
									<a href="#pw-modal" class="modal-trigger btn white black-text"><b>Change Password</b></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="pw-modal" class="modal" style="width:30%;">
				' . form_open('changepw', array("id"=>"frm-changepw")) . '
					<div class="modal-content">
						<div class="col s12 center">
							<b>Change Password</b>
						</div><br>
						' . $err_display . '
						<div class="input-field col s12">
							<input id="old-pw" name="old-pw" type="password" class="validate">
							<label for="old-pw">Old Password</label>
						</div>
						<div class="input-field col s12">
							<input id="new-pw" name="new-pw" type="password" class="validate">
							<label for="new-pw">New Password</label>
						</div>
						<div class="input-field col s12">
							<input id="conf-pw" name="conf-pw" type="password" class="validate">
							<label for="conf-pw">Confirm New Password</label>
						</div>
						<div class="input-field col s12 center">
							<a href="#!" id="btn-change-pw" class="modal-action indigo darker-5 white-text btn">Confirm Password</a>
						</div>
					</div>
				</form>
			</div>
			<div id="conf-modal" class="modal" style="width:30%;">
				<div class="modal-content">
					<div class="center">
						<h6>Are you sure you want to commit the changes you\'ve made to your account? </h6><br>
						<a href="#!" class="modal-action modal-close indigo darker-5 white-text btn">Yes</a>
						<a href="#!" class="modal-action modal-close white black-text btn">No</a>
					</div>
				</div>
			</div>
			<script>
				$(document).ready(function() {
					Materialize.updateTextFields();
					$(".modal").modal();
					'.
					$pw_modal
					.'
					$("#btn-change-pw").click(function (e) {
						e.preventDefault();
						jQuery.ajax({
							url: baseurl + "myaccount/userchangepw",
							type: "POST",
							data: $("#frm-changepw").serialize(),
							dataType: "json",
							success: function(res) {
								changePage("myaccount?err="+res.error);
							}, error: function(e) {
								alert("Error on change password, Please try again later.!");
							}
						});
					});
				});

			</script>
		';

		// $("#frm-changepw").submit();
		$output = json_encode(["error" => 0, "html_append" => $html_append]);
		echo $output;

	}
}
