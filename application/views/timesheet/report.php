<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">工时单模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">工时单报表</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
        <div class="page-header position-relative">
            <h1>工时单报表</h1>
        </div><!--/.page-header-->

        <!-- search start -->
        <div class="row-fluid">

            <!--div class="span6 filter_item" style='width:35%'>
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
            </div-->
            <div class="span6 filter_item"  style='width:100%'>
                <div class="dataTables_length">
                    
                    <label>
                    项目: 
                    <select  id="filter_report_pid" name="type" class='filter_200'>
                        <option value="0">请选择</option>
                        <?php
                            foreach($projectList as $proj){
                        ?>
                            <option value="<?php echo $proj['id']?>"><?php echo $proj['name']?></option>
                        <?php
                            }
                        ?>
                    </select>
                    </label>
                    &nbsp;&nbsp;
                    <label>
                    部门: 
                    <select  id="filter_report_dept" name="type" class='filter_200'>
                        <option value="0">请选择</option>
                        <?php
                            foreach($deptList as $dept){
                        ?>
                            <option value="<?php echo $dept['id']?>"><?php echo $dept['name']?></option>
                        <?php
                            }
                        ?>
                    </select>
                    </label>

                    
                </div>
            </div> <!--  span6 filter_item -->

            <div class="span6 filter_item"  style='width:100%;margin-left:5px'>
                <div>
                    <label>
                    员工: 
                    <input type="text" placeholder="" id="search_username"  name="search_username" value="{search_username}" style="width:180px;">
                    </label>
                    <label>开始时间:</label>
                    <input class="span10 date-picker range_startTime" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" name="startTime"  placeholder="请点击选择开始时间" style="width:150px;">
                    <label>结束时间:</label>
                    <input class="span10 date-picker range_endTime" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" name="endTime"  placeholder="请点击选择结束时间" style="width:150px;">

                    <button class="btn btn-small btn-primary" style='margin-bottom:10px;' onclick="queryTimeSheetReport()">查询结果</button>
                    
                    <button class="btn btn-small btn-primary" style='margin-bottom:10px;' onclick="toDownReport({sel_pid})"><i class=" icon-download bigger-120"></i>导出结果</button>


                </div>
            </div>



        </div> <!-- row-fluid end -->
        <!-- search end -->



        <div class="row-fluid">
            <div class="span12">
                <table id="table_timesheet_list" class="table table-striped table-bordered table-hover">
                    <caption style='font-size:14px;'><b>人工成本统计报表</b></caption>
                    <thead>
                        <tr>
                            <!--th rowspan="2"  valign="middle" style="text-align:center;width:100px;">项目</th-->
                            <th rowspan="2"  valign="middle" style="text-align:center;width:100px;">部门</th>
                            <th rowspan="2"  valign="middle" style="text-align:center;width:100px;">姓名</th>
                        <?php 
                        
                            foreach($monthList as $month){
                            ?>
                            <th colspan="4" style='text-align:center'><?php echo $month['key'] ?></th>
                            <?php 
                            }
                        ?>
                        </tr>
                        <tr>
                            {monthList}
                                <th colspan="4">
                                <table style="width:100%">
                                    <tr>
                                        <td style="background:none;border:0;text-align:center;width:60px">正常工时</td>
                                        <td style="background:none;text-align:center;width:60px">加班工时</td>
                                        <td style="background:none;text-align:center;width:60px">OH工时</td>
                                        <td style="background:none;text-align:center;width:60px">休假工时</td>
                                    </tr>
                                </table>
                                </th>
                            {/monthList}
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($userList as $uid=>$user){
                            ?>
                        <tr class="selected">
                            <!--td style="text-align:center"><?php echo $user['projName'];?></td-->
                            <!--td style="text-align:center"><?php echo 'all';?></td-->
                            <td style="text-align:center"><?php echo $user['deptName'];?></td>
                            <td style="text-align:center"><?php echo $user['employeeName'];?></td>
                        <?php 
                        
                            foreach($monthList as $month){
                                $monthKey = $month['key'];
                                $normalHours = $reportList[$monthKey][$uid][1]['total']>0 ? $reportList[$monthKey][$uid][1]['total']: 0;
                                $otHours = $reportList[$monthKey][$uid][2]['total']>0 ? $reportList[$monthKey][$uid][2]['total']: 0;
                                $ohHours = $reportList[$monthKey][$uid][3]['total']>0 ? $reportList[$monthKey][$uid][3]['total']: 0;
                                $lvHours = $reportList[$monthKey][$uid][4]['total']>0 ? $reportList[$monthKey][$uid][4]['total']: 0;
                                //$hours = $reportList[$monthKey][$uid]['total']>0 ? $reportList[$monthKey][$uid]['total']: 0;
                                $monthList[$monthKey]['normal']['total'] += $normalHours;
                                $monthList[$monthKey]['ot']['total'] += $otHours;
                                $monthList[$monthKey]['oh']['total'] += $ohHours;
                                $monthList[$monthKey]['lv']['total'] += $lvHours;
                            ?>
                            <td style="text-align:center;width:60px"><?php echo $normalHours;?></td>
                            <td style="text-align:center;width:60px"><?php echo $otHours;?></td>
                            <td style="text-align:center;width:60px"><?php echo $ohHours;?></td>
                            <td style="text-align:center;width:60px"><?php echo $lvHours;?></td>
                            <?php
                            }
                        ?>
                        </tr>
                            <?php
                        }
                        ?>
                        <tr class="selected">
                            <td style="text-align:center">总计</td>
                            <td style="text-align:center"></td>
                            <!--td style="text-align:center"></td-->
                        <?php 
                            foreach($monthList as $month){
                                $monthKey = $month['key'];
                            ?>
                            <td style="text-align:center"><?php echo $monthList[$monthKey]['normal']['total'];?></td>
                            <td style="text-align:center"><?php echo $monthList[$monthKey]['ot']['total'];?></td>
                            <td style="text-align:center"><?php echo $monthList[$monthKey]['oh']['total'];?></td>
                            <td style="text-align:center"><?php echo $monthList[$monthKey]['lv']['total'];?></td>
                            <?php
                            }
                        ?>
                        </tr>
                    </tbody>
                </table>
                <!--button id="timesheet_approve_success_btn" class="btn btn-success"><i class="icon-ok bigger-150"></i>审批通过</button-->
                <!--button  class="btn btn-danger"  data-toggle="modal" data-target="#myModal"><i class="icon-undo bigger-150"></i>审批不通过</button-->
            </div><!--/span-->
        </div> <!-- row-fluid -->



    </div> <!--  page-content end -->
</div>



<!-- poup -->
<!--div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
</div-->

<script src="/resource/js/my/timesheet.js"></script>
<script>
$(function() {
        var availableTags = [
        {employeeList}
                {label:"{name}{username} {department} {position}", value:'{username}'},
        {/employeeList}
        ];
        $( "#search_username" ).autocomplete({
            source: availableTags,
            minChars:0
        });

});
</script>

<script>
$(function(){ 
    $('#filter_report_username').val('{search_username}');
    $('#filter_report_pid').val({sel_pid});
    $('#filter_report_dept').val({sel_dept});
    $('.range_startTime').val('{sel_start}');
    $('.range_endTime').val('{sel_end}');
});
</script>
