var done='<svg fill="#5cb85c" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/> <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
var clear='<svg fill="#a94442" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
var wait='<svg fill="#000000" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
var waitb='<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
var account='<div class="panel panel-default"> ' +
    '<div class="panel-heading"><strong>Update login</strong></div> ' +
    '<div class="panel-body"> ' +
    '<label for="newlogin">New login</label> ' +
    '<div class="input-group"> ' +
    '<input type="text" class="form-control" id="newlogin"> ' +
    '<span class="input-group-addon" id="newlogincheck"></span> ' +
    '</div> <span id="newloginalert"><p class="info-reg">This is your new login</p></span> ' +
    '<button class="btn btn-success" id="btn-newlogin">Update login</button> ' +
    '<span id="infologin"></span> ' +
    '</div> </div><div class="panel panel-default"> ' +
    '<div class="panel-heading"><strong>Update email</strong></div> ' +
    '<div class="panel-body"> ' +
    '<label for="oldemail">Old email</label> ' +
    '<div class="input-group"> ' +
    '<input type="text" class="form-control" id="oldemail"> ' +
    '<span class="input-group-addon" id="oldemailcheck"></span> ' +
    '</div> ' +
    '<span id="oldemailalert"><p class="info-reg">This is your old email</p></span> ' +
    '<label for="newemail">New email</label> ' +
    '<div class="input-group"> <input type="text" class="form-control" id="newemail"> ' +
    '<span class="input-group-addon" id="newemailcheck"></span> ' +
    '</div> ' +
    '<span id="newemailalert"><p class="info-reg">This is your new email</p></span> ' +
    '<button class="btn btn-success" id="btn-newemail">Update email</button> ' +
    '<span id="infoemail"></span> </div> </div>';
