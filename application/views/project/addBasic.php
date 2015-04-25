<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">项目模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">创建项目</li>
        </ul><!--.breadcrumb-->
    </div>

<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>创建项目</h1>
    </div><!--/.page-header-->

    <div class="row-fluid">
    <!--PAGE CONTENT BEGINS HERE-->
    <form class="form-horizontal" method="post" id="form_addProject" >
        <div class="control-group">
            <label class="control-label" for="form-field-1">项目编号<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="" name="no">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">项目名称<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="" name="name">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">设定工时<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="例如100小时，填写100即可" name="hours">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">项目金额</label>
            <div class="controls">
                <input type="text" placeholder="" value=""  name="price">(单位为元)
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1" >项目类型<font color='red'>*</font></label>
            <div class="controls">
                <select id="form-field-select-1" name="type">
                    {projectTypeList}
                    <option value="{id}">{name}</option>
                    {/projectTypeList}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1" >项目状态<font color='red'>*</font></label>
            <div class="controls">
                <select id="form-field-select-1" name="project_status">
                    {projectStatusList}
                    <option value="{id}">{name}</option>
                    {/projectStatusList}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">项目财务<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="输入用户名进行搜索" name="owner" id="owner_autocomplete">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">一级审批人<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="输入用户名进行搜索" name="pm" id="pm_autocomplete">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">二级审批人</label>
            <div class="controls">
                <input type="text" placeholder="输入用户名进行搜索" name="dm" id="dm_autocomplete">(可选)
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="form-field-1">开始时间</label>
            <div class="controls">
                <div class="row-fluid input-append date">
                    <input class="span10 date-picker" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" name="startTime" placeholder="请点击输入框">
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
                    <input class="span10 date-picker" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" name="endTime" placeholder="请点击输入框">
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
                    <input class="span10 date-picker" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" name="ex_endTime" placeholder="请点击输入框">
                    <span class="add-on">
                    <i class="icon-calendar"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">完成进度</label>
            <div class="controls">
                <input type="text" id="progress" name="progress" placeholder="完成百分比 例如：5%">
            </div>
        </div>

        <div class="form-actions">
            <label class="control-label" for="form-field-1"></label>
        <button class="btn btn-info" type="submit" id="addProjectForm_btn">
        <i class="icon-ok bigger-110"></i>
        提交 
        </button>
        &nbsp; &nbsp; &nbsp;
        <button class="btn" type="reset">
        <i class="icon-undo bigger-110"></i>
        重置 
        </button>
        </div>
    </form>
    </div> <!--  row-fluid  end -->
    </div> <!--  page-content end -->
</div>

<script src="/resource/js/my/project.js"></script>
<script>
$(function() {
        var availableTags = [
        {employeeList}
                {label:"{username} {department} {position}", value:'{username}'},
        {/employeeList}
        ];
        $( "#owner_autocomplete,#pm_autocomplete,#dm_autocomplete" ).autocomplete({
            source: availableTags,
            minChars:0
        });

});
</script>
