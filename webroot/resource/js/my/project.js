$(function(){ 
    // date picker
    $('.date-picker').datepicker({"autoclose": true});
    // submit form
    $('#resetProjectQuery').click(function() {
        $('#search_no').val('');
        $('#search_name').val('');
        $('#search_status').val(0);
        $('#search_type').val(0);
        $('#search_timeRange').val(0);
    });

    $('#project_append_price_btn').click(function() {
        var price = $('#append_price').val();
        var desc = $('#append_price_desc').val();
        if( isNaN(price) ){
            alert("填写金额有误。");
            return false;
        }
        if(!confirm("确认要追加"+price+"金额？")){
            return false;
        }
        var pid = $('#hidden_pid').val();
        var param = {"pid": pid, "price": price, 'desc':desc};
        $.ajax({
          url:"/project/appendPrice/?time="+ (new Date()).getTime(),
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

    var rowCount = 0;
    var price_rowCount = 0;

    $('#add_project_segment_btn').click(function() {
        rowCount++;
        var rowHtml  = '<tr id="tr_addRow'+rowCount+'">'
                      +'<td style="width:20px">-</td>'
					  +'<td style="width:100px"><select  id="pro_add_subTask1'+rowCount+'" name="pro_add_subTask1" class="filter_100"  style="width:100px" onchange="changeTask1List(this,'+rowCount+')">'
                      +'<option value="0">请选择</option>';
			rowHtml += eval('taskType_level1') + '</select></td>';
            rowHtml += '<td style="width:150px" class="ts_new_row_taskid_td" id="pas2'+rowCount+'">'
                      +'<select id="pro_add_subTask2'+rowCount+'" name="pro_add_subTask2" class="selectpicker" style="width:150px;">'
                      +'<option value="0">请选择</option> </select> </td>'
                      +'<td style="width:100px"><div class="row-fluid input-append date"><input class="span10 date-picker" type="text" data-date-format="yyyy-mm-dd" id="pro_add_startTime'+rowCount+'"><span class="add-on"><i class="icon-calendar"></i></span></td></div>'

                      +'<td style="width:100px"><div class="row-fluid input-append date"><input class="span10 date-picker" type="text" data-date-format="yyyy-mm-dd" id="pro_add_endTime'+rowCount+'"><span class="add-on"><i class="icon-calendar"></i></span></td></div>'

                      +'<td style="width:100px"><input type="text" id="pro_add_hour'+rowCount+'" class="input_100"></td>'
                      +'<td style="width:50px" class="td-actions"><div class="hidden-phone visible-desktop btn-group">'
                      +'<button class="btn btn-mini btn-success" onclick="subAddRow('+rowCount+', 0)"><i class="icon-save bigger-120"></i></button>'
                      +'<button class="btn btn-mini btn-danger" onclick="delFakeRow('+rowCount+')"><i class="icon-trash bigger-120"></i></button>'
                      +'</div></td></tr>';
        
        var tableHtml = $('#table_project_segment').html();
        tableHtml += rowHtml;
        $('#table_project_segment tbody').append(rowHtml);;
        $('.date-picker').datepicker({"autoclose": true});
    });


    $('#add_project_finance_btn').click(function() {
        price_rowCount++;
        var rowHtml  = '<tr id="tr_addRow'+price_rowCount+'">'
                      +'<td style="width:30px">-</td>'
                      +'<td style="width:15px"><div class="row-fluid input-append date"><input class="span10 date-picker" type="text" data-date-format="yyyy-mm-dd" id="pro_add_bill_time'+price_rowCount+'"><span class="add-on"><i class="icon-calendar"></i></span></td></div>'
                      +'<td style="width:150px"><input type="text" id="pro_add_bill_price'+price_rowCount+'" class="input_150"></td>'

                      +'<td style="width:100px"><input type="text" id="pro_add_bill_desc'+price_rowCount+'"></td>'
                      +'<td style="width:100px" class="td-actions"><div class="hidden-phone visible-desktop btn-group">'
                      +'<button class="btn btn-mini btn-success" onclick="addBillSeg('+price_rowCount+', 0)"><i class="icon-save bigger-120"></i></button>'
                      +'<button class="btn btn-mini btn-danger" onclick="delFakeRow('+price_rowCount+')"><i class="icon-trash bigger-120"></i></button>'
                      +'</div></td></tr>';
        
        var tableHtml = $('#table_project_finance').html();
        tableHtml += rowHtml;
        $('#table_project_finance tbody').append(rowHtml);;
        $('.date-picker').datepicker({"autoclose": true});
    });




    $('.add_sub_project_task_btn').click(function() {
        rowCount++;
        var tid = $(this).attr('tid');

        var rowHtml  = '<tr id="tr_addRow'+rowCount+'">'
                      +'<td style="width:30px">-</td>'
                      +'<td style="width:150px"><input type="text" id="pro_add_name'+rowCount+'" class="input_150"></td>'
                      +'<td style="width:15px"><div class="row-fluid input-append date"><input class="span10 date-picker" type="text" data-date-format="yyyy-mm-dd" id="pro_add_startTime'+rowCount+'"><span class="add-on"><i class="icon-calendar"></i></span></td></div>'

                      +'<td style="width:150px"><div class="row-fluid input-append date"><input class="span10 date-picker" type="text" data-date-format="yyyy-mm-dd" id="pro_add_endTime'+rowCount+'"><span class="add-on"><i class="icon-calendar"></i></span></td></div>'

                      +'<td style="width:100px"><input type="text" id="pro_add_hour'+rowCount+'"></td>'
                      +'<td style="width:100px" class="td-actions"><div class="hidden-phone visible-desktop btn-group">'
                      +'<button class="btn btn-mini btn-success" onclick="subAddRow('+rowCount+',' +tid+ ')"><i class="icon-save bigger-120"></i></button>'
                      +'<button class="btn btn-mini btn-danger" onclick="delFakeRow('+rowCount+')"><i class="icon-trash bigger-120"></i></button>'
                      +'</div></td></tr>';
        
        var tableHtml = $('#table_project_segment').html();
        tableHtml += rowHtml;
        $(this).closest('tr').after(rowHtml);
        //$('#table_project_segment tbody').html(tableHtml);;
        $('.date-picker').datepicker({"autoclose": true});
    });




    $('#advanceProjectQuery_View').click(function() {
        var pNo = $('#search_no').val();
        var pName = $('#search_name').val();
        var pType = $('#search_type').val();
        var pStatus = $('#search_status').val();
        var pTimeRange = $('#search_timeRange').val();
        var url = '/project/viewAll?no='+ pNo +'&name='+ pName +'&pstatus=' + pStatus + '&type=' + pType + '&range=' + pTimeRange;
        window.location.href = url;
    });

    $('#advanceProjectQuery').click(function() {
        var pNo = $('#search_no').val();
        var pName = $('#search_name').val();
        var pType = $('#search_type').val();
        var pStatus = $('#search_status').val();
        var pTimeRange = $('#search_timeRange').val();
        var url = '/project/listAll?no='+ pNo +'&name='+ pName +'&pstatus=' + pStatus + '&type=' + pType + '&range=' + pTimeRange;
        window.location.href = url;
    });
    

    $('#form_addProject').submit(function() {
        var success = checkAddProjectForm('form_addProject');
        if(success){
            var param = $("#form_addProject").serialize();
            $.ajax({
              url:"/project/add/?time="+ (new Date()).getTime(),
              type:"post",
              dataType:"json",
              data:param,
              success: function(data){
                        var status = data.status;
                        if(status == 'ok'){
                            window.location.href = '/project/listAll';
                        }else{
                            alert(data.msg);
                        }
              }
            });
        }
        return false;
    });



    $('#update_basicProjectForm').submit(function() {
        var success = checkAddProjectForm('update_basicProjectForm');
        if(success){
            var param = $("#update_basicProjectForm").serialize();
            $.ajax({
              url:"/project/updateBasic/?time="+ (new Date()).getTime(),
              type:"post",
              dataType:"json",
              data:param,
              success: function(data){
                        var status = data.status;
                        if(status == 'ok'){
                            window.location.href = '/project/listAll';
                        }else{
                            alert(data.msg);
                        }
              }
            });
        }
        return false;
    });



     $('#append_project_timesheetBtn').click(function() {
        var hours = $('#append_hours').val();
        var reason = $('#append_reason').val();
        var pid = $('#hidden_pid').val();
        if(parseInt(hours) < 1){
            alert('请填写要追加的工时数');
            return false;
        }
        if($.trim(reason) == ''){
            alert('请填写追加工时的原因');
            return false;
        }
        if(!confirm("确认追加"+hours+"个小时吗？")){
            return false;
        }
        var param = {"pid": pid, "hours":hours, "reason":reason};
        $.ajax({
          url:"/project/appendTimes/?time="+ (new Date()).getTime(),
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
    }); // append_project_timesheetBtn end.





});

function delFakeRow(rowId){
    $("#tr_addRow"+rowId).hide();
}

function delBill(id){
    if(!confirm("确定要删除该付款节点吗? ")){
        return false;
    }
    var param = {"id":id};
    $.ajax({
      url:"/project/delBill/?time="+ (new Date()).getTime(),
      type:"post",
      dataType:"json",
      data:param,
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('付款节点删除成功');
                    window.location.reload(true);
                }else{
                    alert(data.msg);
                }
      }
    });
}


function delParentsTask(taskId){
    if(!confirm("该任务为父级任务，删除后所有子任务也将被删除，是否确定删除? ")){
        return false;
    }
    var param = {"task_id":taskId};
    $.ajax({
      url:"/project/delTask/?time="+ (new Date()).getTime(),
      type:"post",
      dataType:"json",
      data:param,
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('任务删除成功');
                    window.location.reload(true);
                }else{
                    alert(data.msg);
                }
      }
    });
}


function updateTask(obj,taskId){
    var trObj = $(obj).closest('tr');
    //var project_id = $(trObj).find('select[name="project_id"]')[0].value;
    var hour = $(trObj).find('input[name="hour"]')[0].value;
    var startTime = $(trObj).find('input[name="startTime"]')[0].value;
    var endTime = $(trObj).find('input[name="endTime"]')[0].value;
	var param = {"id":taskId, "start_time":startTime, "end_time":endTime, "hour":hour};
	$.ajax({
	  url:"/project/updateTask/?time="+ (new Date()).getTime(),
	  type:"post",
	  dataType:"json",
	  data:param,
	  success: function(data){
				var status = data.status;
				if(status == 'ok'){
					//var url = window.location.pathname;
					//var seg = window.location.hash;
					//url = url+seg;
					//window.location.hash = '#project_segment';
					window.location.reload(true);
				}else{
					alert(data.msg);
				}
	  }
	});
}

function delTask(taskId){
    if(!confirm("删除任务将会影响相关工时单，确认删除吗?")){
        return false;
    }
    var param = {"task_id":taskId};
    $.ajax({
      url:"/project/delTask/?time="+ (new Date()).getTime(),
      type:"post",
      dataType:"json",
      data:param,
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('任务删除成功');
                    window.location.reload(true);
                }else{
                    alert(data.msg);
                }
      }
    });
}


