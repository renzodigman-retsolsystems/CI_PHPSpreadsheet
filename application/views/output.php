<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PROJECT ONE</title>
  </head>
  <body>
    <?php
      echo $_POST['fileUpload'];
    ?>
  </body>
</html>
