<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="600">

    <title>Multimeter</title>
  </head>
  <body>
    <?php
      if (!isset($_GET['rrd'])) {
        echo "You must provide a RRD name!";
      } else {
        echo exec('/bin/bash scripts/update_rrd_from_php.sh rrds/'.escapeshellcmd($_GET['rrd']).'.rrd '.escapeshellcmd($_GET['template']).' '.escapeshellcmd($_GET['data']));
      }
    ?>
  </body>
</html>