function addBillSeg(rowId, parentId){
    var pid = $('#hidden_pid').val();
    var startTime = $('#pro_add_bill_time'+rowId).val();
    var price = $('#pro_add_bill_price'+rowId).val();
    var desc = $('#pro_add_bill_desc'+rowId).val();
    var param = {"pid":pid, "startTime":startTime, "price":price, "desc":desc};
    $.ajax({
      url:"/project/addBill/?time="+ (new Date()).getTime(),
      type:"post",
      dataType:"json",
      data:param,
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    var url = window.location.pathname;
                    var seg = window.location.hash;
                    url = url+seg;
                    window.location.hash = '#project_finance';
                    window.location.reload(true);
                }else{
                    alert(data.msg);
                }
      }
    });
}


function subAddRow(rowId, parentId){
    var pid = $('#hidden_pid').val();
    var name = $('#pro_add_subTask1'+rowId).val();
    var subName = $('#pro_add_subTask2'+rowId).val();
    var startTime = $('#pro_add_startTime'+rowId).val();
    var endTime = $('#pro_add_endTime'+rowId).val();
    var hour = $('#pro_add_hour'+rowId).val();
	var param = {"pid":pid, "name":name, "subName":subName, "startTime":startTime, "endTime":endTime, "hour":hour, "parent_id":parentId};
	$.ajax({
	  url:"/project/addTask/?time="+ (new Date()).getTime(),
	  type:"post",
	  dataType:"json",
	  data:param,
	  success: function(data){
				var status = data.status;
				if(status == 'ok'){
					var url = window.location.pathname;
					var seg = window.location.hash;
					url = url+seg;
					window.location.hash = '#project_segment';
					window.location.reload(true);
				}else{
					alert(data.msg);
				}
	  }
	});
}


