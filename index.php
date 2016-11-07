<?php
require 'includes/db.php';
if ($_COOKIE['logged_user']!=null && !checkKey($_COOKIE['key'])) {
    delCookies('logged_user');
    delCookies('key');
    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
}
if ($_COOKIE['logged_user']!=null) {
    $stmt = B::selectFromBase('users_info', null, array('login'), array($_COOKIE['logged_user']));
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
        $stmt=B::selectFromBase('users',array('id'),array('login'),array($_COOKIE['logged_user']));
        $user=$stmt->fetchAll();
        $stmt = B::selectFromBase('users_files', null, array('id_user'), array($user[0]['id']));
        $books = $stmt->fetchAll();
        if (count($books)==0) $body.='<div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                </svg>
                </svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not uploaded any one book. <a href="library">Upload it now!</a></strong></h3>
            </div>
        </div>'; else {
            $data_key=array();
            foreach ($books as $key=>$arr){
                $data_key[$key]=$arr['id'];
            }
            array_multisort($books, SORT_NUMERIC, $data_key);
            $j=1;
            for ($i=count($books)-1;$i>=0;$i--){
                if ($j>4) break; else {
                    $progress=json_decode($books[$i]['progress'],true);
                    $file_info=pathinfo($books[$i]['path']);
                    $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title name-book">'.$books[$i]['author'].'</h3>
            </div>
            <div class="panel-body preview-book"><img  class="preview-book-cover" src="'.$books[$i]['cover'].'"/></div>
            <div class="panel-footer"><div class="btn-group">
    <a class="btn btn-success" href="reader?id='.$books[$i]['id'].'">Read</a>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <b class="caret"></b>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="'.$books[$i]['path'].'" download="'.$books[$i]['original_name'].'.'.$file_info['extension'].'">Download</a></li>
        <li class="divider"></li>
        <li><a class="btn-delete" href="#">Delete</a></li>
    </ul>
</div><span class="progress-info pull-right">'.$progress['progress'].'%</span></div>
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
                $file_info=pathinfo($book[0]['path']);
                $progress=json_decode($book[0]['progress'],true);
                $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title name-book">'.$book[0]['author'].'</h3>
            </div>
            <div class="panel-body preview-book"><img  class="preview-book-cover" src="'.$book[0]['cover'].'"/></div>
            <div class="panel-footer"><div class="btn-group">
    <a class="btn btn-success" href="reader?id='.$book[0]['id'].'">Read</a>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <b class="caret"></b>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="'.$book[0]['path'].'" download="'.$book[0]['original_name'].'.'.$file_info['extension'].'">Download</a></li>
    </ul>
</div><span class="progress-info pull-right">'.$progress['progress'].'%</span></div>
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
        $stmt=B::selectFromBase('users',array('id'),array('login'),array($_COOKIE['logged_user']));
        $user=$stmt->fetchAll();
        $stmt = B::selectFromBase('users_files', null, array('id_user'), array($user[0]['id']));
        $books = $stmt->fetchAll();
        $data_key=array();
        foreach ($books as $key=>$arr){
            $data_key[$key]=$arr['id'];
        }
        array_multisort($books, SORT_NUMERIC, $data_key);
        for ($i=count($books)-1;$i>=0;$i--){
            if ($j>3) break; else {
                $file_info=pathinfo($books[$i]['path']);
                $progress=json_decode($books[$i]['progress'],true);
                $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title name-book">'.$books[$i]['author'].'</h3>
            </div>
            <div class="panel-body preview-book"><img  class="preview-book-cover" src="'.$books[$i]['cover'].'"/></div>
            <div class="panel-footer"><div class="btn-group">
    <a class="btn btn-success" href="reader?id='.$books[$i]['id'].'">Read</a>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <b class="caret"></b>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="'.$books[$i]['path'].'" download="'.$books[$i]['original_name'].'.'.$file_info['extension'].'">Download</a></li>
    </ul>
</div><span class="progress-info pull-right">'.$progress['progress'].'%</span></div>
            </div>
            </div>';
                $j++;
            }
        }
        if (count($books)>3){
            $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12"><a class="a-all" href="library"><div class="panel panel-default view-all"><div class="panel-body viewdiv"><p><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M0 0h24v24H0z" fill="none"/>
    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
</svg></p><h1 class="maincolor text-center"><b>View all</b></h1></div></div></a></div>';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <?php if ($_COOKIE['logged_user']!=null) echo '<title>CloudLibrary</title>'; else
    echo '<title>PolisBook || Read fb2, epub, pdf and other books online</title>';?>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/dropzone.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
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
        <?php if ($_COOKIE['logged_user']==null) echo '<div class="navbar-collapse collapse" id="mainnav">
            <ul class="nav navbar-nav navbar-right navel">
                <a class="btn btn-success pull-left button-nav button-color btn-rad" href="signin">Sign in</a>
                <a class="btn btn-success pull-right btn-rad" href="signup">Sign up</a>
            </ul>
        </div>'; else echo '<div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" >
                <li class="dropdown maincolor li-nav" id="li-nav">
                    <button class="btn btn-default btn-rad dropdown-toggle" data-toggle="dropdown">'.$_COOKIE['logged_user'].'   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a href="library">Your library</a></li>
                        <li><a href="settings">Settings</a></li>
                        <li><a href="help">Help</a></li>
                        <li class="divider"></li>
                        <li><a href="logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>';
        ?>
    </div>
</div>
<?php if ($_COOKIE['logged_user']==null) echo '<div id="mainbody">
    <div class="jumbotron" id="mainpanel">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-md-offset-3 col-lg-7 col-lg-offset-3 col-sm-12 col-xs-12">
                    <div class="center-block reg main-jumbotron">
                        <h1 class="maintext text-center">Cloud Library</h1>
                        <h2 class="maintext text-center">Your books. Always, everywhere, with you.
                        <div class="button-reg"><a href="signup" class="btn btn-success btn-lg center-block btn-rad" id="button-reg">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="body-info">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 well">
                <h1 class="text-center maincolor"><b>Welcome to your library.</b></h1>
                <h3 class="text-center maincolor">You can keep your books in the cloud and read them whenever you feel like it.</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 well block"><div><img class="info-img" src="/img/Sync.png"></div><h3 class="maincolor text-center text-block"><b>Synchronization</b></h3>
                <h4 class="maincolor text-center">Sync your progress. Always start reading from the place where finished.</h4>
                </div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 well block"><div><img class="info-img" src="/img/Devices.png"></div><h3 class="maincolor text-center text-block"><b>On all your devices</b></h3>
                <h4 class="maincolor text-center">Read your favorite books and magazines on any of your device.</h4>
                </div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 well block"><div><img class="info-img" src="/img/Cloud.png"></div><h3 class="maincolor text-center text-block"><b>Cloud</b></h3>
                <h4 class="maincolor text-center">Keep your books in the cloud for easy access to them.</h4>
                </div>
        </div>
    </div>
</div>
<div id="jumbotron-formats"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <h1 class="maincolor text-center"><b>Read your books in all popular formats</b></h1>
            <h3 class="maincolor text-center">Read your books and magazines online in fb2, pdf, mobi, epub and txt formats.</h3>
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
    </div>
</div>
<div id="jumbotron-reader"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <h1 class="maincolor text-center"><b>Reader</b></h1>
            <h3 class="maincolor text-center">Simple and easy reader. Customize it the way you want it.</h3>
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
    </div>
</div>
</div>';?>
<div class="container">
    <div class="row">
        <?=$body?>
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