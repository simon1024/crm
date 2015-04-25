<div id="main-content" class="clearfix">
    <div id="breadcrumbs">
        <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i> <a href="/">首页</a><span class="divider"> <i class="icon-angle-right"></i></span>
        </li>
        <li>
            <a href="#">供应商管理</a><span class="divider"> <i class="icon-angle-right"></i> </span>
        </li>
        <li class="active">添加供应商</li>
        </ul><!--.breadcrumb-->
    </div>

<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>Add Supplier</h1>
    </div><!--/.page-header-->

    <div class="row-fluid">
    <!--PAGE CONTENT BEGINS HERE-->
    <form class="form-horizontal" method="post" id="form_addSupplier" >
      <table id="table_supplier_info" class="table  table-striped table-bordered table-hover" style="width:80%">
        <tbody>
          <tr>
            <th style="width:15%">Supplier Name (CH):</th>
            <td style="width:25%"><input type="text" name="chName"></td>
            <th style="width:15%">Supplier Name (EN):</th>
            <td style="width:25%"><input type="text" name="enName"></td>
          </tr>
          <tr>
            <th>Country:</th>
            <td><input type="text" name="country"></td>
            <th>Location:</th>
            <td><input type="text" name="city"></td>
          </tr>
          <tr>
           <th>Address:</th>
           <td colspan=3><input type="text" name="addr" style="width:670px"></td>
          </tr>
        <tr>
          <th>Zip Code:</th>
          <td><input type="text" name="zcode"></td>
          <th>Company founded in:</th>
          <td><input type="text" name="foundDate"></td>
        </tr>
        <tr>
          <th>Registered Capital:</th>
          <td><input type="text" name="capital"></td>
          <th>Number of staff:</th>
          <td><input type="text" name="staffNum"></td>
        </tr>
        <tr>
          <th>Vendor Type:</th>
          <td>
            <select id="sel_company_type" name="companyType">
              <option value="0">please select...</option>
              {companyTypeList}
              <option value="{id}">{tname}</option>
              {/companyTypeList}
            </select>
          </td>
          <th>Vendor Property:</tH>
          <td>
            <select id="sel_vendor_property" name="vendorProperty">
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
            <textarea type="text" name="service" style="width:660px"></textarea>
          </td>
        </tr>
        <tr>
          <th>Family ID:</th>
          <td>
            <select id="sel_family_id" name="family" onchange="changeCategoryList(this)">
              <option value="0">please select ...</option>
              {familyList}
              <option value="{id}">{fname}</option>
              {/familyList}
            </select>
          </td>
          <th>Category ID:</th>
          <td id="category">
            <select id="sel_category_id" name="category">
              <option value="0">please select ...</option>
              {categoryList}
              <option value="{id}">{cname}</option>
              {/categoryList}
            </select>
          </td>
        </tr>
        <tr>
          <th>Sub-Category:</th> 
          <td><input type="text" name="subCategory"></td>
          <th>Web site:</th>
          <td><input type="text" name="website"></td>
        </tr>
        <tr>
          <th>Contact Person's 1</th>
          <td><input type="text" name="contactor1"></td>
          <th>Position:</th>
          <td><input type="text" name="position1"></td>
        </tr>
        <tr>          
          <th> Tel No: </th>
          <td> <input type="text" name="telPhone1"></td>
          <th> Cell No: </th>
          <td> <input type="text" name="cellPhone1"></td>
        </tr>
        <tr>
          <th>Fax No:</th>
          <td><input type="text" name="fax1"></td>
          <th>E-Mail:</th>
          <td><input type="text" name="mail1"></td>
        </tr>
          <th>Contact Person's 2</th>
          <td><input type="text" name="contactor2"></td>
          <th>Position:</th>
          <td><input type="text" name="position2"></td>
        <tr>
          <th> Tel No: </th>
          <td> <input type="text" name="telPhone2"></td>
          <th> Cell No: </th>
          <td> <input type="text" name="cellPhone2"></td>
        </tr>
        <tr>
          <th>Fax No:</th>
          <td><input type="text" name="fax2"></td>
          <th>E-Mail:</th>
          <td><input type="text" name="mail2"></td>
        </tr>
        <tr>
          <th> Enterprise qualification(if any):</th>
          <td colspan=3> 
            <textarea type="text" name="qualification" style="width:660px"></textarea>
          </td>
        </tr>
       </tbody>
     </table>
        <div class="form-actions">
        <!-- <button class="btn btn-info" type="submit" id="addSupplierForm_btn"> -->
        <button class="btn btn-info" id="addSupplierForm_btn" type="button" onclick="addSupplier();">
        <i class="icon-ok bigger-110"></i>
        Submit
        </button>
        &nbsp; &nbsp; &nbsp;
        <button class="btn" type="reset">
        <i class="icon-undo bigger-110"></i>
        Reset
        </button>
        </div>
    </form>
    </div> <!--  row-fluid  end -->
    </div> <!--  page-content end -->
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
</script>

<script>
function changeCategoryList(obj){
    var familyId = $(obj).val();
    var html = '<select id="category_id" name="category">';
        html += '<option value="0">please select ...</option>';
        html += eval('category_'+familyId);
    html += '</select>';
    $('#category').html(html);
}

</script>

