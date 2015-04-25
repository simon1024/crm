function addDept(obj){
    var trObj = $(obj).closest('tr');
    var dept_name = $(trObj).find('input[name="dept_name"]')[0].value;
    var dept_approver = $(trObj).find('input[name="dept_approver"]')[0].value;
    var param = {"dept_name":dept_name, "dept_approver":dept_approver};

    var url = window.location.href;

    $.ajax({
      url:"/settings/addDepartment/?time="+ (new Date()).getTime(),
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

function updateDept(obj, id){
    var trObj = $(obj).closest('tr');
    var dept_name = $(trObj).find('input[name="dept_name"]')[0].value;
    var dept_approver = $(trObj).find('input[name="dept_approver"]')[0].value;

    var param = {"dept_name":dept_name, "dept_approver":dept_approver};

    $.ajax({
      url:"/settings/updateDepartment/"+id+"/?time="+ (new Date()).getTime(),
      type:"post",
      dataType:"json",
      data:param,
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('修改成功');
					window.location.href = '/settings/listDepartments';
                }else{
                    alert(data.msg);
                }
      }
    });
}

function delDept(obj, id){
    if(!confirm("确定要删除该部门吗?")){
        return false;
    }
    $.ajax({
      url:"/settings/delDepartment/"+id+"?time="+ (new Date()).getTime(),
      type:"get",
      dataType:"json",
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

function delPosition(obj, id){
    if(!confirm("确定要删除该职位吗?")){
        return false;
    }
    $.ajax({
      url:"/settings/delPosition/"+id+"?time="+ (new Date()).getTime(),
      type:"get",
      dataType:"json",
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

function delFakeDept(obj){
    $(obj).closest('tr').html('');
}

function delFakePosition(obj){
    $(obj).closest('tr').html('');
}

