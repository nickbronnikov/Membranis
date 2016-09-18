<?php
require 'includes/db.php';
require 'includes/file_work.php';
$_SESSION[$_GET['id']]=0;
$_SESSION['id-book']=$_GET['id'];
$stmt=B::selectFromBase('users_files',null,array('id'),array($_GET['id']));
$data=$stmt->fetchAll();
$db=B::selectFromBase('users',null,array('login'),array($_SESSION['logged_user']));
$user=$db->fetchAll();
if ($user[0]['id']==$data[0]['id_user']) {
    $ui = B::selectFromBase('users_info', null, array('login'), array($_SESSION['logged_user']));
    $ui_data = $ui->fetchAll();
    $last_books = json_decode($ui_data[0]['last_books'], true);
    if ($last_books[0]!=$_GET['id']){
        for ($i = 3; $i > 0; $i--) {
        $last_books[$i] = $last_books[$i - 1];
    }
        $last_books[0] = $_GET['id'];
        for ($i=1;$i<count($last_books);$i++){
            if ($last_books[$i]==$_GET['id']) $last_books[$i]=0;
        }
    B::updateBase('users_info', array('last_books'), array(json_encode($last_books)), array('login'), array($_SESSION['logged_user']));
}
    $file_info = pathinfo($data[0]['path']);
    switch ($file_info['extension']) {
        case 'fb2':
            $chapter = chapterList($data[0]['path']);
            $progress = json_decode($data[0]['progress'], true);
            $str = fb2($data[0]['path'], str_replace('cover.jpg', '', $data[0]['cover']), $progress['chapter']);
            $function = '<script>progressPage(' . $progress['page_progress'] . ')</script>';
            $reader = '<div class="container">
    <div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
            <span class="page" id="scrollUp"><</span>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="fb2-reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 ">
            <span class="page" id="scrollDown">></span>
        </div>
    </div>
</div>' . $function;
            break;
        case 'pdf':
            $progress = json_decode($data[0]['progress'], true);
            $reader = '<div class="row">
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
        <iframe id="pdf" src="http://membranis.com/pdf/web/viewer.html?file=http://membranis.com/' . $data[0]['path'] . '" width="100%" height="500px" onload="progressPage(' . $progress['pageProgress'] . ')"/>
        </div></div>';
            break;
        case 'epub':
            $chapter = chapterListEPUB($data[0]['path']);
            $progress = json_decode($data[0]['progress'], true);
            $function = '<script>progressPage(' . $progress['page_progress'] . ')</script>';
            $str=EPUBChapter($data[0]['path'],$progress['chapter']);
            $reader = '<div class="container">
    <div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
            <div class="center-block"><span class="page" id="scrollUp"><</span></div>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="fb2-reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 ">
            <div class="center-block"><span class="page" id="scrollDown">></span></div>
        </div>
    </div>
</div>' . $function;
            break;

    }
} else {
    $reader='<h2>You are trying to download the book that is not available to you.</h2>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CloudReader</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/progress.css" type="text/css" rel="stylesheet"/>
    <script src="js/js-download/jquery.knob.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <?php switch ($file_info['extension']){
        case 'fb2':
            echo '<script src="js/fb2Reader.js"></script>';
            break;
        case 'pdf':
            echo '<script src="js/pdfReader.js"></script>';
            break;
        case 'epub':
            echo '<script src="js/epubReader.js"></script>';
            break;
    }?>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jqueryScrollTo.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
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
                <li class="dropdown maincolor li-nav"><?php switch ($file_info['extension']){
                        case 'fb2':
                            echo $chapter;
                            break;
                        case 'pdf':
                            echo '<button class="btn btn-success btn-rad" id="continueReading">Continue</button>';
                            break;
                        case 'epub':
                            echo $chapter;
                            break;
                    }?></li>
                <li class="dropdown maincolor li-nav">
                    <button class="btn btn-default dropdown-toggle btn-rad" data-toggle="dropdown"><?=$_SESSION['logged_user'];?>   <b class="caret"></b></button>
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
    <?=$reader?>
</div>
</body>
</html>
