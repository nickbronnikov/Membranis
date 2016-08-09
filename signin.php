<?php
$alert='<div class="alert alert-warning alert-dismissable width-full">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Incorrect username or password. 
</div>';
require 'includes/db.php';
$data=$_POST;
$_SESSION['login']=$data['login'];
$check=true;
if (isset($data['loginin'])) {
    if (!checkField('users', array('login'), array($data['login']))) $check = false; else {
        $logpas = array($data['login'], $data['password']);
        if (checkPassword($logpas)) $check = false;
    }
    if ($check) {
        $_SESSION['logged_user'] = $data['login'];
        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index.php">';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sign in to Membranis</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/signup.js"></script>
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
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
                <a class="btn btn-success pull-right" href="signup.php">Sign up</a>
            </ul>
        </div>
    </div>
</div>
<div class="body">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-4 col-lg-offset-4 col-md-4 col-lg-4 col-xs-12 col-sm-12" id="login-div">
                <h1 class="text-center">Sign in to Membranis</h1>
                <?php if ($check==false) echo $alert;?>
                <div id="login-form">
                <div class="panel panel-default width-full">
                    <div class="panel-body">
                        <form action="/signin.php" method="post">
                            <label for="login">Username or email address</label>
                            <input type="text" class="form-control" id="login" name="login" <?php if ($_SESSION['login']!=null) echo 'value="'.$_SESSION['login'].'"'?>><br>
                            <label for="password">Password</label><span class="pull-right"><a>Forgot password?</a></span>
                            <input type="password" class="form-control" id="password" name="password"><br>
                            <button type="submit" class="btn btn-lg btn-success width-full" name="loginin"">Sign in</button>
                        </form>
                    </div>
                </div>
                    <div class="panel panel-default width-full">
                        <div class="panel-body center-block">
                            <h4 class="text-center">Don't have an account? <a href="signup.php">Create it!</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
