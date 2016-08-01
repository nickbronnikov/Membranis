<?php
require 'includes/db.php';
$login=trim($_POST['login']);
$email=trim($_POST['email'])
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CloudLibrary</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/dropzone.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="navbar navbar-default navbar-static-top" id="mainnav" role="navigation">
    <div class="container navel">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand " href="/"><img src="img/Logo_s.png"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right navel">
                <a class="btn btn-success pull-right" href="test.php">Test</a>
                <a class="btn btn-success pull-left button-nav button-color">Sign in</a>
            </ul>
        </div>
    </div>
</div>
<div class="body">
    <div class="container ">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-12 col-xs-12" >
                <h1 class="center-block" id="headinfo">Join Membranis</h1>
                <h3>The best place to read</h3>
            </div>
            <div class="col-md-3 col-lg-3"></div>
            <div id="reg-form">
            <div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 col-sm-12 col-xs-12">
                <ol class="table-reg">
                    <li class="current">
                        <i class="material-icons maincolor md-36 icon">account_circle</i><strong>Step 1:</strong>
                        <p>Create your account</p>
                    </li>
                    <li>
                        <i class="material-icons maincolor md-36 icon">settings</i><strong>Step 2:</strong>
                        <p>Set up your account</p>
                    </li>
                    <li>
                        <i class="material-icons maincolor md-36 icon">check_circle</i><strong>Step 3:</strong>
                        <p>Done!</p>
                    </li>
                </ol>

            </div>
            <div class="col-md-2 col-lg-2"></div>
            <div class="col-md-offset-3 col-lg-offset-3 col-md-5 col-lg-5 col-sm-12 col-xs-12 form-reg">
                <label for="loginreg">Username</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="loginreg">
                    <span class="input-group-addon" id="loginregcheck"></span>
                </div>
                <span id="loginregalert"><p class="info-reg">This will be your username.</p></span>
                <label for="loginreg">Email address</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="emailreg" >
                    <span class="input-group-addon" id="emailregcheck"></span>
                </div>
                <span id="emailregalert"><p class="info-reg">This is your e-mail address. We promise not to share your email with anyone.</p></span>
                <label for="loginreg">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="emailreg" >
                    <span class="input-group-addon"></span>
                </div>
                <span><p class="info-reg">Password should be at least 5 characters.</p></span>
                <button type="submit" class="btn btn-success btn-lg center-block" id="button-reg">Sign up</button>
            </div>
                </div>
        </div>
    </div>
</div>
</body>
</html>
