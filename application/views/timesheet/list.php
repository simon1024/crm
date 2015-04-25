<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">工时单模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">{title}</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
        <div class="page-header position-relative">
            <h1>{title}</h1>
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
                    工作时间: {timeRange}
                    
                    </label>
                    <span class="btn btn-info btn-small tooltip-info" data-rel="tooltip" data-placement="bottom" title="" data-original-title="查询前一周工时" id="pre_week_timesheet">《上周</span>
                    <span class="btn btn-info btn-small tooltip-info" data-rel="tooltip" data-placement="bottom" title="" data-original-title="查询本周工时" id="current_week_timesheet">本周</span>
                    <span class="btn btn-info btn-small tooltip-info" data-rel="tooltip" data-placement="bottom" title="" data-original-title="查询下一周工时" id="next_week_timesheet">下周》</span>
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
                                    <input type="checkbox" value=0  id="chk_all"><span class="lbl"></span>
                                </label>
                            </th>
                            <th>类型</th>
                            <th>所属项目</th>
                            <th>所属任务</th>
                            <th class="hidden-480">周一</th>
                            <th class="hidden-480">周二</th>
                            <th class="hidden-480">周三</th>
                            <th class="hidden-480">周四</th>
                            <th class="hidden-480">周五</th>
                            <th class="hidden-480">周六</th>
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
                            <td>
                                <label>
                                    <input name="ts_id" type="checkbox" value="{id}"><span class="lbl"></span>
                                </label>
                            </td>
                            <td style="width:80px">
                                <span class="label label-success arrowed-in arrowed-in-right">{tsTypeName}</span>
                            </td>
                            <td>{projectName}</td>
                            <td style="width:80px">{taskName}</td>
                            <td><input type="text" class="input_ts_hours"  name="day1_hours" value="{day1_hours}"></td>
                            <td><input type="text" class="input_ts_hours"  name="day2_hours" value="{day2_hours}"></td>
                            <td><input type="text" class="input_ts_hours"  name="day3_hours" value="{day3_hours}"></td>
                            <td><input type="text" class="input_ts_hours"  name="day4_hours" value="{day4_hours}"></td>
                            <td><input type="text" class="input_ts_hours"  name="day5_hours" value="{day5_hours}"></td>
                            <td><input type="text" class="input_ts_hours"  name="day6_hours" value="{day6_hours}"></td>
                            <td><input type="text" class="input_ts_hours"  name="day7_hours" value="{day7_hours}"></td>
                            
                            <td name="total_hours">{total_hours}</td>
                            <td id="approve_status_{id}">{approveName}<br/><font color='red'>{approve_comments}</font></td>


                        <td class="td-actions">
                            <div class="hidden-phone visible-desktop btn-group">'
                                <button class="btn btn-mini btn-success" onclick="updateTimeSheet(this, {id})"><i class="icon-save bigger-120"></i></button>
                                <button class="btn btn-mini btn-danger" onclick="delTimeSheet(this, {id})"><i class="icon-trash bigger-120"></i></button>
                            </div>
                        </td>

                        </tr>
                        {/timeSheetList}
                    </tbody>
                    <tfoot>
                        <tr class="selected">
                            <td>
                                <label>
                                </label>
                            </td>
                            <td colspan="3">
                                合计(正常+OH/休假)
                            </td>
                            <td>{days1_normalTotal}</td>
                            <td>{days2_normalTotal}</td>
                            <td>{days3_normalTotal}</td>
                            <td>{days4_normalTotal}</td>
                            <td>{days5_normalTotal}</td>
                            <td>{days6_normalTotal}</td>
                            <td>{days7_normalTotal}</td>
                            <td>{normalTotal}</td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr class="selected">
                            <td>
                                <label>
                                </label>
                            </td>
                            <td colspan="3">
                                合计(正常+加班+OH/休假)
                            </td>
                            <td>{days1_total}</td>
                            <td>{days2_total}</td>
                            <td>{days3_total}</td>
                            <td>{days4_total}</td>
                            <td>{days5_total}</td>
                            <td>{days6_total}</td>
                            <td>{days7_total}</td>
                            <td>{allTotal}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <button class="btn btn-primary" id="add_timesheet_btn"> <i class="icon-pencil bigger-125"></i> 新增工时单 </button>
                <button class="btn btn-primary  no-radius" onclick="approveTimeSheet()" id="approve_timesheet_btn">
                    <i class="icon-share-alt"></i>
                    <span class="hidden-phone">提交审批</span>
                </button>

                <div style="float:right">
                    <button class="btn btn-success" id="add_ot_timesheet_btn"> <i class="icon-pencil bigger-125"></i> 新增加班 </button>
                    <button class="btn btn-success" id="add_oh_timesheet_btn"> <i class="icon-pencil bigger-125"></i> 新增OH</button>
                    <button class="btn btn-success" id="add_leave_timesheet_btn"> <i class="icon-pencil bigger-125"></i> 新增休假 </button>
                </div>
            </div><!--/span-->
        </div> <!-- row-fluid -->

    </div> <!--  page-content end -->
