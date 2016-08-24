var str=1;
$(document).ready(function () {
    if ($('#pdf').length>0) {
        setInterval(test, 2500);
    }
});
function test() {
    var a=$('#pdf').contents().find('#pageNumber').val();
    var all=$('#pdf').contents().find('#numPages').text();
    all=parseInt(all.replace(/\D+/g,""));
    a=Number(a);
    if (a!=str) {
        str=a;
        alert(all-str);
    }
}
function putProgress() {
    //$('#pdf').contents().find('#pageNumber').val(30);
    var s = 30;
    var b = $('#pdf').contents().find('#pageNumber').val();
    //$('#pdf').contents().find('.pageDown').click();
    if (b > s) {
        while ($('#pdf').contents().find('#pageNumber').val() > s) {
            $('#pdf').contents().find('.pageUp').click();
        }
    } else {
        while ($('#pdf').contents().find('#pageNumber').val() < s) {
            $('#pdf').contents().find('.pageDown').click();
        }
    }
}