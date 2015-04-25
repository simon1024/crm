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


        <div class="row-fluid">
            <div class="span12">
                <table id="table_timesheet_list" class="table table-striped table-bordered table-hover">
                    <caption style='font-size:14px;'><b>人工成本统计报表</b></caption>
                    <tbody>
                        <tr>
                            <td style="vertical-align:middle;height:200px;text-align:center">没有找到可查看的工时报表</td>
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