</div>

<table id="add_timesheet_row" style="display:none">
    <tr class="selected timesheet_row">
        <td>编号</td>
        <td>正常工时</td>
        <td>
            <select  id="project_id" name="project_id" class='filter_100'  onchange="changeTaskList(this)">
                <option value="0">请选择</option>
                {projectList}
                <option value="{id}">{name}</option>
                {/projectList}
            </select>
        </td>
        <td class="ts_new_row_taskid_td" id="csb">
             <select name="task_id" class="selectpicker" style="width:80px;">
                <option value="0">请选择</option>
              </select>
        </td>
        <td><input type="text" class="input_ts_hours"  name="day1_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day2_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day3_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day4_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day5_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day6_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day7_hours" value=""></td>
        <td><input type="hidden" name="type" value="{timeSheetType}"/>0</td>
        <td>新增</td>
        <td class="td-actions">
            <div class="hidden-phone visible-desktop btn-group">'
                <button class="btn btn-mini btn-success" onclick="addTimeSheet(this)"><i class="icon-save bigger-120"></i></button>
                <button class="btn btn-mini btn-danger" onclick="delFakeTimeSheet(this)"><i class="icon-trash bigger-120"></i></button>
            </div>
        </td>
    </tr>
</table>



<table id="add_ot_timesheet_row" style="display:none">
    <tr class="selected timesheet_row">
        <td>编号</td>
        <td>加班工时</td>
        <td>
            <select  id="project_id" name="project_id" class='filter_100'  onchange="changeTaskList(this)">
                <option value="0">请选择</option>
                {projectList}
                <option value="{id}">{name}</option>
                {/projectList}
            </select>
        </td>
        <td class="ts_new_row_taskid_td" id="csb">
            <!--input type="text" class="input_select_task" name="task_name" placeholder="请选择" value="" onclick="selectTask(this)"/>
            <input name="task_id" type="hidden" value="1"/-->
             <select name="task_id" class="selectpicker" style="width:80px;">
                <option value="0">请选择</option>
              </select>
        </td>
        <td><input type="text" class="input_ts_hours"  name="day1_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day2_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day3_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day4_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day5_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day6_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day7_hours" value=""></td>
        <td><input type="hidden" name="type" value="2"/>0</td>
        <td>新增</td>
        <td class="td-actions">
            <div class="hidden-phone visible-desktop btn-group">'
                <button class="btn btn-mini btn-success" onclick="addTimeSheet(this)"><i class="icon-save bigger-120"></i></button>
                <button class="btn btn-mini btn-danger" onclick="delFakeTimeSheet(this)"><i class="icon-trash bigger-120"></i></button>
            </div>
        </td>
    </tr>
</table>