//保存批量工作内容
function saveBatch(){
    var pid = $('#batch_hidden_pid').val();
    var name = $('#sel_subTask1').val();
	var subNames = $("#sel_subTask2").multiselect("MyValues");
    var startTime = $('#date-picker-startTime').val();
    var endTime = $('#date-picker-endTime').val();
    var hour = $('#form-field-hours'+rowId).val();
	var param = {"pid":pid, "name":name, "subNames":subNames, "startTime":startTime, "endTime":endTime, "hour":hour, "parent_id":parentId};
	$.ajax({
	  url:"/project/addBatchTask/?time="+ (new Date()).getTime(),
	  type:"post",
	  dataType:"json",
	  data:param,
	  success: function(data){
				var status = data.status;
				if(status == 'ok'){
					var url = window.location.pathname;
					var seg = window.location.hash;
					url = url+seg;
					window.location.hash = '#project_segment';
					window.location.reload(true);
				}else{
					alert(data.msg);
				}
	  }
	});
}

function checkAddProjectForm(formId){
    $('#'+formId).validate({
        onsubmit:true,// 是否在提交是验证 
        //onfocusout:false,// 是否在获取焦点时验证 
        //onkeyup :false,// 是否在敲击键盘时验证 
        focusCleanup:true,focusInvalid:false,
        errorClass: "unchecked",
        validClass: "checked",
        errorElement: "span",
        errorPlacement:function(error,element){
          var s=element.parent().find("span[htmlFor='" + element.attr("id") + "']");
          if(s!=null){
            s.remove();
          }
          error.appendTo(element.parent());
        },
        success: function(label) {
          //label.addClass("valid").text("Ok!")
          label.removeClass("unchecked").addClass("checked");
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
            $(element.form).find("label[for=" + element.id + "]")
              .addClass(errorClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
            $(element.form).find("label[for=" + element.id + "]")
              .removeClass(errorClass);
        },
        rules:{
          no:{required:true},
          name:{required:true,minlength:2},
          owner:{required:true,minlength:2},
          pm:{required:true,minlength:2},
          hours:{required:true,number:true},
        }
    });
    return $('#'+formId).valid();
}


function toUpdateProject(id){
    window.location.href = '/project/update/'+id;
}

function toViewProject(id){
    window.location.href = '/project/view/'+id;
}

function toViewReport(id){
    window.location.href = '/timesheet/report/'+id;
}

function toDelProject(id){
    if(!confirm("确定要删除项目吗，将影响到所有相关工时单&合同等内容？")){
        return false;
    }
    var param = {"id":id};
    $.ajax({
      url:"/project/del/"+id+"?time="+ (new Date()).getTime(),
      type:"post",
      data:param,
      dataType:"json",
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('项目删除成功');
                    window.location.reload(true);
                }else{
                    alert(data.msg);
                }
      }
    });


}

function changeTask1List(obj,rowId){
    var pid = $(obj).val();
    var html = '<select id="pro_add_subTask2'+rowId+'" name="pro_add_subTask2" class="selectpicker" style="width:150px;">';
        html += '<option value="0">请选择</option>';
    if(pid>0){
        html += eval('taskTypes_'+pid);
    }
    html += '</select>';
    $('#pas2'+rowId).html(html);
}
