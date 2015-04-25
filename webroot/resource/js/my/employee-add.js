$(function(){ 
    // date picker
    $('.date-picker').datepicker({"autoclose": true});
    // submit form
    $('#search_employee_name').keydown(function() {
         if (event.keyCode == "13") {
            var value = $('#search_employee_name').val();
            //window.location.href = '/employee/listAll?s='+value;
            window.location.href = '/employee/listAll/1/s/'+value;
         }
    });

    $('#form_addEmployee').submit(function() {
        var success = checkAddEmployForm();
        if(success){
            var param = $("#form_addEmployee").serialize();
            $.ajax({
              url:"/employee/add/?time="+ (new Date()).getTime(),
              type:"post",
              dataType:"json",
              data:param,
              success: function(data){
                        var status = data.status;
                        if(status == 'ok'){
                            alert('添加成功.');
                            window.location.href = '/employee/listAll';
                            //alert('添加成功, 请继续添加.');
                            //$('#form_addEmployee')[0].reset();
                        }else{
                            alert(data.msg);
                        }
              }
            });
        }
        return false;
    });

    $('#form_updateEmployee').submit(function() {
        var success = checkUpdateEmployForm('form_updateEmployee');
        if(success){
            var param = $("#form_updateEmployee").serialize();
            $.ajax({
              url:"/employee/updateBasic/?time="+ (new Date()).getTime(),
              type:"post",
              dataType:"json",
              data:param,
              success: function(data){
                        var status = data.status;
                        if(status == 'ok'){
                            //window.location.href = '/employee/listAll';
							 location.href = document.referrer;
                        }else{
                            alert(data.msg);
                        }
              }
            });
        }
        return false;
    });

    $('#form_updatePersonalInfo').submit(function() {
        //var success = checkUpdatePersonalInfo();
        var success = checkUpdateEmployForm('form_updatePersonalInfo');
        if(success){
            var param = $("#form_updatePersonalInfo").serialize();
            $.ajax({
              url:"/employee/updatePersonalInfo/?time="+ (new Date()).getTime(),
              type:"post",
              dataType:"json",
              data:param,
              success: function(data){
                        var status = data.status;
                        if(status == 'ok'){
                            window.location.href = '/employee/personal';
                        }else{
                            alert(data.msg);
                        }
              }
            });
        }
        return false;
    });
    $('#form_updatePasswd').submit(function() {
        var success = checkUpdatePasswdForm();
        if(success){
            var param = $("#form_updatePasswd").serialize();
            $.ajax({
              url:"/employee/setpwd/?time="+ (new Date()).getTime(),
              type:"post",
              dataType:"json",
              data:param,
              success: function(data){
                        var status = data.status;
                        if(status == 'ok'){
                            alert('密码修改成功.');
                            window.location.href = '/employee/listAll';
                        }else{
                            alert(data.msg);
                        }
              }
            });
        }
        return false;
    });
});

function checkAddEmployForm(){
	$.validator.addMethod(
		"regex",
		function(value, element, regexp) {
			var re = new RegExp(regexp);
			return this.optional(element) || re.test(value);
		},
		"Please check your input."
	);

    $('#form_addEmployee').validate({
        onsubmit:true,// 是否在提交是验证 
        //onfocusout:false,// 是否在获取焦点时验证 
        //onkeyup :false,// 是否在敲击键盘时验证 
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
          //label.addClass("valid").text("Ok!")
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
          no:{required:true},
          name:{required:true,minlength:2},
          username:{required:true,minlength:4},
		  mail:{required:true,email:true},
          password:{required:true,minlength:6,regex:'[0-9A-Za-z]{6,}'},
          confirm_password:{
            required:true,minlength:6,equalTo:'#password'
          },
          //tel:{required:true,minlength:6},
          mobile:{required:true,minlength:11}
        },
        messages:{
			mail: {
				required: "请输入邮箱地址",
				email: "邮箱地址不正确"
			},
			password:{
				regex:"密码至少6位，由大小写字母和数字组成"
			},
            confirm_password: {
                equalTo: "两次输入密码不一致"
            }
        }

    });
    return $('#form_addEmployee').valid();
}

function checkUpdateEmployForm(formId){
    $('#' + formId).validate({
        onsubmit:true,// 是否在提交是验证 
        //onfocusout:false,// 是否在获取焦点时验证 
        //onkeyup :false,// 是否在敲击键盘时验证 
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
          //label.addClass("valid").text("Ok!")
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
          //no:{required:true},
          name:{required:true,minlength:2},
          //tel:{required:true,minlength:6},
		  mail:{required:true,email:true},
          mobile:{required:true,minlength:11}
        },
		messages:{
		  mail: {
			  required: "请输入邮箱地址",
			  email: "邮箱地址不正确",
		  },
		}

    });
    return $('#' + formId).valid();
}

function checkUpdatePasswdForm(){
	$.validator.addMethod(
		"regex",
		function(value, element, regexp) {
			var re = new RegExp(regexp);
			return this.optional(element) || re.test(value);
		},
		"Please check your input."
	);

	$.validator.addMethod(
		"equalOld",
		function(value, element, flag) {
            var param = $("#form_updatePasswd").serialize();
            var match = false;
			$.ajax({
			  url:"/employee/checkCurrentPasswd/",
			  type:"post",
			  data:param,
			  dataType:"json",
              async:false,
			  success: function(data){
						var status = data.status;
						if(status == 'ok'){
                            match = true;
							//return true;
						}else{
							//return false;
						}
			  }
			});
            return match;
		},
		"Please check your input."
	);
    $('#form_updatePasswd').validate({
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
          //label.addClass("valid").text("Ok!")
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
          current_passwd:{required:true,minlength:6,equalOld:true},
          new_passwd:{required:true,minlength:6,regex:'[0-9A-Za-z]{6,}'},
          repeat_new_passwd:{
            required:true,minlength:6,equalTo:'#new_passwd'
          },
        },
        messages:{
			current_passwd:{
				equalOld:"密码输入有误"
			},
			new_passwd:{
				regex:"密码至少6位，由大小写字母和数字组成"
			},
            repeat_new_passwd: {
                equalTo: "两次输入密码不一致"
            }
        }

    });
    return $('#form_updatePasswd').valid();
}

function toUpdateEmployee(id){
    window.location.href = '/employee/update/'+id;
}

function toViewEmployee(id){
    window.location.href = '/employee/viewDetail/'+id;
}

function toDelEmployee(id){
    if(!confirm("确定要删除该员工吗？")){
        return false;
    }
    var param = {"id":id};
    $.ajax({
      url:"/employee/del/"+id+"?time="+ (new Date()).getTime(),
      type:"post",
      data:param,
      dataType:"json",
      success: function(data){
                var status = data.status;
                if(status == 'ok'){
                    alert('删除员工成功');
                    window.location.reload(true);
                }else{
                    alert(data.msg);
                }
      }
    });
}

function toList(){
    //window.location.href = '/employee/listAll';
	window.history.go(-1);
}

function changePositionList(obj){
    var deptId = $(obj).val();
	var html = '<select id="pos_id" name="position">';
        html += '<option value="0">请选择</option>';
    if(deptId>0){
        html += eval('pos_'+deptId);
    }
    html += '</select>';
    $('#pos').html(html);
}

function search_employee_dept(obj){
    var deptId = $(obj).val();
	if (deptId == 0)
		window.location.href = '/employee/listAll/';
	else
		window.location.href = '/employee/listAll/1/s/'+deptId;
}

