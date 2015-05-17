<!DOCTYPE html>
<html ng-app="app">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <title>Checkpoint</title>
  <!--[if lt IE 9]>
  <script src="assets/js/html5.js"></script>
  <![endif]-->
  <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Montserrat:700' rel='stylesheet' type='text/css'>-->
  <link rel="stylesheet" type="text/css" href="public/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="public/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="public/assets/css/style.css">
</head>
<body>
  <div class="wrapper">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" ui-sref="home">CHK<span class="yellow">.</span></a>
        </div>
        <div class="collapse navbar-collapse navbar-right" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li ui-sref-active="active">
              <a ui-sref="home"><span class="yellow"><b>3</b></span> Friends</a>
            </li>
            <li ui-sref-active="active">
              <a ui-sref="badges"><span class="yellow"><b>2</b></span> Badges</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="main-content" ui-view></div>

    <footer>
      <div class="container">
        <div class="row">
          <div class="col-xs-12 text-center">
            Copyright © 2015 Badgify
          </div>
        </div>
      </div>
    </footer>

    <script type="text/javascript" src="public/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="public/bower_components/angular/angular.min.js"></script>
    <script type="text/javascript" src="public/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
    <script type="text/javascript" src="public/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
    <script type="text/javascript" src="public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="public/assets/js/main.js"></script>
  </div>
</body>
</html>
