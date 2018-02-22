<?php /* Smarty version Smarty-3.1.13, created on 2018-02-09 17:23:38
         compiled from "E:\b2bstockAdmin\application\views\login\login.phtml" */ ?>
<?php /*%%SmartyHeaderCode:135045a77cf005b55e9-71643468%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4004acb9907c57e29b0d514dee2cd335f8e7aaf5' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\login\\login.phtml',
      1 => 1518168206,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '135045a77cf005b55e9-71643468',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77cf006044e3_25946199',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77cf006044e3_25946199')) {function content_5a77cf006044e3_25946199($_smarty_tpl) {?><!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>大宗交易后台 | 登录中心</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="/favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/toastr.css">
    <link rel="stylesheet" href="/public/css/blue.css">
    
<style type="text/css">
    .jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}

</style>

</head>
<body class="blank" style="background: url('/public/images/BG.jpg') no-repeat;background-size: 100% 100%;" onload="">
<!-- Simple splash screen-->
<div style="display: none;" class="splash">
    <div class="color-line"></div>
    <div class="splash-title">
        <div>
            <img src="/public/images/logo_mtq.png" style="width: 45px; display: inline-block; vertical-align: middle; margin-right: 10px; position: relative; top: -4px">

            <div style="display: inline-block; vertical-align: middle;">
                <h4>再小的个体，也可以拥有媒体的翅膀</h4>

                <p>Even tiny individual can has media wings</p>
            </div>
        </div>
        <img src="/public/images/loading-bars.svg" height="50" width="50">
    </div>
</div>
<div class="pull-left m">
</div>

<div class="row" style="padding-top: 4%;">
    <div class="col-md-4 col-md-offset-4">
        <div class="text-center m-b-md">
            <!--
            <img src="/public/images/TV+_logo.png" style="width: 100px;">
            <h3 style="color: #fff;font-size: 30px;">TV+返利商城<img src="/public/images/gc.png" style="width: 39px; vertical-align: top;"></h3>
             -->
        </div>
        <div class="hpanel">
            <div class="panel-body">
                <div class="form-group col-lg-12">
                    <label class="control-label" for="username">用户名</label>
                    <input placeholder="用户名" data-error="请填写登录用户名" title="请填写登录用户名" required="" name="username" id="username" class="form-control" type="text" onblur="getVal(this)">
                    <span class="help-block with-errors"></span>
                </div>
                <div class="form-group col-lg-12 passwodPage" style="display: none;">
                    <span class="help-block with-errors"></span>
                </div>
                <div class="form-group col-lg-12 passwodPage" >
                    <label class="control-label" for="code">验证码</label>
                    <div>
                        <input data-error="请填写验证码" title="请填写验证码" style="width: 70%; float: left;" placeholder="验证码" required="" value="" name="password" id="password" class="form-control" type="password">
                        <span style="float: left; margin-left: 6px; background: #5bc0de; border: 1px #5bc0de; width:100px; " class="btn btn-info" id="code" onclick="smsSend()" >发送验证码</span>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group col-lg-12">
                    <button class="btn btn-info btn-block" id="sub" onclick="check()">登录</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center" style="color:#AAA;">
            <strong>天脉聚源</strong>&nbsp;&nbsp;  ©2015 TVM&nbsp;&nbsp;苏ICP备09017284号
        </div>
    </div>
</div>
<!--<input type="hidden" name="is_remember" id="is_remember" value="1" />-->
<span id="error" style="display: none"></span>
<span id="ua_err" style="display: none"></span>

<script src="/public/scripts/jquery_002.js"></script>
<script src="/public/scripts/bootstrap.js"></script>
<script src="/public/scripts/jquery.js"></script>
<script src="/public/scripts/jquery-ui.js"></script>
<script src="/public/scripts/icheck.js"></script>
<script src="/public/scripts/toastr.js"></script>
<script src="/public/scripts/validator.js"></script>
<script src="/public/scripts/jquery.cookie.js"></script>
<script src="/public/js/jquery.md5.js"></script>
<!-- App scripts -->

<script>
    function getVal(event){
        var userName=$(event).val();
        var preg=/^1[34578]\d{9}$/;
        if(preg.test(userName)){
            $("input[name='password']").attr("type",'text');
            $("input[name='password']").val('');
        }else{
            $("input[name='password']").attr("type",'password');
            $("input[name='password']").val('');
        }
    }
    function check(){
        var error_msg;
        var username = $('#username').val();
        var password = $('#password').val();
        if(username==''){
            error_msg = $('#username').data('error');
            $('#username').closest('div.col-lg-12').addClass('has-error')
            $('#username').closest('div.col-lg-12').find('span.with-errors').text(error_msg)
            return false;
        }else{
            $('#username').closest('div.col-lg-12').removeClass('has-error');
            $('#username').closest('div.col-lg-12').find('span.with-errors').text('')
        }
        if(password==''){
            error_msg = $('#password').data('error');
            $('#password').closest('div.col-lg-12').addClass('has-error')
            $('#password').closest('div.col-lg-12').find('span.with-errors').text(error_msg)
            return false;
        }
        $.ajax({
            url:'/Login/doLogin',
            type:'post',
            async:false,
            data:'username='+username+'&password='+password,
            dataType:'json',
            success:function(data){
                if(data.status == 'success'){
                    location.href = data.url;
                }else{
                    $("#error").text(data.msg)
                    var error = $("#error").text();
                    if (error != "") {
                        toastr.options = {
                            "debug": false,
                            "newestOnTop": false,
                            "positionClass": "toast-top-center",
                            "closeButton": true,
                            "debug": false,
                            "timeOut": "3000",
                            "toastClass": "animated fadeInDown"
                        };
                        toastr.error(error);
                    }
                    return false;
                }
            }
        });
    }
//    $('.icheckbox_flat-blue').click(function(){
//        $(this).toggleClass('checked');
//        if($(this).hasClass('checked')){
//            $("#is_remember").val('1');
//        } else {
//            $("#is_remember").val('');
//        }
//    })
    function smsSend(){
        var username=$("input[name='username']").val();
        var preg=/^1[34578]\d{9}$/
        if($("#code").attr("disabled")){
            return false;
        }
        if(!preg.test(username)){
            alert('用户名错误');
            return false;
        }
        $.ajax({
            type:'post',
            url:'/Login/smsSend',
            async:false,
            dataType:'json',
            data:"mobile="+username,
            success:function(res){
                if(res && res.status=='success'){
                    $("#code").html("发送成功");
                    $("#code").attr("disabled",true);
                    $("#code").css("background","#3f3f3f");
                    var i=59
                    var interval=setInterval(function(){
                        $("#code").html(i+"s");
                        i--;
                    },1000)
                    setTimeout(function(){
                        clearInterval(interval);
                        $("#code").html("发送验证码");
                        $("#code").css("background","#5bc0de");
                        $("#code").attr("disabled",false);
                    },60*1000)

                }else{
                    $("#error").text(res.msg)
                    var error = $("#error").text();
                    if (error != "") {
                        toastr.options = {
                            "debug": false,
                            "newestOnTop": false,
                            "positionClass": "toast-top-center",
                            "closeButton": true,
                            "debug": false,
                            "timeOut": "3000",
                            "toastClass": "animated fadeInDown"
                        };
                        toastr.error(error);
                    }
                }
            }
        })

    }
</script>

</body></html><?php }} ?>