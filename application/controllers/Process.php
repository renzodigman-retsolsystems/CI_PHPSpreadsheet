<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require ('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Process extends CI_Controller {


	public function processexcel() {
		$s = $this->session->all_userdata();
		if (empty($s['username'])) { show_404(); }
		if (empty($s['status'])) { show_404(); }
		else { if ($s['status'] != 1) { show_404(); }}

		if (empty($this->input->post('account_id'))) {
			show_404();
		} else {
			$account_id = $this->input->post('account_id');
		}

		$config['upload_path'] = "assets/img/" . $account_id . "/files/" ;
		$config['file_name'] = $_FILES['file']['name'];
		$config['allowed_types'] = 'csv|xls|xlsx';
		$config['max_size'] = '100000'; //3 MB

		$html_append = '';
		$prog_bar = 0;

		if (isset($_FILES['file']['name'])) {
			if (0 < $_FILES['file']['error']) {
				$html_append = 'FILE ERROR';
			} else {
				if (!file_exists($config['upload_path'])) {
					mkdir($config['upload_path'], 0777, true);
				}

				$this->load->library('upload', $config);
				$uploaded = $this->upload->do_upload('file');

				ini_set('memory_limit', '-1');
				ini_set('max_execution_time', 600);

				if (!$uploaded) {
					$html_append = 'NO IMAGE FILE';
				} else {
					$file_path = $config['upload_path'] . $config['file_name'];
					$html_append = 'FILE UPLOADED';
					$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
					$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
					$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
					$highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
					$highestCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

					$header_check = "select * from account_headers where description not in (";

					for($col=1; $col <= $highestCol; $col++) {
						$column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
						$header_check .=  "'" . $xls_data[1][$column] . "',";
					}
					$header_check .= "'') and account_id = '$account_id';";

					$checkHeaders = $this->common_model->boolNoCommitQuery($header_check);
					if ($checkHeaders) {

						for($row=2; $row <= $highestRow; $row++) {
							$html_append .=  "<br>";
							$rowArray = array();
							for($col=1; $col <= $highestCol; $col++) {
								$column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
								// $html_append .=  $xls_data[$row][$column];
								$cellArray = array($xls_data[1][$column] => $xls_data[$row][$column]);
								$rowArray = array_merge($rowArray, $cellArray);
							}
							$account_header = $this->process_model->getAccountHeader($account_id);
							$table_name = $this->process_model->checkTableTrans($account_header, $rowArray);
							$insert_success = $this->process_model->insertTrans($rowArray, $table_name);
							if($insert_success) {
								$html_append .= 'Inserted Row Successfully ('.($row-1).'/'.($highestRow-1).')';
								$prog_bar = (int) ((($row-1)/($highestRow-1)) * 100);
							}
							else {
								$html_append .= 'Inserted Row Failed ('.($row-1).'/'.($highestRow-1).')';
							}
						}
					} else {
						$html_append = "Invalid File Headers. Please try again.";
					}
				}
			}
			$output = json_encode(["error" => 0, "html_append" => $html_append, "prog_bar" => $prog_bar]);
			echo $output;
		}
	}

	public function index() {
		$s = $this->session->all_userdata();
		if (empty($s['username'])) { show_404(); }
		if (empty($s['status'])) { show_404(); }
		else { if ($s['status'] != 1) { show_404(); }}

		$data2 = "";
		if (!empty($this->input->get('acct'))) {

			$accountName = $this->input->get('acct');

			$getAccDetails = $this->process_model->getAccountDet($accountName,$s['username']);
			$dropAccountYear = $this->common_model->drop_account_year($this->input->get('acct'));
			$dropAccountMonth = $this->common_model->drop_account_month($this->input->get('acct'),'',2017);
			$dropYear = $this->common_model->drop_year();
			$dropMonth = $this->common_model->drop_month();

			if ($getAccDetails) {

				$data['title'] = "Project One (POS)";
				$prog_bar = 0;

				$html_append = '
					<br>
					<h5 class="center grey lighten-2 black-text" style="padding:5px;">Process POS Transactions of: ' . $getAccDetails['description'] . '</h5>
					<div class="row">
						<div class="col l6 m6 s12">
							<div class="card">
								<div class="card-content cmd-text">
									<span id="upload-logs" style="height: 370px; display: block; overflow:auto !important;">Upload Logs:</span>
								</div>
								<div class="card-action center">
									<div class="row">
										<div class="col s12 m12">
											<form id="process-excel" method="post" enctype="multipart/form-data">
												<input type="hidden" name="account_id" id="account_id" value="' . $getAccDetails['account_id'] . '">
												<input type="hidden" name="account_desc" id="account_desc" value="' . $getAccDetails['description'] . '">
												<input type="file" name="file" id="file" style="display:none;">
												<label class="btn indigo darker-5" for="file"><b>Upload a File</b></label>
												<div class="progress">
													<div id="progress-bar" style="width: 0%" class="determinate"></div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col l6 m6 s12">
							<div class="card">
								<div class="card-content cmd-text">
									<span id="download-logs">Download Logs:</span>
								</div>
								<div class="card-action center">
									<div class="row">
										<div class="col s12 m12">
											<a hre0f="#" class="btn indigo darker-5 changePage" name=""><b>Download</b></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<script>
						$("select").material_select();
						$("#process-excel").change(function() {
							$("#process-excel").submit();
						});
						$("#process-excel").submit(function(e) {
							e.preventDefault();
							jQuery.ajax({
								url: baseurl + "process/processexcel",
								type: "POST",
								data: new FormData(this),
								contentType: false,
								cache: false,
								processData:false,
								dataType: "json",
								success: function(res) {
									var up_logs = $("#upload-logs").html();
									up_logs += "<br>";
									up_logs += res.html_append;
									$("#upload-logs").html(up_logs);

									$("#progress-bar").attr("style", "width: "+res.prog_bar+"%");

								}, error: function(e) {
									alert("Error on Upload!");
								}
							});
						});
					</script>
				';

			} else {
				$html_append = '
				<div class="row">
					<br>
					<div class="col l10 offset-l1 m10 offset-m1 s10 offset-s1 center">
						<div class="card-panel red lighten-2">
							<span class="black-text">
								Selected Account is Invalid. Please select another account, <br>Go back to the <span class="changePage cursor" name="dashboard/accounts"><u>Accounts</u></span> Page.
							</span>
						</div>
					</div>
				</div>
				';
			}
		} else {
			$html_append = '
			<div class="row">
				<br>
				<div class="col l10 offset-l1 m10 offset-m1 s10 offset-s1 center">
					<div class="card-panel red lighten-2">
						<span class="black-text">
							No account selected. Please select an account, <br>Go back to the <span class="changePage cursor" name="dashboard/accounts"><u>Accounts</u></span> Page.
						</span>
					</div>
				</div>
			</div>
			';

		}

		$output = json_encode(["error" => 0, "html_append" => $html_append, "prog_bar" => $prog_bar]);
		echo $output;
	}
}
