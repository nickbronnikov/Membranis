<?php
include 'includes/db.php';
function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}
function checkConfirm($key){
    $stmt=B::selectFromBase('users',null,array('id_key'),array($key));
    $data=$stmt->fetchAll();
    if (count($data)>0) {
        $id_key = preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/", "", crypt(rus2translit($_COOKIE['logged_user'])));
        B::updateBase('users',array('id_key','confirmation'),array($id_key,1),array('id_key'),array($key));
        setCookies('logged_user',$data[0]['login']);
        setCookies('key',$id_key);
        return true;
    } else return false;
}
if ($_GET['com']=='cnf' && isset($_GET['key'])){
    $check=checkConfirm($_GET['key']); 
} else $check=false;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recovery</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/recovery.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="57x57" href="img/logo/57.png" >
    <link rel="apple-touch-icon" sizes="114x114" href="img/logo/114.png" >
    <link rel="apple-touch-icon" sizes="72x72" href="img/logo/72.png" >
    <link rel="apple-touch-icon" sizes="144x144" href="img/logo/144.png" >
    <link rel="apple-touch-icon" sizes="60x60" href="img/logo/60.png" >
    <link rel="apple-touch-icon" sizes="120x120" href="img/logo/120.png" >
    <link rel="apple-touch-icon" sizes="76x76" href="img/logo/76.png" >
    <link rel="apple-touch-icon" sizes="152x152" href="img/logo/152.png" >
    <link rel="icon" type="image/png" href="img/logo/196.png" sizes="196x196">
    <link rel="icon" type="image/png" href="img/logo/160.png" sizes="160x160">
    <link rel="icon" type="image/png" href="img/logo/96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="img/logo/16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="img/logo/32.png" sizes="32x32">
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
                <?php if ($_COOKIE['logged_user']!=null && checkKey($_COOKIE['key'])) echo '<li class="dropdown maincolor">
                        <button class="btn btn-default dropdown-toggle btn-rad" data-toggle="dropdown" id="user_name">'.$_COOKIE["logged_user"].'   <b class="caret"></b></button>
                        <ul class="dropdown-menu">
                            <li><a href="library">Your library</a></li>
                            <li><a href="settings">Settings</a></li>
                            <li><a href="help">Help</a></li>
                            <li class="divider"></li>
                            <li><a href="logout">Log out</a></li>
                        </ul>
                    </li>'; else if (!$check) echo '<a class="btn btn-success pull-left button-nav button-color btn-rad" href="signin">Sign in</a><a class="btn btn-success pull-right btn-rad" href="signup.php">Sign up</a>';?>
            </ul>
        </div>
    </div>
</div>
<div class="body">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-4 col-lg-offset-4 col-md-4 col-lg-4 col-xs-12 col-sm-12" id="login-div">
                <?php if ($check) echo '<div id="login-form">
                    <div class="panel panel-default width-full">
                        <div class="panel-body panel-confirm">
                                <h1 class="text-center">Your account is confirmed</h1>
                                <div><a href="/" class="btn btn-success btn-lg center-block width-full btn-rad" id="start">Back to your library</a></div>
                        </div>
                    </div>
                </div>'; else echo '<h1 class="text-center">Recover the password</h1>
                <span class="width-full" id="info"></span>
                <div id="login-form">
                    <div class="panel panel-default width-full">
                        <div class="panel-body">
                                <label for="login">Email address</label>
                                <input type="text" class="form-control" id="sEmail" name="email"><br>
                                <button class="btn btn-lg btn-success width-full" id="recover">Recover</button>
                        </div>
                    </div>
                </div>';
                ?>
            </div>
        </div>
    </div>
</div>
<div id="footer" class="recovery-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-5 col-sm-4 col-xs-4 copyright">
                <b class="maincolor">© 2016 PolisBook</b>
            </div>
            <div class="col-md-2 col-lg-2  col-sm-4 col-xs-4">
                <img class="img-footer center-block" src="img/Logo_s.png">
            </div>
            <div class="col-md-4 col-lg-4 col-sm-2 col-xs-2">
            </div>
            <div class="col-md-1 col-lg-1 col-sm-2 col-xs-2 copyright"><b><a href="help">Help</a></b></div>
        </div>
    </div>
</div>
</body>
</html>

