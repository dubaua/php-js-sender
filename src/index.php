<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>A simple PHP + JS Sender</title>
  <?php 
    // find first main.hash.css
    $cssFileArray = scandir('./css/');
    if (isset($cssFileArray)) {
      foreach($cssFileArray as $filename) {
        if (preg_match('/^main\..*css$/', $filename)) {
          echo "<link rel=\"stylesheet\" href=\"css/$filename\">";
          break;
        }
      }
    }
  ?>
</head>
<body>
<?php include('./contact-form.php'); ?>
<?php
// find all main.hash.js или vendor.hash.js
$jsFileArray = scandir('./js/');
if (isset($jsFileArray)) {
  foreach($jsFileArray as $filename) {
    if (preg_match('/^(main|vendor)\..*js$/', $filename)) {
      $scriptPath = "/js/$filename";
      ?><script src="<?=$scriptPath?>"></script><?php
    }
  }
}
?>
</body>
</html>