<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="/supplier/listAll">供应商管理</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">供应商评分</li>
        </ul><!--.breadcrumb-->
    </div>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>Evaluate</h1>
    </div><!--/.page-header-->

    <form id="form_addScore" class="form-horizontal" method="post">
        <input id="hidden_sid" type="hidden" name="sid" placeholder=""  value="{sid}">
        <table id="table_detail_score" class="table table-striped table-bordered table-hover" style="width:80%">
            <tbody>
                <tr>
                <th colspan=1> Project Name: </th>
                <td colspan=5> <input type="text" style="width:500px" placeholder="" name="project_name"> </td>
                </tr>
                <tr>
                <th colspan=1> Project Location: </th>
                <td colspan=5> <input type="text" style="width:500px" placeholder="" name="project_location"> </td>
                </tr>
                <tr>
                <th colspan=1> Project Period: </th>
                <td colspan=5> <input type="text" style="width:500px" name="project_period"> </td>
                </tr>
                <tr>
                <th colspan=1> Project Type: </th>
                <td colspan=5> 
                   <div class='span2'><label class="radio"><input type="radio" name="project_type" value="1" /> EPC </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="project_type" value="2" /> EPCM </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="project_type" value="3" /> COST ESTIMATION </label></div>
                </td>
                </tr>
                <tr>
                <th colspan=1> Inquiry: </th>
                <td colspan=5> 
                   <div class='span2'><label class="radio"><input type="radio" name="inquiry" value="1" onclick="getInquiry(this);"/> YES </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="inquiry" value="2" onclick="getInquiry(this);"/> NO </label></div>
                </td>
                </tr>
                <tr>
                  <th colspan=1>Inquired Product:</th>
                  <td colspan=2 > <input type="text" name="inquired_product"></td>
                  <th colspan=1>Inquired Value:</th>
                  <td colspan=2> <input type="text" name="inquired_value"></td>
                </tr>
                <tr>
                <th colspan=1> Awarded: </th>
                <td colspan=5> 
                   <div class='span2'><label class="radio"><input type="radio" name="awarded" value="1" /> Awarded by LBT </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="awarded" value="2" /> Awarded by Client </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="awarded" value="3" /> Not Awarded </label></div>
                </td>
                </tr>
                <tr>
                  <th colspan=1> Awarded Value:</th>
                  <td colspan=5> <input type="text" style="width:500px" name="awarded_value"> </td>
                </tr>
                <tr>
                <th colspan=1> Prequalification: </th>
                <td colspan=5> 
                   <div class='span2'><label class="radio"><input type="radio" name="prequalification" value="1" /> Approved </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="prequalification" value="2" /> Approved with Condition </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="prequalification" value="3" />Not approved </label></div>
                </td>
                </tr>
                <tr>
                <th colspan=1> Qualification(if any): </th>
                <td colspan=5> 
                   <div class='span2'><label class="radio"><input type="radio" name="qualification" value="1" /> Supplier Survey </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="qualification" value="2" /> Pre-Quotation </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="qualification" value="3" /> End User Inquiry </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="qualification" value="3" /> Others </label></div>
                </td>
                </tr>
                <tr>
                <th colspan=1>Qualification Result:</th>
                <td colspan=5> 
                   <div class='span2'><label class="radio"><input type="radio" name="qualification_result" value="1" /> Approval </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="qualification_result" value="2" /> Approved with comments </label></div>
                   <div class='span2'><label class="radio"><input type="radio" name="qualification_result" value="3" /> Not Approval </label></div>
                </td>
                </tr>
                <tr>
                <th colspan=1> ITEM </thd>
                <th colspan=1> Low </th>
                <th colspan=1> High </th>
                <th colspan=3> Evaluation Standards </th>
                </tr>
                <tr>
                <th colspan=1> Capability(20%): </th>
                <td colspan=2> 
                   <div class='row-fluid'>
                   <div class='span2'><label class="radio"><input id="capability1" type="radio" name="capability" value="1" /> 1 </label></div>
                   <div class='span2'><label class="radio"><input id="capability2" type="radio" name="capability" value="2" /> 2 </label></div>
                   <div class='span2'><label class="radio"><input id="capability3" type="radio" name="capability" value="3" /> 3 </label></div>
                   <div class='span2'><label class="radio"><input id="capability4" type="radio" name="capability" value="4" /> 4 </label></div>
                   <div class='span2'><label class="radio"><input id="capability5" type="radio" name="capability" value="5" /> 5 </label></div>
                   </div>
                </td>
                <td colspan=3> License and Code, R&D and Technical Capability, Facility &Staff, Production Availability, Logistics, Information System </td>
                </tr>
                <tr>
                <th colspan=1> Compliance(10%):</th>
                <td colspan=2> 
                   <div class='row-fluid'>
                   <div class='span2'><label class="radio"><input id="compliance1" type="radio" name="compliance" value="1" /> 1 </label></div>
                   <div class='span2'><label class="radio"><input id="compliance2" type="radio" name="compliance" value="2" /> 2 </label></div>
                   <div class='span2'><label class="radio"><input id="compliance3" type="radio" name="compliance" value="3" /> 3 </label></div>
                   <div class='span2'><label class="radio"><input id="compliance4" type="radio" name="compliance" value="4" /> 4 </label></div>
                   <div class='span2'><label class="radio"><input id="compliance5" type="radio" name="compliance" value="5" /> 5 </label></div>
                   </div>
                </td>
                <td colspan=3> Comply with local regulation, such as Anti-corruption, SHE Performance, IPP,etc.</td>
                </tr>
                <tr>
                <th colspan=1> Financial(20%):</th>
                <td colspan=2> 
                   <div class='row-fluid'>
                   <div class='span2'><label class="radio"><input id="financial1" type="radio" name="financial" value="1" /> 1 </label></div>
                   <div class='span2'><label class="radio"><input id="financial2" type="radio" name="financial" value="2" /> 2 </label></div>
                   <div class='span2'><label class="radio"><input id="financial3" type="radio" name="financial" value="3" /> 3 </label></div>
                   <div class='span2'><label class="radio"><input id="financial4" type="radio" name="financial" value="4" /> 4 </label></div>
                   <div class='span2'><label class="radio"><input id="financial5" type="radio" name="financial" value="5" /> 5 </label></div>
                   </div>
                </td>
                <td colspan=3> Price, Payment term, Warranty, Financial Health </td>
                </tr>
                <tr>
                <th colspan=1> Quality(25%):</th>
                <td colspan=2> 
                   <div class='row-fluid'>
                   <div class='span2'><label class="radio"><input id="quality1" type="radio" name="quality" value="1" /> 1 </label></div>
                   <div class='span2'><label class="radio"><input id="quality2" type="radio" name="quality" value="2" /> 2 </label></div>
                   <div class='span2'><label class="radio"><input id="quality3" type="radio" name="quality" value="3" /> 3 </label></div>
                   <div class='span2'><label class="radio"><input id="quality4" type="radio" name="quality" value="4" /> 4 </label></div>
                   <div class='span2'><label class="radio"><input id="quality5" type="radio" name="quality" value="5" /> 5 </label></div>
                   </div>
                </td>
                <td colspan=3>  QA/QC System, Documents Control, Product Quality, Product Performance</td>
                </tr>
                <tr>
                <th colspan=1> Cooperation & Service(25%):</th>
                <td colspan=2> 
                   <div class='row-fluid'>
                   <div class='span2'><label class="radio"><input id="cooperation1" type="radio" name="cooperation" value="1" /> 1 </label></div>
                   <div class='span2'><label class="radio"><input id="cooperation2" type="radio" name="cooperation" value="2" /> 2 </label></div>
                   <div class='span2'><label class="radio"><input id="cooperation3" type="radio" name="cooperation" value="3" /> 3 </label></div>
                   <div class='span2'><label class="radio"><input id="cooperation4" type="radio" name="cooperation" value="4" /> 4 </label></div>
                   <div class='span2'><label class="radio"><input id="cooperation5" type="radio" name="cooperation" value="5" /> 5 </label></div>
                   </div>
                </td>
                <td colspan=3> Management commitment, Good Correspondence & Communication, Fullfill of delivery obligations, Aftersales service </td>
                </tr>
                <tr>
                <th colspan=1> COMMENTS(satisfactory, unsatisfactory): </th>
                <td colspan=5> <textarea id="comment" rows="5" style="width:500px" placeholder="有什么比较满意的地方？或者不满意的地方？" name="comments"> </textarea></td>
                </tr>
            </tbody>
        </table>
    </form>
        <div>
        <button class="btn btn-primary" type="button" id="addScore_btn" onclick="addScore();">
        <i class="icon-ok bigger-110"></i>
        Submit
        </button>
         &nbsp; &nbsp; &nbsp;
        <button class="btn btn-info" id="backScore_btn" onclick="goBack()">
        <i class="icon-undo bigger-110"></i>
        Back
        </button>
        </div>
</div> <!--  page-content end -->
</div>

<script src="/resource/js/my/supplier.js"></script>

<script>
function getInquiry(obj) {
    var inquiry = $(obj).val();
    var num = 6;
    if(inquiry==1) {
        for(i=1; i < num; i++) {
            $('#capability'+i).removeAttr("disabled");
            $('#compliance'+i).removeAttr("disabled");
            $('#financial'+i).removeAttr("disabled");
            $('#quality'+i).removeAttr("disabled");
            $('#cooperation'+i).removeAttr("disabled");
        }
        $('#comment').removeAttr("disabled");
    }else {
        for(i=0; i < num; i++) {
            $('#capability'+i).attr("disabled", "disabled");
            $('#compliance'+i).attr("disabled", "disabled");
            $('#financial'+i).attr("disabled", "disabled");
            $('#quality'+i).attr("disabled", "disabled");
            $('#cooperation'+i).attr("disabled", "disabled");
        }
        $('#comment').attr("disabled", "disabled");
    }
}

function goBack() {
    window.history.go(-1);
}

</script>
