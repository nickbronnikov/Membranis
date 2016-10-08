<?php 
require 'includes/db.php';
if ($_SESSION['logged_user']==null)  echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index.php">';
$stmt=B::selectFromBase('users',array('id'),array('login'),array($_SESSION['logged_user']));
$data=$stmt->fetchAll();
$stmt=B::selectFromBase('users_files',null,array('id_user'),array($data[0]['id']));
$data=$stmt->fetchAll();
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
    <link href="css/progress.css" type="text/css" rel="stylesheet"/>
    <script src="js/js-download/jquery.knob.js"></script>
    <script src="js/library.js"></script>
    <script src="js/js-download/jquery.ui.widget.js"></script>
    <script src="js/js-download/jquery.iframe-transport.js"></script>
    <script src="js/js-download/jquery.fileupload.js"></script>
    <script src="js/js-download/script.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
<script>progressShow()</script>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="errorExtension">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myLargeModalLabel"><strong>Wrong extension</strong></h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-error">You are trying to download a file with an extension that does not support  by PolisBook. Available extensions: <strong>fb2, pdf</strong>.</div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="errorStorage">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myLargeModalLabel"><strong>Not enough storage</strong></h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-error">Not enough storage to download the file. Delete some files, or increase the amount of available storage.</div>
            </div>
        </div>
    </div>
</div>
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
            <ul class="nav navbar-nav navbar-right nav-pills">
                <li class="li-nav"><form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
                    <div id="drop">
                        <a class="btn btn-success btn-rad" id="download">Upload</a>
                        <input type="file" name="upl" multiple />
                    </div>
                </form></li>
                <li class="li-nav-progress" style="margin-left: 0%"><span class="progress-download" id="pd">
                    <span class="dropdown">
                        <a class="btn btn-default dropdown-toggle btn-rad" type="button" data-toggle="dropdown" disabled="disabled" id="pd-btn"><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu download-info">
                            <span id="append"></span>
                            <li class="divider"></li>
                            <li><a  class="width-full btn btn-default" id="clearprogressbar">Clear downloads list</a></li>
                        </ul>
                    </span>
                </span></li>
                <li class="dropdown maincolor li-nav">
                    <button class="btn btn-default btn-rad dropdown-toggle" data-toggle="dropdown"><?=$_SESSION['logged_user'];?>   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a onclick="showBook(0)">Update list</a></li>
                        <li><a href="settings">Settings</a></li>
                        <li><a href="#">Recycle bin</a></li>
                        <li class="divider"></li>
                        <li><a href="logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="body">
<div class="container lib-body">
    <div class="row" id="book">
        <?php if (count($data)==0) echo '<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                </svg>
                </svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not uploaded any one book. <a href="library">Upload it now!</a></strong></h3>
            </div>
        </div>';?>
    </div>
</div>
</div>
</body>
</html>