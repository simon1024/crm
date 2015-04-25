<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="/supplier/listAll">供应商管理</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">编辑供应商</li>
        </ul>
    </div>

<div id="page-content" class="clearfix">
  {basicInfo}
  <div class="row" >
    <!-- <div class="page-header position-relative"> -->
    <div class="span10">
        <h1 style="color:#2679b5; font-size: 24px; font-weight:lighter">{chName} {enName}</h1>
    </div>
    <div class="span1" align="right">
        <h1 style="color:#2679b5; font-size: 24px; font-weight:lighter">{noStr}</h1>
    </div>
  </div>
    
    <!-- row-fluid start -->
    <div class="row-fluid">
        <div class="span6" style='width:100%'> <!-- span6 start -->
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li id='li_supplier_basic' class='active'>
                        <a data-toggle="tab" href="#supplier_basic"><i class="green icon-home bigger-110"></i>Supplier Information</a>
                    </li>
                    <li id='li_supplier_score'>
                        <a data-toggle="tab" href="#supplier_score"><i class="green icon-rocket bigger-110"></i>Supplier Evaluation<!--span class="badge badge-important">4</span-->
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="supplier_basic" class="tab-pane active"> <!-- supplier_basic start -->
                        <!--PAGE CONTENT BEGINS HERE-->
                        <form class="form-horizontal" method="post" id="form_updateBasicSupplier">
                          <table id="table_supplier_info" class="table  table-striped table-bordered table-hover" style="width:80%">
                            <tbody>
                              <tr>
                                <th style="width:15%">Supplier Name (CH):</th>
                                <td style="width:25%"><input type="text" name="chName" value="{chName}"></td>
                                <th style="width:15%">Supplier Name (EN):</th>
                                <td style="width:25%"><input type="text" name="enName" value="{enName}"></td>
                              </tr>
                              <tr>
                                <th>Country:</th>
                                <td><input type="text" name="country" value="{country}"></td>
                                <th>Location:</th>
                                <td><input type="text" name="city" value="{city}"></td>
                              </tr>
                              <tr>
                                <th>Address:</th>
                                <td colspan=3><input type="text" name="addr" style="width:660px" value="{addr}"></td>
                              </tr>
                              <tr>
                                <th>Zip Code:</th>
                                <td><input type="text" name="zcode" value="{zcode}"></td>
                                <th>Company founded in:</th>
                                <td><input type="text" name="foundDate" value="{foundDate}"></td>
                              </tr>
                              <tr>
                                <th>Registered Capital:</th>
                                <td><input type="text" name="capital" value="{capital}"></td>
                                <th>Number of staff:</th>
                                <td><input type="text" name="staffNum" value="{staffNum}"></td>
                              </tr>
                              <tr>
                                <th>Vendor Type:</th>
                                <td>
                                  <select id="sel_company_type" name="companyType" sel_val="{companyType}">
                                    <option value="0">please select...</option>
                                    {companyTypeList}
                                    <option value="{id}">{tname}</option>
                                    {/companyTypeList}
                                  </select>
                                </td>
                                <th>Vendor Property:</th>
                                <td>
                                <select id="sel_vendor_property" name="vendorProperty" sel_val="{vendorProperty}">
                                  <option value="0">please select...</option>
                                  {vendorPropertyList}
                                  <option value="{id}">{property}</option>
                                  {/vendorPropertyList}
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <th>Major product/Service description:</th>
                                <td colspan=3>
                                  <textarea type="text" name="service" style="width:660px">{service}</textarea>
                                </td>
                              </tr>
                              <tr>
                                <th>Family ID:</th>
                                <td>
                                  <select id="sel_family_id" name="family" onchange="changeCategoryList(this)" sel_val="{familyId}">
                                    <option value="0">please select ...</option>
                                    {familyList}
                                    <option value="{id}">{fname}</option>
                                    {/familyList}
                                  </select>
                                </td>
                                <th>Category ID:</th>
                                <td id="category">
                                  <select id="sel_category_id" name="category" sel_val="{categoryId}">
                                    <option value="0">please select ...</option>
                                    {categoryList}
                                    <option value="{id}">{cname}</option>
                                    {/categoryList}
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th>Sub-Category:</th> 
                                <td><input type="text" name="subCategory" value="{subCategory}"></td>
                                <th>Web site:</th>
                                <td><input type="text" name="website" value="{website}"></td>
                              </tr>
                              <tr>
                                <th>Contact Person's 1</th>
                                <td><input type="text" name="contactor1" value="{contactor1}"></td>
                                <th>Position:</th>
                                <td><input type="text" name="position1" value="{position1}"></td>
                              </tr>
                              <tr>          
                                <th> Tel No: </th>
                                <td> <input type="text" name="telPhone1" value="{telPhone1}"></td>
                                <th> Cell No: </th>
                                <td> <input type="text" name="cellPhone1" value="{cellPhone1}"></td>
                              </tr>
                              <tr>
                                <th>Fax No:</th>
                                <td><input type="text" name="fax1" value="{fax1}"></td>
                                <th>E-Mail:</th>
                                <td><input type="text" name="mail1" value="{mail1}"></td>
                              </tr>
                              <th>Contact Person's 2</th>
                              <td><input type="text" name="contactor2" value="{contactor2}"></td>
                              <th>Position:</th>
                              <td><input type="text" name="position2" value="{position2}"></td>
                              <tr>
                                <th> Tel No: </th>
                                <td> <input type="text" name="telPhone2" value="{telPhone2}"></td>
                                <th> Cell No: </th>
                                <td> <input type="text" name="cellPhone2" value="{cellPhone2}"></td>
                              </tr>
                              <tr>
                                <th>Fax No:</th>
                                <td><input type="text" name="fax2" value="{fax2}"></td>
                                <th>E-Mail:</th>
                                <td><input type="text" name="mail2" value="{mail2}"></td>
                              </tr>
                              <tr>
                                <th> Enterprise qualification(if any):</th>
                                <td colspan=3> 
                                  <textarea type="text" name="qualification" style="width:660px">{qualification}</textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table>

                          <div class="form-actions">
                            <button class="btn btn-info" type="submit" id="updateSupplierForm_btn">
                              <i class="icon-ok bigger-110"></i>
                              Submit
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn btn-info" id="back_btn" onclick="toList()">
                              <i class="icon-ok bigger-110"></i>
                              Back 
                            </button>
                          </div>
                          <input id="hidden_sid" type="hidden" name="sid" placeholder=""  value="{sid}">
                          {/basicInfo}
                        </form>
                    </div> <!-- supplier_basic end -->

                    <!-- supplier_score  start-->
                    <div id="supplier_score" class="tab-pane" align="left">
                        <!--div class="span12"-->
                        <table id="table_total_score" class="table table-striped table-bordered table-hover" style="width:90%">
                          <tr>
                            {basicInfo2}
                            <td colspan="2" style="width:80%"><b>{chName} {enName}</b></td>
                            {/basicInfo2}
                            <td colspan="1"><button class="btn-info" onclick="evaluateSupplier()">Evaluate</button></td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              {totalScore}
                              <b>TTL Scoring: </b>{total}<br/>
                              <b>Awarded Total Value: </b>{awardedTotal}<br/>
                              <b>Inquiry: </b>{inquiry}
                              {/totalScore}
                            </td>
                          </tr>
                        </table>
                        <?php
                           foreach($comments as  $comment){
                        ?>
                        <table id="table_total_score" class="table table-striped table-bordered table-hover" style="width:90%">
                          <tr>
                            <td colspan="1" rowspan="6" style="vertical-align:middle; width:40%">
                              <b>User name: </b><?php echo $comment['evaluator']; ?><br/>
                              <b>date: </b><?php echo $comment['addTime']; ?>
                            </td>
                            <td colspan="2"><b>Inqired Product: </b><?php echo $comment['inquiredProduct']; ?></td>
                          </tr>
                          <tr>
                            <td colspan="2"><b>Project Name: </b><?php echo $comment['projectName']; ?></td>
                          </tr>
                          <tr>
                            <td colspan="1"><b>Project Type: </b><?php echo $comment['projectTypeName']; ?></td>
                            <td colspan="1"><b>project Period: </b><?php echo $comment['projectTime']; ?></td>
                          </tr>
                          <tr>
                            <td colspan="1"><b>Capability(20%): </b><?php echo $comment['capability']; ?></td>
                            <td colspan="1"><b>Quality(25%): </b><?php echo $comment['quality']; ?></td>  
                          </tr>
                          <tr>  
                            <td colspan="1"><b>Compliance(10%): </b><?php echo $comment['compliance']; ?></td> 
                            <td colspan="1"><b>Financial(20%): </b><?php echo $comment['financial']; ?></td> 
                          </tr>
                          <tr>
                           <td colspan="1"><b>Cooperation(25%): </b><?php echo $comment['cooperation']; ?></td> 
                           <td colspan="1"><b>Summary(5): </b><?php echo $comment['total']; ?></td>
                          </tr>  
                          <tr>
                            <td>
                              <b>Prequalification: </b><?php echo $comment['prequalificationName']; ?></br>
                              <b>Qualification: </b><?php echo $comment['qualificationName']; ?></br>
                              <b>Qualification Result: </b><?php echo $comment['qualificationResultName']; ?></br>
                              <b>Inquiry: </b><?php echo $comment['inquiryName']; ?></br>
                              <b>Inquiry Value: </b><?php echo $comment['inquiredValue']; ?></br>
                              <b>Awarded: </b><?php echo $comment['awardedName']; ?></br>
                              <b>Awarded Value: </b><?php echo $comment['awardedValue']; ?>
                            </td>
                            <td colspan="2"><b>Comments(satifactory, unsatisfactory): </b><?php echo $comment['comments']; ?></br>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6" style="align:right">
                              <div align="right">
                              <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-placement="right" data-original-title="删除"  
                                 <?php  echo "  onclick='toDelComment(" . htmlspecialchars($comment['id']) . ")'";  ?>
                                 style="text-decoration:none">
                                <span class="red"><i class="icon-trash bigger-120"></i></span>
                              </a>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <?php
                           }
                        ?>

                    </div><!-- supplier_score end -->

                </div>
            </div>
        </div><!-- span6 end  -->
        
    </div>
    <!-- row-fluid end -->
