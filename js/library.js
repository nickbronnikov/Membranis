$(document).ready(function () {
    showBook(0);
});
function showBook(page) {
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'checkInput',key: $('#loginreg').val(),field: 'login'},
        beforeSend: function () {

        },
        success: function (data) {
            if (data!='') {
                $('#book').html(data);
                $('body').show();
                $('.version').text(NProgress.version);
                NProgress.start();
                setTimeout(function () {
                    NProgress.done();
                    $('.fade').removeClass('out');
                }, 1000);
            }
        }
    });
}