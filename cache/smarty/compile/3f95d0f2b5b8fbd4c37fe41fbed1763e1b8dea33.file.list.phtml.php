<?php /* Smarty version Smarty-3.1.13, created on 2018-02-06 16:43:12
         compiled from "E:\b2bstockAdmin\application\views\createmenu\list.phtml" */ ?>
<?php /*%%SmartyHeaderCode:235125a79233567abc6-96549021%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f95d0f2b5b8fbd4c37fe41fbed1763e1b8dea33' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\createmenu\\list.phtml',
      1 => 1517906587,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '235125a79233567abc6-96549021',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a7923359523a5_52242309',
  'variables' => 
  array (
    'lists' => 0,
    'info' => 0,
    'pages' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7923359523a5_52242309')) {function content_5a7923359523a5_52242309($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="/public/js/choiceCategory.js"></script>
<div class="normalheader transition animated fadeIn" style="margin-bottom:10px;">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="#">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>

            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li>
                        <span>菜单列表</span>
                    </li></ol>
            </div>
            <h2 class="font-light m-b-xs">
                菜单列表            </h2>
            <small>菜单列表</small>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12 animated-panel bounceIn animate" style="animation-delay: 0.2s;">
            <div class="content" style="padding: 5px 40px 40px 10px">
                <div style="text-align: right;margin-right: -30px;">
                    <button class="btn w-xs btn-info " onclick="toCreate()">创建菜单</button>
                </div>
            </div>

            <div class="hpanel">

                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr style="background: lavender;" >
                            <th>菜单列表</th>
                            <th>类名称</th>
                            <th>方法名称</th>
                            <th>菜单类型</th>
                            <th>操作</th>
                        </tr>
                        <tbody class="goods-body">
                        <?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value){
$_smarty_tpl->tpl_vars['info']->_loop = true;
?>
                        <tr class="tr-bd" >
                            <td ><?php echo $_smarty_tpl->tpl_vars['info']->value['menuName'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['action'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['method'];?>
</td>
                            <td><?php if (isset($_smarty_tpl->tpl_vars['info']->value['stat'])&&$_smarty_tpl->tpl_vars['info']->value['stat']==1){?> 主菜单 <?php }?></td>
                            <td>
                                <a href="/Createmenu/index?id=<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
">修改菜单</a>&nbsp;
                                <a href="javascript:void(0)" onclick="OneDel(this,'<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
')">删除菜单</a>&nbsp;
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-sm-8 pull-right pages">
            <span style="float:right"><?php echo $_smarty_tpl->tpl_vars['pages']->value;?>
</span>
        </div>
    </div>

</div>

<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
    function toCreate(){
        location.href = "/Createmenu/index";
    }
    function OneDel(event,id){
        if(!id){
            return false;
        }

        if(!confirm("您确定要删除吗？")){
            return false;
        }
        $.ajax({
            url:'/Createmenu/delmenu',
            type:'post',
            data:'id='+id,
            dataType:'json',
            success:function(data){
                if(data.status == 'success') {
                    $(event).parents("tr").remove();
                    return
                }else{
                    alert(data.msg);
                }
            }
        });

    }

</script><?php }} ?>