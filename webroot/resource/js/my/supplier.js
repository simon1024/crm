$(function(){ 
    // date picker
    $('.date-picker').datepicker({"autoclose": true});

    $('#form_updateBasicSupplier').submit(function() {
        //var success = checkAddProjectForm('update_basicProjectForm');
        var success = true
        if(success){
            var param = $("#form_updateBasicSupplier").serialize();
            $.ajax({
              url:"/supplier/updateBasic/?time="+ (new Date()).getTime(),
              type:"post",
              dataType:"json",
              data:param,
              success: function(data){
                        var status = data.status;
                        if(status == 'ok'){
                            window.location.href = '/supplier/listAll';
                        }else{
                            alert(data.msg);
                        }
              }
            });
        }
        return false;
    });

});

function addSupplier() {
    var success = checkAddSupplierForm("form_addSupplier");
    if(success){
        var param = $("#form_addSupplier").serialize();
        $.ajax({
            url:"/supplier/add/?time="+ (new Date()).getTime(),
            type:"post",
            dataType:"json",
            data:param,
            success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('添加成功.')
                    window.location.href = '/supplier/listAll';
                }else{
                    alert(data.msg);
                }
            }
        });
    }
}

function checkAddSupplierForm(formId){
    $('#'+formId).validate({
        onsubmit:true,// 是否在提交是验证 
        focusCleanup:true,focusInvalid:false,
        errorClass: "unchecked",
        validClass: "checked",
        errorElement: "span",
        errorPlacement:function(error,element){
          var s=element.parent().find("span[htmlFor='" + element.attr("id") + "']");
          if(s!=null){
            s.remove();
          }
          error.appendTo(element.parent());
        },
        success: function(label) {
          label.removeClass("unchecked").addClass("checked");
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
            $(element.form).find("label[for=" + element.id + "]")
              .addClass(errorClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
            $(element.form).find("label[for=" + element.id + "]")
              .removeClass(errorClass);
        },
        rules:{
            chName:{required:true},
            enName:{required:true},
            family:{required:true},
        }
    });
    return $('#'+formId).valid();
}

function addScore() {
    //var success = checkAddProjectForm('form_addScore');
    var success = true;
    if(success){
        var param = $("#form_addScore").serialize();
        $.ajax({
            url:"/supplier/addScore/?time="+ (new Date()).getTime(),
            type:"post",
            dataType:"json",
            data:param,
            success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    // window.location.href = '/supplier/listAll';
                    path = document.referrer.split('/supplier')[1];
                    window.location.href = '/supplier' + path;
                }else{
                    alert(data.msg);
                }
            }
        });
    }
}


