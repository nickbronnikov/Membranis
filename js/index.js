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
        data: {function: 'deleteBookMain',id: id},
        beforeSend: function () {

        },
        success: function (data) {
            $('#deleteBookModal').modal('hide');
            $('.body').html(data);
            $('.version').text(NProgress.version);
            NProgress.start();
            setTimeout(function () {
                NProgress.done();
                $('.fade').removeClass('out');
            }, 1000);
        }
    });
}
function footer() {
    if ($('#book').height()<($(window).height()-$('#nav').height())){
        $('#book').css('min-height',$(window).height()-$('#nav').height()+'px');
    }
}
