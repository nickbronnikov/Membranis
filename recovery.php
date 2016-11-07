<?php
include 'includes/db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sign in to Membranis</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/recovery.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
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
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right navel">
                <?php if ($_COOKIE['logged_user']!=null && checkKey($_COOKIE['key'])) echo '<li class="dropdown maincolor">
                        <button class="btn btn-default dropdown-toggle btn-rad" data-toggle="dropdown" id="user_name">'.$_COOKIE["logged_user"].'   <b class="caret"></b></button>
                        <ul class="dropdown-menu">
                            <li><a href="library">Your library</a></li>
                            <li><a href="settings">Settings</a></li>
                            <li><a href="help">Help</a></li>
                            <li class="divider"></li>
                            <li><a href="logout">Log out</a></li>
                        </ul>
                    </li>'; else echo '<a class="btn btn-success pull-right btn-rad" href="signup.php">Sign up</a>';?>
            </ul>
        </div>
    </div>
</div>
<div class="body">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-4 col-lg-offset-4 col-md-4 col-lg-4 col-xs-12 col-sm-12" id="login-div">
                <h1 class="text-center">Recover the password</h1>
                <div id="login-form">
                    <div class="panel panel-default width-full">
                        <div class="panel-body">
                            <form action="/signin.php" method="post">
                                <label for="login">Email address</label>
                                <input type="text" class="form-control" id="login" name="email"><br>
                                <button type="submit" class="btn btn-lg btn-success width-full" name="recover"">Recover</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-5 col-sm-4 col-xs-4 copyright">
                <b class="maincolor">© 2016 PolisBook</b>
            </div>
            <div class="col-md-2 col-lg-2  col-sm-4 col-xs-4">
                <img class="img-footer center-block" src="img/Logo_s.png">
            </div>
            <div class="col-md-4 col-lg-4 col-sm-2 col-xs-2">
            </div>
            <div class="col-md-1 col-lg-1 col-sm-2 col-xs-2 copyright"><b><a href="help">Help</a></b></div>
        </div>
    </div>
</div>
</body>
</html>

