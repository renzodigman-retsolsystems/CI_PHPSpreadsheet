<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//  Create Excel file

/*
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');

$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');


// Download from server manually

$this->load->helper('download');
force_download('hello world.xlsx', NULL);
*/

?>

<!DOCTYPE html>

<html>
  <head>
    <title>Home</title>
  </head>

  <body>
    Hello World!
  </body>
</html>
