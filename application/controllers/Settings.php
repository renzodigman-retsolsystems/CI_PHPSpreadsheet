<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	public function index() {
		$s = $this->session->all_userdata();

		if (empty($s['username'])) { show_404(); }
		if (empty($s['status'])) { show_404(); }
		else { if ($s['status'] != 1) { show_404(); }}

		$html_append = '
			<br>
			<h4 class="center grey lighten-2 black-text" style="padding:5px;">Settings</h4>
			<h1>On Going</h1>
		';

		$output = json_encode(["error" => 0, "html_append" => $html_append]);
		echo $output;

	}
}
