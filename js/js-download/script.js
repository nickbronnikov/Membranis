$(function(){
    var ul = $('#upload ul');
    $('#drop a').click(function(){
        $(this).parent().find('input').click();
    });
    $('#upload').fileupload({
        dropZone: $('#drop'),
        add: function (e, data) {
            var tpl = $('<li><div class="download-li width-full"><input class="progress-download" type="text" value="0" data-width="24" data-height="24" data-displayInput=false data-fgColor="#607d8b"'+
                ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#ffffff" /><span class="info-file"></span><div class="pull-right"><a class="info-progress"><svg fill="#a94442" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg></a></div></div></li>');
            tpl.find('span').text(data.files[0].name).append('<i>' + formatFileSize(data.files[0].size) + '</i>');
            data.context = tpl.appendTo($('#append'));
            tpl.find('input').knob();
            tpl.find('a').click(function(){
                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }
                tpl.fadeOut(function(){
                    tpl.remove();
                });
            });
            var jqXHR = data.submit();
        },
        progress: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);
            data.context.find('input').val(progress).change();
            if(progress == 100){
                data.context.removeClass('working');
                $('.info-progress').html('<svg fill="#5cb85c" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"/> <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>');
            }
        },
        fail:function(e, data){
            data.context.addClass('error');
        }
    });
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }
        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }
        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }
        return (bytes / 1000).toFixed(2) + ' KB';
    }
});
$(document).ready(function () {
    var downinfo='<span class="dropdown"><a class="dropdown-toggle" type="button" data-toggle="dropdown"><i class="caret"></i></a><ul class="dropdown-menu download-info"><span id="append"></span><li class="divider"></li><li><a>Clear</a></li></ul></span>';
    $('#download').on('click',function () {
        if ($('#pd-btn').attr('disabled')=='disabled')  $('#pd-btn').removeAttr('disabled');
    });
    $('#clearprogressbar').on('click',function () {
        $('#append').empty();
        $('#pd-btn').attr('disabled','disabled');
    });
});