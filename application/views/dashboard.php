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
    <form class="upload" action="output" method="post">
      <div>
        <input type="file" name="fileUpload"/>
        <input type="submit" name="btnUpload">
      <div>
    </form>
  </body>
</html>
