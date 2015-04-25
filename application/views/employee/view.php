<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">员工模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">查看基本信息</li>
        </ul><!--.breadcrumb-->
    </div>

	<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>查看基本信息</h1>
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
			<!--div class="span4">入职时间：{joinDate}</div-->
        </div>
		{/basicInfo}
		<div class="row-fluid">
			<button class="btn btn-info" id="return" onclick="toList()">
			<i class="icon-ok bigger-110"></i>
			返回 
			</button>
		</div>
    </div> <!--  page-content end -->
</div>

<script src="/resource/js/my/employee-add.js"></script>
