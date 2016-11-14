<?php 
require 'includes/db.php';
if ($_COOKIE['logged_user']==null)  echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">'; else
    if (!checkKey($_COOKIE['key'])) {
        delCookies('logged_user');
        delCookies('key');
        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
    }
$stmt=B::selectFromBase('users',array('id'),array('login'),array($_COOKIE['logged_user']));
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="errorExtension">
    <div class="modal-dialog modal-lg">
        <div class="modal-content btn-rad">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"><strong>Wrong extension</strong></h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-error">You are trying to download a file with an extension that does not support  by PolisBook. Available extensions: <strong>fb2, pdf, epub, txt, html</strong>.</div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="deleteBookModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content btn-rad center-block" style="width:70%">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"><strong>Delete</strong></h3>
            </div>
            <div class="modal-body" id="infoDelete">
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-default btn-rad pull-left" data-dismiss="modal">Cancel</button>
                <button class="btn btn-danger btn-rad pull-right" id="btnDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="errorStorage">
    <div class="modal-dialog modal-lg">
        <div class="modal-content btn-rad">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"><strong>Not enough storage</strong></h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-error">Not enough storage to download the file. Delete some files, clear your recycle bin, or increase the amount of available storage.</div>
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
                        <input type="file" name="upl" multiple/>
                    </div>
                </form></li>
                <li class="li-nav-progress" style="margin-left: 0%"><span class="progress-download" id="pd">
                    <span class="dropdown">
                        <a class="btn btn-default dropdown-toggle btn-rad" type="button" data-toggle="dropdown" disabled="disabled" id="pd-btn"><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu download-info btn-rad" id="download-list">
                            <span id="append"></span>
                            <li class="divider"></li>
                            <li><a  class="width-full btn btn-default btn-rad" id="clearprogressbar">Clear downloads list</a></li>
                        </ul>
                    </span>
                </span></li>
                <li class="dropdown maincolor li-nav">
                    <button class="btn btn-default btn-rad dropdown-toggle" data-toggle="dropdown"><?=$_COOKIE['logged_user'];?>   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a href="" onclick="showBook(0)">Update list</a></li>
                        <li><a href="settings">Settings</a></li>
                        <li><a href="help">Help</a></li>
                        <li class="divider"></li>
                        <li><a href="logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div>
<div class="container lib-body">
    <div class="row" id="book">
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
            <div class="col-md-5 col-lg-5 col-sm-4 col-xs-4">
            </div>
        </div>
    </div>
</div>
</body>
</html>