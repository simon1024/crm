$(function(){ 
    // date picker
    $('.date-picker').datepicker({"autoclose": true});
    // add row
    $('#add_timesheet_btn').click(function() {
        var rowHtml = $('#add_timesheet_row').html();
        rowHtml = rowHtml.replace("<tbody>", "");;
        rowHtml = rowHtml.replace("</tbody>", "");;
        rowHtml = rowHtml.replace("<TBODY>", "");;
        rowHtml = rowHtml.replace("</TBODY>", "");;
        $('#table_timesheet_list tbody').append(rowHtml);;
    });

    $('#add_ot_timesheet_btn').click(function() {
        var rowHtml = $('#add_ot_timesheet_row').html();
        rowHtml = rowHtml.replace("<tbody>", "");;
        rowHtml = rowHtml.replace("</tbody>", "");;
        rowHtml = rowHtml.replace("<TBODY>", "");;
        rowHtml = rowHtml.replace("</TBODY>", "");;
        $('#table_timesheet_list tbody').append(rowHtml);;
    });

    $('#add_oh_timesheet_btn').click(function() {
        var rowHtml = $('#add_oh_timesheet_row').html();
        rowHtml = rowHtml.replace("<tbody>", "");;
        rowHtml = rowHtml.replace("</tbody>", "");;
        rowHtml = rowHtml.replace("<TBODY>", "");;
        rowHtml = rowHtml.replace("</TBODY>", "");;
        $('#table_timesheet_list tbody').append(rowHtml);;
    });

    $('#add_leave_timesheet_btn').click(function() {
        var rowHtml = $('#add_leave_timesheet_row').html();
        rowHtml = rowHtml.replace("<tbody>", "");;
        rowHtml = rowHtml.replace("</tbody>", "");;
        rowHtml = rowHtml.replace("<TBODY>", "");;
        rowHtml = rowHtml.replace("</TBODY>", "");;
        $('#table_timesheet_list tbody').append(rowHtml);;
    });

    $("#current_week_timesheet").click(function(){
        var url = window.location.href;
        var typeUrl = url.split('/')[4];
        window.location.href = '/timesheet/' + typeUrl;
    });

    $("#pre_week_timesheet").click(function(){
        var url = window.location.href;
        var typeUrl = url.split('/')[4];
        var currIndex = parseInt(url.split('/')[url.split('/').length - 1]) || 0;
        var goIndex = currIndex + 1;
        window.location.href = '/timesheet/'+typeUrl+'/'+goIndex;
    });

    $("#next_week_timesheet").click(function(){
        var url = window.location.href;
        var typeUrl = url.split('/')[4];
        var currIndex = parseInt(url.split('/')[url.split('/').length - 1]) || 0;
        var goIndex = currIndex - 1;
        window.location.href = '/timesheet/'+typeUrl+'/'+goIndex;
    });

    $("#chk_all").click(function(){
        var checked = $(this).attr("checked");
        if(checked == "checked"){
            $("input[name='ts_id']").attr("checked", true);
        }else{
            $("input[name='ts_id']").attr("checked", false);
        }
    });


    $("#filter_pid,#filter_type").change(function(){
        //var pid = $(this).children('option:selected').val();
        var pid = $('#filter_pid').val();
        var tid = $('#filter_type').val();
        window.location.href= '/timesheet/approve/'+pid+'/'+tid;
    });

    /**
    $("#filter_report_pid").change(function(){
        var pid = $('#filter_report_pid').val();
        window.location.href= '/timesheet/report/'+pid;
    });
    **/


    $('#timesheet_approve_failure_btn').click(function() {
        var comments = $('#reject_comments').val();
        var val = [];
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();
        });
        if(val.length < 1){
            alert("请先勾选要审批的工时单。");
            return false;
        }
        if(!confirm("确认要驳回工时单？")){
            return false;
        }
        var param = {"ids": val, 'comments':comments};
        $.ajax({
          url:"/timesheet/rejectApprove/?time="+ (new Date()).getTime(),
          type:"post",
          data: param,
          dataType:"json",
          success: function(data){
                    var status = data.status;
                    if(status == 'ok'){
                        alert(data.msg);
                        window.location.reload(true);
                    }else{
                        alert(data.msg);
                    }
          }
        });
    });




    $('#timesheet_approve_success_btn').click(function() {
        var val = [];
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();
        });
        if(val.length < 1){
            alert("请先勾选要审批的工时单。");
            return false;
        }
        if(!confirm("确认审批通过？")){
            return false;
        }
        var param = {"ids": val};
        $.ajax({
          url:"/timesheet/authApprove/?time="+ (new Date()).getTime(),
          type:"post",
          data: param,
          dataType:"json",
          success: function(data){
                    var status = data.status;
                    if(status == 'ok'){
                        alert(data.msg);
                        window.location.reload(true);
                    }else{
                        alert(data.msg);
                    }
          }
        });
    });
   

});

