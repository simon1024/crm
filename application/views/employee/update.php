<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">员工模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">编辑员工</li>
        </ul><!--.breadcrumb-->
    </div>

<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>编辑员工</h1>
    </div><!--/.page-header-->

    <div class="row-fluid">
    <!--PAGE CONTENT BEGINS HERE-->
    <form class="form-horizontal" method="post" id="form_updateEmployee" >
    {basicInfo}
        <div class="control-group">
            <label class="control-label" for="form-field-1">员工编号<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="" name="no" value="{no}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">员工姓名<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="" name="name" value="{name}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">登录用户名<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="" name="username" value="{username}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1" >系统角色</label>
            <div class="controls">
                <select id="sel_role" name="role" sel_val="{role}">
                    <option value="0">请选择</option>
                    {roleList}
                    <option value="{id}">{name}</option>
                    {/roleList}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">性别</label>
            <div class="controls">
                <select id="sel_gender" name="gender" sel_val="{gender}">
                    <option value="1">男</option>
                    <option value="0">女</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">所属部门</label>
            <div class="controls">
                <select id="sel_department" name="department" sel_val="{department}" onchange="changePositionList(this)">
                    <option value="0">请选择</option>
                    {deptList}
                    <option value="{id}">{name}</option>
                    {/deptList}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">职位</label>
            <div class="controls" id="pos">
                <select id="sel_position" name="position" sel_val="{position}">
                    <option value="0">请选择</option>
					{posList}
                    <option value="{id}">{name}</option>
					{/posList}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">直接上级</label>
            <div class="controls">
                <input type="text" placeholder="输入用户名进行搜索" name="leader" id="leader_autocomplete" value="{leader}">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="form-field-1">邮箱<font color="red">*</font></label>
            <div class="controls">
                <input type="text" id="form-field-1" placeholder="" name="mail" value="{mail}">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="form-field-1">联系电话</label>
            <div class="controls">
                <input type="text" id="form-field-1" placeholder="" name="tel" value="{tel}">
            </div>
        </div>

        <!--div class="control-group">
            <label class="control-label" for="form-field-1">联系电话</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-phone"></i></span>
                    <input type="text" id="form-field-1" placeholder="">
                </div>
            </div>
        </div-->
        <div class="control-group">
            <label class="control-label" for="form-field-1">手机<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" id="form-field-1" placeholder="" name="mobile" value="{mobile}">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">出生年月</label>
            <div class="controls">
                <div class="row-fluid input-append date">
                    <input class="span10 date-picker" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" name="birthday" value="{birthday}">
                    <span class="add-on">
                    <i class="icon-calendar"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">入职时间</label>
            <div class="controls">
                <div class="row-fluid input-append date">
                    <input class="span10 date-picker" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" name="joinDate" value="{joinDate}">
                    <span class="add-on">
                    <i class="icon-calendar"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-actions">
        <button class="btn btn-info" type="submit" id="updateEmployeeForm_btn">
        <i class="icon-ok bigger-110"></i>
        提交 
        </button>
        &nbsp; &nbsp; &nbsp;
        <button class="btn" type="reset">
        <i class="icon-undo bigger-110"></i>
        重置 
        </button>
        </div>
		<input id="hidden_eid" type="hidden" name="eid" placeholder=""  value="{id}">
	{/basicInfo}
    </form>
    </div> <!--  row-fluid  end -->
    </div> <!--  page-content end -->
</div>

<script src="/resource/js/my/employee-add.js"></script>
<script>
$(function(){ 
    var role = $('#sel_role').attr('sel_val');
    var gender = $('#sel_gender').attr('sel_val');
    var position = $('#sel_position').attr('sel_val');
    var department = $('#sel_department').attr('sel_val');
    $('#sel_role').val(role);
    $('#sel_gender').val(gender);
    $('#sel_position').val(position);
    $('#sel_department').val(department);
});
</script>
<script>
$(function() {
        var availableTags = [
        {employeeList}
                {label:"{name}{username} {department} {position}", value:'{username}'},
        {/employeeList}
        ];
        $( "#leader_autocomplete" ).autocomplete({
            source: availableTags,
            minChars:0
        });

});
</script>

<script>
<?php
foreach($positionsOfDept as $deptId=>$allPosition){
    echo "var pos_{$deptId} = ''; \n";
    foreach($allPosition as $id=>$position){
		echo "pos_{$deptId} += \"<option value='{$position['id']}'>{$position['name']}</option>\"; \n"; 
    }
}
?>
</script>
