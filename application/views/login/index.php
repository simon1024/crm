<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>登录页面 - 利柏特公司管理系统</title>
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
                                        <span class="red">公司管理系统</span>
                                        <!--span class="white">系统</span-->
                                    </h1>
                                    <h4 class="blue">&copy; 利柏特工程有限公司 </h4>
                                </div>
                            </div>

                            <div class="space-6"></div>

                            <div class="row-fluid">
                                <div class="position-relative">
                                    <div id="login-box" class="visible widget-box no-border">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <h4 class="header blue lighter bigger">
                                                    <i class="icon-coffee green"></i>
                                                   请登录 
                                                </h4>

                                                <div class="space-6"></div>

                                                <form id='loginForm'>
                                                    <fieldset>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" class="span12" name="username" placeholder="用户名" />
                                                                <i class="icon-user"></i>
                                                            </span>
                                                        </label>

                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" class="span12" name="password" placeholder="密码" />
                                                                <i class="icon-lock"></i>
                                                            </span>
                                                        </label>

                                                        <div class="space"></div>

                                                        <div class="row-fluid">
                                                            <label class="span8"  id='loginForm_blank'>
                                                            </label>
                                                            <label id="forget_pwd" class="span4">
															<a href="/login/resetPasswd">忘记密码？</a>
                                                            </label>
                                                        </div>
                                                        <div class="row-fluid">
                                                            <!--label class="span8">
                                                                <input type="checkbox" />
                                                                <span class="lbl"> Remember Me</span>
                                                            </label-->
                                                            <label class="span8"  id='loginForm_failure'>
                                                            </label>
                                                            <button id="login_btn" onclick="return false;" class="span4 btn btn-small btn-primary">
                                                                <i class="icon-key"></i>
                                                               登录 
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div><!--/widget-main-->

                                            <div class="toolbar clearfix">
                                                <!--div>
                                                    <a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
                                                        <i class="icon-arrow-left"></i>
                                                        I forgot my password
                                                    </a>
                                                </div-->
                                                <!--div>
                                                    <a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
                                                        I want to register
                                                        <i class="icon-arrow-right"></i>
                                                    </a>
                                                </div-->
                                            </div>
                                        </div><!--/widget-body-->
                                    </div><!--/login-box-->

                                    <div id="forgot-box" class="widget-box no-border">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <h4 class="header red lighter bigger">
                                                    <i class="icon-key"></i>
                                                    Retrieve Password
                                                </h4>

                                                <div class="space-6"></div>
                                                <p>
                                                    Enter your email and to receive instructions
                                                </p>

                                                <form>
                                                    <fieldset>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="email" class="span12" placeholder="Email" />
                                                                <i class="icon-envelope"></i>
                                                            </span>
                                                        </label>

                                                        <div class="row-fluid">
                                                            <button onclick="return false;" class="span5 offset7 btn btn-small btn-danger">
                                                                <i class="icon-lightbulb"></i>
                                                                Send Me!
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div><!--/widget-main-->

                                            <div class="toolbar center">
                                                <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                                    Back to login
                                                    <i class="icon-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div><!--/widget-body-->
                                    </div><!--/forgot-box-->

                                    <div id="signup-box" class="widget-box no-border">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <h4 class="header green lighter bigger">
                                                    <i class="icon-group blue"></i>
                                                    New User Registration
                                                </h4>

                                                <div class="space-6"></div>
                                                <p>
                                                    Enter your details to begin:
                                                </p>

                                                <form>
                                                    <fieldset>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="email" class="span12" placeholder="Email" />
                                                                <i class="icon-envelope"></i>
                                                            </span>
                                                        </label>

                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" class="span12" placeholder="用户名" />
                                                                <i class="icon-user"></i>
                                                            </span>
                                                        </label>

                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" class="span12" placeholder="密码" />
                                                                <i class="icon-lock"></i>
                                                            </span>
                                                        </label>

                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" class="span12" placeholder="Repeat password" />
                                                                <i class="icon-retweet"></i>
                                                            </span>
                                                        </label>

                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lbl">
                                                                I accept the
                                                                <a href="#">User Agreement</a>
                                                            </span>
                                                        </label>

                                                        <div class="space-24"></div>

                                                        <div class="row-fluid">
                                                            <button type="reset" class="span6 btn btn-small">
                                                                <i class="icon-refresh"></i>
                                                                Reset
                                                            </button>

                                                            <button onclick="return false;" class="span6 btn btn-small btn-success">
                                                                Register
                                                                <i class="icon-arrow-right icon-on-right"></i>
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div class="toolbar center">
                                                <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                                    <i class="icon-arrow-left"></i>
                                                    Back to login
                                                </a>
                                            </div>
                                        </div><!--/widget-body-->
                                    </div><!--/signup-box-->
                                </div><!--/position-relative-->
                            </div>
                        </div>
                    </div><!--/span-->
                </div><!--/row-->
            </div>
        </div><!--/.fluid-container-->

        <!--basic scripts-->

		<script src="/resource/js/jquery-1.9.1.min.js"></script>
        <!--page specific plugin scripts-->

        <!--inline scripts related to this page-->

        <script type="text/javascript">
            function show_box(id) {
             $('.widget-box.visible').removeClass('visible');
             $('#'+id).addClass('visible');
            }
        </script>
    </body>
</html>
<script type="text/javascript">
$(function(){ 
    $('#login_btn').click(function() {
        $('#loginForm_failure').html("");
        var param = $("#loginForm").serialize();
        $.ajax({
          url:"/login/check",
          type:"post",
          dataType:"json",
          data:param,
          success: function(data){
                    var status = data.status;
                    if(status == 'ok'){
                        window.location.href='/';
                        //window.location.href='/timesheet/index';
                    }else{
                        $('#loginForm_failure').html("<font color='red'>"+data.msg+"</font>");
                    }
          }
        });
        return false;
    });

});
</script>
