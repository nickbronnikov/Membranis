<?php
require 'includes/db.php';
require 'includes/file_work.php';
$_SESSION[$_GET['id']]=0;
$_SESSION['id-book']=$_GET['id'];
$stmt=B::selectFromBase('users_files',null,array('id'),array($_GET['id']));
$data=$stmt->fetchAll();
$file_info=pathinfo($data[0]['path']);
switch ($file_info['extension']){
    case 'fb2':
        if ($data[0]['progress']==null) $str=fb2($data[0]['path'],str_replace('cover.jpg', '', $data[0]['cover']),0); else{
            $progress=json_decode($data[0]['progress'],true);
            $str=fb2($data[0]['path'],str_replace('cover.jpg', '', $data[0]['cover']),$progress['chapter']);
            $function='<script>progressPage('.$progress['page_progress'].')</script>';
        }
        $reader='<div class="container">
    <div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
            <button class="btn btn-success nav-btn" id="scrollUp">Up</button>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="fb2-reader">
            '.$str.'
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
            <button class="btn btn-success nav-btn" id="scrollDown">Down</button>
        </div>
    </div>
</div>'.$function;
        break;

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CloudReader</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <link href="css/download-style.css" type="text/css" rel="stylesheet"/>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/progress.css" type="text/css" rel="stylesheet"/>
    <script src="js/js-download/jquery.knob.js"></script>
    <script src="js/reader.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jqueryScrollTo.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
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
                    <button href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?=$_SESSION['logged_user'];?>   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Действие</a></li>
                        <li><a href="#" onclick="showBook(0)">Обновить список</a></li>
                        <li><a href="#">Что-то еще</a></li>
                        <li class="divider"></li>
                        <li><a href="logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
    <div id="reader-body">
        <?=$reader?>
    </div>
</div>
</body>
</html>
