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



<div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
    <div class="row-fluid">
        <div class="span6">
            <div class="DTTT btn-group">
                <a class="btn DTTT_button_text" id="ToolTables_example_0">
                    <span>新增</span>
                </a>
                <a class="btn DTTT_button_text disabled" id="ToolTables_example_1">
                    <span>修改</span>
                </a>
                <a class="btn DTTT_button_text disabled" id="ToolTables_example_2">
                    <span>删除</span>
                </a>
            </div>
        </div>
        <div class="span6">
            <div class="dataTables_filter" id="example_filter">
                <label>
                    Search:
                    <input type="text" aria-controls="example">
                </label>
            </div>
        </div>
    </div>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dataTable DTTT_selectable"
    id="example" aria-describedby="example_info"  style="margin-left:5px">
        <thead>
            <tr role="row">
                <th class="sorting" role="columnheader" tabindex="0">所属项目</th>
                <th class="sorting" role="columnheader" tabindex="0">所属任务</th>
                <th class="sorting" role="columnheader"  tabindex="0">周一</th>
                <th class="sorting" role="columnheader"  tabindex="0">周二</th>
                <th class="sorting" role="columnheader"  tabindex="0">周三</th>
                <th class="sorting" role="columnheader"  tabindex="0">周四</th>
                <th class="sorting" role="columnheader"  tabindex="0">周五</th>
                <th class="sorting" role="columnheader"  tabindex="0">周六</th>
                <th class="sorting" role="columnheader"  tabindex="0">周日</th>
                <th class="sorting" role="columnheader"  tabindex="0">总计</th>
                <th class="sorting" role="columnheader"  tabindex="0">状态</th>
             </tr>
        </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all">

            {timeSheetList}
            <tr id="row_57" class="odd">
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
                <td class="center">{approveName}</td>
            </tr>
            {/timeSheetList}
        </tbody>
    </table>
</div>


</div>


<script type="text/javascript" charset="utf-8" src="/resource/js/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" src="/resource/js/datatables/TableTools.js"></script>
<script type="text/javascript" charset="utf-8" src="/resource/js/datatables/dataTables.editor.js"></script>

<script type="text/javascript" charset="utf-8" src="/resource/js/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" charset="utf-8" src="/resource/js/datatables/dataTables.editor.bootstrap.js"></script>
<script type="text/javascript" charset="utf-8" id="init-code">
    var editor; // use a global for the submit and return data rendering in the examples

    $(document).ready(function() {

        editor = new $.fn.dataTable.Editor( {
            "ajaxUrl": "php/browsers.php",
            "domTable": "#example",
            "fields": [ {
                    "label": "项目:",
                    "name": "project"
                }, {
                    "label": "任务:",
                    "name": "task"
                },{
                    "label": "周一",
                    "name": "day1_hours"
                },{
                    "label": "周二",
                    "name": "day2_hours"
                },{
                    "label": "周三",
                    "name": "day3_hours"
                },{
                    "label": "周四",
                    "name": "day4_hours"
                },{
                    "label": "周五",
                    "name": "day5_hours"
                },{
                    "label": "周六",
                    "name": "day6_hours"
                },{
                    "label": "周日",
                    "name": "day7_hours"
                },{
                    "label": "总计",
                    "name": "total_hours"
                },{
                    "label": "审批状态",
                    "name": "approve_status"
                }
            ]
        } );

        $('#example').dataTable( {
            "sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
            //"sAjaxSource": "php/browsers.php",
            "bPaginate":false,
            "aoColumns": [
                { "mData": "project" },
                { "mData": "task" },
                { "mData": "day1_hours" },
                { "mData": "day2_hours" },
                { "mData": "day3_hours" },
                { "mData": "day4_hours" },
                { "mData": "day5_hours" },
                { "mData": "day6_hours" },
                { "mData": "day7_hours" },
                { "mData": "total_hours" },
                { "mData": "approve_status" , "sClass": "center" }
            ],
            "oTableTools": {
                "sRowSelect": "multi",
                "aButtons": [
                    { "sExtends": "editor_create", "editor": editor },
                    { "sExtends": "editor_edit",   "editor": editor },
                    { "sExtends": "editor_remove", "editor": editor }
                ]
            }
        } );
        $('#example_info').html();
    } );
</script>


