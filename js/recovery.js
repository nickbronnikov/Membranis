$(document).ready(function () {
    console.log($(window).height()-$('#nav').height());
    $('.body').css('min-height',$(window).height()-$('#nav').height()-100);
});