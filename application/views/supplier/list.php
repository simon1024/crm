<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">供应商管理</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">供应商列表</li>
        </ul><!--.breadcrumb-->
    </div>

    <div id="page-content" class="clearfix dataTables_wrapper">
        <div class="page-header position-relative">
            <h1>Supplier Preview</h1>
        </div><!--/.page-header-->

        <!-- search start -->
        <div class="row-fluid">
          <table>
            <tbody>
              <tr style="text-align:right;">
                <td style="text-align:right;">
                  <label>
                    Supplier NO: <input type="text"  name="search_sno" id="search_sno"  placeholder="">
                  </label>
                </td>
                <td>
                  <label>
                    Supplier Name: <input type="text"  name="search_name" id="search_name"  placeholder="">
                  </label>
                </td>
                <td style="text-align:right;">
                  <label>
                    Major Product: <input type="text"  name="search_product" id="search_product"  placeholder="">
                  </label>
                </td>
                <td></td>
              </tr>
              <tr align="right">
                <td style="text-align:right;">
                  <label>
                    Project Name: <input type="text"  name="search_pname" id="search_pname"  placeholder="">
                  </label>
                </td>
                <td style="text-align:right;">
                  <label>
                    Project Type: 
                    <select  id="search_ptype" name="search_ptype">
                      <option value="0">不限</option>
                      <option value="1">EPC</option>
                      <option value="2">EPCM</option>
                      <option value="3">COST ESTIMATION</option>
                    </select>
                  </label>
                </td>
                <td style="text-align:right;">
                  <label>
                    Others: <input type="text"  name="search_others" id="search_others"  placeholder="">
                  </label>
                </td>
                <td style="text-align:right;">
                  <button class="btn btn-small btn-primary" id="advanceSupplierQuery" onclick="searchSupplier()">Search</button>
                  <!-- <button class="btn btn-small btn-info" id="resetSupplierQuery" onclick="resetSearch()">Reset</button> -->
                  <?php 
                     $user = CI_Controller::getSessionUserInfo();
                     $roleId = $user['role'];
                     $deptId = $user['department'];
                     if($roleId==1 || $roleId ==7){
                     ?>
                  <button class="btn btn-small btn-primary" onclick="exportSupplier()"><i class=" icon-download bigger-120"></i>export</button>
                  <?php
                     }
                     ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <br/>
        <div class="row-fluid">
            <div class="span12">
                <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Supplier NO</th>
                            <th>Supplier Name(EN)</th>
                            <th>Supplier Name(CH)</th>
                            <th>Vendor Type</th>
                            <th>Major Product</th>
                            <th>Location</th>
                            <th>Scoring</th>
                            <th>Inquired</th>
                            <?php 
                                $user = CI_Controller::getSessionUserInfo();
                                $roleId = $user['role'];
                                if($roleId==1 || $roleId ==2){
                                ?>
                            <th></th>
                            <?php
                                }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        {supplierList}
                        <tr class="selected">
                            <td>{noStr}</td>
                            <td>{enName}</td>
                            <td>{chName}</td>
                            <td>{companyType}</td>
                            <td>{service}</td>
                            <td>{city}</td>
                            <td>{score}</td>
                            <td>{inquiryCount}</td>
                            <!-- <td>{inquiryCount}</td> -->
                            <td style="text-align:center;width:120px;" style="text-decoration:none">
                                <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-placement="left" data-original-title="浏览"  onclick="toViewSupplier({id})" style="text-decoration:none">
                                    <span class="info"><i class="icon-eye-open  bigger-120"></i></span>
                                </a>
                                &nbsp;&nbsp;
                            <?php 
                                $user = CI_Controller::getSessionUserInfo();
                                $roleId = $user['role'];
                                if($roleId==1 || $roleId ==7){
                               ?>
                                <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-placement="left" data-original-title="编辑"  onclick="toUpdateSupplier({id})" style="text-decoration:none">
                                    <span class="green"><i class="icon-edit bigger-120"></i></span>
                                </a>
                                &nbsp;&nbsp;
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-placement="left" data-original-title="删除"  onclick="toDelSupplier({id})"  style="text-decoration:none">
                                    <span class="red"><i class="icon-trash bigger-120"></i></span>
                                </a>
                            </td>
                            <?php

                                }
                            ?>

                        </tr>
                        {/supplierList}
                    </tbody>
                </table>
            </div><!--/span-->
        </div> <!-- row-fluid -->

        <!-- pagenation start -->
        <div class="row-fluid">
            <div class="span6">
                <div class="dataTables_info" id="table_report_info">total: {total} suppliers
                </div>
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

<script src="/resource/js/my/supplier.js"></script>

<script>
function toDelSupplier(id){
    if(!confirm("确定要删除该供应商吗？")){
        return false;
    }
    var param = {"id":id};
    $.ajax({
      url:"/supplier/del/"+id+"?time="+ (new Date()).getTime(),
      type:"post",
      data:param,
      dataType:"json",
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('删除供应商成功');
                    window.location.reload(true);
                }else{
                    alert(data.msg);
                }
      }
    });
}

function toUpdateSupplier(id){
    window.location.href = '/supplier/update/'+id;
}

function toViewSupplier(id){
    window.location.href = '/supplier/view/'+id;
}

function searchSupplier() {
    var sno = $('#search_sno').val();
    var name = $('#search_name').val();
    var product = $('#search_product').val();
    var pname = $('#search_pname').val();
    var ptype = $('#search_ptype').val();
    var others = $('#search_others').val();
    var url = '/supplier/listAll?sno='+sno+'&name='+ name +'&product=' + product 
             + '&pname=' + pname + '&ptype=' + ptype + '&others=' + others;
    window.location.href = url;
}

function exportSupplier() {
    var sno = $('#search_sno').val();
    var name = $('#search_name').val();
    var product = $('#search_product').val();
    var pname = $('#search_pname').val();
    var ptype = $('#search_ptype').val();
    var others = $('#search_others').val();
    var url = '/supplier/export?sno='+sno+'&name='+ name +'&product=' + product 
             + '&pname=' + pname + '&ptype=' + ptype + '&others=' + others;
    window.location.href = url;
}

function resetSearch() {
    $('#search_name').val('');
    $('#search_product').val('');
    $('#search_pname').val('');
    $('#search_others').val('');
    $('#search_ptype').val(0);
    $('#search_sno').val('');
}


</script>
<script>
$(function(){ 
    $('#search_name').val('{name}');
    $('#search_product').val('{product}');
    $('#search_pname').val('{pname}');
    $('#search_others').val('{others}');
    $('#search_ptype').val({ptype});
    $('#search_sno').val('{sno}');
});
</script>
