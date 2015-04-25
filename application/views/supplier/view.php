<style tye="text/css">
  .title{font-weight:bold;}
</style>
<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="/supplier/listAll">供应商管理</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">供应商view</li>
        </ul><!--.breadcrumb-->
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

    <div class="span6" style='width:100%'> <!-- span6 start -->
      <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
          <li id='li_supplier_basic' class="active">
            <a data-toggle="tab" href="#supplier_basic"><i class="green icon-home bigger-110"></i>Supplier Information</a>
          </li>
          <li id='li_supplier_score'>
            <a data-toggle="tab" href="#supplier_score"><i class="green icon-rocket bigger-110"></i>Supplier Evaluation<!--span class="badge badge-important">4</span-->
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <input id="hidden_sid" type="hidden" name="sid" placeholder=""  value="{sid}">
          <div id="supplier_basic" class="tab-pane active"> <!-- supplier_basic start -->
            <table id="table_supplier_info" class="table  table-bordered table-hover" style="width:80%">
              <!-- <caption><h1>Supplier Information<h1></caption> -->
              <tbody>
                <tr>
                  <th colspan=1 >Supplier Name (CH):</th>
                  <td colspan=3 >{chName}</td>
                </tr>
                <tr>
                  <th colspan=1 >Supplier Name (EN):</th>
                  <td colspan=3 >{enName}</td>
                </tr>
                <tr>
                  <th colspan=1 >Address:</th>
                  <td colspan=3 >{addr}</td>
                </tr>
                <tr>
                  <th colspan=1 >Location:</th>
                  <td colspan=3 >{city}</td>
                </tr>
                <tr>
                  <th colspan=1 >Country:</th>
                  <td colspan=3>{country}</td>
                </tr>
                <tr>
                  <th colspan=1 >Zip Code:</th>
                  <td colspan=3 >{zcode}</td>
                </tr>
                <tr>
                  <th colspan=1 >Company founded in:</th>
                  <td colspan=3 >{foundDate}</td>
                </tr>
                <tr>
                  <th colspan=1 >Registered Capital:</th>
                  <td colspan=3 >{capital}</td>
                <tr>
                  <th colspan=1 >Number of staff:</th>
                  <td colspan=3 >{staffNum}</td>
                </tr>
                <tr>
                  <th colspan=1 >Vendor Type:</th>
                  <td colspan=3 >{companyTypeName}</td>
                </tr>
                <tr>
                  <th colspan=1 >Vendor Property:</th>
                  <td colspan=3 >{vendorPropertyName}</td>
                </tr>
                <tr>
                  <td colspan=4 ><b>Major product/Service description:</b><br/>{service}</td>
                </tr>
                <tr>
                  <td colspan=4 > 
                    <b>Supplier classification</b><br/> 
                    <b>Family ID:</b> {familyName}<br /> 
                    <b>Category ID:</b> {categoryName}<br/>
                    <b>Sub-Category:</b> {subCategory}
                  </td>
                </tr>
                <tr>
                  <td colspan=4 ><b>Web site:</b> <a href="http://{website}" target="_blank"> {website}</a></td>
                </tr>
                <tr>
                  <th colspan=1 >Contact Person's 1:</th>
                  <td colspan=1 >{contactor1}</td>
                  <th colspan=1 >Position:</th>
                  <td colspan=1 >{position1}</td>
                </tr>
                <tr>          
                  <th colspan=1 >Tel No:</th>
                  <td colspan=1 >{telPhone1}</td>
                  <th colspan=1 >Cell No:</th>
                  <td colspan=1 >{cellPhone1}</td>
                </tr>
                <tr>
                  <th colspan=1 >Fax No:</th>
                  <td colspan=1 >{fax1}</td>
                  <th colspan=1 >E-Mail:</th>
                  <td colspan=1 >{mail1}</td>
                </tr>
                <th colspan=1 >Contact Person's 2</th>
                <td colspan=1 >{contactor2}</td>
                <th colspan=1 >Position:</th>
                <td colspan=1 >{position2}</td>
                <tr>
                  <th colspan=1 > Tel No: </th>
                  <td colspan=1 > {telPhone2}</td>
                  <th colspan=1 > Cell No: </th>
                  <td colspan=1 > {cellPhone2}</td>
                </tr>
                <tr>
                  <th colspan=1 style="width:20%">Fax No:</th>
                  <td colspan=1 style="width:20%">{fax2}</td>
                  <th colspan=1 style="width:20%">E-Mail:</th>
                  <td colspan=1 style="width:20%">{mail2}</td>
                </tr>
                <tr>
                  <td colspan=4 > <b>Enterprise qualification (if any):</b><br/>{qualification}</td>
                </tr>
                {/basicInfo}
              </tbody>
            </table>
          </div>

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
              <?php 
                 $user = CI_Controller::getSessionUserInfo();
                 $userName = $user['username'];
                 $evaluator = $comment['evaluator'];
                 $roleId = $user['role'];
                 if($roleId==1 || $roleId ==7 || $userName == $evaluator){
                 ?>
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
              <?php
                 }
                 ?>
            </table>
            <?php
               }
               ?>

          </div><!-- supplier_score end -->

          <button type="button" class="btn-info btn-middle" id="back_btn" onclick="toList()">
            Back 
          </button>

        </div><!--tabcontent-->
      </div>
    </div><!--span6-->
</div> <!--  page-content end -->
</div>

<script src="/resource/js/my/supplier.js"></script>
<script>

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

