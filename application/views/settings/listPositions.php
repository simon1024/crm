<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">设置模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">{title}</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
        <div class="page-header position-relative">
            <h1>{title}</h1>
        </div><!--/.page-header-->

        <div class="row-fluid">
            <div class="span12">
                <table id="table_position_list" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>职位</th>
                            <th>部门</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
						{positionList}
                        <tr class="selected">
                            <td><input type="text" name="position_name" value="{pname}"></td>
                            <td>
                                <select id="sel_department" name="sel_department_array" sel_val="{did}">
                                    <option value="0">请选择</option>
                                    {deptList}
                                    <option value="{id}">{name}</option>
                                    {/deptList}
                                </select>
                            </td>
							<td class="td-actions">
								<div class="hidden-phone visible-desktop btn-group">'
									<button class="btn btn-mini btn-success" onclick="updatePosition(this, {pid})"><i class="icon-save bigger-120"></i></button>
									<button class="btn btn-mini btn-danger" onclick="delPosition(this, {pid})"><i class="icon-trash bigger-120"></i></button>
								</div>
							</td>
                        </tr>
                        {/positionList}
                    </tbody>
                </table>
                <button class="btn btn-primary" id="add_position_btn"> <i class="icon-pencil bigger-125"></i> 新增职位 </button>

            </div><!--/span-->
        </div> <!-- row-fluid -->

    </div> <!--  page-content end -->
</div>

<table id="add_position_row" style="display:none">
    <tr class="selected position_row">
		<td><input type="text" name="position_name" value=""></td>
        <td>
            <select id="sel_department" name="sel_department_array">
                <option value="0">请选择</option>
                {deptList2}
                <option value="{id}">{name}</option>
                {/deptList2}
            </select>
        </td>
        <td class="td-actions">
            <div class="hidden-phone visible-desktop btn-group">'
                <button class="btn btn-mini btn-success" onclick="addPosition(this)"><i class="icon-save bigger-120"></i></button>
                <button class="btn btn-mini btn-danger" onclick="delFakePosition(this)"><i class="icon-trash bigger-120"></i></button>
            </div>
        </td>
    </tr>
</table>

<script src="/resource/js/bootstrap-tableselect.js"></script>
<script src="/resource/js/my/settings.js"></script>

<script>
$(function(){ 
    var dept_array = document.getElementsByName("sel_department_array");
    for( var i=0; i<dept_array.length; i++) {
        var department = dept_array[i].getAttribute("sel_val");
        dept_array[i].selectedIndex = department;
    }
});
</script>

<script>
$('#add_position_btn').click(function() {
    var rowHtml = $('#add_position_row').html();
    rowHtml = rowHtml.replace("<tbody>", "");;
    rowHtml = rowHtml.replace("</tbody>", "");;
    rowHtml = rowHtml.replace("<TBODY>", "");;
    rowHtml = rowHtml.replace("</TBODY>", "");;
    $('#table_position_list tbody').append(rowHtml);;
});

function updatePosition(obj, id){
    var trObj = $(obj).closest('tr');
    var position_name = $(trObj).find('input[name="position_name"]')[0].value;
    var department = $(trObj).find('select[name="sel_department_array"]')[0].value;

    var param = {"position_name":position_name, "department":department};

    $.ajax({
      url:"/settings/updatePosition/"+id+"/?time="+ (new Date()).getTime(),
      type:"post",
      dataType:"json",
      data:param,
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('修改成功');
                                        window.location.href = '/settings/listPositions';
                }else{
                    alert(data.msg);
                }
      }
    });
}

function addPosition(obj){
    var trObj = $(obj).closest('tr');
    var name = $(trObj).find('input[name="position_name"]')[0].value;
    var department = $(trObj).find('select[name="sel_department_array"]')[0].value;
    var param = {"name":name, "department":department};

    var url = window.location.href;

    $.ajax({
      url:"/settings/addPosition/?time="+ (new Date()).getTime(),
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

</script>
