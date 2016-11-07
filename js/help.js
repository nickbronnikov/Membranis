$(document).ready(function () {
    $('#problem').on('input',function () {
        if (($(this).val().length!=0) && ($('#subject').val().length!=0)){
            $('#send').removeAttr('disabled');
        } else {
            $('#send').attr('disabled','disabled');
        }
    });
    $('#subject').on('input',function () {
        if (($(this).val().length!=0) && ($('#problem').val().length!=0)){
            $('#send').removeAttr('disabled');
        } else {
            $('#send').attr('disabled','disabled');
        }
    });
    $('#send').click(function () {
        var email=$('#email').val();
        $.ajax({
            type: "POST",
            url: "includes/set.php",
            data: {function: 'help', email: email, subject: $('#subject').val().trim(), problem: $('#problem').val().trim()},
            beforeSend: function () {
            },
            success: function (data) {
                if (data=='true') {
                    $('#check').html('<div class="alert alert-success alert-dismissable settingsAlert"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>The messages was sent. We will solve your problem as quickly as possible.</div>');
                    $('#send').attr('disabled','disabled');
                } else {
                    $('#check').html('<div class="alert alert-danger alert-dismissable settingsAlert"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>An error occurred while sending your message. Try again.</div>');
                }
            }
        });
    });
});