<table id="add_oh_timesheet_row" style="display:none">
    <tr class="selected timesheet_row">
        <td>编号</td>
        <td>OH工时</td>
        <td>
            <select  name="project_id" class='filter_100' >
                <option value="0">请选择</option>
                {ohProjectList}
                <option value="{id}">{name}</option>
                {/ohProjectList}
            </select>
        </td>
        <td class="ts_new_row_taskid_td">
            <!--input type="text" class="input_select_task" name="task_name" placeholder="请选择" value="" onclick="selectTask(this)"/>
            <input name="task_id" type="hidden" value="1"/-->
             <select name="task_id" class="selectpicker" style="width:80px;">
                <option value="0">请选择</option>
                {ohTaskList}
                <option value="{id}">{name}</option>
                {/ohTaskList}
              </select>
        </td>
        <td><input type="text" class="input_ts_hours"  name="day1_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day2_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day3_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day4_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day5_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day6_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day7_hours" value=""></td>
        <td><input type="hidden" name="type" value="3"/>0</td>
        <td>新增</td>
        <td class="td-actions">
            <div class="hidden-phone visible-desktop btn-group">'
                <button class="btn btn-mini btn-success" onclick="addTimeSheet(this)"><i class="icon-save bigger-120"></i></button>
                <button class="btn btn-mini btn-danger" onclick="delFakeTimeSheet(this)"><i class="icon-trash bigger-120"></i></button>
            </div>
        </td>
    </tr>
</table>


<table id="add_leave_timesheet_row" style="display:none">
    <tr class="selected timesheet_row">
        <td>编号</td>
        <td>休假工时</td>
        <td>
            <select  name="project_id" class='filter_100' >
                <option value="0">请选择</option>
                {leaveProjectList}
                <option value="{id}">{name}</option>
                {/leaveProjectList}
            </select>
        </td>
        <td class="ts_new_row_taskid_td">
            <!--input type="text" class="input_select_task" name="task_name" placeholder="请选择" value="" onclick="selectTask(this)"/>
            <input name="task_id" type="hidden" value="1"/-->
             <select name="task_id" class="selectpicker" style="width:80px;">
                <option value="0">请选择</option>
                {leaveTaskList}
                <option value="{id}">{name}</option>
                {/leaveTaskList}
              </select>
        </td>
        <td><input type="text" class="input_ts_hours"  name="day1_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day2_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day3_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day4_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day5_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day6_hours" value=""></td>
        <td><input type="text" class="input_ts_hours"  name="day7_hours" value=""></td>
        <td><input type="hidden" name="type" value="4"/>0</td>
        <td>新增</td>
        <td class="td-actions">
            <div class="hidden-phone visible-desktop btn-group">'
                <button class="btn btn-mini btn-success" onclick="addTimeSheet(this)"><i class="icon-save bigger-120"></i></button>
                <button class="btn btn-mini btn-danger" onclick="delFakeTimeSheet(this)"><i class="icon-trash bigger-120"></i></button>
            </div>
        </td>
    </tr>
</table>



<script src="/resource/js/my/timesheet.js"></script>
<script src="/resource/js/bootstrap-tableselect.js"></script>
<script>
<?php
foreach($taskList as $pid=>$allTask){
    echo "var task_{$pid} = ''; \n";
    foreach($allTask as $tid=>$task){
        if(empty($allTask[$tid]['subTask'])){
            echo "task_{$pid} += \"<optgroup label='{$task['taskName']}'><option value='{$task['tid']}'>{$task['taskName']}</option></optgroup>\"; \n"; 
        }else{
            echo "task_{$pid} += \"<optgroup label='" . $allTask[$tid]['subTask'][0]['taskName'] . "'>\"; \n"; 
            foreach($allTask[$tid]['subTask'] as $subTask){
                echo "task_{$pid} += \"<option value='{$subTask['subTaskId']}'>{$subTask['subTaskName']}</option>\"; \n"; 
            }
            echo "task_{$pid} += '</optgroup>'; \n"; 
        }
    }
}
?>
</script>
