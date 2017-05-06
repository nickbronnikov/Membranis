<?php
include 'includes/db.php';
print_r($_SESSION['test']);
$datetime1 = date_create('2017-5-21');
$datetime2 = date_create(date('Y-n-j'));
$interval = date_diff($datetime1, $datetime2);
//print_r($interval->days);
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Date</title>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/progress-bar/progress.js"></script>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="css/bootstrap-datetimepicker.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <script src="js/moment.js"></script>
    <script src="js/datetimepicker.js"></script>
    <script src="js/readingplan.js"></script>
</head>
<body>
<strong><p id="descriptionReadingPlan"></p></strong>
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="alert"></div>
<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="readingPlan">
    <div class="modal-dialog">
        <div class="modal-content btn-rad">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="readingPlanLabel"><strong>Reading plan</strong></h3>
            </div>
            <div class="modal-body list">
                <div id="rp">
                    <div class="panel panel-default">
                        <div class="panel-body pmw">
                            <div class="input-group date" id="datetimepicker" style="visibility: hidden">
                                <input type="text" class="form-control" id="timepickerInput"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                           <div>
                                   <svg style="padding: 50px 40px 70px 40px;" class="center-block" fill="#5cb85c" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/>
                                        <path d="M0 0h24v24H0z" fill="none"/>
                                   </svg>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right" id="notmod-bottom-button">
                    <button class="btn btn-danger btn-rad" data-dismiss="modal">Close</button>
                    <button class="btn btn-success btn-rad" id="btnSavePlan" disabled="disabled">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">

        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title name-book" id="nameBook205">Энди Вейр - Марсианин</h3>
                </div>
                <div class="panel-body preview-book"><img class="preview-book-cover" src="img/covers/1Za3u30ekpO2kSuljvQqKJUCo3l.jpg"></div>
                <div class="panel-footer"><div class="btn-group">
                        <a class="btn btn-success" href="reader?id=205">Read</a>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <b class="caret"></b>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="download?id=205">Download</a></li>
                            <li><a class="btn-pln" onclick="readingPlan(205)">Reading plan<input class="pull-right" type="checkbox" id="rpcb198"></a></li>
                            <li class="divider"></li>
                            <li><a class="btn-del" onclick="modalDelete(205)">Delete</a></li>
                        </ul>
                    </div><span class="progress-info pull-right">11%</span></div>
            </div>


        </div>
    </div>
</div>

<h1 id="test"></h1>
</body>
</html>
