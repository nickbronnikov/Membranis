var empty='<div class="panel panel-default"><div class="panel-body" id="noOneBookmark"><svg class="center-block" fill="#5cb85c" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/><path d="M0 0h24v24H0z" fill="none"/><h3 class="text-center"><strong>You have not added any one bookmark.</strong></h3></svg></div></div>';
var pageprogress;
var fromTop=0;
var lastScrollTop = 0;
var id = getUrlVars()["id"];
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
            data: {function: 'addBookmark', id:id},
            beforeSend: function () {
                $('#addbookmark').attr('disabled','disabled');
            },
            success: function (data) {
                $('#addbookmark').removeAttr('disabled');
                if ($('*').is('#noOneBookmark')){
                    $('#lb').html('');
                    $('#lb').html(data);
                } else 
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
            // $("html, body").animate({ scrollTop: 0 }, 10);
        }
        lastScrollTop = st;
        var r=document.getElementById('reader');
        var cont_top = r.pageYOffset ? r.pageYOffset : r.scrollTop;
        if (Math.abs(fromTop-cont_top)>=$(window).height()){
            pageProgress(cont_top,$('#reader')[0].scrollHeight,$(window).height());
            fromTop=cont_top;
        }
    });
    $('#scrollDown').on('click',function () {
        var r=document.getElementById('reader');
        var cont_top = r.pageYOffset ? r.pageYOffset : r.scrollTop;;
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
            $("html, body").animate({ scrollTop: $(document).height() }, 10);
        }
    });
});
function nextChapter() {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'nextChapter', id:id},
        beforeSend: function () {
            NProgress.start();
        },
        success: function (data) {
            if (data!='**/**/**') {
                $('#reader').html(data);
                $('#reader').animate({"scrollTop": 0}, 100);
            }
            NProgress.done();
        }
    });
}
function previousChapter() {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'previousChapter', id:id},
        beforeSend: function () {
            NProgress.start();
        },
        success: function (data) {
            if (data!='**/**/**') {
                $('#reader').html(data);
                $("html, body").animate({scrollTop: $(document).height()}, 300);
            }
            NProgress.done();
        }
    });
}
function toChapter(chapter) {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        async: false,
        data: {function: 'toChapter', chapter: chapter, id:id},
        beforeSend: function () {
            NProgress.start();
        },
        success: function (data) {
            $('#reader').html(data);
            $('#reader').animate({"scrollTop": 0}, 100);
            $("html, body").animate({ scrollTop: $(document).height() }, 300);
            NProgress.done();
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
        data: {function: 'pageScroll',scroll: scroll,docHeight: documentHeight, windowHeight: windowHeight, id:id},
        success: function (data) {
        }
    });
}
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
function deleteBookmark(id) {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'pageScroll',scroll: scroll,docHeight: documentHeight, windowHeight: windowHeight, id:id},
        success: function (data) {
        }
    });
}
function deleteBookmark(idBookmark) {
    var bookmarkID='#bookmarkID'+idBookmark.toString();
    var btnDelBookmark='#btnDelBookmark'+idBookmark.toString();
    var btnGoBookmark='#btnGoBookmark'+idBookmark.toString();;
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'deleteBookmark', id: idBookmark},
        beforeSend: function () {
            $(btnDelBookmark).attr('disabled','disabled');
            $(btnGoBookmark).attr('disabled','disabled');
        },
        success: function (data) {
            if ($('.bmp').length==1) {
                $('#lb').html(empty);
                $(bookmarkID).remove();
            } else $(bookmarkID).remove();
        }
    });
}