<?php
require 'includes/db.php';
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
                <a class="btn btn-success pull-left button-nav button-color" href="signin">Sign in</a>
                <a class="btn btn-success pull-right" href="signup">Sign up</a>
            </ul>
        </div>'; else echo '<div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown maincolor">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$_SESSION['logged_user'].'<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Действие</a></li>
                        <li><a href="library">Your library</a></li>
                        <li><a href="#">Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="#" onclick="logout()">Log out</a></li>
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
                        <div class="button-reg"><a href="signup.php" class="btn btn-success btn-lg center-block" id="button-reg">Sign up</a>
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
<div id="logout"></div>
</body>

<footer >
    <hr>
    <div class="container">
        <p>© CloudLibrary 2014</p>
    </div>
</footer>
</html>