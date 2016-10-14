$(document).ready(function () {
    $(window).on('scroll',function () {
        var cont_top = window.pageYOffset ? window.pageYOffset : document.body.scrollTop;
        pageProgress(cont_top,$(document).outerHeight(true),$(window).height());
    });
    $('#scrollDown').on('click',function () {
        var cont_top = window.pageYOffset ? window.pageYOffset : document.body.scrollTop;
        if (Math.floor((cont_top+$(window).height())/$(document).outerHeight(true)*100)!=100) {
            $("body,html").animate({"scrollTop": cont_top + $(window).height()}, 300);
        }
    });
    $('#scrollUp').on('click',function () {
        var cont_top = window.pageYOffset ? window.pageYOffset : document.body.scrollTop;
        if (cont_top!=0){
            $("body,html").animate({"scrollTop": cont_top - $(window).height()}, 300);
        }
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
function progressPage(progress){
    var pagePoint=Math.round(progress/100*$(document).outerHeight(true));
    $("body,html").animate({"scrollTop": pagePoint});
}