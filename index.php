<?php
require 'includes/db.php';
if ($_SESSION['logged_user']!=null) {
    $stmt = B::selectFromBase('users_info', null, array('login'), array($_SESSION['logged_user']));
    $data = $stmt->fetchAll();
    $last_books = json_decode($data[0]['last_books'], true);
    $s = 0;
    for ($i = 0; $i < count($last_books); $i++) {
        $s += $last_books[$i];
    }
    if ($s == 0) {
        $body='<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <h3 class="maincolor"><strong>Last books:</strong></h3>
            <div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                    <path d="M0 0h24v24H0z" fill="none"/>
                </svg>
                </svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not started any one book to read. <a href="library">Start now!</a></strong></h3>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <h3 class="maincolor"><strong>Your books:</strong></h3>';
        $stmt=B::selectFromBase('users',array('id'),array('login'),array($_SESSION['logged_user']));
        $user=$stmt->fetchAll();
        $stmt = B::selectFromBase('users_files', null, array('id_user'), array($user[0]['id']));
        $books = $stmt->fetchAll();
        if (count($books)==0) $body.='<div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                </svg>
                </svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not uploaded any one book. <a href="library">Download it now!</a></strong></h3>
            </div>
        </div>'; else {
            $j=1;
            for ($i=0;$i<count($books);$i++){
                if ($j>4) break; else {
                    $progress=json_decode($books[$i]['progress'],true);
                    $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title name-book">'.$books[$i]['author'].'</h3>
            </div>
            <div class="panel-body preview-book"><img  class="preview-book-cover" src="'.$books[$i]['cover'].'"/></div>
            <div class="panel-footer"><a class="btn btn-success" href="reader?id='.$books[$i]['id'].'">Read</a><span>'.$progress['progress'].'%</span></div>
            </div>
            </div>';
                    $j++;
                }
            }
            $body.='</div>';
        }
    } else {
        $body='<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <h3 class="maincolor"><strong>Last books:</strong></h3></div>';
        for ($i=0;$i<count($last_books);$i++){
            if ($last_books[$i]!=0) {
                $stmt = B::selectFromBase('users_files', null, array('id'), array($last_books[$i]));
                $book = $stmt->fetchAll();
                $progress=json_decode($book[0]['progress'],true);
                $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title name-book">'.$book[0]['author'].'</h3>
            </div>
            <div class="panel-body preview-book"><img  class="preview-book-cover" src="'.$book[0]['cover'].'"/></div>
            <div class="panel-footer"><a class="btn btn-success" href="reader?id='.$book[0]['id'].'">Read</a><span>'.$progress['progress'].'%</span></div>
            </div>
            </div>';
            }
        }
        for ($i=0;$i<count($last_books);$i++){
            if ($last_books[$i]==0) {
                $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12"></div>';
            }
        }
        $body.='<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <h3 class="maincolor"><strong>Your books:</strong></h3></div>';
        $j=1;
        $stmt=B::selectFromBase('users',array('id'),array('login'),array($_SESSION['logged_user']));
        $user=$stmt->fetchAll();
        $stmt = B::selectFromBase('users_files', null, array('id_user'), array($user[0]['id']));
        $books = $stmt->fetchAll();
        for ($i=0;$i<count($books);$i++){
            if ($j>4) break; else {
                $progress=json_decode($books[$i]['progress'],true);
                $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title name-book">'.$books[$i]['author'].'</h3>
            </div>
            <div class="panel-body preview-book"><img  class="preview-book-cover" src="'.$books[$i]['cover'].'"/></div>
            <div class="panel-footer"><a class="btn btn-success" href="reader?id='.$books[$i]['id'].'">Read</a><span>'.$progress['progress'].'%</span></div>
            </div>
            </div>';
                $j++;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Membranis</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/dropzone.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
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
        <?php if ($_SESSION['logged_user']==null) echo '<div class="navbar-collapse collapse" id="mainnav">
            <ul class="nav navbar-nav navbar-right navel">
                <a class="btn btn-success pull-left button-nav button-color btn-rad" href="signin">Sign in</a>
                <a class="btn btn-success pull-right btn-rad" href="signup">Sign up</a>
            </ul>
        </div>'; else echo '<div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" >
                <li class="dropdown maincolor li-nav" id="li-nav">
                    <button class="btn btn-default btn-rad dropdown-toggle" data-toggle="dropdown">'.$_SESSION['logged_user'].'   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Действие</a></li>
                        <li><a href="library">Your library</a></li>
                        <li><a href="#">Что-то еще</a></li>
                        <li class="divider"></li>
                        <li><a href="logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>';
        ?>
    </div>
</div>
<?php if ($_SESSION['logged_user']==null) echo '<div id="mainbody">
    <div class="jumbotron" id="mainpanel">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-md-offset-3 col-lg-7 col-lg-offset-3 col-sm-12 col-xs-12">
                    <div class="center-block reg main-jumbotron">
                        <h1 class="maintext text-center">Облачная библиотека</h1>
                        <h2 class="maintext text-center">Ваши книги. Всегда, везде, с вами.
                        <div class="button-reg"><a href="signup" class="btn btn-success btn-lg center-block btn-rad" id="button-reg">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12"><h2 class="maincolor"><b>Синхронизация</b></h2>
                <p>Синхронизация вашего прогресса. Всегда начинайте читать с того места, на котором закончили. На любом устройстве.</p>
                <p><a class="btn btn-default" href="http://bootstrap-3.ru/examples/jumbotron/#" role="button">Узнать больше</a></p></div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12"><h2 class="maincolor"><b>На любом устройстве</b></h2>
                <p>Читайте свои любимые книги журналы на любом своем устройстве.</p>
                <p><a class="btn btn-default" href="http://bootstrap-3.ru/examples/jumbotron/#" role="button">Узнать больше</a></p></div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12"><h2 class="maincolor"><b>Облако</b></h2>
                <p>Храните свои книги в облаке для беспрепятственного доступа к ним с любого устройства.</p>
                <p><a class="btn btn-default" href="http://bootstrap-3.ru/examples/jumbotron/#" role="button">Узнать больше</a></p></div>
        </div>
    </div>
</div>';?>
<div class="container">
    <div class="row">
        <?=$body?>
    </div>
</div>
</body>
</html>