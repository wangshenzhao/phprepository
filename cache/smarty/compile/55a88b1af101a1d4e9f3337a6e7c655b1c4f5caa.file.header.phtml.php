<?php /* Smarty version Smarty-3.1.13, created on 2018-02-06 12:39:10
         compiled from "E:\b2bstockAdmin\application\views\layout\header.phtml" */ ?>
<?php /*%%SmartyHeaderCode:40825a77ceeb8ea7a8-69126497%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55a88b1af101a1d4e9f3337a6e7c655b1c4f5caa' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\layout\\header.phtml',
      1 => 1517890497,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40825a77ceeb8ea7a8-69126497',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77ceeb911b05_82275628',
  'variables' => 
  array (
    'title' => 0,
    'adminUserName' => 0,
    'menuList' => 0,
    'info' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77ceeb911b05_82275628')) {function content_5a77ceeb911b05_82275628($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
        <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <meta HTTP-EQUIV="Cache-Control" CONTENT="no-store">
        <meta HTTP-EQUIV="Expires" CONTENT="0">
        <link rel="stylesheet" href="/public/vendor/fontawesome/css/font-awesome.css"/>
        <link rel="stylesheet" href="/public/vendor/metisMenu/dist/metisMenu.css"/>
        <link rel="stylesheet" href="/public/vendor/animate.css/animate.css"/>
        <link rel="stylesheet" href="/public/vendor/bootstrap/dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="/public/vendor/xeditable/bootstrap3-editable/css/bootstrap-editable.css"/>
        <link rel="stylesheet" href="/public/vendor/select2-3.5.2/select2.css"/>
        <link rel="stylesheet" href="/public/vendor/select2-bootstrap/select2-bootstrap.css"/>
        <link rel="stylesheet" href="/public/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css"/>
        <link rel="stylesheet" href="/public/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css"/>
        <link rel="stylesheet" href="/public/vendor/sweetalert/lib/sweet-alert.css"/>
        <link rel="stylesheet" href="/public/vendor/toastr/build/toastr.min.css"/>
        <link rel="stylesheet" href="/public/css/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
        <!-- App styles -->
        <link rel="stylesheet" href="/public/css/bootstrap.css">
        <link rel="stylesheet" href="/public/css/style.css">
        <link rel="stylesheet" href="/public/css/page.css"/>
        <script src="/public/vendor/jquery/dist/jquery.min.js"></script>
        <script src="/public/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/public/vendor/jquery-ui/jquery-ui.min.js"></script>
        <script src="/public/vendor/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="/public/vendor/metisMenu/dist/metisMenu.min.js"></script>
        <script src="/public/vendor/iCheck/icheck.min.js"></script>
        <script src="/public/vendor/sparkline/index.js"></script>
        <script src="/public/vendor/moment/moment.js"></script>
        <script src="/public/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js"></script>
        <script src="/public/vendor/xeditable/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
        <script src="/public/vendor/select2-3.5.2/select2.min.js"></script>
        <script src="/public/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
        <script src="/public/vendor/sweetalert/lib/sweet-alert.min.js"></script>
        <script src="/public/vendor/toastr/build/toastr.min.js"></script>
		<script src="/public/js/jquery.js"></script>
        <script src="/public/scripts/jquery.twbsPagination.min.js"></script>
        
    </head>
    <body >
        <!-- Header -->
        <div id="header">
            <div class="color-line">
            </div>
<!--            <div id="logo" class="light-version">-->
<!--                <span>考评系统</span>-->
<!--            </div>-->
            <nav role="navigation">
                <a href="/Index/index">
                    <div class="header-link " ><i class="glyphicon glyphicon-home"></i></div>
                </a>

                <div class="navbar-brand">
                    <span>管理系统 </span>
                </div>

           

                <div class="navbar-right">
                    <ul class="nav navbar-nav no-borders">
                        <li class="dropdown">
                            <a class="dropdown-toggle label-menu-corner" href="" title="查看用户信息">
                                <i style="font-size:16px;font-style: normal;">用户名:<?php echo $_smarty_tpl->tpl_vars['adminUserName']->value;?>
</i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="/Login/logout">
                                <i class="pe-7s-upload pe-rotate-90"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <aside id="menu">
            <div id="navigation">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="#"><span class="nav-label">用户管理</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value){
$_smarty_tpl->tpl_vars['info']->_loop = true;
?>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['stat'])&&$_smarty_tpl->tpl_vars['info']->value['stat']==1){?>
                                    <li ><a href="/<?php echo $_smarty_tpl->tpl_vars['info']->value['action'];?>
/<?php echo $_smarty_tpl->tpl_vars['info']->value['method'];?>
?active_id=1&tid=0"><?php echo $_smarty_tpl->tpl_vars['info']->value['menuName'];?>
</a></li>
                                <?php }?>
                            <?php } ?>

                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
        <div id="wrapper">
           

<?php }} ?>