$(function(){ 
    // date picker
    $('.date-picker').datepicker({"autoclose": true});
});

function downEmployeeReport(){
    var startTime= $('#start_time_1').val();
    var endTime = $('#end_time_1').val();
    var pjNo = $('#project_autocomplete').val();

    if (startTime  == '' || endTime == '') {
        alert('please choose time!');
        return ;
    }

    if (startTime > endTime) {
        alert('start time should be early than end time');
        return ;
    }

    window.location.href = '/finance/exportEmployeeReport/'+startTime+'/'+endTime+'/'+pjNo;
}

