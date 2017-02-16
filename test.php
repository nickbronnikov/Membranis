<?php
$str='';
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
<div style="width: 536px">
    <div style="width: 100%;max-width: 600px; margin: auto; border: 1px solid #e3e3e3;">
        <div style="width: 100%; height: 50px; background-color: #EEEEEE;">
            <div style="display: block;margin-right: auto; margin-left: auto;"><img style="padding-top:5px;display: block;margin-right: auto; margin-left: auto;" src="https://polisbook.com/img/Logo_s.png"></div>
        </div>
        <div style="padding: 20px 40px">
            <h1 style="text-align: center; color: #607d8b;"><b>Password recovery</b></h1>
            <h3 style=" text-align: justify; color: #607d8b;"><b>Hello, nick.bronnikov!</b></h3>
            <p style="font-size: 20px; text-align: justify; font-weight: 600; color: #607d8b; white-space: normal;">You were sent a request for password recovery. If you haven't sent a request please ignore this message. Your new password:</p>
            <div style="padding: 20px 0px">
                <div  style="height:40px; display: block;margin-right: auto; margin-left: auto;background-color: #FFFFFF;color: #607d8b;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: normal;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;background-image: none;border: 1px solid transparent;border-color: #607d8b; width: 50%"><b><?=$str?></b></div>
            </div>
            <p style="font-size: 20px; text-align: justify; font-weight: 600; color: #607d8b; white-space: normal;">If you have any questions or suggestions you can always <a href="https://polisbook.com/help">contact us</a>.</p>
        </div>
        <div style="width: 100%; height: 60px; background-color: #EEEEEE; padding: 20px 30px">
            <p style="text-align: justify; color: #607d8b; white-space: normal;"><b>With best regards, PolisBook.</b></p>
        </div>
    </div>
</div>
<h1 class="text-center">Your account is confirmed</h1>
<div id="login-form">
    <div><a href="/" class="btn btn-success btn-lg center-block width-full btn-rad" id="start">Back to your library</a></div>
</div>
</body>
</html>
