<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">项目模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">项目编辑</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
        <div class="page-header position-relative">
            <h1>项目编辑</h1>
        </div><!--/.page-header-->

        <!-- search start -->
        <div class="row-fluid">

            <div class="span3 filter_item" style='width:30%'>
                <div class="dataTables_length">
                    <label>
                    项目编号: <input type="text"  name="search_no" id="search_no"  placeholder="请输入项目编号">
                    </label>
                </div>
            </div>
            <div class="span3 filter_item" style='width:30%'>
                <div class="dataTables_length">
                    <label>
                    项目名称: <input type="text"  name="search_name" id="search_name"  placeholder="请输入项目名字">
                    </label>
                </div>
            </div>
            <div class="span3 filter_item"  style='width:30%'>
                <div class="dataTables_length">
                    <label>
                    项目类型: 
                    <select  id="search_type" name="type" class='filter_200'>
                        <option value="0">不限</option>
                        {ptList}
                        <option value="{id}">{name}</option>
                        {/ptList}
                    </select>
                    </label>
                </div>
           </div>
           <div style='clear:both'></div>
           <div class="span3 filter_item"  style='width:30%;margin-left:0'>
                <div class="dataTables_length">
                    <label>
                    项目状态: 
                    <select  id="search_status" name="type"  class='filter_200'>
                        <option value="0">不限</option>
                        {pstList}
                        <option value="{id}">{name}</option>
                        {/pstList}
                    </select>
                    </label>
                </div>
           </div>

           <div class="span3 filter_item"  style='width:45%'>
                <div class="dataTables_length">
                    <label>
                    时间范围: 
                    <select  id="search_timeRange" name="type"  class='filter_200'>
                        <option value="0">不限</option>
                        <option value="2013~2014">2013 - 2014</option>
                        <option value="2012~2013">2012 - 2013</option>
                        <option value="2011~2012">2011 - 2012</option>
                        <option value="2010~2011">2010 - 2011</option>
                    </select>
                    </label>
                    <span class="btn btn-info btn-small tooltip-info" data-rel="tooltip" data-placement="bottom" title="" data-original-title="高级查询" id="advanceProjectQuery">查询</span>

                    <span class="btn btn-info btn-small tooltip-info" data-rel="tooltip" data-placement="bottom" title="" data-original-title="重置" id="resetProjectQuery">重置</span>
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
                            <th>项目编号</th>
                            <th>项目名称</th>
                            <th class="hidden-480">项目类型</th>
                            <th class="hidden-480">项目经理</th>
                            <th class="hidden-480">完成百分比</th>
                            <!-- add -->
                            <th class="hidden-480">项目状态</th>
                            <th class="hidden-480">预计完成时间</th>
                            <th class="hidden-480">计划开始时间</th>
                            <th class="hidden-480">计划结束时间</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        {projectList}
                        <tr class="selected">
                            <!--td class="center">
                                <label><input type="checkbox"><span class="lbl"></span></label>
                            </td-->
                            <td>{no}</td>
                            <td>{name}</td>
                            <td>{typeName}</td>
                            <td>{pmName}</td>
                            <td>{progress}</td>
                            <td>{statusName}</td>
                            <td>{ex_endTime}</td>
                            <td>{startTime}</td>
                            <td>{endTime}</td>
                            <td style="text-align:center;width:60px;">

                                <?php
                                $user = CI_Controller::getSessionUserInfo();
                                $roleId = $user['role'];
                                if($roleId == 1 || $roleId ==3 || $roleId==4){
                                
                                    ?>

                                <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-placement="left" data-original-title="编辑"  onclick="toUpdateProject({id})" style="text-decoration:none">
                                    <span class="green"><i class="icon-edit bigger-120"></i></span>
                                </a>&nbsp;&nbsp;

                                <!--button class="btn btn-mini btn-success" onclick="toUpdateProject({id})"><i class="icon-edit bigger-120"></i></button-->

                                <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-placement="left" data-original-title="删除"  onclick="toDelProject({id})"  style="text-decoration:none">
                                    <span class="red"><i class="icon-trash bigger-120"></i></span>
                                </a>
                                <!--button class="btn btn-mini btn-danger" onclick="toDelProject({id})"><i class="icon-trash bigger-120"></i></button-->
                                    <?php
                                }
                                ?>
                                <!--button class="btn btn-mini btn-info" onclick="toViewReport({id})"><i class="icon-signal bigger-120"></i></button-->
                            </td>
                        </tr>
                        {/projectList}
                    </tbody>
                </table>
            </div><!--/span-->
        </div> <!-- row-fluid -->

        <!-- pagenation start -->
        <div class="row-fluid">
            <div class="span6">
                <div class="dataTables_info" id="table_report_info">总共: {total} 条记录</div>
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


<script src="/resource/js/my/project.js"></script>
<script>
$(function(){ 
    $('#search_no').val('{search_no}');
    $('#search_name').val('{search_name}');
    $('#search_status').val({search_status});
    $('#search_type').val({search_type});
    $('#search_timeRange').val('{search_timeRange}');
});
</script>
