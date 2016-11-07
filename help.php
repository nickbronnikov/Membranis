<?php
require 'includes/db.php';
if ($_COOKIE['logged_user']!=null && checkKey($_COOKIE['key'])) {
    $stmt = B::selectFromBase('users', null, array('login'), array($_COOKIE['logged_user']));
    $data = $stmt->fetchAll();
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Help</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/dropzone.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/help.js"></script>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="navbar navbar-default navbar-static-top" id="nav" role="navigation">
    <div class="container navel">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="img/Logo_s.png"></a>
        </div>
        <?php if ($_COOKIE['logged_user']!=null) echo '<div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" >
                <li class="dropdown maincolor li-nav" id="li-nav">
                    <button class="btn btn-default btn-rad dropdown-toggle" data-toggle="dropdown">'.$_COOKIE['logged_user'].'   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a href="library">Your library</a></li>
                        <li><a href="settings">Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>'; else echo '<div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right navel">
                <a class="btn btn-success pull-left button-nav button-color btn-rad" href="signin">Sign in</a>
            </ul>
        </div>';
        ?>
    </div>
</div>
<div id="jumbotron-help"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <h1 class="maincolor text-center"><b>Help</b></h1>
            <h3 class="maincolor text-center">If you have any problems with our service, please send us a message.</h3>
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
        <div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 col-xs-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <label for="email-help">Email</label>
                    <?php if ($_COOKIE['logged_user']!=null && checkKey($_COOKIE['key'])) echo '<div class="panel panel-default" id="email-help">
                        <div class="panel-body" style="padding: 6px 12px">
                            <span>'.$data[0]['email'].'</span>
                        </div>
                    </div>'; else echo '<input class="form-control" type="text" id="email" maxlength="50">';
                    ?>
                    <label for="subject">Subject</label>
                    <input class="form-control" type="text" id="subject" maxlength="250">
                    <label for="problem">Your problem</label>
                    <textarea class="form-control" rows="5" id="problem" placeholder="Please describe in detail your problem." maxlength="3000"></textarea>
                    <span id="check"></span>
                    <button type="button" class="btn btn-success" id="send" disabled="disabled">Send</button>
                </div>
            </div>
        </div><div class="col-md-2 col-lg-2"></div>

    </div>
</div>
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-5 col-sm-4 col-xs-4 copyright">
                <b class="maincolor">© 2016 PolisBook</b>
            </div>
            <div class="col-md-2 col-lg-2  col-sm-4 col-xs-4">
                <a href="/"><img class="img-footer center-block" src="img/Logo_s.png"></a>
            </div>
            <div class="col-md-5 col-lg-5 col-sm-4 col-xs-4">
            </div>
        </div>
    </div>
</div>
</body>
</html>
