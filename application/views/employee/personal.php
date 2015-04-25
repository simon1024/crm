<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">员工模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">个人信息</li>
        </ul><!--.breadcrumb-->
    </div>

	<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>个人信息</h1>
    </div><!--/.page-header-->

		{basicInfo}
        <!--div class="control-group"-->
    	<div class="row-fluid">
			<div class="span4">员工编号：{no}</div>
			<div class="span4">登录用户名：{username}</div>
        </div>
    	<div class="row-fluid">
			<div class="span4">员工姓名：{name}</div>
			<div class="span4">性别：{genderName}</div>
        </div>
    	<div class="row-fluid">
			<div class="span4">系统角色：{role}</div>
			<div class="span4">职位：{position}</div>
        </div>
    	<div class="row-fluid">
			<div class="span4">所属部门：{department}</div>
			<div class="span4">直接上级：{leader}</div>
        </div>
    	<div class="row-fluid">
			<div class="span4">邮箱：{mail}</div>
			<div class="span4">手机：{mobile}</div>
        </div>
    	<div class="row-fluid">
			<div class="span4">联系电话：{tel}</div>
            <div class="span4">出生年月:{birthday}</div>
        </div>
		<div class="row-fluid">
			<a data-toggle="modal" href="#modify_personal_info" class="btn btn-primary">修改个人信息</a>
			<div id="modify_personal_info" class="modal hide fade" role="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>修改个人信息:</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="form_updatePersonalInfo" >
					<div class="control-group">
						<label class="control-label" for="form-field-1">员工姓名<font color='red'>*</font></label>
						<div class="controls">
							<input type="text" placeholder="" name="name" value="{name}">
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
						<label class="control-label" for="form-field-1">联系电话</label>
						<div class="controls">
							<input type="text" id="form-field-1" placeholder="" name="tel" value="{tel}">
						</div>
					</div>
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
								<input class="span10 date-picker" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" name="birthday"  placeholder="请点击输入框" value="{birthday}">
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
								<input class="span10 date-picker" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd" name="joinDate" placeholder="请点击输入框" value="{joinDate}">
								<span class="add-on">
								<i class="icon-calendar"></i>
								</span>
							</div>
						</div>
					</div>
					<input id="hidden_eid" type="hidden" name="eid" placeholder=""  value="{id}">
					<div class="form-actions">
						<button class="btn btn-info" type="submit" id="updatePersonalInfo_btn">
						<i class="icon-ok bigger-110"></i>
						保存 
						</button>
						&nbsp; &nbsp; &nbsp;
						<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">取消</a>
					</div>
				</form>
			</div>
			<!--div class="modal-footer">
			</div-->
		</div>
		{/basicInfo}
    </div> <!--  page-content end -->
</div>

<script src="/resource/js/my/employee-add.js"></script>
<script>
$(function(){ 
    var gender = $('#sel_gender').attr('sel_val');
    $('#sel_gender').val(gender);
});
</script>
