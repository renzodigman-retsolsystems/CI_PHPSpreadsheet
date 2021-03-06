<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$file = $_POST['fileUpload'];

echo $file;

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
$highestColumn = $spreadsheet->getActiveSheet()->GetHighestColumn();
$highestCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

echo 'Row: '.$highestRow.'<br />';
echo 'Col: '.$highestCol.' / '.$highestColumn .'<br />';

print_r($xls_data);

// $newspreadsheet = new Spreadsheet();
// $sheet = $newspreadsheet->getActiveSheet()->fromArray($xls_data);
// /*
// for($x=1; $x <= $highestRow; $x++)
//   for($y=1; $y <= $highestCol; $y++)
//     $sheet->setCellValueByColumnAndRow($y, $x, $xls_data->);
// */
// $writer = new Xlsx($newspreadsheet);
// $writer->save('uploaded_file.xlsx');
//
// $this->load->helper('download');
// force_download('hello world.xlsx', NULL);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PROJECT ONE</title>
  </head>
  <body>
    <table border='1'>
    <?php
      $htm_tbl = '<tr><th>'.implode('</th><th>', $xls_data[1]).'</th></tr>';

      for($row=2; $row <= $highestRow; $row++)
        // for($col=1; $col <= $highestCol; $col++)
          $htm_tbl .= '<tr><td>'.implode('</td><td>', $xls_data[$row]).'</td></tr>';

      echo $htm_tbl;
    ?>
    </table>
  </body>
</html>
