$(document).ready(function () {
    showBook(0);
});
function showBook(page) {
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'showBooks',page: page},
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
function deleteBook(id){
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'deleteBook',id: id},
        beforeSend: function () {

        },
        success: function (data) {
                showBook(0);
        }
    });
}