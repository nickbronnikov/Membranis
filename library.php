<?php 
require 'includes/db.php';
if ($_SESSION['logged_user']==null)  echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index.php">';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CloudLibrary</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <link href="css/download-style.css" type="text/css" rel="stylesheet"/>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <script src="js/js-download/jquery.knob.js"></script>
    <script src="js/signup.js"></script>
    <script src="js/js-download/jquery.ui.widget.js"></script>
    <script src="js/js-download/jquery.iframe-transport.js"></script>
    <script src="js/js-download/jquery.fileupload.js"></script>
    <script src="js/js-download/script.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
            <ul class="nav navbar-nav navbar-right">
                <li class="li-nav"><form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
                    <div id="drop">
                        <a class="btn btn-default" id="download">Download</a>
                        <input type="file" name="upl" multiple />
                    </div>
                </form></li>
                <li class="li-nav-progress"><span class="progress-download" id="pd">
                    <span class="dropdown">
                        <a class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" disabled="disabled" id="pd-btn"><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu download-info">
                            <span id="append"></span>
                            <li class="divider"></li>
                            <li><a  class="width-full btn btn-default" id="clearprogressbar">Clear downloads list</a></li>
                        </ul>
                    </span>
                </span></li>
                <li class="dropdown maincolor li-nav">
                    <button href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?=$_SESSION['logged_user'];?>   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Действие</a></li>
                        <li><a href="#">Другое действие</a></li>
                        <li><a href="#">Что-то еще</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="body">

</div>
</body>
</html>