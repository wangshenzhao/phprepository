<?php /* Smarty version Smarty-3.1.13, created on 2018-02-05 11:26:35
         compiled from "E:\b2bstockAdmin\application\views\layout\footer.phtml" */ ?>
<?php /*%%SmartyHeaderCode:138915a77ceebcca6d8-72084762%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b168364cd3c1121a9470838b615ade745cd474d3' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\layout\\footer.phtml',
      1 => 1517305629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138915a77ceebcca6d8-72084762',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'activeId' => 0,
    'tid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77ceebcf3db0_66269643',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77ceebcf3db0_66269643')) {function content_5a77ceebcf3db0_66269643($_smarty_tpl) {?><input type="hidden" name="active_id" value="<?php echo $_smarty_tpl->tpl_vars['activeId']->value;?>
" id="active_id">
<input type="hidden" name="tab_id" value="<?php echo $_smarty_tpl->tpl_vars['tid']->value;?>
" id="tab_id">
</div>
</body>
</html>
<script language='javascript'>
    $(function () {
        aid = $("#active_id").val();
        tid = $("#tab_id").val();
        $("#side-menu>li").each(function (i, n) {
            if (i == aid) {
                $(n).attr("class", "active");
                $(n).find("ul").attr("class", "nav nav-second-level collapse in").attr("aria-expanded", "true").attr("style", "");
                $(n).find("li").eq(tid).addClass("active").attr("style","background:#EEEEEE");
            }
        });

    });
</script><?php }} ?>