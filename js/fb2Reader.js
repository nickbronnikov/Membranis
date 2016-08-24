$(document).ready(function () {
    $(window).on('scroll',function () {
        var cont_top = window.pageYOffset ? window.pageYOffset : document.body.scrollTop;
        pageProgress(cont_top,$(document).outerHeight(true));
    });
    $('#scrollDown').on('click',function () {
        var cont_top = window.pageYOffset ? window.pageYOffset : document.body.scrollTop;
        if (Math.floor((cont_top+$(window).height())/$(document).outerHeight(true)*100)==100){
            nextChapter();
        } else {
            $("body,html").animate({"scrollTop": cont_top + $(window).height()}, 300);
        }
    });
    $('#scrollUp').on('click',function () {
        var cont_top = window.pageYOffset ? window.pageYOffset : document.body.scrollTop;
        if (cont_top==0){
            previousChapter();
        } else {
            $("body,html").animate({"scrollTop": cont_top - $(window).height()}, 300);
        }
    });
});
function nextChapter() {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'nextChapter'},
        beforeSend: function () {
            
        },
        success: function (data) {
            $('#fb2-reader').html(data);
            $("body,html").animate({"scrollTop": 0}, 100);
        }
    });
}
function previousChapter() {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'previousChapter'},
        beforeSend: function () {

        },
        success: function (data) {
            $('#fb2-reader').html(data);
        }
    });
}
function toChapter(chapter) {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'toChapter', chapter: chapter},
        beforeSend: function () {

        },
        success: function (data) {
            $('#fb2-reader').html(data);
        }
    });
}
function progressPage(progress){
    var pagePoint=Math.round(progress/100*$(document).outerHeight(true));
    $("body,html").animate({"scrollTop": pagePoint});
}
function height(){
    return $(document).outerHeight(true);
}
function pageProgress(scroll,documentHeight) {
    $.ajax({
        type: "POST",
        url: "includes/reader-file.php",
        data: {function: 'pageScroll',scroll: scroll,docHeight: documentHeight},
        success: function (data) {
            
        }
    });
}