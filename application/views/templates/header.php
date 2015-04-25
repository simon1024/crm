<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>公司管理系统</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!--basic styles-->

		<link href="/resource/css/bootstrap.min.css" rel="stylesheet" />
		<!--link href="/resource/css/bootstrap-dt.css" rel="stylesheet" /-->
		<link href="/resource/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/resource/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="/resource/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!--page specific plugin styles-->

		<!--fonts-->

		<!--link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" /-->

		<!--ace styles-->

		<link rel="stylesheet" href="/resource/css/ace.min.css" />
		<link rel="stylesheet" href="/resource/css/ace-responsive.min.css" />
		<link rel="stylesheet" href="/resource/css/ace-skins.min.css" />
		<link rel="stylesheet" href="/resource/css/ui-lightness/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" href="/resource/css/bootstrap-select.min.css" />
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="/resource/css/ace-ie.min.css" />
		<![endif]-->
		<!--inline styles if any-->
        <style class="include" type="text/css">
        </style>
		<!--link rel="stylesheet" href="/resource/css/dataTables.bootstrap.css" /-->
		<link rel="stylesheet" href="/resource/css/my.css" />

		<!--basic scripts-->
		<!-- script src="/resource/js/jquery-1.9.1.min.js"></script-->
		<script src="/resource/js/jquery-1.8.2.min.js"></script>
	    <script src="/resource/js/bootstrap.min.js"></script>
	    <script src="/resource/js/jquery.dump.js"></script>
	    <script src="/resource/js/jquery-ui-1.10.3.custom.min.js "></script>
		<!--for multiselect-->
		<link rel="stylesheet" type="text/css" href="/resource/css/multiselect/jquery.multiselect.css" />
		<link rel="stylesheet" type="text/css" href="/resource/css/multiselect/style.css" />
		<link rel="stylesheet" type="text/css" href="/resource/css/multiselect/prettify.css" />
		<!--link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" /-->
		<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

		<script type="text/javascript" src="/resource/js/multiselect/jquery.ui.core.js"></script-->
		<script type="text/javascript" src="/resource/js/multiselect/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="/resource/js/multiselect/prettify.js"></script>
		<script type="text/javascript" src="/resource/js/multiselect/jquery.multiselect.js"></script>

	</head>
    <body>
    <div class="navbar navbar-inverse">

    <div class="navbar-inner">
        <div class="container-fluid">
            <a href="#" class="brand">
                <small>
		<img src="/resource/images/icon-lbt.png" class="img-rounded"></img>
                公司管理系统
                </small>
            </a><!--/.brand-->
            <ul class="nav ace-nav pull-right">

        <!-- profile start -->
        <li class="light-blue user-profile">
            <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                <img class="nav-user-photo" src="/resource/avatars/avatar2.png">
					<span id="user_info" style='width:80px'>
                欢迎,
                <?php 
                $user = CI_Controller::getSessionUserInfo();
                $name = $user['name'];
                echo $name;
                ?>
                </span>
                <i class="icon-caret-down"></i>
            </a>

            <ul class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer" id="user_menu">
                <!--li>
                    <a href="#">
                        <i class="icon-cog"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                    <i class="icon-user"></i>
                    Profile
                    </a>
                </li>
                <li class="divider"></li-->
                <li>
                    <a href="/login/logout"><i class="icon-off"></i>退出</a>
                </li>
            </ul>
        </li> <!-- profile end-->


    </ul><!--/.ace-nav-->
    </div><!--/.container-fluid-->
    </div><!--/.navbar-inner-->
    </div>

    <div class="container-fluid" id="main-container">

        <a id="menu-toggler" href="#">
        <span></span>
        </a>

        <! -- nav start -->
        <div id="sidebar">
            <ul class="nav nav-list">
                <li>
                    <a href="/">
                    <i class="icon-dashboard"></i>
                    <span>欢迎页</span>
                    </a>
                </li>

                <li class="open">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-edit"></i><span>员工管理</span><b class="arrow icon-angle-down"></b> 
                    </a>
                    <ul class="submenu" style="display: none;">
                        <li id="li_employee_listAll"><a href="/employee/listAll"><i class="icon-double-angle-right"></i>员工列表</a></li>
                <?php 
                $role = $user['role'];
                if(($role==1) || ($role==2)){
                ?>
                        <li id="li_employee_add"><a href="/employee/add"><i class="icon-double-angle-right"></i>添加员工</a></li>
                <?php
                }
                ?>
                        <li id="li_employee_personal"><a href="/employee/personal"><i class="icon-double-angle-right"></i>个人信息</a></li>
                        <li id="li_employee_setpwd"><a href="/employee/setpwd"><i class="icon-double-angle-right"></i>修改密码</a></li>
                    </ul>
                </li>

                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-edit"></i><span>项目管理</span><b class="arrow icon-angle-down"></b> 
                    </a>
                    <ul class="submenu" style="display: none;">
                        <li id="li_project_viewAll"><a href="/project/viewAll"><i class="icon-double-angle-right"></i>项目浏览</a></li>
						
                        <?php 
                        $role = $user['role'];
                        if(($role==1) || ($role==3) || ($role==4)){
                        ?>
                        <li id="li_project_listAll"><a href="/project/listAll"><i class="icon-double-angle-right"></i>项目编辑</a></li>
						
                            <li id="li_project_add"><a href="/project/add"><i class="icon-double-angle-right"></i>创建项目</a></li>
                        <?php
                        }
                        ?>

                    </ul>
                </li>

                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-edit"></i><span>工时管理</span><b class="arrow icon-angle-down"></b> 
                    </a>
                    <ul class="submenu" style="display: none;">
                        <li id="li_timesheet_listAll"><a href="/timesheet/listAll"><i class="icon-double-angle-right"></i>工时单提交</a></li>
                        <li id="li_timesheet_approve"><a href="/timesheet/approve"><i class="icon-double-angle-right"></i>工时单审批</a></li>
                        <li id="li_timesheet_report"><a href="/timesheet/report"><i class="icon-double-angle-right"></i>工时单报表</a></li>
                    </ul>
                </li>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-edit"></i><span>供应商管理</span><b class="arrow icon-angle-down"></b> 
                    </a>
                            <?php
                            $role = $user['role'];
                            $deptId = $user['department'];
                            if(($role==1) || ($deptId==3 || $deptId==1)){
                            ?>
                    <ul class="submenu" style="display: none;">
                        <li id="li_supplier_listAll"><a href="/supplier/listAll"><i class="icon-double-angle-right"></i>Supplier List</a></li>
						<?php 
						if(($role==1) || ($role==7 || $deptId==1)){
						?>
								<li id="li_supplier_add"><a href="/supplier/add"><i class="icon-double-angle-right"></i>Add Supplier</a></li>
                                                <?php
                                                }}
						?>
                    </ul>
                </li>
				<?php 
				$role = $user['role'];
				if($role==1){
				?>
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-edit"></i><span>设置</span><b class="arrow icon-angle-down"></b> 
                    </a>
                    <ul class="submenu" style="display: none;">
                        <li id="li_settings_listDepartments"><a href="/settings/listDepartments"><i class="icon-double-angle-right"></i>部门设置</a></li>
                        <li id="li_settings_listPositions"><a href="/settings/listPositions"><i class="icon-double-angle-right"></i>职位设置</a></li>
                    </ul>
                </li>
				<?php
				}
				?>

            </ul><!--/.nav-list-->
        </div>
        <! -- nav end -->