var password='<div class="panel panel-default"> <div class="panel-heading"><strong>Change password</strong></div> <div class="panel-body"> <label for="oldpassword">Old password</label> <div class="input-group"> <input type="password" class="form-control" id="oldpassword"> <span class="input-group-addon" id="oldpasswordcheck"></span> </div> <span id="oldpasswordalert"><p class="info-reg">This is your old password</p></span> <label for="newpassword">New password</label> <div class="input-group"> <input type="password" class="form-control" id="newpassword"> <span class="input-group-addon" id="newpasswordcheck"></span> </div> <span id="newpasswordalert"><p class="info-reg">This is your new password</p></span> <label for="newlogin">Confirm new password</label> <div class="input-group"> <input type="password" class="form-control" id="newpasswordr"> <span class="input-group-addon" id="newpasswordrcheck"></span> </div> <span id="newpasswordralert"><p class="info-reg">Confirm your new password</p></span> <button class="btn btn-success" id="btn-newpassword">Change password</button> <span id="infopassword"></span> </div> </div>';
$(document).ready(function () {
    $('#s-account').on('click',function () {
        $('.active-set').removeClass('active-set');
        $('#s-account').addClass('active-set');
        $('#bs').html(account);
    });
    $('#s-password').on('click',function () {
        $('.active-set').removeClass('active-set');
        $('#s-password').addClass('active-set');
        $('#bs').html(password);
    });
    $('#s-storage').on('click',function () {
        $('.active-set').removeClass('active-set');
        $('#s-storage').addClass('active-set');
        $.ajax({
            type: "POST",
            url: "includes/set.php",
            data: {function: 'storage'},
            beforeSend: function () {
                $('#bs').html(waitb);
            },
            success: function (data) {
                $('#bs').html(data);
            }
        });
    });
    $('#s-reader').on('click',function () {
        $('.active-set').removeClass('active-set');
        $('#s-reader').addClass('active-set');
    });
    $('#s-storage').on('click',function () {
        $('.active-set').removeClass('active-set');
        $('#s-storage').addClass('active-set');
    });
    $('#bs').on('focusout','#newlogin',function () {
        $.ajax({
            type: "POST",
            url: "includes/set.php",
            data: {function: 'newlogin',key: $('#newlogin').val()},
            beforeSend: function () {
                $('#newloginalert').html('<p class="info-reg">This is your new login</p>');
                $('#newlogincheck').html(wait);
            },
            success: function (data) {
                if ($('#newlogin').val()=='') {
                    $('#newlogincheck').html(clear);
                    $('#newloginalert').html("<div class='alert alert-danger'>Username can't be blank</div>");
                } else {
                    if (data==clear) {
                        $('#newlogincheck').html(data);
                        if (data == clear) $('#newloginalert').html('<div class="alert alert-danger">Username is already taken</div>');
                    } else $('#newlogincheck').html(data);
                }
            }
        });
    });
    $('#bs').on('click','#btn-newlogin',function () {
        newLogin();
    });
    $('#bs').on('focusout','#oldemail',function () {
        $.ajax({
            type: "POST",
            url: "includes/set.php",
            data: {function: 'oldemail',key: $('#oldemail').val()},
            beforeSend: function () {
                $('#oldemailalert').html('<p class="info-reg">This is your old email</p>');
                $('#oldemailcheck').html(wait);
            },
            success: function (data) {
                if ($('#oldemail').val()=='') {
                    $('#oldemailcheck').html(clear);
                    $('#oldemailalert').html("<div class='alert alert-danger'>Email can't be blank</div>");
                } else {
                    if (data==clear) {
                        $('#oldemailcheck').html(data);
                        if (data == clear) $('#oldemailalert').html('<div class="alert alert-danger">Wrong email</div>');
                    } else $('#oldemailcheck').html(data);
                }
            }
        });
    });
    $('#bs').on('focusout','#newemail',function () {
        $.ajax({
            type: "POST",
            url: "includes/set.php",
            data: {function: 'newemail',key: $('#newemail').val()},
            beforeSend: function () {
                $('#newemailalert').html('<p class="info-reg">This is your old email</p>');
                $('#newemailcheck').html(wait);
            },
            success: function (data) {
                if ($('#newemail').val()=='') {
                    $('#newemailcheck').html(clear);
                    $('#newemailalert').html("<div class='alert alert-danger'>Email can't be blank</div>");
                } else {
                    if (data==clear) {
                        $('#newemailcheck').html(data);
                        if (data == clear) $('#newemailalert').html('<div class="alert alert-danger">Email is invalid or already taken</div>');
                    } else $('#newemailcheck').html(data);
                }
            }
        });
    });
    $('#bs').on('click','#btn-newemail',function () {
        newEmail();
    });
    $('#bs').on('input','#newpassword',function () {
        if ($('#newpassword').val().length<5) {
            $('#newpasswordcheck').html(clear);
            $('#newpasswordalert').html('<div class="alert alert-danger">Password should be at least 5 characters</div>');
        } else{
            $('#newpasswordcheck').html(done);
            $('#newpasswordalert').html('<p class="info-reg">Done</p>');
        }
    });
    $('#bs').on('input','#newpasswordr',function () {
        if ($('#newpasswordr').val()==$('#newpassword').val() && $('#newpasswordr').val().length>0) {
            $('#newpasswordrcheck').html(done);
            $('#newpasswordralert').html('<p class="info-reg">Done</p>');
        } else{
            $('#newpasswordrcheck').html(clear);
            $('#newpasswordralert').html('<div class="alert alert-danger">Passwords do not match</div>');
        }
    });
    $('#bs').on('click','#btn-newpassword',function () {
        newPassword();
    });
});
function newPassword() {
    $.ajax({
        type: "POST",
        url: "includes/set.php",
        data: {function: 'doNewpassword',key: $('#newpassword').val(),keyOld: $('#oldpassword').val()},
        beforeSend: function () {
            $('#oldpasswordalert').html('');
            $('#btn-newpassword').attr('disabled','disabled');
            $('#btn-newpassword').html(waitb);
        },
        success: function (data) {
            if (data=='true') {
                $('#oldpasswordalert').html('<p class="info-reg">Done</p>');
                $('#btn-newpassword').removeAttr('disabled');
                $('#btn-newpassword').html('Change password');
                $('#infopassword').html('<div class="alert alert-success alert-dismissable settingsAlert"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your password was updated.</div>');
            } else {
                $('#oldpasswordalert').html('<div class="alert alert-danger">Incorrect password</div>');
                $('#btn-newpassword').removeAttr('disabled');
                $('#btn-newpassword').html('Change password');
                if ($('#newpassword').val().length<5) {
                    $('#newpasswordcheck').html(clear);
                    $('#newpasswordalert').html('<div class="alert alert-danger">Password should be at least 5 characters</div>');
                } else{
                    $('#newpasswordcheck').html(done);
                    $('#newpasswordalert').html('<p class="info-reg">Done</p>');
                }
                if ($('#newpasswordr').val()==$('#newpassword').val() && $('#newpasswordr').val().length>0) {
                    $('#newpasswordrcheck').html(done);
                    $('#newpasswordralert').html('<p class="info-reg">Done</p>');
                } else{
                    $('#newpasswordrcheck').html(clear);
                    $('#newpasswordralert').html('<div class="alert alert-danger">Passwords do not match</div>');
                }
            }
        }
    });
}
function newLogin() {
        $.ajax({
            type: "POST",
            url: "includes/set.php",
            data: {function: 'doNewlogin',keyNew: $('#newlogin').val()},
            beforeSend: function () {
                $('#btn-newlogin').attr('disabled','disabled');
                $('#btn-newlogin').html(waitb);
            },
            success: function (data) {
                if (data=='true') {
                    $('#btn-newlogin').removeAttr('disabled');
                    $('#btn-newlogin').html('Change login');
                    $('#infologin').html('<div class="alert alert-success alert-dismissable settingsAlert"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your login was changed.</div>');
                    $('#user_name').html($('#newlogin').val().trim()+'   <b class="caret"></b>');
                } else {
                    $('#btn-newlogin').removeAttr('disabled');
                    $('#btn-newlogin').html('Change login');
                    $.ajax({
                        type: "POST",
                        url: "includes/set.php",
                        data: {function: 'newlogin',key: $('#newlogin').val()},
                        beforeSend: function () {
                            $('#newloginalert').html('<p class="info-reg">This is your new login</p>');
                            $('#newlogincheck').html(wait);
                        },
                        success: function (data) {
                            if ($('#newlogin').val()=='') {
                                $('#newlogincheck').html(clear);
                                $('#newloginalert').html("<div class='alert alert-danger'>Username can't be blank</div>");
                            } else {
                                if (data==clear) {
                                    $('#newlogincheck').html(data);
                                    if (data == clear) $('#newloginalert').html('<div class="alert alert-danger">Username is already taken</div>');
                                } else $('#newlogincheck').html(data);
                            }
                        }
                    });
                }
            }
        });
}
function newEmail() {
    $.ajax({
        type: "POST",
        url: "includes/set.php",
        data: {function: 'doNewemail',keyOld: $('#oldemail').val(),keyNew: $('#newemail').val()},
        beforeSend: function () {
            $('#btn-newemail').attr('disabled','disabled');
            $('#btn-newemail').html(waitb);
        },
        success: function (data) {
            if (data=='true') {
                $('#btn-newemail').removeAttr('disabled');
                $('#btn-newemail').html('Change email');
                $('#infoemail').html('<div class="alert alert-success alert-dismissable settingsAlert"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your email was changed.</div>')
            } else {
                $('#btn-newemail').removeAttr('disabled');
                $('#btn-newemail').html('Change email');
                $.ajax({
                    type: "POST",
                    url: "includes/set.php",
                    data: {function: 'oldemail',key: $('#oldemail').val()},
                    beforeSend: function () {
                        $('#oldemailalert').html('<p class="info-reg">This is your old email</p>');
                        $('#oldemailcheck').html(wait);
                    },
                    success: function (data) {
                        if ($('#oldemail').val()=='') {
                            $('#oldemailcheck').html(clear);
                            $('#oldemailalert').html("<div class='alert alert-danger'>Email can't be blank</div>");
                        } else {
                            if (data==clear) {
                                $('#oldemailcheck').html(data);
                                if (data == clear) $('#oldemailalert').html('<div class="alert alert-danger">Wrong email</div>');
                            } else $('#oldemailcheck').html(data);
                        }
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "includes/set.php",
                    data: {function: 'newemail',key: $('#newemail').val()},
                    beforeSend: function () {
                        $('#newemailalert').html('<p class="info-reg">This is your old email</p>');
                        $('#newemailcheck').html(wait);
                    },
                    success: function (data) {
                        if ($('#newemail').val()=='') {
                            $('#newemailcheck').html(clear);
                            $('#newemailalert').html("<div class='alert alert-danger'>Email can't be blank</div>");
                        } else {
                            if (data==clear) {
                                $('#newemailcheck').html(data);
                                if (data == clear) $('#newemailalert').html('<div class="alert alert-danger">Email is invalid or already taken</div>');
                            } else $('#newemailcheck').html(data);
                        }
                    }
                });
            }
        }
    });
}
