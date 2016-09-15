var progPage=null;
$(document).ready(function () {
    $('#continueReading').on('click',function () {
        putProgress();
    });
    $(window).resize(function () {
        $('#pdf').attr('height',$(window).height());
    });
});
var checkStr=1;
function pdfProgress() {
    var str=$('#pdf').contents().find('#pageNumber').val();
    var numStr=$('#pdf').contents().find('#numPages').text();
    numStr=parseInt(numStr.replace(/\D+/g,""));
    str=Number(str);
    if (str!=checkStr) {
        $.ajax({
            type: "POST",
            url: "includes/reader-file.php",
            data: {function: 'progressPDF',page_progress: str,p:numStr},
            success: function (data) {
                
            }
        });
    }
}
function putProgress() {
    if (progPage !=null && $('#pdf').contents().find('#pageNumber').length>0 && $('#pdf').contents().find('.pageUp').length>0 && $('#pdf').contents().find('.pageDown').length>0) {
        var str = $('#pdf').contents().find('#pageNumber').val();
        if (str > progPage && str != checkStr) {
            while ($('#pdf').contents().find('#pageNumber').val() > progPage) {
                $('#pdf').contents().find('.pageUp').click();
            }
        } else {
            while ($('#pdf').contents().find('#pageNumber').val() < progPage) {
                $('#pdf').contents().find('.pageDown').click();
            }
        }
    }
}
function progressPage(page) {
    progPage=page;
    $('#pdf').attr('height',$(window).height());
}