function addTimeSheet(obj){
    var trObj = $(obj).closest('tr');
    var project_id = $(trObj).find('select[name="project_id"]')[0].value;
    var task_id= $(trObj).find('select[name="task_id"]')[0].value;
    var day1_hours = $(trObj).find('input[name="day1_hours"]')[0].value;
    var day2_hours = $(trObj).find('input[name="day2_hours"]')[0].value;
    var day3_hours = $(trObj).find('input[name="day3_hours"]')[0].value;
    var day4_hours = $(trObj).find('input[name="day4_hours"]')[0].value;
    var day5_hours = $(trObj).find('input[name="day5_hours"]')[0].value;
    var day6_hours = $(trObj).find('input[name="day6_hours"]')[0].value;
    var day7_hours = $(trObj).find('input[name="day7_hours"]')[0].value;
    var type = $(trObj).find('input[name="type"]')[0].value;
    if(project_id<1){
        alert('请选择项目');
        return false;
    }
    if(task_id<1){
        alert('请任务，如果任务内容为空请联系项目经理添加任务.');
        return false;
    }
    var param = {"pid":project_id, "tid":task_id, "day1_hours":day1_hours, "day2_hours":day2_hours, "day3_hours":day3_hours, "day4_hours":day4_hours, "day5_hours":day5_hours, "day6_hours":day6_hours, "day7_hours":day7_hours,"type":type};

    var url = window.location.href;
    var currIndex = parseInt(url.split('/')[url.split('/').length - 1]) || 0;

    //var param = {};
    $.ajax({
      url:"/timesheet/add/"+currIndex+"?time="+ (new Date()).getTime(),
      type:"post",
      dataType:"json",
      data:param,
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    window.location.reload(true);
                }else{
                    alert(data.msg);
                }
      }
    });
}

function updateTimeSheet(obj, id){
    var trObj = $(obj).closest('tr');
    var day1_hours = $(trObj).find('input[name="day1_hours"]')[0].value;
    var day2_hours = $(trObj).find('input[name="day2_hours"]')[0].value;
    var day3_hours = $(trObj).find('input[name="day3_hours"]')[0].value;
    var day4_hours = $(trObj).find('input[name="day4_hours"]')[0].value;
    var day5_hours = $(trObj).find('input[name="day5_hours"]')[0].value;
    var day6_hours = $(trObj).find('input[name="day6_hours"]')[0].value;
    var day7_hours = $(trObj).find('input[name="day7_hours"]')[0].value;
    var total_hours = parseInt(day1_hours) + parseInt(day2_hours) + parseInt(day3_hours) + parseInt(day4_hours) + parseInt(day5_hours) + parseInt(day6_hours) + parseInt(day7_hours);

    var param = {"day1_hours":day1_hours, "day2_hours":day2_hours, "day3_hours":day3_hours, "day4_hours":day4_hours, "day5_hours":day5_hours, "day6_hours":day6_hours, "day7_hours":day7_hours};

    //var param = {};
    $.ajax({
      url:"/timesheet/update/"+id+"/?time="+ (new Date()).getTime(),
      type:"post",
      dataType:"json",
      data:param,
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('修改成功');
                    $(trObj).find('td[name="total_hours"]').html(total_hours);
					url = window.location.href;
					typeUrl = url.split('/')[4];
					currIndex = parseInt(url.split('/')[url.split('/').length - 1]) || 0;
					window.location.href = '/timesheet/'+typeUrl+'/'+currIndex;
                }else{
                    alert(data.msg);
                }
      }
    });
}


