<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">项目模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">编辑项目</li>
        </ul><!--.breadcrumb-->
    </div>

<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>编辑项目</h1>
    </div><!--/.page-header-->
    
    <!-- row-fluid start -->
    <div class="row-fluid">

        <div class="span6" style='width:100%'> <!-- span6 start -->
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li id='li_project_basic' class="active">
                        <a data-toggle="tab" href="#project_basic"><i class="green icon-home bigger-110"></i>项目基本信息</a>
                    </li>
                    <li id='li_project_segment'>
                        <a data-toggle="tab" href="#project_segment"><i class="green icon-rocket bigger-110"></i>项目工作内容分解<!--span class="badge badge-important">4</span-->
                        </a>
                    </li>
                    <li id='li_project_finance'>
                        <a data-toggle="tab" href="#project_finance"><i class="green icon-rocket bigger-110"></i>项目合同金额<!--span class="badge badge-important">4</span-->
                        </a>
                    </li>

                    <li id='li_project_hours'>
                        <a data-toggle="tab" href="#project_hours"><i class="green icon-rocket bigger-110"></i>追加工时</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="project_basic" class="tab-pane active"> <!-- project_basic start -->
                        <!--PAGE CONTENT BEGINS HERE-->
                        <form class="form-horizontal" method="post" id="update_basicProjectForm" >
                        {basicInfo}
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">项目编号</label>
                                <div class="controls">
                                    <?php
                                    $user = CI_Controller::getSessionUserInfo();
                                    $role = $user['role'];
                                    ?>
                                    
                                    <input type="text" placeholder="" name="no" value="{no}" >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">项目名称</label>
                                <div class="controls">
                                    <input type="text" placeholder="" name="name"  value="{name}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">设定工时</label>
                                <div class="controls">
                                    <input type="text" placeholder="" name="hours"  value="{hours}小时" disabled='true'>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">项目合同金额</label>
                                <div class="controls">
                                    <input type="text" placeholder="" name="total_price"  value="{total_price}" disabled='true'>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1" >项目类型</label>
                                <div class="controls">
                                    <select id="sel_project_type" name="type" sel_val="{project_type}">
                                        {projectTypeList}
                                        <option value="{id}">{name}</option>
                                        {/projectTypeList}
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1" >项目状态</label>
                                <div class="controls">
                                    <select id="sel_project_status" name="project_status" sel_val="{project_status}">
                                        {projectStatusList}
                                        <option value="{id}">{name}</option>
                                        {/projectStatusList}
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">项目财务</label>
                                <div class="controls">
                                    <input type="text" placeholder="输入用户名进行搜索" name="owner" id="owner_autocomplete" value="{ownerUserName}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">一级审批人</label>
                                <div class="controls">
                                    <input type="text" placeholder="输入用户名进行搜索" name="pm" id="pm_autocomplete" value="{pmUserName}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">二级审批人</label>
                                <div class="controls">
                                    <input type="text" placeholder="输入用户名进行搜索" name="dm" id="dm_autocomplete" value="{dmUserName}">(可选)
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="form-field-1">开始时间</label>
                                <div class="controls">
                                    <div class="row-fluid input-append date">
                                        <input class="span10 date-picker" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" name="startTime"  value="{startTime}">
                                        <span class="add-on">
                                        <i class="icon-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">结束时间</label>
                                <div class="controls">
                                    <div class="row-fluid input-append date">
                                        <input class="span10 date-picker" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" name="endTime"  value="{endTime}">
                                        <span class="add-on">
                                        <i class="icon-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">预计完成时间</label>
                                <div class="controls">
                                    <div class="row-fluid input-append date">
                                        <input class="span10 date-picker" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" name="ex_endTime"  value="{ex_endTime}">
                                        <span class="add-on">
                                        <i class="icon-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">完成进度</label>
                                <div class="controls">
                                    <input type="text" id="progress" name="progress" placeholder=""  value="{progress}">
                                </div>
                            </div>

                            <div class="form-actions">
                            <button class="btn btn-info" type="submit" id="updateProjectForm_btn">
                            <i class="icon-ok bigger-110"></i>
                            提交 
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn" type="reset"> <i class="icon-undo bigger-110"></i> 重置 </button>
                            </div>
                            <input id="hidden_pid" type="hidden" name="pid" placeholder=""  value="{id}">
                        {/basicInfo}
                        
                        </form>
                    </div> <!-- project_basic end -->



                    <!-- project_segment start-->
                    <div id="project_segment" class="tab-pane">
                        <table id="table_project_segment" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>一级任务</th>
                                    <th>二级任务</th>
                                    <th>计划开始时间</th>
                                    <th>计划结束时间</th>
                                    <th>工作上限(小时)</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    foreach($taskList as  $task){
                                        if(array_key_exists('subTask', $task)){
                                            $subTaskList = $task['subTask'];
                                        }else{
                                            $subTaskList = array();
                                        }
										foreach($subTaskList as  $subTask)
										{
                                ?>
                                <tr class="selected" >
                                    <td style="width:30px"><img src='/resource/img/details_open.png'/></td>
									<td style='width:150px'><?php echo $subTask['taskName']; ?></td>
									<td style='width:150px'><?php echo $subTask['subTaskName']; ?></td>
									<!--td style='width:150px'><?php echo $subTask['start_time']; ?></td>
									<td style='width:150px'><?php echo $subTask['end_time']; ?></td>
									<td style='width:100px'><?php echo $subTask['hour']; ?></td-->
									<td style="width:100px"><div class="row-fluid input-append date"><input class="span10 date-picker" type="text" data-date-format="yyyy-mm-dd" name="startTime" value=<?php echo $subTask['start_time']; ?>><span class="add-on"><i class="icon-calendar"></i></span></td></div>

                      				<td style="width:100px"><div class="row-fluid input-append date"><input class="span10 date-picker" type="text" data-date-format="yyyy-mm-dd" name="endTime" value=<?php echo $subTask['end_time']; ?>><span class="add-on"><i class="icon-calendar"></i></span></td></div>
									<td style='width:100px'><input type="text" name="hour" class="input_100" value=<?php echo $subTask['hour']; ?> ></td>
                                    <td style='width:100px' class="td-actions">
                                        <div>
                                <a href="#project_segment" class="tooltip-error" data-rel="tooltip" title="" data-placement="left" data-original-title="更新"  onclick="updateTask(this,<?php echo $subTask['id']; ?>)"  style="text-decoration:none">
                                    <span class="red"><i class="icon-save bigger-120"></i></span>
                                </a>

                                <a href="#project_segment" class="tooltip-error" data-rel="tooltip" title="" data-placement="left" data-original-title="删除"  onclick="delTask(<?php echo $subTask['id']; ?>)"  style="text-decoration:none">
                                    <span class="red"><i class="icon-trash bigger-120"></i></span>
                                </a>

                                        </div>
                                    </td>
                                </tr>
								<?php
									}
								}
								?>

                            </tbody>
                        </table>
                        <button class="btn btn-primary" id="add_project_segment_btn">
                            <i class="icon-pencil bigger-125"></i>
                            新增工作内容
                        </button>
                        &nbsp;&nbsp;
                        <button class="btn btn-primary" id="batch_add_project_segment_btn" data-toggle="modal" data-target="#batchAddSegments">
                            <i class="icon-pencil bigger-125"></i>
                            批量新增工作内容   
                        </button>
                        <!--button class="btn btn-primary" id="save_all_btn">
                            <i class="icon-save bigger-125"></i>
                            全部保存 
                        </button-->

                    </div><!-- project_segment end -->



                    <!-- project_price  start-->
                    <div id="project_finance" class="tab-pane">

                        <h3 class="header smaller lighter green">
                        <i class="icon-bullhorn"></i>
                        合同金额变更记录: 
                       </h3>

                        <div class="span5" style="width:450px">
                            <ul class="unstyled spaced">
                            {appendPriceHistory}
                                <div class="alert alert-warning" >
                                    <!--button type="button" class="close" data-dismiss="alert">
                                        <i class="icon-remove"></i>
                                    </button-->
                                    <i class="icon-bell purple"></i>【{addTime}】项目合同价格变更【{price}】, 变更描述【{desc}】
                                </div>
                                <li>
                                </li>
                            {/appendPriceHistory}
                            </ul>
                        </div>
                        <div class="span5">
                            <form>
                                <div class="control-group">
                                    <label class="control-label" for="form-field-1" style="float:left">合同签订金额:&nbsp;&nbsp;</label>
                                    <div class="controls">
                                        <input type="text" placeholder="" name="price"  value="<?php echo $basicInfo[0]['price']; ?>" disabled='true'>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="form-field-1" style="float:left">当前合同金额:&nbsp;&nbsp;</label>
                                    <div class="controls">
                                        <input type="text" placeholder="" name="total_price"  value="<?php echo $basicInfo[0]['total_price']; ?>" disabled='true'>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <table id="table_project_finance" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>付款节点</th>
                                    <th>金额</th>
                                    <th>描述</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    foreach($billList as  $bill){
                                ?>
                                <tr class="selected" >
                                    <td style="width:50px"><img src='/resource/img/details_open.png'/></td>
                                    <td style='width:150px'><?php echo $bill['start_time']; ?></td>
                                    <td style='width:150px'><?php echo $bill['price']; ?></td>
                                    <td style='width:150px'><?php echo $bill['desc']; ?></td>
                                    <td style='width:100px' class="td-actions">
                                        <!--div class="hidden-phone visible-desktop btn-group"-->
                                        <div>
                                <!--a href="#project_finance" class="tooltip-success add_sub_project_task_btn" data-rel="tooltip" title="" data-placement="left" data-original-title="增加子任务" style="text-decoration:none" tid="<?php echo $bill['id']; ?>">
                                    <span class="green"><i class="icon-edit bigger-120"></i></span>
                                </a-->&nbsp;&nbsp;



                                <a href="#project_finance" class="tooltip-error" data-rel="tooltip" title="" data-placement="left" data-original-title="删除"  onclick="delBill(<?php echo $bill['id']; ?>)"  style="text-decoration:none">
                                    <span class="red"><i class="icon-trash bigger-120"></i></span>
                                </a>



                                            <!--button class="btn btn-mini btn-danger" onclick="delParentsTask(<?php echo $task['id']; ?>)" >
                                                <i class="icon-trash bigger-120"></i>
                                            </button-->
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>

                            </tbody>
                        </table>
                        <button class="btn btn-primary" id="add_project_finance_btn">
                            <i class="icon-pencil bigger-125"></i>
                            添加付款节点
                        </button>
                        &nbsp;&nbsp;
                        <button class="btn btn-primary" id="add_project_finance_btn" data-toggle="modal" data-target="#myModal">
                            <i class="icon-pencil bigger-125"></i>
                            变更金额   
                        </button>

                    </div><!-- project_finance end -->




                    <!-- hours start -->
                    <div id="project_hours" class="tab-pane">
                        <h3 class="header smaller lighter green">
                        <i class="icon-bullhorn"></i>
                        追加记录: 
                       </h3>

                        <div class="span5">
                            <ul class="unstyled spaced">
                            {hoursList}
                                <div class="alert alert-warning" style="width:380px">
                                    <!--button type="button" class="close" data-dismiss="alert">
                                        <i class="icon-remove"></i>
                                    </button-->
                                    <i class="icon-bell purple"></i>【{addTime}】【{name}】追加【{hours}】小时工时, 追加原因【{reason}】
                                </div>
                                <li>
                                </li>
                            {/hoursList}
                            </ul>
                        </div>
                        <div class="span5">
                            <!--PAGE CONTENT BEGINS HERE-->
                            <form class="form-horizontal" method="post" id="append_project_timesheetForm" >
                                <div class="control-group">
                                    <label class="control-label" for="form-field-1">追加工时</label>
                                    <div class="controls">

                                    <?php 
                                    $user = CI_Controller::getSessionUserInfo();
                                    $role = $user['role'];
                                    ?>
                                        <input type="text" placeholder="(单位小时)" name="hours" value="" id="append_hours" <?php if($role!=1 && $role!=4){echo "disabled='true'";} ?>>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="form-field-1">原因描述</label>
                                    <div class="controls">
                                        <input type="text" placeholder="" name="reason"  value="" id="append_reason" <?php if($role!=1 && $role!=4){echo "disabled='true'";} ?>>
                                    </div>
                                </div>
                                <div class="form-actions" style='background:none;border:0'>
                                <button class="btn btn-info" type="button" id="append_project_timesheetBtn" <?php if($role!=1 && $role!=4){echo "disabled='true'";} ?>>                                    <i class="icon-ok bigger-110"></i>提交 
                                </button>
                                </div>
                                <input id="hidden_pid" type="hidden" name="pid" placeholder=""  value="{id}">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- span6 end  -->
        
    </div>
    <!-- row-fluid end -->

<!-- poup -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">变更金额</h3>
    </div>

    <div class="modal-body">
        <label style='float:left'>变更金额:&nbsp;&nbsp;</label>
        <input type="text" placeholder="" name="price" id="append_price">
        <p></p>
        <label style="float:left">变更描述:&nbsp;&nbsp;</label>
        <input type="text" placeholder="" name="desc" id="append_price_desc">
    </div>

    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
        <button class="btn btn-primary" id="project_append_price_btn">提交</button>
    </div>
</div>

<div id="batchAddSegments" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">批量新增工作内容</h3>
    </div>

    <div class="modal-body">
		<form class="form-horizontal" method="post" id="form_batchAddSegments" >
			<div class="control-group">
				<label class="control-label" for="form-field-1">一级任务</label>
				<div class="controls">
					<select id="sel_subTask1" name="subTask1" onchange="changeSubTask1List(this)">
						<option value="0">请选择</option>
						{taskType1List}
						<option value="{id}">{name}</option>
						{/taskType1List}
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="form-field-1">二级任务</label>
				<div class="controls" id="div_subTask2">
					<select id ="sel_subTask2" multiple="multiple" name="subTask2">
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="form-field-1">计划开始时间</label>
				<div class="controls">
					<div class="row-fluid input-append date">
						<input class="span10 date-picker" id="date-picker-startTime" type="text" data-date
-format="yyyy-mm-dd" name="startTime"  placeholder="请点击输入框" >
						<span class="add-on">
						<i class="icon-calendar"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="form-field-1">计划结束时间</label>
				<div class="controls">
					<div class="row-fluid input-append date">
						<input class="span10 date-picker" id="date-picker-endTime" type="text" data-date
-format="yyyy-mm-dd" name="endTime" placeholder="请点击输入框" >
						<span class="add-on">
						<i class="icon-calendar"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="form-field-1">工作上限(小时)</label>
				<div class="controls">
					<input type="text" id="form-field-hours" placeholder="" name="hours">
				</div>
			</div>
			<input id="batch_hidden_pid" type="hidden" name="pid" placeholder=""  value="<?php echo $basicInfo[0]['id']; ?>">
		</form>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary" id="batch_add_save_btn" onclick="saveBatch()">新增</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
    </div>
</div>

<script src="/resource/js/my/project.js"></script>
<script>
$(function(){ 
    var projectType = $('#sel_project_type').attr('sel_val');
    var projectStatus = $('#sel_project_status').attr('sel_val');
    $('#sel_project_type').val(projectType);
    $('#sel_project_status').val(projectStatus);


    var availableTags = [
    {employeeList}
            {label:"{username} {department} {position}", value:'{username}'},
    {/employeeList}
    ];
    $( "#owner_autocomplete,#pm_autocomplete,#dm_autocomplete" ).autocomplete({
        source: availableTags,
        minChars:0
    });
    var seg = window.location.hash;
    if(seg == '#project_basic' || seg == '#project_segment' || seg == '#project_finance'){
        $('.nav-tabs li').removeClass();
        $('.tab-pane').attr('class','tab-pane');
        seg = seg.replace("#",'');
        $('#li_'+seg).addClass('active');
        $('#'+seg).addClass('active');
    }

    // select

    /**
    var arr = url.split("/");
    var c = arr[1];
    var m = arr[2];

    if(document.getElementById(activeItem) != undefined ){
        document.getElementById(activeItem).className = 'active';;
        //$('#'+activeItem).parent().parent().className = 'open';
        $('#'+activeItem).parent().css('display','block');
    }
    **/
});
</script>

<script>
<?php
foreach($taskType2List as $parentId=>$taskTypes){
	echo "var taskTypes_{$parentId} = ''; \n";
	foreach($taskTypes as $id=>$taskType){
		echo "taskTypes_{$parentId} += \"<option value='{$taskType['id']}'>{$taskType['name']}</option>\"; \n"; 
	}
}
?>
</script>

<script>
<?php
echo "var taskType_level1 = ''; \n";
foreach($taskType1List as $id=>$taskType){
	echo "taskType_level1 += \"<option value='{$taskType['id']}'>{$taskType['name']}</option>\"; \n"; 
}
?>
</script>

<script>
function changeSubTask1List(obj){
    var pid = $(obj).val();
	var html = '<select id ="sel_subTask2" multiple="multiple" name="subTask2">';
    if(pid>0){
        html += eval('taskTypes_'+pid);
    }
    html += '</select>';
    $('#div_subTask2').html(html);
	$('#sel_subTask2').multiselect();
}
</script>

<script>
$('#sel_subTask2').multiselect();
function showValues() {
var valuestr = $("#sel_subTask2").multiselect("MyValues");
alert(valuestr);
}
</script>

<script>
//保存批量工作内容
function saveBatch(){
    var pid = $('#batch_hidden_pid').val();
    var name = $('#sel_subTask1').val();
	var subNames = $("#sel_subTask2").multiselect("MyValues");
    var startTime = $('#date-picker-startTime').val();
    var endTime = $('#date-picker-endTime').val();
    var hour = $('#form-field-hours').val();
	var parentId = 0;
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
</script>
