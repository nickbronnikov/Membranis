<?php
require 'reader-file.php';
class html{
    var $page;
    function html($name){
        $this->page=$name;
    }
    function getPage(){
        $head=new head($this->page);
        $body=new body($this->page);
        $footer=new footer($this->page);
        $html=$head->getHead().'<body>'.$head->getMainNav().$body->getBody().$footer->getFooter().'</body>';
        return $html;
    }
}
class head{
    var $page;
    function head($name){
        $this->page=$name;
    }
    function getHead(){
        $head='';
        switch ($this->page){
            case 'index':
                if (isset($_COOKIE['logged_user'])) $title = 'CloudLibrary'; else
                    $title = 'PolisBook  Read fb2 epub pdf and other books online';
                $head='<head>
    <meta charset="utf-8">
    <title>'.$title.'</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/dropzone.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <script src="js/index.js"></script>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link href="css/progress.css" type="text/css" rel="stylesheet"/>
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
</head>';
                break;
            case 'library':
                $head='<head>
    <meta charset="utf-8">
    <title>Your Library</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <link href="css/download-style.css" type="text/css" rel="stylesheet"/>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/progress.css" type="text/css" rel="stylesheet"/>
    <script src="js/js-download/jquery.knob.js"></script>
    <script src="js/library.js"></script>
    <script src="js/js-download/jquery.ui.widget.js"></script>
    <script src="js/js-download/jquery.iframe-transport.js"></script>
    <script src="js/js-download/jquery.fileupload.js"></script>
    <script src="js/js-download/script.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/progress-bar/progress.js"></script>
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
</head>';
                break;
            case 'settings':
                $head='<head>
    <meta charset="utf-8">
    <title>Settings</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/progress.css" type="text/css" rel="stylesheet"/>
    <script src="js/js-download/jquery.knob.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jqueryScrollTo.js"></script>
    <script src="js/progress-bar/progress.js"></script>
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
    <link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css" />
    <script type="text/javascript" src="js/colorpicker.js"></script>
    <script src="js/style.js"></script>
    <script src="js/settings.js"></script>
</head>';
                break;
            case 'help':
                $head='<head>
    <meta charset="utf-8">
    <title>Help</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/dropzone.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/help.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <link href="css/progress.css" type="text/css" rel="stylesheet"/>
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
</head>';
                break;
            case 'recovery':
                if ($_GET['com']=='cnf') $title='Confirm your account'; else
                    $title='Recovery';
                $head='<head>
    <meta charset="utf-8">
    <title>'.$title.'</title>
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
</head>';
                break;
            case 'signin':
                $head='<head>
    <meta charset="utf-8">
    <title>Sign in to PolisBook</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/signup.js"></script>
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
</head>';
                break;
            case 'signup':
                $head='<head>
    <meta charset="utf-8">
    <title>Join PolisBook</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/signup.js"></script>
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
</head>';
                break;
            case 'reader':
                $stmt=B::selectFromBase('users_files',null,array('id'),array($_GET['id']));
                $data=$stmt->fetchAll();
                $file_info = pathinfo($data[0]['path']);
                $js='';
                switch ($file_info['extension']){
                    case 'fb2':
                        $js.='<script src="js/fb2Reader.js"></script>';
                        $js.='<script src="js/style.js"></script>';
                        break;
                    case 'pdf':
                        $js.='<script src="js/pdfReader.js"></script>';
                        break;
                    case 'epub':
                        $js.='<script src="js/epubReader.js"></script>';
                        $js.='<script src="js/style.js"></script>';
                        break;
                    case 'txt':
                        $js.='<script src="js/htmltxtReader.js"></script>';
                        $js.='<script src="js/style.js"></script>';
                        break;
                    case 'html':
                        $js.='<script src="js/htmltxtReader.js"></script>';
                        $js.='<script src="js/style.js"></script>';
                        break;
                }
                $head='<head>
    <meta charset="utf-8">
    <title>'.$data[0]['original_name'].'</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/progress.css" type="text/css" rel="stylesheet"/>
    <script src="js/js-download/jquery.knob.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <script src="js/bootstrap.min.js"></script>'.$js.'
    <script src="js/jqueryScrollTo.js"></script>
    <script src="js/progress-bar/progress.js"></script>
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
</head>';
                break;
        }
        return $head;
    }
    function getMainNav(){
        $mainNav='';
        switch ($this->page){
            case 'index':
                if (isset($_COOKIE['logged_user'])) {
                    $progressShow='<script>progressShow()</script>';
                    $rNav='<div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" >
                <li class="dropdown maincolor" id="li-nav">
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
                } else {
                    $progressShow='';
                    $rNav='<div class="navbar-collapse collapse" id="mainnav">
            <ul class="nav navbar-nav navbar-right navel">
                <a class="btn btn-success pull-left button-nav button-color btn-rad" href="signin">Sign in</a>
                <a class="btn btn-success pull-right btn-rad" href="signup">Sign up</a>
            </ul>
        </div>';
                }
                $mainNav=$progressShow.'<div class="navbar navbar-default navbar-static-top" id="nav" role="navigation">
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
        '.$rNav.'
    </div>
</div><div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="deleteBookModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content btn-rad center-block" style="width:70%">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"><strong>Delete</strong></h3>
            </div>
            <div class="modal-body" id="infoDelete">
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-default btn-rad pull-left" data-dismiss="modal">Cancel</button>
                <button class="btn btn-danger btn-rad pull-right" id="btnDelete">Delete</button>
            </div>
        </div>
    </div>
</div>';
                break;
            case 'library':
                $mainNav='<script>progressShow()</script><div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="errorExtension">
    <div class="modal-dialog modal-lg">
        <div class="modal-content btn-rad">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"><strong>Wrong extension</strong></h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-error">You are trying to download a file with an extension that does not support  by PolisBook. Available extensions: <strong>fb2, pdf, epub, txt, html</strong>.</div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="deleteBookModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content btn-rad center-block" style="width:70%">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"><strong>Delete</strong></h3>
            </div>
            <div class="modal-body" id="infoDelete">
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-default btn-rad pull-left" data-dismiss="modal">Cancel</button>
                <button class="btn btn-danger btn-rad pull-right" id="btnDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="errorStorage">
    <div class="modal-dialog modal-lg">
        <div class="modal-content btn-rad">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"><strong>Not enough storage</strong></h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-error">Not enough storage to download the file. Delete some files or increase the amount of available storage.</div>
            </div>
        </div>
    </div>
</div>
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
                <li class="li-nav"><form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
                    <div id="drop">
                        <a class="btn btn-success btn-rad" id="download">Upload</a>
                        <input type="file" name="upl" multiple/>
                    </div>
                </form></li>
                <li class="li-nav" style="margin-left: 0%"><span class="progress-download" id="pd">
                    <span class="dropdown">
                        <a class="btn btn-default dropdown-toggle btn-rad" type="button" data-toggle="dropdown" disabled="disabled" id="pd-btn"><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu download-info btn-rad" id="download-list">
                            <span id="append"></span>
                            <li class="divider"></li>
                            <li><a  class="width-full btn btn-default btn-rad" id="clearprogressbar">Clear downloads list</a></li>
                        </ul>
                    </span>
                </span></li>
                <li class="dropdown maincolor" id="li-nav">
                    <button class="btn btn-default btn-rad dropdown-toggle" data-toggle="dropdown">'.$_COOKIE['logged_user'].'   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a href="settings">Settings</a></li>
                        <li><a href="help">Help</a></li>
                        <li class="divider"></li>
                        <li><a href="logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div>';
                break;
            case 'settings':
                $mainNav='<script>progressShow()</script>
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
                    <li class="dropdown maincolor" id="li-nav">
                        <button class="btn btn-default dropdown-toggle btn-rad" data-toggle="dropdown" id="user_name">'.$_COOKIE['logged_user'].'   <b class="caret"></b></button>
                        <ul class="dropdown-menu">
                            <li><a href="library">Your library</a></li>
                            <li><a href="help">Help</a></li>
                            <li class="divider"></li>
                            <li><a href="logout">Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>';
                break;
            case 'help':
                if (isset($_COOKIE['logged_user'])) $rNav='<div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" >
                <li class="dropdown maincolor" id="li-nav">
                    <button class="btn btn-default btn-rad dropdown-toggle" data-toggle="dropdown">'.$_COOKIE['logged_user'].'   <b class="caret"></b></button>
                    <ul class="dropdown-menu">
                        <li><a href="library">Your library</a></li>
                        <li><a href="settings">Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="logout">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>'; else $rNav='<div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right navel">
                <a class="btn btn-success pull-left button-nav button-color btn-rad" href="signin">Sign in</a>
            </ul>
        </div>';
                $mainNav='<script>progressShow()</script>
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
        </div>'.$rNav.'
    </div>
</div>';
                break;
            case 'recovery':
                if ($_GET['com']=='cnf' && isset($_GET['key'])){
                    $check=checkConfirmData($_GET['key']);
                } else $check=false;
                $rNav='';
                if (isset($_COOKIE['logged_user']) && checkKey($_COOKIE['key'])) $rNav='<li class="dropdown maincolor">
                        <button class="btn btn-default dropdown-toggle btn-rad" data-toggle="dropdown" id="user_name">'.$_COOKIE["logged_user"].'   <b class="caret"></b></button>
                        <ul class="dropdown-menu">
                            <li><a href="library">Your library</a></li>
                            <li><a href="settings">Settings</a></li>
                            <li><a href="help">Help</a></li>
                            <li class="divider"></li>
                            <li><a href="logout">Log out</a></li>
                        </ul>
                    </li>'; else if (!$check) $rNav='<a class="btn btn-success pull-left button-nav button-color btn-rad" href="signin">Sign in</a><a class="btn btn-success pull-right btn-rad" href="signup.php">Sign up</a>';
                $mainNav='<div class="navbar navbar-default navbar-static-top" id="nav" role="navigation">
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
            <ul class="nav navbar-nav navbar-right navel">'.$rNav.'
            </ul>
        </div>
    </div>
</div>';
                break;
            case 'signin':
                $mainNav='<div class="navbar navbar-default navbar-static-top" id="nav" role="navigation">
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
                <a class="btn btn-success pull-right btn-rad" href="signup">Sign up</a>
            </ul>
        </div>
    </div>
</div>';
                break;
            case 'signup':
                $mainNav='<div class="navbar navbar-default navbar-static-top" id="nav" role="navigation">
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
</div>';
                break;
            case 'reader':
                $stmt=B::selectFromBase('users_files',null,array('id'),array($_GET['id']));
                $data=$stmt->fetchAll();
                $file_info = pathinfo($data[0]['path']);
                $chapter='';
                switch ($file_info['extension']) {
                    case 'fb2':
                        $chapter = FB2::chapterList($data[0]['path']);
                        break;
                    case 'epub':
                        $chapter = EPUB::chapterListEPUB($data[0]['path']);
                        break;
                }
                $rNav='';
                switch ($file_info['extension']){
                    case 'fb2':
                        $rNav=$chapter;
                        break;
                    case 'pdf':
                        $rNav='<button class="btn btn-success btn-rad" id="continueReading">Continue</button>';
                        break;
                    case 'epub':
                        $rNav=$chapter;
                        break;
                    case 'txt':
                        $rNav='';
                        break;
                    case 'html':
                        $rNav='';
                        break;
                }
                $mainNav='<script>progressShow()</script>
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
                <li class="dropdown maincolor li-nav">
                    <button class="btn btn-success dropdown-toggle li-nav-read btn-rad" id="bookmarks"><svg fill="#FFFFFF" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                            <path d="M0 0h24v24H0z" fill="none"/>
                        </svg></button>
                </li>
                <li class="dropdown maincolor li-nav">'.$rNav.'</li>
                <li class="dropdown maincolor" id="li-nav">
                    <button class="btn btn-default dropdown-toggle btn-rad" data-toggle="dropdown">'.$_COOKIE['logged_user'].'   <b class="caret"></b></button>
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
    </div>';
                break;
        }
        return $mainNav;
    }
}
class body{
    var $page;
    function body($name){
        $this->page=$name;
    }
    function getBody(){
        $body='';
        switch ($this->page){
            case 'index':
                if (isset($_COOKIE['logged_user'])){
                    $showBook=new showBook();
                    $stmt = B::selectFromBase('users_info', null, array('login'), array($_COOKIE['logged_user']));
                    $data = $stmt->fetchAll();
                    $last_books = json_decode($data[0]['last_books'], true);
                    $s = array_sum($last_books);
                    if ($s == 0) {
                        $body='<div class="body"><div class="container">
    <div class="row"><div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
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
                        $stmt = B::selectFromBaseSet('users_files', null, array('id_user'), array($user[0]['id']),'ORDER BY `id` DESC LIMIT 4');
                        $books = $stmt->fetchAll();
                        $books=$showBook->booksSort($books);
                        if (count($books)==0) $body.='<div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                </svg>
                </svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not uploaded any one book. <a href="library">Upload it now!</a></strong></h3>
            </div>
        </div>'; else {
                            if (count($books)>3){
                                $body.=$showBook->books(array($books[1],$books[2],$books[3]));
                                $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12"><a class="a-all" href="library"><div class="panel panel-default view-all"><div class="panel-body viewdiv"><p><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M0 0h24v24H0z" fill="none"/>
    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
</svg></p><h1 class="maincolor text-center"><b>View all</b></h1></div></div></a></div></div>';
                            } else {
                                $body.=$showBook->books($books);
                                $body.='</div>';
                            }
                        }
                        $body.='</div></div></div>';
                    } else {
                        $body='<div class="body"><div class="container">
    <div class="row"><div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <h3 class="maincolor"><strong>Last books:</strong></h3></div>';
                        $keys=array();
                        $conditions=array();
                        for ($i=0;$i<count($last_books);$i++) {
                            if ($last_books[$i] != 0) {
                                array_push($keys, $last_books[$i]);
                                array_push($conditions, 'id');
                            }
                        }
                        $stmt=B::selectFromBaseOr('users_files',null,$conditions,$keys);
                        $books=$stmt->fetchAll();
                        $sorted_books=array();
                        $j=-1;
                        for ($i=0;$i<count($last_books);$i++){
                            if ($last_books[$i]!=0) $j++;
                        }
                        for ($i=0;$i<count($last_books);$i++){
                            if ($last_books!=0) {
                                foreach ($books as $item) {
                                    if ($item['id'] == $last_books[$i]) $sorted_books[$j] = $item;
                                }
                                $j--;
                            }
                        }
                        $body.=$showBook->books($sorted_books);
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
                        $stmt = B::selectFromBaseSet('users_files', null, array('id_user'), array($user[0]['id']),'ORDER BY id DESC LIMIT 4');
                        $books = $stmt->fetchAll();
                        $books=$showBook->booksSort($books);
                        if (count($books)>3){
                            $body.=$showBook->books(array($books[1],$books[2],$books[3]));
                            $body.='<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12"><a class="a-all" href="library"><div class="panel panel-default view-all"><div class="panel-body viewdiv"><p><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg">
    <path d="M0 0h24v24H0z" fill="none"/>
    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
</svg></p><h1 class="maincolor text-center"><b>View all</b></h1></div></div></a></div></div>';
                        } else {
                            $body.=$showBook->books($books);
                            $body.='</div>';
                        }
                    }
                    $body.='</div></div></div>';
                } else {
                    $body='<div id="mainbody">
    <div class="jumbotron" id="mainpanel">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 col-sm-12 col-xs-12">
                    <div class="center-block reg main-jumbotron">
                        <h1 class="maintext text-center">Polisbook</h1>
                        <h2 class="maintext text-center">Your books. Always, everywhere, with you.
                        <div class="button-reg"><a href="signup" class="btn btn-success btn-lg center-block btn-rad" id="button-reg">Sign up</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="body-info">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 well btn-rad">
                <h1 class="text-center maincolor"><b>Welcome to your library.</b></h1>
                <h3 class="text-center maincolor">You can save your books to the cloud and read them whenever you want.</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 well block btn-rad"><div><img class="info-img" src="/img/Sync.png"></div><h3 class="maincolor text-center text-block"><b>Synchronization</b></h3>
                <h4 class="maincolor text-center">Sync your progress. Always start reading from the place where finished.</h4>
                </div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 well block btn-rad"><div><img class="info-img" src="/img/Devices.png"></div><h3 class="maincolor text-center text-block"><b>On all your devices</b></h3>
                <h4 class="maincolor text-center">Read your favorite books and magazines on any of your device.</h4>
                </div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 well block btn-rad"><div><img class="info-img" src="/img/Cloud.png"></div><h3 class="maincolor text-center text-block"><b>Cloud</b></h3>
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
            <a href="signup" class="btn btn-success btn-lg center-block btn-rad" id="button-reg">Join to PolisBook</a>
        </div>
    </div>
</div>
</div>';
                }
                break;
            case 'library':
                $stmt=B::selectFromBase('users',array('id'),array('login'),array($_COOKIE['logged_user']));
                $data=$stmt->fetchAll();
                $showBook=new showBook();
                $show=$showBook->showAllBook();
                $body='<div class="body"><div class="container lib-body">
    <div class="row" id="book">
        '.$show.'
    </div>
</div>
</div></div>';
                break;
            case 'settings':
                $body='<div class="body"><div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-10 col-md-offset-1 ol-lg-offset-1 col-xs-12 col-sm-12 s-panel">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading settings-head">Settings</div>
                            <div class="">
                                <p class="li-setting active-set" id="s-account"><span>Account</span></p>
                                <p class="li-setting" id="s-password"><span>Password</span></p>
                                <p class="li-setting" id="s-reader"><span>Reader</span></p>
                                <p class="li-setting" id="s-storage"><span>Storage</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-md-9 col-lg-9">
                            <div id="bs">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><strong>Update login</strong></div>
                                    <div class="panel-body">
                                        <label for="newlogin">New login</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="newlogin">
                                            <span class="input-group-addon" id="newlogincheck"></span>
                                        </div>
                                        <span id="newloginalert"><p class="info-reg">This is your new login</p></span>
                                        <button class="btn btn-success" id="btn-newlogin">Update login</button>
                                        <span id="infologin"></span>
                                    </div>
                                </div><div class="panel panel-default">
                                    <div class="panel-heading"><strong>Update email</strong></div>
                                    <div class="panel-body">
                                        <label for="oldemail">Old email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oldemail">
                                            <span class="input-group-addon" id="oldemailcheck"></span>
                                        </div>
                                        <span id="oldemailalert"><p class="info-reg">This is your old email</p></span>
                                        <label for="newemail">New email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="newemail">
                                            <span class="input-group-addon" id="newemailcheck"></span>
                                        </div>
                                        <span id="newemailalert"><p class="info-reg">This is your new email</p></span>
                                        <button class="btn btn-success" id="btn-newemail">Update email</button>
                                        <span id="infoemail"></span>
                                    </div>
                                </div>
                </div>
            </div>
            <div class="col-md-1 col-lg-1">
            </div>
        </div>
    </div>
</div>
</div>
    </div></div>';
                break;
            case 'help':
                if (isset($_COOKIE['logged_user']) && checkKey($_COOKIE['key'])) {
                    $stmt = B::selectFromBase('users', null, array('login'), array($_COOKIE['logged_user']));
                    $data = $stmt->fetchAll();
                    $mail='<div class="panel panel-default" id="email-help">
                        <div class="panel-body" style="padding: 6px 12px">
                            <span>'.$data[0]['email'].'</span>
                        </div>
                    </div>';
                } else $mail='<input class="form-control" type="text" id="email" maxlength="50">';
                $body='<div id="page body">
<div id="jumbotron-help"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <h1 class="maincolor text-center"><b>Help</b></h1>
            <h3 class="maincolor text-center">If you have any problems with our service, please send us a message.</h3>
        </div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <hr class="hr-info">
        </div>
        <div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 col-xs-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <label for="email-help">Email</label>'.$mail.'
                    <label for="subject">Subject</label>
                    <input class="form-control" type="text" id="subject" maxlength="250">
                    <label for="problem">Your problem</label>
                    <textarea class="form-control" rows="5" id="problem" placeholder="Please describe in detail your problem." maxlength="3000"></textarea>
                    <span id="check"></span>
                    <button type="button" class="btn btn-success" id="send" disabled="disabled">Send</button>
                </div>
            </div>
        </div><div class="col-md-2 col-lg-2"></div>

    </div>
</div>
</div>';
                break;
            case 'recovery':
                if ($_GET['com']=='cnf' && isset($_GET['key'])){
                    $check=checkConfirm($_GET['key']);
                } else $check=false;
                if ($check) {
                    $main_block='<div id="login-form">
                    <div class="panel panel-default width-full">
                        <div class="panel-body panel-confirm">
                                <h1 class="text-center">Your account is confirmed</h1>
                                <div><a href="/" class="btn btn-success btn-lg center-block width-full btn-rad" id="start">Back to your library</a></div>
                        </div>
                    </div>
                </div>';
                } else $main_block='<h1 class="text-center">Recover the password</h1>
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
                $body='<div class="body">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-4 col-lg-offset-4 col-md-4 col-lg-4 col-xs-12 col-sm-12" id="login-div">'.$main_block.'
            </div>
        </div>
    </div>
</div>';
                break;
            case 'signin':
                $data=$_POST;
                $check=true;
                if (isset($data['loginin'])) {
                    if (!checkField('users', array('login'), array($data['login']))) $check = false; else {
                        $logpas = array($data['login'], $data['password']);
                        if (checkPassword($logpas,'login')) $check = true; else $check=false;
                    }
                    if ($check) {
                        setCookies("logged_user",$data['login']);
                        $stmt=B::selectFromBase('users',null,array('login'),array($data['login']));
                        $login=$stmt->fetchAll();
                        setCookies("key",$login[0]['id_key']);
                        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
                    } else {
                        $check=true;
                        if (!checkField('users', array('email'), array($data['login']))) $check = false; else {
                            $logpas = array($data['login'], $data['password']);
                            if (checkPassword($logpas,'email')) $check = true; else $check=false;
                        }
                        if ($check) {
                            $stmt=B::selectFromBase('users',null,array('email'),array($data['login']));
                            $login=$stmt->fetchAll();
                            setCookies("logged_user",$login[0]['login']);
                            setCookies("key",$login[0]['id_key']);
                            echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=/">';
                        }
                    }
                }
                if ($check==false) $alert='<div class="alert alert-warning alert-dismissable width-full">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Incorrect username (email) or password. 
                        </div>'; else
                    $alert='';
                $body='<div class="body">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-4 col-lg-offset-4 col-md-4 col-lg-4 col-xs-12 col-sm-12" id="login-div">
                <h1 class="text-center">Sign in to Polisbook</h1>
                '.$alert.'
                <div id="login-form">
                <div class="panel panel-default width-full">
                    <div class="panel-body">
                        <form action="/signin" method="post">
                            <label for="login">Username or email address</label>
                            <input type="text" class="form-control" id="login" name="login"><br>
                            <label for="password">Password</label><span class="pull-right"><a href="recovery">Forgot password?</a></span>
                            <input type="password" class="form-control" id="password" name="password"><br>
                            <button type="submit" class="btn btn-lg btn-success width-full" name="loginin"">Sign in</button>
                        </form>
                    </div>
                </div>
                    <div class="panel panel-default width-full">
                        <div class="panel-body center-block">
                            <h4 class="text-center">Don\'t have an account? <a href="signup">Create it!</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
                break;
            case 'signup':
                $body='<div class="body center-block">
    <div class="container ">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-12 col-xs-12" >
                <h1 class="text-center" id="headinfo">Join to PolisBook</h1>
                <h3 class="text-center">The best place to read</h3>
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
            <div class="col-md-offset-3 col-lg-offset-3 col-md-6 col-lg-6 col-sm-12 col-xs-12 regform">
                <label for="loginreg">Username</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="loginreg" maxlength="30">
                    <span class="input-group-addon" id="loginregcheck"></span>
                </div>
                <span id="loginregalert"><p class="info-reg">This will be your username.</p></span>
                <label for="emailreg">Email address</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="emailreg" maxlength="50">
                    <span class="input-group-addon" id="emailregcheck"></span>
                </div>
                <span id="emailregalert"><p class="info-reg">We promise not to share your email with anyone.</p></span>
                <label for="passwordreg">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="passwordreg" maxlength="40">
                    <span class="input-group-addon" id="passwordregcheck"></span>
                </div>
                <span id="passwordregallert"><p class="info-reg">Password should be at least 5 characters.</p></span>
                <button type="submit" class="btn btn-success btn-lg center-block" id="regbutton">Sign up</button>
            </div>
                </div>
                </div>
        </div>
    </div>
</div>';
                break;
            case 'reader':
                $stmt=B::selectFromBase('users_files',null,array('id'),array($_GET['id']));
                $data=$stmt->fetchAll();
                $db=B::selectFromBase('users',null,array('login'),array($_COOKIE['logged_user']));
                $user=$db->fetchAll();
                if ($user[0]['id']==$data[0]['id_user']) {
                    $ui = B::selectFromBase('users_info', null, array('login'), array($_COOKIE['logged_user']));
                    $ui_data = $ui->fetchAll();
                    $last_books = json_decode($ui_data[0]['last_books'], true);
                    $i_book=-1;
                    for ($i=0;$i<4;$i++){
                        if ($last_books[$i]==$_GET['id']) {
                            $i_book=$i;
                            break;
                        }
                    }
                    if ($i_book!=-1){
                        for ($i=$i_book; $i>0;$i--){
                            $last_books[$i]=$last_books[$i-1];
                        }
                        $last_books[0]=$_GET['id'];
                    } else{
                        for ($i=3; $i>0;$i--){
                            $last_books[$i]=$last_books[$i-1];
                        }
                        $last_books[0]=$_GET['id'];
                    }
                    B::updateBase('users_info', array('last_books'), array(json_encode($last_books)), array('login'), array($_COOKIE['logged_user']));
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
                    $reader='';
                    switch ($file_info['extension']) {
                        case 'fb2':
                            $reader = FB2::getReader($data,$ui_data);
                            break;
                        case 'pdf':
                            $reader = PDF::getReader($data);
                            break;
                        case 'epub':
                            $reader = EPUB::getReader($data,$ui_data);
                            break;
                        case 'txt':
                            $reader=HTMLandTXT::getReaderTXT($data,$ui_data);
                            break;
                        case 'html':
                            $reader=HTMLandTXT::getReaderHTML($data,$ui_data);
                            break;
                    }
                } else {
                    $reader='<h2>You are trying to read the book that is not available to you.</h2>';
                }
                $body='  <div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="bookmarks-list">
        <div class="modal-dialog">
            <div class="modal-content btn-rad">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myLargeModalLabel"><strong>Bookmarks</strong></h3>
                </div>
                <div class="modal-body list" id="lb">
                    '.$modalbody.'
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-rad center-block" id="addbookmark">Add new bookmark</button>
                </div>
            </div>
        </div>
    </div>
</div>
    '.$reader.'
</div>';
                break;
        }
        return $body;
    }
}
class footer{
    var $page;
    function footer($name){
        $this->page=$name;
    }
    function getFooter(){
        $footer='';
        switch ($this->page){
            case 'help':
            case 'settings':
            case 'library':
            case 'index':
                $footer='<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-5 col-sm-4 col-xs-4 copyright">
                <b class="maincolor">© 2017 PolisBook</b>
            </div>
            <div class="col-md-2 col-lg-2  col-sm-4 col-xs-4">
                <img class="img-footer center-block" src="img/Logo_s.png">
            </div>
            <div class="col-md-5 col-lg-5 col-sm-4 col-xs-4">
            </div>
        </div>
    </div>
</div>';
                break;
            case 'recovery':
                $footer='<div id="footer" class="recovery-footer">
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
</div>';
                break;
            case 'reader':
            case 'signin':
                $footer='';
                break;
            case 'signup':
                $footer='<div id="footer">
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
</div>';
                break;
        }
        return $footer;
    }
}
?>