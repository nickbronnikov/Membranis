<?php
require 'includes/db.php';
require 'includes/file_work.php';
if ($_COOKIE['logged_user']==null || $_COOKIE['key']==null)  echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">'; else
    if (!checkKey($_COOKIE['key'])) {
    delCookies('logged_user');
        delCookies('key');
    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
}
$stmt=B::selectFromBase('users_files',null,array('id'),array($_GET['id']));
$data=$stmt->fetchAll();
$db=B::selectFromBase('users',null,array('login'),array($_COOKIE['logged_user']));
$user=$db->fetchAll();
if ($user[0]['id']==$data[0]['id_user']) {
    $ui = B::selectFromBase('users_info', null, array('login'), array($_COOKIE['logged_user']));
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
    B::updateBase('users_info', array('last_books'), array(json_encode($last_books)), array('login'), array($_COOKIE['logged_user']));
}
    $file_info = pathinfo($data[0]['path']);
    $stmt=B::selectFromBase('bookmarks',null,array('id_book'),array($_GET['id']));
    $bm=$stmt->fetchAll();
    if (count($bm)==0){
        $modalbody='<div class="panel panel-default">
  <div class="panel-body" id="noOneBookmark">
    <svg class="center-block" fill="#5cb85c" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
    <path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
    <path d="M0 0h24v24H0z" fill="none"/>
        <h3 class="text-center"><strong>You have not added any one bookmark.</strong></h3>
</svg>
  </div>
</div>';
    }else {
        $modalbody='';
        foreach ($bm as $item){
            $pr=json_decode($item['progress'],true);
            $progress = json_decode($data[0]['progress'], true);
            $toProgress='';
            switch ($file_info['extension']){
                case 'epub':
                    $toProgress='toChapter('.$pr['chapter_id'].');'.'toprogressPage('.$pr['page_progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                    break;
                case 'fb2':
                    $toProgress='toChapter('.$pr['chapter'].');'.'toprogressPage('.$pr['page_progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                    break;
                case 'txt':
                    $toProgress='toprogressPage('.$pr['progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                    break;
                case 'html':
                    $toProgress='toprogressPage('.$pr['progress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                    break;
                case 'pdf':
                    $toProgress='toProgress('.$pr['pageProgress'].');$(\'#bookmarks-list\').modal(\'hide\')';
                    break;
            }
            $modalbody.='<div class="panel panel-default bmp" id="bookmarkID'.$item['id'].'">
  <div class="panel-body bookmark-body">
  <div><button class="btn btn-danger btn-bookmark btn-sm btn-rad" id="btnDelBookmark'.$item['id'].'" onclick="deleteBookmark('.$item['id'].')">Delete</button><button class="btn btn-success btn-bookmark btn-sm btn-rad" id="btnGoBookmark'.$item['id'].'" onclick="'.$toProgress.'">Go</button></div>
    <div class="description-info">'.$item['description'].'</div>
  </div>
</div>';
        }
    }
    switch ($file_info['extension']) {
        case 'fb2':
            $chapter = chapterList($data[0]['path']);
            $progress = json_decode($data[0]['progress'], true);
            $path=explode('/',$data[0]['path']);
            $str = fb2($data[0]['path'], str_replace($path[count($path)-1], '', $data[0]['path']), $progress['chapter']);
            $function = '<script>progressPage(' . $progress['page_progress'] . ')</script><script>styleReader(\'' . $ui_data[0]['style'] . '\')</script>';
            $reader ='<div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollUp"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"/>
    <path d="M0-.5h24v24H0z" fill="none"/>
</svg></div>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollDown"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
    <path d="M0-.25h24v24H0z" fill="none"/>
</svg></div>
        </div>
    </div>' . $function;
            break;
        case 'pdf':
            $progress = json_decode($data[0]['progress'], true);
            $reader = '<div class="row">
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
        <iframe id="pdf" src="https://polisbook.com/pdf/web/viewer.html?file=https://polisbook.com/' . $data[0]['path'] . '" width="100%" height="500px" onload="progressPage(' . $progress['pageProgress'] . ')"/>
        </div></div>';
            break;
        case 'epub':
            $chapter = chapterListEPUB($data[0]['path']);
            $progress = json_decode($data[0]['progress'], true);
            $function = '<script>progressPage(' . $progress['page_progress'] . ')</script><script>styleReader(\'' . $ui_data[0]['style'] . '\')</script>';
            $str='';
            $str=EPUBChapter($data[0]['path'],$progress['chapter']);
            $reader ='<div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollUp"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"/>
    <path d="M0-.5h24v24H0z" fill="none"/>
</svg></div>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollDown"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
    <path d="M0-.25h24v24H0z" fill="none"/>
</svg></div>
        </div>
    </div>' . $function;
            break;
        case 'txt':
            $progress=json_decode($data[0]['progress'],true);
            $function='<script>progressPage(' . $progress['progress'] . ')</script><script>styleReader(\'' . $ui_data[0]['style'] . '\')</script>';
            $str=file_get_contents($data[0]['path']);
            $reader ='<div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollUp"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"/>
    <path d="M0-.5h24v24H0z" fill="none"/>
</svg></div>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollDown"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
    <path d="M0-.25h24v24H0z" fill="none"/>
</svg></div>
        </div>
    </div>' . $function;
        break;
        case 'html':
            $progress=json_decode($data[0]['progress'],true);
            $function='<script>progressPage(' . $progress['progress'] . ')</script><script>styleReader(\'' . $ui_data[0]['style'] . '\')</script>';
            $str=file_get_contents($data[0]['path']);
            $reader ='<div class="row">
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollUp"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"/>
    <path d="M0-.5h24v24H0z" fill="none"/>
</svg></div>
        </div>
        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 well" id="reader">
            ' . $str . '
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 rp">
            <div class="page" id="scrollDown"><svg class="btn-page center-block" fill="#000000" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
    <path d="M0-.25h24v24H0z" fill="none"/>
</svg></div>
        </div>
    </div>' . $function;
            break;
    }
} else {
    $reader='<h2>You are trying to read the book that is not available to you.</h2>';
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
    <script src="js/bootstrap.min.js"></script>
    <?php switch ($file_info['extension']){
        case 'fb2':
            echo '<script src="js/fb2Reader.js"></script>';
            echo '<script src="js/style.js"></script>';
            break;
        case 'pdf':
            echo '<script src="js/pdfReader.js"></script>';
            break;
        case 'epub':
            echo '<script src="js/epubReader.js"></script>';
            echo '<script src="js/style.js"></script>';
            break;
        case 'txt':
            echo '<script src="js/htmltxtReader.js"></script>';
            echo '<script src="js/style.js"></script>';
            break;
        case 'html':
            echo '<script src="js/htmltxtReader.js"></script>';
            echo '<script src="js/style.js"></script>';
            break;
    }?>
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
            <ul class="nav navbar-nav navbar-right nav-pills">
                <?='<li class="dropdown maincolor li-nav">
                    <button class="btn btn-success dropdown-toggle li-nav-read btn-rad" id="bookmarks"><svg fill="#FFFFFF" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                            <path d="M0 0h24v24H0z" fill="none"/>
                        </svg></button>
                </li>';
                ?>
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
                        case 'txt':
                            echo '';
                            break;
                        case 'html':
                            echo '';
                            break;
                    }?></li>
                <li class="dropdown maincolor li-nav">
                    <button class="btn btn-default dropdown-toggle btn-rad" data-toggle="dropdown"><?=$_COOKIE['logged_user'];?>   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a href="library">Your library</a></li>
                        <li><a href="settings">Settings</a></li>
                        <li><a href="help">Help</a></li>
                        <li class="divider"></li>
                        <li><a href="logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="bookmarks-list">
        <div class="modal-dialog">
            <div class="modal-content btn-rad">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myLargeModalLabel"><strong>Bookmarks</strong></h3>
                </div>
                <div class="modal-body list" id="lb">
                    <?=$modalbody?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-rad center-block" id="addbookmark">Add new bookmark</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <?=$reader?>
</div>
</body>
</html>
