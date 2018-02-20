<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$file = $_POST['fileUpload'];

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
$highestColumn = $spreadsheet->getActiveSheet()->GetHighestColumn();
$highestCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

echo 'Row: '.$highestRow.'<br>';
echo 'Col: '.$highestCol.' / '.$highestColumn;

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
