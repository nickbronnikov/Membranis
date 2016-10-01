var done='<svg fill="#5cb85c" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/> <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
var clear='<svg fill="#a94442" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
var wait='<svg fill="#000000" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
var waitb='<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z"/><path d="M0 0h24v24H0z" fill="none"/></svg>';
$(document).ready(function () {
    $('#newlogin').on('focusout',function () {
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
    $('#btn-newlogin').on('click',function () {
        newLogin();
    });
    $('#oldemail').on('focusout',function () {
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
    $('#newemail').on('focusout',function () {
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
    $('#btn-newemail').on('click',function () {
        newEmail();
    });
});
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
                    $('#btn-newlogin').html('Update login');
                    $('#infologin').html('<div class="alert alert-success alert-dismissable settingsAlert"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your login was updated.</div>');
                    $('#user_name').html($('#newlogin').val().trim()+'   <b class="caret"></b>');
                } else {
                    $('#btn-newlogin').removeAttr('disabled');
                    $('#btn-newlogin').html('Update login');
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
                $('#btn-newemail').html('Update email');
                $('#infoemail').html('<div class="alert alert-success alert-dismissable settingsAlert"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your email was updated.</div>')
            } else {
                $('#btn-newemail').removeAttr('disabled');
                $('#btn-newemail').html('Update email');
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
