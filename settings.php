<?php
include "includes/db.php";
if ($_COOKIE['logged_user']==null)  echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">'; else 
if (!checkKey($_COOKIE['key'])) {
    delCookies('logged_user');
    delCookies('key');
    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CloudReader</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/progress.css" type="text/css" rel="stylesheet"/>
    <script src="js/js-download/jquery.knob.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jqueryScrollTo.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css" />
    <script type="text/javascript" src="js/colorpicker.js"></script>
    <script src="js/style.js"></script>
    <script src="js/settings.js"></script>
</head>
<body>
<script>progressShow()</script>
<div id="page">
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
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown maincolor li-nav">
                        <button class="btn btn-default dropdown-toggle btn-rad" data-toggle="dropdown" id="user_name"><?=$_COOKIE['logged_user'];?>   <b class="caret"></b></button>
                        <ul class="dropdown-menu">
                            <li><a href="library">Your library</a></li>
                            <li><a onclick="showBook(0)">Обновить список</a></li>
                            <li><a >Что-то еще</a></li>
                            <li class="divider"></li>
                            <li><a href="logout">Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-10 col-md-offset-1 ol-lg-offset-1 col-xs-12 col-sm-12 s-panel">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading settings-head">Settings</div>
                            <div class="">
                                <p class="li-setting active-set" id="s-account"><span>Account</span></p>
                                <p class="li-setting" id="s-password"><span>Password</span></p>
                                <p class="li-setting" id="s-reader"><span>Reader</span></p>
                                <p class="li-setting" id="s-storage"><span>Storage</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-md-9 col-lg-9">
                            <div id="bs">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><strong>Update login</strong></div>
                                    <div class="panel-body">
                                        <label for="newlogin">New login</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="newlogin">
                                            <span class="input-group-addon" id="newlogincheck"></span>
                                        </div>
                                        <span id="newloginalert"><p class="info-reg">This is your new login</p></span>
                                        <button class="btn btn-success" id="btn-newlogin">Update login</button>
                                        <span id="infologin"></span>
                                    </div>
                                </div><div class="panel panel-default">
                                    <div class="panel-heading"><strong>Update email</strong></div>
                                    <div class="panel-body">
                                        <label for="oldemail">Old email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oldemail">
                                            <span class="input-group-addon" id="oldemailcheck"></span>
                                        </div>
                                        <span id="oldemailalert"><p class="info-reg">This is your old email</p></span>
                                        <label for="newemail">New email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="newemail">
                                            <span class="input-group-addon" id="newemailcheck"></span>
                                        </div>
                                        <span id="newemailalert"><p class="info-reg">This is your new email</p></span>
                                        <button class="btn btn-success" id="btn-newemail">Update email</button>
                                        <span id="infoemail"></span>
                                    </div>
                                </div>
                </div>
            </div>
            <div class="col-md-1 col-lg-1">
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>