<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">设置模块</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">{title}</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
        <div class="page-header position-relative">
            <h1>{title}</h1>
        </div><!--/.page-header-->

        <div class="row-fluid">
            <div class="span12">
                <table id="table_dept_list" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>部门名称</th>
                            <th>审批人</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
						{deptList}
                        <tr class="selected">
                            <td><input type="text" name="dept_name" value="{dname}"></td>
                            <td><input type="text" name="dept_approver" value="{ename}" id="auto"></td>
							<td class="td-actions">
								<div class="hidden-phone visible-desktop btn-group">'
									<button class="btn btn-mini btn-success" onclick="updateDept(this, {id})"><i class="icon-save bigger-120"></i></button>
									<button class="btn btn-mini btn-danger" onclick="delDept(this, {id})"><i class="icon-trash bigger-120"></i></button>
								</div>
							</td>
                        </tr>
                        {/deptList}
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                <button class="btn btn-primary" id="add_dept_btn"> <i class="icon-pencil bigger-125"></i> 新增部门 </button>

            </div><!--/span-->
        </div> <!-- row-fluid -->
    </div> <!--  page-content end -->
</div>

<table id="add_dept_row" style="display:none">
    <tr class="selected dept_row">
		<td><input type="text" name="dept_name" value=""></td>
		<td><input type="text" name="dept_approver" placeholder="输入拼音进行搜索" id="approver_autocomplete"></td>
        <td class="td-actions">
            <div class="hidden-phone visible-desktop btn-group">'
                <button class="btn btn-mini btn-success" onclick="addDept(this)"><i class="icon-save bigger-120"></i></button>
                <button class="btn btn-mini btn-danger" onclick="delFakeDept(this)"><i class="icon-trash bigger-120"></i></button>
            </div>
        </td>
    </tr>
</table>

<script src="/resource/js/bootstrap-tableselect.js"></script>
<script src="/resource/js/my/settings.js"></script>
<script>
$(function() {
        var availableTags = [
			"aaa",
			"bbb"
        ];
        $( "#auto" ).autocomplete({
            source: availableTags,
            minChars:0
        });

});
</script>
