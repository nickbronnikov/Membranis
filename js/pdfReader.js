var empty='<div class="panel panel-default"><div class="panel-body" id="noOneBookmark"><svg class="center-block" fill="#5cb85c" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/><path d="M0 0h24v24H0z" fill="none"/><h3 class="text-center"><strong>You have not added any one bookmark.</strong></h3></svg></div></div>';
var progPage=null;
var id = getUrlVars()["id"];
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
    setInterval(pdfProgress, 2500);
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
            data: {function: 'progressPDF',page_progress: str, p:numStr, id:id},
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
function toProgress(page) {
    if (page !=null && $('#pdf').contents().find('#pageNumber').length>0 && $('#pdf').contents().find('.pageUp').length>0 && $('#pdf').contents().find('.pageDown').length>0) {
        var str = $('#pdf').contents().find('#pageNumber').val();
        if (str > page && str != checkStr) {
            while ($('#pdf').contents().find('#pageNumber').val() > page) {
                $('#pdf').contents().find('.pageUp').click();
            }
        } else {
            while ($('#pdf').contents().find('#pageNumber').val() < page) {
                $('#pdf').contents().find('.pageDown').click();
            }
        }
    }
}
function progressPage(page) {
    progPage=page;
    $('#pdf').attr('height',$(window).height());
}
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
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