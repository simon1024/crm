<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Export</title>
    </head>
    <body>
                <table id="table_timesheet_list" class="table table-striped table-bordered table-hover"  border=1 bordercolor=gray cellspaciing=0 cellpading=0 style="border-collapse:collapse">
                    <caption style='font-size:14px;'><b>{projectName}&nbsp;&nbsp;人工成本统计报表</b></caption>
                    <thead>
                        <tr>
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
                                <!--th>{key}加班工时</th-->
                            {/monthList}
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($userList as $uid=>$user){
                            ?>
                        <tr class="selected">
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

</body>
</html>
