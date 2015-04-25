<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>密码重置页面 - 利伯特公司CRM平台</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--basic styles-->
        <link href="/resource/css/bootstrap.min.css" rel="stylesheet" />
        <link href="/resource/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/resource/css/font-awesome.min.css" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="/resource/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!--page specific plugin styles-->

        <!--fonts-->

        <!--link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" /-->

        <!--ace styles-->

        <link rel="stylesheet" href="/resource/css/ace.min.css" />
        <link rel="stylesheet" href="/resource/css/ace-responsive.min.css" />

        <!--[if lt IE 9]>
          <link rel="stylesheet" href="/resource/css/ace-ie.min.css" />
        <![endif]-->
    </head>

    <body class="login-layout">
        <div class="container-fluid" id="main-container">
            <div id="main-content">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="login-container">
                            <div class="row-fluid">
                                <div class="center">
                                    <h1>
                                        <!--i class="icon-leaf green"></i-->
										<img src="/resource/images/icon-lbt.png" class="img-rounded"></img>
                                        <span class="red">CRM</span>
                                        <span class="white">系统</span>
                                    </h1>
                                    <h4 class="blue">&copy; 利伯特公司 </h4>
                                </div>
                            </div>

                            <div class="space-6"></div>

                            <div class="row-fluid">
                                <div class="position-relative">
                                    <div id="login-box" class="visible widget-box no-border">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <h5 class="header blue lighter bigger">
                                                    <i class="icon-coffee green"></i>
                                                   请输入您的用户名，我们会发送账户确认邮件，确认账户后会为您重置密码 
                                                </h5>

                                                <form id='resetForm'>
                                                    <fieldset>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" id = "username" class="span12" name="username" placeholder="用户名" />
                                                                <i class="icon-user"></i>
                                                            </span>
                                                        </label>

                                                        <div class="row-fluid">
                                                            <button id="reset_btn" class="span8 btn btn-small btn-primary">
                                                               发送密码重置邮件 
                                                            </button>
                                                            <button id="back_btn" class="span4 btn btn-small btn-primary">
                                                               返回 
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                <!--/form-->
                                            </div><!--/widget-main-->

                                        </div><!--/widget-body-->
                                    </div><!--/login-box-->
                                </div><!--/position-relative-->
                            </div> <!--row-fluid-->

                        </div><!--login-container-->
                    </div><!--/span-->
                </div><!--/row-->
            </div>
        </div><!--/.fluid-container-->

        <!--basic scripts-->

		<script src="/resource/js/jquery-1.9.1.min.js"></script>
        <!--page specific plugin scripts-->

        <!--inline scripts related to this page-->

    </body>
</html>
<script type="text/javascript">
$(function(){ 
    $('#back_btn').click(function() {
		window.location.href='/login/index/';
        return false;
    });

});
</script>

<script>
$(function(){ 
    $('#reset_btn').click(function() {
		var name = $('#username').val();
		//var name = "Administrator";
		var param = {"name":name};
		$.ajax({
		  url:"/login/generatePwd/?time="+ (new Date()).getTime(),
		  type:"post",
		  dataType:"json",
		  data:param,
		  success: function(data){
					var status = data.status;
					if(status == 'ok'){
						alert("Temporary passwd has been sent to your mailbox");
					}else{
						alert(data.msg);
					}
		  }
		});
        return false;
    });

});
</script>
