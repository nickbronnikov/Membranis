var idG;
$(document).ready(function () {
    $('#readingPlan').on('click', '#datetimepicker', function(){
        $(this).datetimepicker({
            format: 'DD-MM-Y',
            widgetPositioning: {
                horizontal: 'right',
                vertical: 'bottom'},
            minDate: moment().add(1, 'd').toDate()
        });
    });
    $('#readingPlan').on('dp.show', '#datetimepicker', function (e) {
        $('#pbmp').css('height','400px');
    });
    $('#readingPlan').on('dp.hide', '#datetimepicker', function (e) {
        $('#pbmp').removeAttr('style');
    });
});
function readingPlan(id){
    var idBook='#nameBook'+id.toString();
    var idCheckBox='rpcb'+id.toString();
    var name=$(idBook).html();
    $('#btnSavePlan').attr('onclick','setDate('+id+')');
    $('#readingPlan').modal('show');
    checkForm(id,name);
}
function checkForm(id,name){
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'checkForm', name: name, id: id},
        beforeSend: function () {

        },
        success: function (data) {
            var json=JSON.parse(data);
            var panel='';
            if (json.value=='0') {
                panel = '<div class="panel panel-default"><div class="panel-body" id="pbmp"><p style="font-weight: bold">' + json.text + '</p><div class="col-md-6 col-lg-6 sol-sm-12 col-xs-12 col-md-offset-3 col-lg-offset-3"><div class="form-group"><div class="input-group date" id="datetimepicker"><input type="text" class="form-control" id="timepickerInput"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div><div class="col-md-12 col-lg-12 sol-sm-12 col-xs-12"><div id="infoPlan"></div></div></div></div>';
            }
            else {
                var idBook='#nameBook'+id.toString();
                var idCheckBox='rpcb'+id.toString();
                var name=$(idBook).html();
                var pDate=Math.round(json.daysLeft/json.interval*100);
                panel = '<p style="font-weight: bold" class="text-center">Reading plan for '+name+':</p><div class="alert alert-success">'+json.infoRes+'</div><p>Reading progress:</p>' +
                    '<div class="col-md-12 col-lg-12 sol-sm-12 col-xs-12"><div class="progress"><div class="progress-bar progress-bar-maincolor" role="progressbar" aria-valuenow="'+json.progress+'" aria-valuemin="0" aria-valuemax="100" style="width: '+json.progress+'%;">'+json.progress+'%</div></div></div><p>Days left:</p>' +
                    '<div style="padding-bottom: 10px; "class="col-md-12 col-lg-12 sol-sm-12 col-xs-12"><div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: '+pDate+'%;">'+json.daysLeft+'/'+json.interval+'</div></div></div>';
            }
            $('#rp').html(panel);
            $('#btnSavePlan').removeAttr('disabled');
        }
    });
}
function setDate(id) {
    $.ajax({
        type: "POST",
        url: "includes/lib.php",
        data: {function: 'setTime', date: $('#datetimepicker').data("DateTimePicker").viewDate().format('D.M.Y'), id: id},
        beforeSend: function () {

        },
        success: function (data) {
            console.log(data);
            var json=JSON.parse(data);
            if (json.correct=="1") {
                var idBook='#nameBook'+id.toString();
                var idCheckBox='rpcb'+id.toString();
                var name=$(idBook).html();
                $('#pbmp').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+json.otherInfo+'</div>' +
                    '<p style="font-weight: bold" class="text-center">Reading plan for '+name+':</p><div class="alert alert-success">'+json.infoRes+'</div><p>Reading progress:</p>' +
                    '<div class="col-md-12 col-lg-12 sol-sm-12 col-xs-12"><div class="progress"><div class="progress-bar progress-bar-maincolor" role="progressbar" aria-valuenow="'+json.progress+'" aria-valuemin="0" aria-valuemax="100" style="width: '+json.progress+'%;">'+json.progress+'%</div></div></div><p style="padding-top: 10px;">Days left:</p>' +
                    '<div class="col-md-12 col-lg-12 sol-sm-12 col-xs-12"><div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">'+json.numberDays+'/'+json.numberDays+'</div></div></div>');
            } else {
                $('#infoPlan').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Could not create a reading plan. The date you entered is incorrect. Try again.</div>');
            }
            $('#btnSavePlan').attr('disabled','disabled');
        }
    });
}