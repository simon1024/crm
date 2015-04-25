<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>自助统计查询平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="/resource/css/bootstrap.css" rel="stylesheet">
    <link href="/resource/css/datepicker.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      .control-group button{
        width:80px;
      }
      .form-horizontal .control-label{
        width:80px;
      }

      .form-horizontal .controls{
        margin-left:100px;
      }
      .label-warning, .badge-warning{
        height:25px;
        padding: 5px 0 0 0 ;
        text-align:center;
        vertical-align:middle;
        width:400px;
        font-size:14px;
      }
      .hero-unit{
        background:#FFF;
      }
      .input-prepend{
        margin-right:20px;
      }

      .fl_item{
        margin-left:20px;
      }
      .query-pointers label{
        width:90px;
      }
      .query-hosts label{
        width:90px;
      }

      .nav-list{
        margin-bottom:30px;
      }
      div.date-range{
        float:left;
      }
      #mess_tips{
        text-align:center;
        margin: 0 0 0 100px;
      }


      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="/resource/css/bootstrap-responsive.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="resource/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Query 平台</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link">Username</a>
            </p>
            <ul class="nav">
              <li class="active"><a href="#">首页</a></li>
              <li><a href="#about">关于</a></li>
              <li><a href="#contact">联系</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">国际化统计查询</li>
              <li class="active"><a href="/">基础查询</a></li>
              <li><a href="/stats/muvquery">月统计查询</a></li>
            </ul>
            <ul class="nav nav-list">
              <li class="nav-header">报表数据查看</li>
              <li><a href="#">精准统计</a></li>
              <li><a href="#">留存率</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          <div class="hero-unit">

<form class="form-horizontal">
    <legend>统计查询系统 <span id="mess_tips" class="label label-warning"></span>  </legend>
    
    <div class="control-group">
        <label class="control-label" for="">开始日期:</label>
        <div class="controls date-range" style='margin-left:10px'>
            <input type="text" id="date" name="date" value="20130603" data-date-format="yyyy-mm-dd">
        </div>
        <label class="control-label" for="">结束日期:</label>
        <div class="controls date-range" style='margin-left:10px'>
            <input type="text" id="end_date" name="end_date" value="20130603" data-date-format="yyyy-mm-dd">
        </div>
    </div>
     <!-- pointers start  -->
    <div class="control-group">
        <label class="control-label" for="checkboxPointers">统计指标</label>
        <div class="controls query-pointers">
            <label class="checkbox inline">
                PV<input type="checkbox" id="checkbox_pv" value="cookie_pv" name="pointers" > 
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="checkbox_uv" value="cookie_uv" name="pointers" > UV
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="checkbox_newuv" value="cookie_clickUV" name="pointers" > 有操作UV
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="checkbox_newuv" value="cookie_newUV" name="pointers" > 新增UV
            </label>
        </div>


        <div class="controls query-pointers">
            <label class="checkbox inline">
                站点点击次数<input type="checkbox" id="cookie_linksTimes" value="cookie_linksTimes" name="pointers" > 
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="cookie_linksUV" value="cookie_linksUV" name="pointers" > 站点点击UV
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="cookie_searchTimes" value="cookie_searchTimes" name="pointers" >搜索次数 
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="cookie_searchUV" value="cookie_searchUV" name="pointers" > 搜索UV
            </label>
        </div>
    </div>
    <!-- pointers end -->
   
    <!-- countries start  -->
    <div class="control-group">
        <label class="control-label" for="checkboxPointers">国家</label>
        <div class="controls query-hosts">
            <label class="checkbox inline">
                所有<input type="checkbox" id="hosts_all" value="hosts_all" name="hosts"> 
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="hosts_br" value="br.hao123.com" name="host" > 巴西
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="hosts_ar" value="ar.hao123.com" name="host" > 埃及
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="hosts_th" value="th.hao123.com" name="host" > 泰国
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="hosts_jp" value="jp.hao123.com" name="host" > 日本
            </label>
        </div>


        <div class="controls query-hosts">
            <label class="checkbox inline">
                <input type="checkbox" id="hosts_tw" value="tw.hao123.com" name="host" > 台湾
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="hosts_vn" value="vn.hao123.com" name="host" > 越南
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="hosts_ae" value="ae.hao123.com" name="host" > 阿联酋
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="hosts_sa" value="sa.hao123.com" name="host" > 沙特
            </label>
            <label class="checkbox inline">
                <input type="checkbox" id="hosts_id" value="id.hao123.com" name="host" > 印尼
            </label>
        </div>
    </div>
    <!-- countries end -->

    <!-- filter  start -->
    <div class="control-group">
        <div>
            <p>
                <label class="control-label" for="">过滤条件:</label>
            </p>
        </div>
        <div class="controls">
            <p>
            <div class="input-prepend input-append">
                <span class="add-on">渠道号</span>
                <input class="input-medium" id="fl_tn" type="text" name="globalhao123_tn" >
            </div>

            <div class="input-prepend input-append">
                <span class="add-on">模块名</span>
                <input class="input-medium" id="fl_modid" type="text" name="modid" >
            </div>
            </p>
            <p>
                <div class="input-prepend input-append">
                    <span class="add-on">二级页</span>
                    <input class="input-medium" id="fl_channel" type="text" name="channel">
                </div>
                <div class="input-prepend input-append">
                    <span class="add-on">BaiduId 结尾为</span>
                    <input class="input-medium" id="fl_baiduid" type="text" name="baiduid">
                </div>
            </p>
        </div>
    </div>
    <!-- filter  end-->

    <div class="control-group">
        <p><a id="biglog_query" href="#" class="btn btn-primary btn-large">查询一下</a></p>
    </div>

</form>




            <div class="control-group">
                <table class="table table-striped table-bordered table-hover" id="tb_result">
            </div>




        </div><!--/span-->
      </div><!--/row-->

      <hr>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/resource/js/bootstrap.min.js"></script>
    <script src="/resource/js/jquery-1.7.2.min.js"></script>
    <script src="/resource/js/bootstrap-datepicker.js"></script>
    <script src="/resource/js/stats-query.js"></script>
  </body>
</html>
