setInterval(hashDel, 10);
function hashDel() {
    var s=location.href;
    var a=s.split('#');
    if (a.length>1) {
        console.log(a[1]);
        history.pushState('', document.title, window.location.pathname);
    }
}
history.pushState('', document.title, window.location.pathname);
$('#hash').click(function() {
    console.log('Hash!!!');
    history.pushState('', document.title, window.location.pathname);
});
$("#next").on('click',function () {
    console.log('Hash!!!');
    history.pushState('', document.title, window.location.pathname);
});
$("#prev").on('click',function () {
    console.log('Hash!!!');
    history.pushState('', document.title, window.location.pathname);
});