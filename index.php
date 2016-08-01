<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CloudLibrary</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/dropzone.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="navbar navbar-default navbar-static-top" id="mainnav" role="navigation">
    <div class="container navel">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand " href="/"><img src="img/Logo_s.png"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right navel">
                <a class="btn btn-success pull-left button-nav button-color">Sign in</a>
                <a class="btn btn-success pull-right" href="signup.php">Sign up</a>
            </ul>
        </div>
    </div>
</div>
<div>
    <div class="jumbotron" id="mainpanel">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
                    <h1 class="center-block maintext">Облачная библиотека</h1>
                        <h2 class="maintext">Ваши книги. Всегда, везде, с вами.</h2>
            </div>
                <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                    <br><br><br><br>
                    <form>
                        <input type="text" class="form-control" id="login" placeholder="Enter login"><br>
                        <input type="text" class="form-control" id="email" placeholder="Enter e-mail"><br>
                        <input type="text" class="form-control" id="password" placeholder="Enter password"><br>
                        <button type="submit" class="btn btn-success btn-lg center-block" id="button-reg">Sign up</button>
                    </form>
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

    <hr>
    <footer>
        <div class="container">
            <p>© CloudLibrary 2014</p>
        </div>
    </footer>
</body>
</html>