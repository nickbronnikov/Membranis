var eb='<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><div class="well well-lg info-panel"><svg class="center-block" fill="#607d8b" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg></svg><span class="text-center"><h3 class="text-center maincolor"><strong>You have not uploaded any one book. Upload it now!</strong></h3></div></div>';
var sb=1;
$(document).ready(function () {
    showBook(sb);
});
function showBook(page) {
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'showBooks',page: page},
        beforeSend: function () {

        },
        success: function (data) {
            if (data!='$$$$') {
                $('#book').html(data);
                $('body').show();
                $('.version').text(NProgress.version);
                NProgress.start();
                setTimeout(function () {
                    NProgress.done();
                    $('.fade').removeClass('out');
                }, 1000);
            } else $('#book').html(eb);
            if ($('#book').height()<($(window).height()-$('#nav').height())){
                $('#book').css('min-height',$(window).height()-$('#nav').height()-+'px');
            }
            sb++;
        }
    });
}
function modalDelete(id){
    var idBook='#nameBook'+id.toString();
    var name=$(idBook).html();
    $('#infoDelete').html('Are you sure you want to delete "'+name+'"?');
    $('#btnDelete').attr('onclick','deleteBook('+id+')');
    $('#deleteBookModal').modal('show');
}
function deleteBook(id){
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'deleteBook',id: id},
        beforeSend: function () {

        },
        success: function (data) {
            $('#deleteBookModal').modal('hide');
            showBook(0);
        }
    });
}