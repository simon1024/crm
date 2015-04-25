<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">员工模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">添加员工</li>
        </ul><!--.breadcrumb-->
    </div>

<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>添加员工</h1>
    </div><!--/.page-header-->

    <div class="row-fluid">
    <!--PAGE CONTENT BEGINS HERE-->
    <form class="form-horizontal" method="post" id="form_addEmployee" >
        <div class="control-group">
            <label class="control-label" for="form-field-1">员工编号<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="" name="no">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">员工姓名<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" placeholder="" name="name">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">登录用户名<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" id="form-field-1" placeholder="" name="username">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1" >初始密码<font color='red'>*</font></label>
            <div class="controls">
                <input type="password" id="password" name="password" placeholder="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1"  >确认密码<font color='red'>*</font></label>
            <div class="controls">
                <input type="password" id="form-field-1" name="confirm_password" placeholder="">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1" >系统角色</label>
            <div class="controls">
                <select id="form-field-select-1" name="role">
                    {roleList}
                    <option value="{id}">{name}</option>
                    {/roleList}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">性别</label>
            <div class="controls">
                <select id="form-field-select-1" name="gender">
                    <option value="1">男</option>
                    <option value="0">女</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">所属部门</label>
            <div class="controls">
                <select id="form-field-select-1" name="department" onchange="changePositionList(this)">
                	<option value="0">请选择</option>
                    {deptList}
                    <option value="{id}">{name}</option>
                    {/deptList}
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">职位</label>
            <div class="controls" id="pos" >
                <select id="pos_id" name="position">
                	<option value="0">请选择</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">直接上级</label>
            <div class="controls">
                <input type="text" placeholder="输入用户名进行搜索" name="leader" id="leader_autocomplete">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="form-field-1">邮箱<font color='red'>*</font></label>
            <div class="controls">
                <input type="text" id="form-field-1" placeholder="" name="mail">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="form-field-1">联系电话</label>
            <div class="controls">
                <input type="text" id="form-field-1" placeholder="" name="tel">
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
                <input type="text" id="form-field-1" placeholder="" name="mobile">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1">出生年月</label>
            <div class="controls">
                <div class="row-fluid input-append date">
                    <input class="span10 date-picker" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" name="birthday"  placeholder="请点击输入框">
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
                    <input class="span10 date-picker" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" name="joinDate" placeholder="请点击输入框">
                    <span class="add-on">
                    <i class="icon-calendar"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-actions">
        <button class="btn btn-info" type="submit" id="addEmployeeForm_btn">
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

<script src="/resource/js/my/employee-add.js"></script>
<script>
$(function() {
        var availableTags = [
        {employeeList}
                {label:"{username} {department} {position}", value:'{username}'},
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
