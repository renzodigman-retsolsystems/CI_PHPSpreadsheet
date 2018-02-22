<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$file_name = $upload_data['file_name'];
$file_type = $upload_data['file_ext'];
$file_path = './uploads/';

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path.$file_name);


$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
$highestColumn = $spreadsheet->getActiveSheet()->GetHighestColumn();
$highestCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>UPLOAD SUCCESS</title>
  </head>

  <body>

    <h3>Your file was successfully uploaded!</h3>

    <ul>
      <?php foreach ($upload_data as $item => $value):?>
      <li><?php echo $item;?>: <?php echo $value;?></li>
      <?php endforeach; ?>
    </ul>

    <p><?php echo anchor('upload', 'Upload Another File!'); ?></p>

    <br />

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
