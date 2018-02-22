<?php /* Smarty version Smarty-3.1.13, created on 2018-02-05 11:26:34
         compiled from "E:\b2bstockAdmin\application\views\index\index.phtml" */ ?>
<?php /*%%SmartyHeaderCode:58855a77ceea9507d4-92103308%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd19b59ad40adcb386effa1b3060fd90773d58aed' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\index\\index.phtml',
      1 => 1517305629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '58855a77ceea9507d4-92103308',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'placeList' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77ceeb5352c7_52225684',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77ceeb5352c7_52225684')) {function content_5a77ceeb5352c7_52225684($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="normalheader transition animated fadeIn" style="margin-bottom:30px;">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="#">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>

            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="#">用户列表</a></li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                用户列表            </h2>
            <small>用户列表</small>
        </div>
    </div>
</div>
<div class="content animate-panel" style="padding-bottom: 0px;">
    <div class="row" >
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['placeList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['placeUrl'];?>
?active_id=0&tid=0">
            <div class="col-sm-2 place" >
                <div class="hpanel" style="margin-top: 25px" >
                    <div class="panel-body text-center">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['image'];?>
" style="width: 100%">
                    </div>
                    <div class="panel-footer text-center">
                        <?php echo $_smarty_tpl->tpl_vars['item']->value['placeName'];?>

                    </div>
                </div>
            </div>
        </a>
        <?php } ?>
    </div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>