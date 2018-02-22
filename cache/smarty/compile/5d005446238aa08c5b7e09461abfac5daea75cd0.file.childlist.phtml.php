<?php /* Smarty version Smarty-3.1.13, created on 2018-02-05 13:07:29
         compiled from "E:\b2bstockAdmin\application\views\account\childlist.phtml" */ ?>
<?php /*%%SmartyHeaderCode:4285a77e69194f337-50534831%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d005446238aa08c5b7e09461abfac5daea75cd0' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\account\\childlist.phtml',
      1 => 1517800293,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4285a77e69194f337-50534831',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
    'list' => 0,
    'info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77e692d38507_00888590',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77e692d38507_00888590')) {function content_5a77e692d38507_00888590($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
                        <span>帐户列表</span>
                    </li></ol>
            </div>
            <h2 class="font-light m-b-xs">
                帐户列表            </h2>
            <small>帐户列表</small>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12 animated-panel bounceIn animate" style="animation-delay: 0.2s;">
            <div class="content" style="padding: 5px 40px 40px 10px">
                <div style="text-align: right;margin-right: -30px;">
                    <button class="btn w-xs btn-info " onclick="toCreate('<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
')">创建子账号</button>
                </div>
            </div>

            <div class="hpanel">

                <div class="panel-body">
                    <table class="table table-bordered" >
                        <tr style="background: lavender;">
                            <th>用户名称</th>
                            <th>开户时间</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        <tbody class="goods-body">
                        <?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value){
$_smarty_tpl->tpl_vars['info']->_loop = true;
?>
                        <tr class="tr-bd" >
                            <td  title="<?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>
"><?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>

                            </td>                            
                            <td>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['creatTime'])){?>
                                <?php echo $_smarty_tpl->tpl_vars['info']->value['creatTime'];?>

                                <?php }?>
                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['remark'];?>
</td>
                            <td>
                                <span onclick=del('<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>
')>删除</span>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

</div>

<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
    function toCreate(id){
        location.href = "/Account/addchild?id="+id;
    }
    function del(id,userName){
        $.ajax({
            url:'/Account/delchild',
            type:'post',
            async:false,
            data:'id='+id+'&userName='+userName,
            dataType:'json',
            success:function(data){
                if(data.status=="success"){
                    alert(data.msg);
                    location.href = data.url;
                }else{
                    alert(data.msg);
                    return false;
                }
            }
        });
    }
</script><?php }} ?>