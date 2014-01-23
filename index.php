<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- meta http-equiv="refresh" content="900" -->

    <title>Multimeter</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Starter template style -->
    <link href="css/starter-template.css" rel="stylesheet">
  </head>
  <body>
    <?php if (!isset($_GET['rrd'])) { $_GET['rrd'] = 'raspberry_pi'; } ?>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <!-- span class="icon-bar"></span>
            <span class="icon-bar"></span -->
          </button>
          <a class="navbar-brand" href="#">Multimeter</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php?rrd=raspberry_pi">Raspberry Pi</a></li>
            <li><a href="index.php?rrd=work">Workplace</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <h3>Last 24 Hours</h3>
        <div id="day" style="height:300px" class="col-xs-12"></div>
      </div>
      <div class="row">
        <h3>Last 7 Days</h3>
        <div id="week" style="height:300px" class="col-xs-12"></div>
      </div>
      <div class="row">
        <h3>Last 365 Days</h3>
        <div id="year" style="height:300px" class="col-xs-12"></div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Flot includes -->
    <script src="js/jquery.flot.min.js"></script>
    <script src="js/jquery.flot.time.min.js"></script>
    <script src="js/jquery.flot.tooltip.min.js"></script>

    <!-- Flot code -->
    <script type="text/javascript">
      $(document).ready(function() {
        var options = {
          xaxis: {
            mode: "time",
            timezone: "browser",
            format: "%d/%m/%y %H:%M"
          },
          yaxis: {
            tickFormatter: function(value) {
              return value.toFixed(1) + 'ºC' // < ?php echo strtoupper($config['unit'])?>&deg;';
            }
          },
          grid: {
            hoverable: true,
            clickable: true,
          },
          tooltip: true,
          tooltipOpts: {
            content: "%y"
          }
        };

        var dataDay = [<?php echo exec('/bin/bash scripts/fetch_rrd.sh rrds/'.escapeshellcmd($_GET['rrd']).'.rrd 24h');?>];
        $.plot($("#day"), dataDay, options);
        var dataWeek = [<?php echo exec('/bin/bash scripts/fetch_rrd.sh rrds/'.escapeshellcmd($_GET['rrd']).'.rrd 7d');?>];
        $.plot($("#week"), dataWeek, options);
        var dataYear = [<?php echo exec('/bin/bash scripts/fetch_rrd.sh rrds/'.escapeshellcmd($_GET['rrd']).'.rrd 365d');?>];
        $.plot($("#year"), dataYear, options);
      });
    </script>
  </body>
</html>

