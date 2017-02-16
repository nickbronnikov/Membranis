var alertEmail='<div class="alert alert-warning alert-dismissable width-full"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>User with this email does not exist.</div>';
var invalidEmail='<div class="alert alert-warning alert-dismissable width-full"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Invalid email.</div>';
var success='<div class="alert alert-success alert-dismissable width-full"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>New password sent to your email.</div>';
var send=true;
$(document).ready(function () {
    footer();
    $('.body').css('min-height',$(window).height()-$('#nav').height()-100);
    $('#sEmail').on('input',function () {
        if (send){
            $('#recover').removeAttr('disabled');
            $('#info').html('');
        }
    });
    $('#recover').on('click',function () {
        if (checkEmail($('#sEmail').val())){
            email($('#sEmail').val().trim());
        } else $('#info').html(invalidEmail);
    });
});
function checkEmail(email) {
    var check=true;
    email=email.trim();
    if (email.length==0) check=false; else
        if (email.indexOf('@')==-1) check=false; else
            if (email.indexOf('@')+1==email.length) check=false; else
                if (email.indexOf('.',email.indexOf('@')+2)==-1) check=false; else
                    if (email.indexOf('.',email.indexOf('@')+2)+1==email.length) check=false;
    return check;
}
function footer() {
    if ($('.body').height()<($(window).height()-$('#nav').height())){
        $('.body').css('min-height',$(window).height()-$('#nav').height()+'px');
    }
}
function email(email) {
    $.ajax({
        type: "POST",
        url: "includes/reg.php",
        data: {function: 'emailPassword',email: email},
        beforeSend: function () {
            $('#recover').attr('disabled','disabled');
        },
        success: function (data) {
console.log(data);
            if (data==false) {
                $('#info').html(alertEmail);
                $('#recover').attr('disabled','disabled');
            } else if (data==true){
                $('#info').html(success);
                $('#recover').attr('disabled','disabled');
                send=false;
            }
        }
    });
}