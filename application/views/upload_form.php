<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Upload Form</title>
  </head>
  <body>
    
    <?php
      echo $error;

      echo form_open_multipart('upload/do_upload');
    ?>

    <input type="file" name="userfile" size="20" />

    <br /><br />

    <input type="submit" value="upload" />

    </form>

  </body>
</html>
