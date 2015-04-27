<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">财务管理</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">统计报表</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
      <div>
        <h2>表一汇总（按人头所有项目）</h2>
      </div>

      <div class="row-fluid">
        <div class="span6"  style='margin-left:5px'>
            <label>开始时间:</label>
            <input class="span10 date-picker range_startTime" id="start_time_1" type="text" data-date-format="yyyy-mm-dd" name="startTime"  placeholder="请点击选择开始时间" style="width:150px;">
            <label>结束时间:</label>
            <input class="span10 date-picker range_endTime" id="end_time_1" type="text" data-date-format="yyyy-mm-dd" name="endTime"  placeholder="请点击选择结束时间" style="width:150px;">
        </div>

        <div class="span4">
          <button class="btn btn-small btn-primary" style="margin-bottom:10px" onclick="downEmployeeReport()"><i class=" icon-download bigger-120"></i>导出结果</button>
        </div>
      </div>

      <br/>
      <div class="page-header"></div>

      <div>
        <h2>表二系统数据汇总表</h2>
      </div>
      <div class="row-fluid">
        <div class="span6"  style='margin-left:5px'>
            <label>开始时间:</label>
            <input class="span10 date-picker range_startTime" id="start_time_2" type="text" data-date-format="yyyy-mm-dd" name="startTime"  placeholder="请点击选择开始时间" style="width:150px;">
            <label>结束时间:</label>
            <input class="span10 date-picker range_endTime" id="end_time_2" type="text" data-date-format="yyyy-mm-dd" name="endTime"  placeholder="请点击选择结束时间" style="width:150px;">
        </div>
        <div class="span4">
            <button class="btn btn-small btn-primary" style="margin-bottom:10px" onclick="downProjectReport()"><i class=" icon-download bigger-120"></i>导出结果</button>
        </div>
      </div>

      <br/>
      <div class="page-header"></div>

      <div>
        <h2>表三-按单个项目汇总</h2>
      </div>
      <div class="row-fluid">
        <div class="span5"  style='margin-left:5px'>
            <label>开始时间:</label>
            <input class="span10 date-picker range_startTime" id="start_time_3" type="text" data-date-format="yyyy-mm-dd" name="startTime"  placeholder="请点击选择开始时间" style="width:150px;">
            <label>结束时间:</label>
            <input class="span10 date-picker range_endTime" id="end_time_3" type="text" data-date-format="yyyy-mm-dd" name="endTime"  placeholder="请点击选择结束时间" style="width:150px;">
        </div>
      <!-- </div> -->
      <!-- <div class="row-fluid"> -->
        <div class="span4">
            <label>项目:</label>
            <input type="text" placeholder="输入项目名进行搜索" name="projectName" id="project_autocomplete">
        </div>
        <div class="span2">
          <button class="btn btn-small btn-primary" style="margin-bottom:10px" onclick="downOneProjectReport()"><i class=" icon-download bigger-120"></i>导出结果</button>
        </div>
      </div>
      <br/>
    </div><!-- page-content end-->
</div>

<script src="/resource/js/my/finance.js"></script>
<script>
$(function() {
        var availableTags = [
        {projectList}
            {label:"{name}", value:'{no}'},
        {/projectList}
        ];
        $( "#project_autocomplete" ).autocomplete({
            source: availableTags,
            minChars:0
        });

});
</script>
