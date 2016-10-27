var pageprogress;
var lastScrollTop = 0;
function progressPage(progress){
    pageprogress=progress;
}
$(document).ready(function () {
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
        if (Math.floor((cont_top+$(window).height())/$('#reader')[0].scrollHeight*100)==100 || $('#reader')[0].scrollHeight<=$(window).height()){
            nextChapter();
        } else {
            $('#reader').animate({"scrollTop": cont_top + $(window).height()}, 300);
        }
    });
    $('#scrollUp').on('click',function () {
        var r=document.getElementById('reader');
        var cont_top = r.pageYOffset ? r.pageYOffset : r.scrollTop;
        if (cont_top==0){
            previousChapter();
        } else {
            $('#reader').animate({"scrollTop": cont_top - $(window).height()}, 300);
        }
    });
});
function nextChapter() {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'nextChapterEPUB'},
        beforeSend: function () {
        },
        success: function (data) {
            if (data!='**/**/**') {
                $('#reader').html(data);
                $('#reader').animate({"scrollTop": 0}, 100);
            }
        }
    });
}
function previousChapter() {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'previousChapterEPUB'},
        beforeSend: function () {
        },
        success: function (data) {
            if (data!='**/**/**') {
                $('#reader').html(data);
            }
        }
    });
}
function toChapter(chapter) {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'toChapterEPUB', chapter: chapter},
        beforeSend: function () {
        },
        success: function (data) {
            $('#reader').html(data);
            $('#reader').animate({"scrollTop": 0}, 100);
        }
    });
}
function toprogressPage(progress){
    var pagePoint=Math.round(progress/100*$('#reader')[0].scrollHeight);
    $('#reader').animate({"scrollTop": pagePoint});
}
function height(){
    return $(document).outerHeight(true);
}
function pageProgress(scroll,documentHeight,windowHeight) {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'pageScrollEPUB',scroll: scroll,docHeight: documentHeight, windowHeight: windowHeight},
        success: function (data) {

        }
    });
}