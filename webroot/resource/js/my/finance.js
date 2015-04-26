$(function(){ 
    // date picker
    $('.date-picker').datepicker({"autoclose": true});
});

function downEmployeeReport(){
    var startTime= $('#start_time_1').val();
    var endTime = $('#end_time_1').val();
    // var searchName = $('#search_username').val();

    if(startTime ==''){
        startTime = '0';
    }

    //todo
    if(endTime ==''){
        endTime = '0';
    }

    window.location.href = '/finance/exportEmployeeReport/'+startTime+'/'+endTime;
}

