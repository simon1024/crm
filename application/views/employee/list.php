<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">员工管理</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">员工列表</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
        <div class="page-header position-relative">
            <h1>员工信息</h1>
        </div><!--/.page-header-->

        <!-- search start -->
        <div class="row-fluid">
            <div class="span4">
                <div id="table_report_length" class="dataTables_length">
                    <label>每页显示 20 条
                    <!--select size="1" name="table_report_length" aria-controls="table_report">
                    <option value="10" selected="selected">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    </select--> 
                    记录</label>
                </div>
            </div>
            <div class="span4">
            	<label>筛选:
					<select id="search_employee_dept" name="search_employee_dept"  onchange="search_employee_dept(this)">
						<option value="0">请选择部门</option>
						{deptList}
						<option value="{id}">{name}</option>
						{/deptList}
					</select>
				</label>
            </div>
            <div class="span4">
                <div class="dataTables_filter" id="table_report_filter">
                    <label>搜索: <input type="text" aria-controls="table_report" id="search_employee_name"  placeholder="输入名字，回车进行搜索" style="width:200px"></label>
                </div>
            </div>
        </div>
        <!-- search end -->

        <div class="row-fluid">
            <div class="span12">
                <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <!--th class="center">
                                <label>
                                    <input type="checkbox"><span class="lbl"></span>
                                </label>
                            </th-->
                            <th>员工编号</th>
                            <th>姓名</th>
                            <th class="hidden-480">性别</th>
                            <th class="hidden-phone">所属部门
                            </th>
                            <th class="hidden-480">职位</th>
                            <?php 
                                $user = CI_Controller::getSessionUserInfo();
                                $roleId = $user['role'];
                                if($roleId==1 || $roleId ==2){
                                ?>
                            <th></th>
                            <?php

                                }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        {employeeList}
                        <tr class="selected">
                            <!--td class="center">
                                <label><input type="checkbox"><span class="lbl"></span></label>
                            </td-->
                            <td>{no}</td>
                            <td>{name}</td>
                            <td class="hidden-480">{genderName}</td>
                            <td class="hidden-phone">{department}</td>
                            <td class="hidden-480">
                                {position}
                            </td>
                            <td style="text-align:center;width:120px;" style="text-decoration:none">
                                <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-placement="left" data-original-title="浏览"  onclick="toViewEmployee({id})" style="text-decoration:none">
                                    <span class="info"><i class="icon-eye-open  bigger-120"></i></span>
                                </a>
                                &nbsp;&nbsp;
                            <?php 
                                $user = CI_Controller::getSessionUserInfo();
                                $roleId = $user['role'];
                                $deptId = $user['department'];
                                if($roleId==1 || $roleId ==2){
                                ?>
                                <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-placement="left" data-original-title="编辑"  onclick="toUpdateEmployee({id})" style="text-decoration:none">
                                    <span class="green"><i class="icon-edit bigger-120"></i></span>
                                </a>
                                &nbsp;&nbsp;
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-placement="left" data-original-title="删除"  onclick="toDelEmployee({id})"  style="text-decoration:none">
                                    <span class="red"><i class="icon-trash bigger-120"></i></span>
                                </a>
                                <!--button class="btn btn-mini btn-info"><i class="icon-eye-open bigger-120"></i></button>
                                <button class="btn btn-mini btn-success" onclick="toUpdateEmployee({id})"><i class="icon-edit bigger-120"></i></button>
                                <button class="btn btn-mini btn-danger" onclick="toDelEmployee({id})"><i class="icon-trash bigger-120"></i></button-->
                            </td>

                            <?php

                                }
                            ?>


                        </tr>
                        {/employeeList}
                    </tbody>
                </table>
            </div><!--/span-->
        </div> <!-- row-fluid -->

        <!-- pagenation start -->
        <div class="row-fluid">
            <div class="span6">
                <div class="dataTables_info" id="table_report_info">总共: {total} 条记录
                </div>
            </div>
            <div class="span6">

                <div class="dataTables_paginate paging_bootstrap pagination">
                    <ul>
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- pagenation end -->

    </div> <!--  page-content end -->
</div>


<script src="/resource/js/my/employee-add.js"></script>