function delTimeSheet(obj, id){
    if(!confirm("确定要删除该工时单吗?")){
        return false;
    }
    $.ajax({
      url:"/timesheet/del/"+id+"?time="+ (new Date()).getTime(),
      type:"get",
      dataType:"json",
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    $(obj).closest('tr').html('');
					url = window.location.href;
					typeUrl = url.split('/')[4];
					currIndex = parseInt(url.split('/')[url.split('/').length - 1]) || 0;
					window.location.href = '/timesheet/'+typeUrl+'/'+currIndex;
                }else{
                    alert(data.msg);
                }
      }
    });
}

function approveTimeSheet(){
    var val = [];
    //var val = "";
    $(':checkbox:checked').each(function(i){
        val[i] = $(this).val();
    });
    if(val.length < 1){
        alert("请先勾选要提交工时单");
        return false;
    }
    if(!confirm("确定要提交审批吗?")){
        return false;
    }
    var param = {"ids": val};
    $.ajax({
      url:"/timesheet/submitApprove/?time="+ (new Date()).getTime(),
      type:"post",
      data:param,
      dataType:"json",
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert(data.msg);
                    $.each(data.data, function(i, item) {
                        $('#approve_status_'+item).html('待一级审批');
                    });
                    //approve_status
                }else{
                    alert(data.msg);
                }
      }
    });
}


function toDownReport(id){
    var pid = $('#filter_report_pid').val();
    var dept = $('#filter_report_dept').val();
    var startTime= $('input[name="startTime"]').first().val();
    var endTime = $('input[name="endTime"]').first().val();
    var searchName = $('#search_username').val();
    //window.location.href = '/timesheet/export/'+id;
    var searchName = $('#search_username').val();
    if(startTime ==''){
        startTime = '0';
    }
    if(endTime ==''){
        endTime = '0';
    }
    window.location.href = '/timesheet/export/'+pid+'/'+dept+'/'+startTime+'/'+endTime+'/'+searchName;
}

function queryTimeSheetReport(){
    var pid = $('#filter_report_pid').val();
    var dept = $('#filter_report_dept').val();
    var startTime= $('input[name="startTime"]').first().val();
    var endTime = $('input[name="endTime"]').first().val();
    if($.trim(startTime)!='' && $.trim(endTime)==''){
        alert('请选择结束时间');
        return false;
    }
    if($.trim(endTime)!='' && $.trim(startTime)==''){
        alert('请选择开始时间');
        return false;
    }
    if(startTime>endTime){
        alert('结束时间不能小于开始时间');
        return false;
    }
    var searchName = $('#search_username').val();
    if(startTime ==''){
        startTime = '0';
    }
    if(endTime ==''){
        endTime = '0';
    }
    window.location.href = '/timesheet/report/'+pid+'/'+dept+'/'+startTime+'/'+endTime+'/'+searchName;
}

function selectTask(obj){
    var trObj = $(obj).closest('tr');
    var pid= $(trObj).find('select[name="project_id"]')[0].value;
}


function delFakeTimeSheet(obj){
    $(obj).closest('tr').html('');
}

function changeTaskList(obj){
    var pid = $(obj).val();
    var html = '<select name="task_id" class="selectpicker" style="width:80px;">';
        html += '<option value="0">请选择</option>';
    if(pid>0){
        html += eval('task_'+pid);
    }
    html += '</select>';
    //$('#csb').html(html);
    var trObj = $(obj).closest('tr');
    var pid= $(trObj).find('select[name="task_id"]').html(html);

}

