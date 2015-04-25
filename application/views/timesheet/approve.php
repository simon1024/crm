<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">工时单模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">工时单审批</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
        <div class="page-header position-relative">
            <h1>工时单审批</h1>
        </div><!--/.page-header-->

        <!-- search start -->
        <div class="row-fluid">

            <div class="span6 filter_item" style='width:35%'>
                <div class="dataTables_length">
                    <label>
                    项目: 
                    <select  id="filter_pid" name="filter_pid" class='filter_200'>
                        <option value="0">不限</option>
                        {projectList}
                        <option value="{id}">{name}</option>
                        {/projectList}
                    </select>
                </div>
            </div>
            <div class="span6 filter_item"  style='width:35%'>
                <div class="dataTables_length">
                    <label>
                    工时单类型: 
                    <select  id="filter_type" name="type" class='filter_200'>
                        <option value="0">不限</option>
                        <option value="1">正常工时</option>
                        <option value="2">加班工时</option>
                        <option value="3">OH工时</option>
                        <option value="4">休假工时</option>
                    </select>
                    </label>
                </div>
           </div>
        </div> <!-- row-fluid end -->
        <!-- search end -->



        <div class="row-fluid">
            <div class="span12">
                <table id="table_timesheet_list" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>
                                <label>
                                    <input type="checkbox" value="0" id="chk_all"><span class="lbl"></span>
                                </label>
                            </th>
                            <th>姓名</th>
                            <th>所属项目</th>
                            <th>所属任务</th>
                            <th>类型</th>
                            <th class="hidden-480">周一</th>
                            <th class="hidden-480">周二</th>
                            <th class="hidden-480">周三</th>
                            <th class="hidden-480">周四</th>
                            <th class="hidden-480">周五</th>
                            <th class="hidden-480">周六</th>
                            <th class="hidden-480">周日</th>
                            <!-- add -->
                            <th class="hidden-480">总计</th>
                            <th class="hidden-480">时间</th>
                            <th>状态</th>
                        </tr>
                    </thead>

                    <tbody>
                        {timeSheetList}
                        <tr class="selected">
                            <td>
                                <label>
                                    <input name="ts_id" type="checkbox" value="{id}"><span class="lbl"></span>
                                </label>
                            </td>
                            <td>{employeeName}</td>
                            <td>{projectName}</td>
                            <td style="width:80px">{taskName}</td>
                            <td style="width:80px">
                                <span class="label label-success arrowed-in arrowed-in-right">{tsTypeName}</span>
                            </td>
                            <td>{day1_hours}</td>
                            <td>{day2_hours}</td>
                            <td>{day3_hours}</td>
                            <td>{day4_hours}</td>
                            <td>{day5_hours}</td>
                            <td>{day6_hours}</td>
                            <td>{day7_hours}</td>
                            <td name="total_hours">{total_hours}</td>
                            <td>{range_key}</td>
                            <td id="approve_status_{id}">{approveName}</td>
                        </tr>
                        {/timeSheetList}
                    </tbody>
                </table>
                <button id="timesheet_approve_success_btn" class="btn btn-success"><i class="icon-ok bigger-150"></i>审批通过</button>
                <button  class="btn btn-danger"  data-toggle="modal" data-target="#myModal"><i class="icon-undo bigger-150"></i>审批不通过</button>
            </div><!--/span-->
        </div> <!-- row-fluid -->



    </div> <!--  page-content end -->
</div>



<!-- poup -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">请填写拒绝理由</h3>
    </div>
    <div class="modal-body">
        <textarea cols="50" rows="3" style="width:400px" name="reject_comments" id="reject_comments"></textarea>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
        <button class="btn btn-primary" id="timesheet_approve_failure_btn">提交</button>
    </div>
</div>



<script src="/resource/js/my/timesheet.js"></script>
<script>
$(function(){ 
    $('#filter_pid').val({sel_pid});
    $('#filter_type').val({sel_typeId});
});
</script>
