var done='<svg fill="#5cb85c" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/> <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
var clear='<svg fill="#a94442" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
var wait='<svg fill="#000000" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
var waitb='<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
var step2='<div class="col-md-3 col-lg-3 col-md-offset-3 col-lg-offset-3 col-sm-6 col-xs-6 form-reg"> <div class="panel panel-default" style="width: 100%"> <div class="panel-heading"><h3><strong>Standard</strong></h3></div><div class="panel-body"><br><h1>FREE</h1><br><hr><p>By choosing this plan, you will have 100 MB of cloud storage. Also, you will be shown an advertisement.</p></div><div class="panel-footer"><button type="button" class="btn btn-success btn-lg button-plan center-block" href="signup.php" id="freeplan" onclick="showstep3()">Join Membranis</button></div> </div></div><div class="col-md-3 col-lg-3  col-sm-6 col-xs-6 form-reg"> <div class="panel panel-default" style="width: 100%"> <div class="panel-heading"><h3><strong>Premium</strong></h3></div> <div class="panel-body"> <br><h1>$8 <span class="info-plan">/  year</span></h1><br><hr> <p>For storage of your books you will have 25 gigabytes and no advertising.</p> </div> <div class="panel-footer"><button type="button" class="btn btn-success btn-lg  center-block" href="signup.php" id="payplan" disabled="disabled">Join Membranis</button></div> </div> </div>';
var step3='<div class="col-md-offset-3 col-lg-offset-3 col-md-5 col-lg-5 col-sm-12 col-xs-12 regform"><div class="panel panel-default width-full"><div class="panel-body"><svg fill="#5cb85c" height="48" viewBox="0 0 24 24" width="48"  xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z"/></svg><span class="done">Done!</span><h4>Your account is created. Let\'s start working with your library.</h4><div><a href="index.php" class="btn btn-success btn-lg center-block width-full" id="start">Start</a></div></div></div></div>';
$(document).ready(function () {
    $('#loginreg').on('focusout',function () {
        $.ajax({
            type: "POST",
            url: "includes/reg.php",
            data: {function: 'checkInput',key: $('#loginreg').val(),field: 'login'},
            beforeSend: function () {
                $('#loginregalert').html('<p class="info-reg">This will be your username.</p>');
                $('#loginregcheck').html(wait);
            },
            success: function (data) {
                if ($('#loginreg').val()=='') $('#loginregcheck').html(clear); else {
                    $('#loginregcheck').html(data);
                    if (data == clear) $('#loginregalert').html('<div class="alert alert-danger">Username is already taken</div>');
                }
            }
        });
    });
    $('#loginreg').on('focusout',function () {
        if ($('#loginreg').val()=='') {
            $('#loginregalert').html("<div class='alert alert-danger'>Username can't be blank</div>");
            $('#loginregcheck').html(clear);
        }
    });
    $('#emailreg').on('focusout',function () {
        $.ajax({
            type: "POST",
            url: "includes/reg.php",
            data: {function: 'checkInput',key: $('#emailreg').val(),field: 'email'},
            beforeSend: function () {
                $('#emailregalert').html('<p class="info-reg">This is your e-mail address. We promise not to share your email with anyone.</p>');
                $('#emailregcheck').html(wait);
            },
            success: function (data) {
                if($('#emailreg').val()!='') {
                    $('#emailregcheck').html(data);
                    if (data == clear) $('#emailregalert').html('<div class="alert alert-danger">Email is invalid or already taken</div>');
                }
            }
        });
    });
    $('#emailreg').on('focusout',function () {
        if ($('#emailreg').val()=='') {
            $('#emailregalert').html("<div class='alert alert-danger'>E-mail can't be blank</div>");
            $('#emailregcheck').html(clear);
        }
    });
    $('#passwordreg').on('input',function () {
        if ($('#passwordreg').val().length<5) {
            $('#passwordregcheck').html(clear);
            $('#passwordregallert').html('<div class="alert alert-danger">Password should be at least 5 characters.</div>');
        } else{
            $('#passwordregcheck').html(done);
            $('#passwordregallert').html('<p class="info-reg">Done.</p>');
        }
    });
    $('#passwordreg').on('focusout',function () {
        if ($('#passwordreg').val()=='') {
            $('#passwordregcheck').html(clear);
            $('#passwordregallert').html("<div class='alert alert-danger'>Enter your password.</div>");
        }
    });
    $('#regbutton').on('click',function () {
        allCheck();
    });
    $('#freeplan').on('click',function () {
        showstep3();
    });
    $('#start').on('click',function () {
        
    });
});
function allCheck() {
    var check=true;
    var functionName='allCheck';
    $.ajax({
        type: "POST",
        url: "includes/reg.php",
        data: {function: functionName,login: $('#loginreg').val(),email: $('#emailreg').val(),password: $('#passwordreg').val()},
        beforeSend: function () {
            $('#regbutton').attr('disabled','disabled');
            $('#regbutton').html(waitb);
        },
        success: function (data) {
            var json = JSON.parse(data);
            if (json.error=='false')showstep2(); else {
                errorHandler(json);
            }
        }
    });
}
function showstep2(){
    $('#step2').addClass('current');
    $('#form').empty();
    $('#form').html(step2);
}
function showstep3() {
    $('#step3').addClass('current');
    $('#form').empty();
    $('#form').html(step3);
}
function errorHandler(json) {
    $('#regbutton').removeAttr('disabled');
    $('#regbutton').html('Sign up');
    if (json.loginerror == 'null') {
        $('#loginregalert').html("<div class='alert alert-danger'>Username can't be blank</div>");
        $('#loginregcheck').html(clear);
    } else if (json.loginerror == 'yes') {
        $('#loginregcheck').html(clear);
        $('#loginregalert').html('<div class="alert alert-danger">Username is already taken</div>');
    }
    if (json.emailerror=='null'){
        $('#emailregalert').html("<div class='alert alert-danger'>E-mail can't be blank</div>");
        $('#emailregcheck').html(clear);
    } else if (json.emailerror=='yes'){
        $('#emailregalert').html("<div class='alert alert-danger'>Email is invalid or already taken</div>");
        $('#emailregcheck').html(clear);
    }
    if (json.passworderror=='null') {
        $('#passwordregcheck').html(clear);
        $('#passwordregallert').html('<div class="alert alert-danger">Enter your password.</div>');
    } else if (json.passworderror=='yes'){
        $('#passwordregcheck').html(clear);
        $('#passwordregallert').html('<div class="alert alert-danger">Password should be at least 5 characters.</div>');
    }
}