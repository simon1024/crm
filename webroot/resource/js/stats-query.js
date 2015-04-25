function fetchResult(){
    $.ajax({
        type:'POST',
        url: '/stats/result',
        dataType:'json',
        success:function(result){
            var finished = result.finished;
            if(finished == 'yes'){
                $('#mess_tips').html('');
                if(result.data.length < 1){
                    $('#mess_tips').html('查询结果为空');
                }else{
                    // render.
                    var data        = result.data;
                    var dataLength  = data.length;
                    var pointers    = result.pointers;
                    var pLength     = pointers.length;
                    var html = "<tr>";
                    // render header.
                    for(var p=0; p<pLength; p++){
                        html += "<td>"+pointers[p]+"</td>";
                    }
                    html += "</tr>";
                    for(var d=0;d<dataLength;d++){
                        var item = data[d];
                        for(var i=0;i<item.length;i++){
                            html += "<td>"+item[i]+"</td>";
                        }
                        html += "</tr>";
                    }
                    // render body
                    $('#tb_result').html(html);
                    //alert(result.data.length);
                }
            }else{
                setTimeout('fetchResult()', 5000);
                $('#mess_tips').html('获取结果中......................');
            }
        }
   });
}


$(function(){
    // bind hosts event.
    $('#hosts_all').click(function(e){
        if(this.checked){
            $("input[name='host']").each(function(){this.checked=true;});
        }else{
            $("input[name='host']").each(function(){this.checked=false;});
        }
    });

    $('#biglog_query').click(function(e){
        $('#mess_tips').html('');
        var fl_date = $('#date').val();
        var end_date = $('#end_date').val();
        var hVals = '';
        var pVals = '';
        var filters= '';
        // hosts
        $('[name="host"]:checked').each(function() {
            hVals += $(this).val()+"|";
        });
        // pointers
        $('[name="pointers"]:checked').each(function() {
            pVals += $(this).val()+",";
        });
        // filters
        $('[id^="fl_"]').each(function() {
            filters += $(this).attr('name') + "="+$(this).val()+",";
        });
        // validate
        if(fl_date > end_date){
            $('#mess_tips').html('结束时间不能小于开始时间');
            return false;
        }

        if(hVals==''){
            $('#mess_tips').html('请选择国家');
            return false;
        }
        if(pVals=='' || fl_date==''){
            $('#mess_tips').html('统计指标&日期不能为空');
            return false;
        }
        // send request
        $.ajax({
            type:'POST',
            url: '/stats/query',
            dataType:'json',
            data:{date:fl_date,end_date:end_date, pointers:pVals,filters:filters,hosts:hVals},
            success:function(result){
                var status = result.status;
                if(status == 'no'){
                    $('#mess_tips').html(result.message);
                    return true;
                }
                if(status != 'running'){
                    $('#mess_tips').html('上一个统计任务还没运行结束');
                    return true;
                }
                fetchResult();
            }
       });
        return false;
    });

    // date picker
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var defaultDate = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate()-1, 0, 0, 0, 0);
    $('#date,#end_date').datepicker({
        onRender: function(date) {
            return date.valueOf() >= now.valueOf() ? 'disabled' : '';
        }
    });
    $('#date,#end_date').datepicker('setValue',defaultDate);

});


