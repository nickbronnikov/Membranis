<?php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Join Membranis</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/signup.js"></script>
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
            <a class="navbar-brand " href="/"><img src="img/Logo_s.png"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right navel">
                <a class="btn btn-success pull-left button-nav button-color btn-rad" href="signin">Sign in</a>
            </ul>
        </div>
    </div>
</div>
<div class="body center-block">
    <div class="container ">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-12 col-xs-12" >
                <h1 class="text-center maincolor" id="headinfo"><b>Join Membranis</b></h1>
                <h3 class="text-center maincolor">The best place to read</h3>
            </div>
            <div class="col-md-3 col-lg-3"></div>
            <div id="reg-form">
            <div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 col-sm-12 col-xs-12">
                <ol class="table-reg">
                    <li class="current" id="step1">
                        <svg class="icon" fill="#607d8b" height="36" viewBox="0 0 24 24" width="36" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                            <path d="M0 0h24v24H0z" fill="none"/>
                        </svg><strong>Step 1:</strong>
                        <p>Create your account</p>
                    </li>
                    <li id="step2">
                        <svg class="icon" fill="#607d8b" height="36" viewBox="0 0 24 24" width="36" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"/>
                        </svg><strong>Step 2:</strong>
                        <p>Set up your account</p>
                    </li>
                    <li id="step3">
                        <svg class="icon" fill="#607d8b" height="36" viewBox="0 0 24 24" width="36" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg><strong>Step 3:</strong>
                        <p>Done!</p>
                    </li>
                </ol>

            </div>
            <div class="col-md-2 col-lg-2"></div>
                <div id="form">
            <div class="col-md-offset-3 col-lg-offset-3 col-md-5 col-lg-5 col-sm-12 col-xs-12 regform">
                <label for="loginreg">Username</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="loginreg">
                    <span class="input-group-addon" id="loginregcheck"></span>
                </div>
                <span id="loginregalert"><p class="info-reg">This will be your username.</p></span>
                <label for="emailreg">Email address</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="emailreg">
                    <span class="input-group-addon" id="emailregcheck"></span>
                </div>
                <span id="emailregalert"><p class="info-reg">We promise not to share your email with anyone.</p></span>
                <label for="passwordreg">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="passwordreg">
                    <span class="input-group-addon" id="passwordregcheck"></span>
                </div>
                <span id="passwordregallert"><p class="info-reg">Password should be at least 5 characters.</p></span>
                <button type="submit" class="btn btn-success btn-lg center-block" id="regbutton">Sign up</button>
            </div>
                </div>
                </div>
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
            <div class="col-md-4 col-lg-4 col-sm-2 col-xs-2">
            </div>
            <div class="col-md-1 col-lg-1 col-sm-2 col-xs-2 copyright"><b><a href="help">Help</a></b></div>
        </div>
    </div>
</div>
</body>
</html>
