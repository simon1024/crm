<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">项目模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">浏览项目</li>
        </ul><!--.breadcrumb-->
    </div>

<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>浏览项目</h1>
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
                        <a data-toggle="tab" href="#project_finance"><i class="green icon-rocket bigger-110"></i>追加工时</a>
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
                                    <input type="text" placeholder="" name="no" value="{no}" disabled='true' >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">项目名称</label>
                                <div class="controls">
                                    <input type="text" placeholder="" name="name"  value="{name}"  disabled='true'>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1" >项目类型</label>
                                <div class="controls">
                                    <select id="sel_project_type" name="type" sel_val="{project_type}"  disabled='true'>
                                        {projectTypeList}
                                        <option value="{id}">{name}</option>
                                        {/projectTypeList}
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1" >项目状态</label>
                                <div class="controls">
                                    <select id="sel_project_status" name="project_status" sel_val="{project_status}" disabled='true'>
                                        {projectStatusList}
                                        <option value="{id}">{name}</option>
                                        {/projectStatusList}
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">项目财务</label>
                                <div class="controls">
                                    <input type="text" placeholder="输入用户名进行搜索" name="owner" id="owner_autocomplete" value="{ownerUserName}"  disabled='true'>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">一级审批人</label>
                                <div class="controls">
                                    <input type="text" placeholder="输入用户名进行搜索" name="pm" id="pm_autocomplete" value="{pmUserName}"  disabled='true'>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">二级审批人</label>
                                <div class="controls">
                                    <input type="text" placeholder="输入用户名进行搜索" name="dm" id="dm_autocomplete" value="{dmUserName}"  disabled='true'>(可选)
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="form-field-1">开始时间</label>
                                <div class="controls">
                                    <div class="row-fluid input-append date">
                                        <input class="span10 date-picker" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" name="startTime"  value="{startTime}"  disabled='true'>
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
                                        <input class="span10 date-picker" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" name="endTime"  value="{endTime}"  disabled='true'>
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
                                        <input class="span10 date-picker" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" name="ex_endTime"  value="{ex_endTime}"  disabled='true'>
                                        <span class="add-on">
                                        <i class="icon-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">完成进度</label>
                                <div class="controls">
                                    <input type="text" id="progress" name="progress" placeholder=""  value="{progress}"  disabled='true'>
                                </div>
                            </div>
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
									<td style='width:150px'><?php echo $subTask['start_time']; ?></td>
									<td style='width:150px'><?php echo $subTask['end_time']; ?></td>
									<td style='width:100px'><?php echo $subTask['hour']; ?></td>
                                </tr>
								<?php
                                    	}
                                    }
                                ?>

                            </tbody>
                        </table>
                    </div><!-- project_segment end -->
                    <div id="project_finance" class="tab-pane">
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



                    </div>
                </div>
            </div>
        </div><!-- span6 end  -->
        
    </div>
    <!-- row-fluid end -->


    <div class="row-fluid" style="display:none">

        <tr  id="tr_addRow">
                <td>OverHead</td>
                <td>2013-09-01</td>
                <td>2013-09-01</td>
                <td>2013-09-01</td>
                <td class="td-actions">
                    <div class="hidden-phone visible-desktop btn-group">

                        <button class="btn btn-mini btn-info">
                            <i class="icon-edit bigger-120"></i>
                        </button>
                        <button class="btn btn-mini btn-danger">
                            <i class="icon-trash bigger-120"></i>
                        </button>
                    </div>
                </td>
            </tr>
    </div> <!--  row-fluid  end -->
    </div> <!--  page-content end -->
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