</div>

<script src="/resource/js/my/supplier.js"></script>


<script>
<?php
foreach($categoryOfFamily as $familyId=>$allCategory){
    echo "var category_{$familyId} = ''; \n";
    foreach($allCategory as $id=>$category){
		echo "category_{$familyId} += \"<option value='{$category['id']}'>{$category['cname']}</option>\"; \n"; 
    }
}
?>
var categoryId = $('#sel_category_id').attr('sel_val');
var familyId = $('#sel_family_id').attr('sel_val');
var html = '<select id="sel_category_id" name="category">';
html += '<option value="0">please select ...</option>';
html += eval('category_'+familyId);
html += '</select>';
$('#category').html(html);

$('#sel_category_id').val(categoryId);
$(function(){ 
    var companyType = $('#sel_company_type').attr('sel_val');
    var familyId = $('#sel_family_id').attr('sel_val');
    var vendorProperty = $('#sel_vendor_property').attr('sel_val');
    $('#sel_company_type').val(companyType);
    $('#sel_family_id').val(familyId);
    $('#sel_vendor_property').val(vendorProperty);
});
</script>

<script>
function changeCategoryList(obj){
    var familyId = $(obj).val();
    var html = '<select id="sel_category_id" name="category">';
        html += '<option value="0">please select ...</option>';
        html += eval('category_'+familyId);
    html += '</select>';
    $('#category').html(html);
}

function evaluateSupplier(){
    var sid = $('#hidden_sid').val();
    window.location.href = '/supplier/score/'+sid;
}

function toList(){
    window.history.go(-1);
}

function toDelComment(id){
    if(!confirm("确定要删除该comment吗？")){
        return false;
    }

    var sid = $('#hidden_sid').val();
    var param = {"id":id, "sid":sid};
    $.ajax({
      url:"/supplier/delComment/"+id+"?time="+ (new Date()).getTime(),
      type:"post",
      data:param,
      dataType:"json",
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('删除comment成功');
                    window.location.reload(true);
                }else{
                    alert(data.msg);
                }
      }
    });
}

</script>
