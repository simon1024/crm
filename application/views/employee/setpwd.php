<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">员工模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">修改密码</li>
        </ul><!--.breadcrumb-->
    </div>

<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>修改密码</h1>
    </div><!--/.page-header-->

    <div class="row-fluid">
    <!--PAGE CONTENT BEGINS HERE-->
    <form class="form-horizontal" method="post" id="form_updatePasswd" >
        <div class="control-group">
            <label class="control-label" for="form-field-1">现在的密码<font color="red">*</font></label>
            <div class="controls">
                <input type="password" id="current_passwd" placeholder="" name="current_passwd">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1" >设置新的密码<font color="red">*</font></label>
			<div class="controls">
				<input type="password" placeholder="" id="new_passwd" name="new_passwd">
			</div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form-field-1" >重复新的密码<font color="red">*</font></label>
			<div class="controls">
				<input type="password" placeholder="" id="repeat_new_passwd" name="repeat_new_passwd">
			</div>
        </div>
        <div class="form-actions">
			<button class="btn btn-info" type="submit" id="updatePasswdForm_btn">
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
    var leader = $('#sel_leader').attr('sel_val');
    $('#sel_role').val(role);
    $('#sel_gender').val(gender);
    $('#sel_position').val(position);
    $('#sel_department').val(department);
    $('#sel_leader').val(leader);
});
</script>
