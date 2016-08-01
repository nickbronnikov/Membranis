$(document).ready(function () {
    $('#button-reg').click(function () {
        $.ajax({
            type: "POST",
            url: "signup.php",
            data: {login: $('#login').val(),email: $('#email').val(),password: $('#password').val()},
            success: function () {
                $(location).attr('href','signup.php');
            }
        });
    });
    $('#loginreg').on('input',function () {
        $.ajax({
            type: "POST",
            url: "includes/reg.php",
            data: {function: 'checkInput',key: $('#loginreg').val(),field: 'login'},
            beforeSend: function () {
                $('#loginregalert').html('<p class="info-reg">This will be your username.</p>');
                $('#loginregcheck').html('<i class="material-icons md-18">cached</i>');
            },
            success: function (data) {
                $('#loginregcheck').html(data);
                if (data=='<i class="material-icons md-18 alert-col">clear</i>') $('#loginregalert').html('<div class="alert alert-danger">Username is already taken</div>');
            }
        });
    });
    $('#loginreg').on('focusout',function () {
        if ($('#loginreg').val()=='') {
            $('#loginregalert').html("<div class='alert alert-danger'>Login can't be blank</div>");
            $('#loginregcheck').html('<i class="material-icons md-18 alert-col">clear</i>');
        }
    });
    $('#emailreg').on('input',function () {
        $.ajax({
            type: "POST",
            url: "includes/reg.php",
            data: {function: 'checkInput',key: $('#emailreg').val(),field: 'email'},
            beforeSend: function () {
                $('#emailregalert').html('<p class="info-reg">This is your e-mail address. We promise not to share your email with anyone.</p>');
                $('#emailregcheck').html('<i class="material-icons md-18">cached</i>');
            },
            success: function (data) {
                $('#emailregcheck').html(data);
                if (data=='<i class="material-icons md-18 alert-col">clear</i>') $('#emailregalert').html('<div class="alert alert-danger">Email is invalid or already taken</div>');
            }
        });
    });
    $('#emailreg').on('focusout',function () {
        if ($('#emailreg').val()=='') {
            $('#emailregalert').html("<div class='alert alert-danger'>E-mail can't be blank</div>");
            $('#emailregcheck').html('<i class="material-icons md-18 alert-col">clear</i>');
        }
    });
});
