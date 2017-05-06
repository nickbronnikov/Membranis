var buttons;
var group_buttons='<button class="btn btn-success button-color btn-rad" id="markAllNotifications" onclick="allRead()">Mark all notifications as read</button><button class="btn btn-success btn-rad" id="seeAllNotifications" onclick="seeAllNotifications()">See all notification</button>';
var ln;
var ids;
var default_ln='';
$(document).ready(function () {
    allIds();
    $('#notifications').on('click',function () {
        $('#notifications-list').modal('show');
    });
    setInterval(function (){showNewNotifications();},8000);
});
function showNewNotifications() {
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'showNewNotifications', ids:ids},
        beforeSend: function () {

        },
        success: function (data) {
            var json=JSON.parse(data);
            if (json.count>0) {
                if ($('.oldnotification').length==0) {
                    if ($('#noOneNotification').length==0)
                        $('#ln').html(json.notifications+$('#ln').html());
                    else
                        $('#ln').html(json.notifications);
                    $('#notmod-bottom-button').html(group_buttons);
                    allIds();
                } else {
                    if (ln.indexOf('id="noOneNotification"')==-1)
                        ln=json.notifications+ln;
                    else
                        ln=json.notifications;
                    buttons=group_buttons;
                }
                if ($('.badge').eq(0).html()==''){
                    $('.badge').eq(0).html(1);
                    $('.badge').eq(1).html(1);
                } else {
                    $('.badge').eq(0).html(Number($('.badge').eq(0).html())+1);
                    $('.badge').eq(1).html(Number($('.badge').eq(1).html())+1);
                }
            }
        }
    });
}
function allIds() {
    ids='';
    for (var i=0;i<$('.notification').length;i++){
        ids=ids+$('.notification').eq(i).attr('id').replace('notification','')+'$$$$$';
    }
    return ids;
}
function readNotification(id) {
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'markNotificationAsRead', id:id},
        beforeSend: function () {
            $('#notification'+id).addClass('readNotification');
            $('#btnReadNotification'+id).attr('disabled','disabled');
            if ($('.badge').eq(0).html()!='')
            if ($('.badge').eq(0).html()=='1'){
                $('.badge').eq(0).html('');
                $('.badge').eq(1).html('');
            } else {
                $('.badge').eq(0).html(Number($('.badge').eq(0).html())-1);
                $('.badge').eq(1).html(Number($('.badge').eq(1).html())-1);
            }
        },
        success: function (data) {

        }
    });
}
function allRead() {
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'markAllNotificationsAsRead'},
        beforeSend: function () {
            for (var i=0;i<$('.notification').length;i++){
                $('.notification').eq(i).addClass('readNotification');
                $('#'+$('.notification').eq(i).find('button').attr('id')).attr('disabled','disabled');
            }
            $('.badge').eq(0).html('');
            $('.badge').eq(1).html('');
        },
        success: function (data) {

        }
    });
}
function seeAllNotifications() {
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'showAllNotifications'},
        beforeSend: function () {
            buttons=$('#notmod-bottom-button').html();
            ln=$('#ln').html();
            $('#markAllNotifications').attr('disabled','disabled');
            $('#seeAllNotifications').attr('disabled','disabled');

        },
        success: function (data) {
            $('#ln').html(data);
            $('#notmod-bottom-button').html('<button class="btn btn-danger btn-rad" id="closeNotifications" onclick="closeNotifications()">Hide</button>');
        }
    });
}
function closeNotifications() {
    $('#notmod-bottom-button').html(buttons);
    $('#ln').html(ln);
    allIds();
}