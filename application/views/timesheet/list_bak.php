<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">工时单模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">工时单列表</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
        <div class="page-header position-relative">
            <h1>工时单列表</h1>
        </div><!--/.page-header-->

        <!-- search start -->
        <div class="row-fluid">

            <div class="span6 filter_item" style='width:20%'>
                <div class="dataTables_length">
                    <label>
                    员工姓名: 
                    <?php 
                        $user = CI_Controller::getSessionUserInfo();
                        $name = $user['name'];
                        echo $name;
                    ?>
                    </label>
                </div>
            </div>
            <div class="span6 filter_item"  style='width:55%'>
                <div class="dataTables_length">
                    <label>
                    工作时间: 
                    <select  id="search_type" name="type" class='filter_200'>
                        <option value="0">不限</option>
                        {ptList}
                        <option value="{id}">{name}</option>
                        {/ptList}
                    </select>
                    </label>
                    <span class="btn btn-info btn-small tooltip-info" data-rel="tooltip" data-placement="bottom" title="" data-original-title="高级查询" id="advanceProjectQuery">《上周</span>
                    <span class="btn btn-info btn-small tooltip-info" data-rel="tooltip" data-placement="bottom" title="" data-original-title="高级查询" id="advanceProjectQuery">本周</span>
                    <span class="btn btn-info btn-small tooltip-info" data-rel="tooltip" data-placement="bottom" title="" data-original-title="高级查询" id="advanceProjectQuery">下周》</span>
                </div>
           </div>
        </div> <!-- row-fluid end -->
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
                            <th>所属项目</th>
                            <th>所属任务</th>
                            <th class="hidden-480">周一</th>
                            <th class="hidden-480">周二</th>
                            <th class="hidden-480">周三</th>
                            <th class="hidden-480">周四</th>
                            <th class="hidden-480">周五</th>
                            <th class="hidden-480">周刘</th>
                            <th class="hidden-480">周日</th>
                            <!-- add -->
                            <th class="hidden-480">总计</th>
                            <th class="hidden-480">状态</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        {timeSheetList}
                        <tr class="selected">
                            <!--td class="center">
                                <label><input type="checkbox"><span class="lbl"></span></label>
                            </td-->
                            <td>{projectName}</td>
                            <td>{taskName}</td>
                            <td>{day1_hours}</td>
                            <td>{day2_hours}</td>
                            <td>{day3_hours}</td>
                            <td>{day4_hours}</td>
                            <td>{day5_hours}</td>
                            <td>{day6_hours}</td>
                            <td>{day7_hours}</td>
                            <td>{day1_hours+day2_hours}</td>
                            <td>{approveName}</td>
                            <td>
                                <div class="inline position-relative">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-cog icon-only bigger-110"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-icon-only dropdown-light pull-right dropdown-caret dropdown-close">
                                        <li>
                                            <a href="/project/view/{id}" class="tooltip-success" data-rel="tooltip" title="" data-placement="left" data-original-title="浏览">
                                                <span class="green"><i class="icon-only icon-align-justify"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/project/update/{id}" class="tooltip-success" data-rel="tooltip" title="" data-placement="left" data-original-title="修改">
                                                <span class="green"><i class="icon-edit"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-placement="left" data-original-title="删除">
                                                <span class="red"><i class="icon-trash"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        {/timeSheetList}
                    </tbody>
                </table>
            </div><!--/span-->
        </div> <!-- row-fluid -->

        <!-- pagenation start -->
        <div class="row-fluid">
            <div class="span6">
                <!--div class="dataTables_info" id="table_report_info">Showing 1 to 10 of 23 entries</div-->
            </div>
            <div class="span6">

                <div class="dataTables_paginate paging_bootstrap pagination">
                    <ul>
                        <?php //echo $this->pagination->create_links(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- pagenation end -->







    </div> <!--  page-content end -->
</div>


<script src="/resource/js/my/project.js"></script>
