var pageprogress;
var lastScrollTop = 0;
function progressPage(progress){
    pageprogress=progress;
}
$(document).ready(function () {
    $('#bookmarks').on('click',function () {
        $('#bookmarks-list').modal('show');
    });
    $('#addbookmark').on('click',function () {
        $.ajax({
            type: "POST",
            url: "includes/reader-file.php",
            data: {function: 'addBookmark'},
            beforeSend: function () {
                $('#addbookmark').attr('disabled','disabled');
            },
            success: function (data) {
                $('#addbookmark').removeAttr('disabled');
                $('#lb').append(data);
            }
        });
    });
    $('#reader').css('max-height', $(window).height());
    toprogressPage(pageprogress);
    $(window).resize(function () {
        $('#reader').css('max-height', $(window).height());
    });
    $('#reader').on('scroll',function () {
        var st = $(this).scrollTop();
        if (st > lastScrollTop) {
            $("html, body").animate({ scrollTop: $(document).height() }, 10);
        } else {
            $("html, body").animate({ scrollTop: 0 }, 10);
        }
        lastScrollTop = st;
        var r=document.getElementById('reader');
        var cont_top = r.pageYOffset ? r.pageYOffset : r.scrollTop;
        pageProgress(cont_top,$('#reader')[0].scrollHeight,$(window).height());
    });
    $('#scrollDown').on('click',function () {
        var r=document.getElementById('reader');
        var cont_top = r.pageYOffset ? r.pageYOffset : r.scrollTop;
            $('#reader').animate({"scrollTop": cont_top + $(window).height()}, 300);
    });
    $('#scrollUp').on('click',function () {
        var r=document.getElementById('reader');
        var cont_top = r.pageYOffset ? r.pageYOffset : r.scrollTop;
        $('#reader').animate({"scrollTop": cont_top - $(window).height()}, 300);
    });
});
function height(){
    return $(document).outerHeight(true);
}
function pageProgress(scroll,documentHeight,windowHeight) {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'pageScrollSimple',scroll: scroll,docHeight: documentHeight, windowHeight: windowHeight},
        success: function (data) {
        }
    });
}
function toprogressPage(progress){
    var pagePoint=Math.round(progress/100*$('#reader')[0].scrollHeight);
    $('#reader').animate({"scrollTop": pagePoint});
}