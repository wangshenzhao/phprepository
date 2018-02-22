<?php /* Smarty version Smarty-3.1.13, created on 2018-02-09 16:37:49
         compiled from "E:\b2bstockAdmin\application\views\admin\edit.phtml" */ ?>
<?php /*%%SmartyHeaderCode:307735a7806f09dc544-74996529%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '164df3bbf215aea5eb688a818d5e7f147e18c50e' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\admin\\edit.phtml',
      1 => 1518161379,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '307735a7806f09dc544-74996529',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a7806f09fedd6_17049551',
  'variables' => 
  array (
    'info' => 0,
    'menuList1' => 0,
    'info2' => 0,
    'list' => 0,
    'info1' => 0,
    'id' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7806f09fedd6_17049551')) {function content_5a7806f09fedd6_17049551($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="/public/js/jquery.js"></script>
<div class="normalheader transition animated fadeIn" style="margin-bottom:30px;">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="#">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>
            <h2 class="font-light m-b-xs">账户编辑</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 right animated-panel zoomIn" style="animation-delay: 0.1s;">
        <div style="text-align: right;margin-right: 40px;">
            <button class="btn w-xs btn-info " onclick="toList()">账户列表</button>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12 animated-panel bounceIn animate" style="animation-delay: 0.2s;">
            <div class="hpanel">
            <div class="panel-body form-horizontal">
                <div class="form-group"><label class="col-sm-2 control-label">手  机  号：</label>
                    <div class="col-sm-6">
                        <input type="text" class="required pattern form-control m-b" placeholder="手机号" required="required" name="userName" id="userName"  <?php if ((isset($_smarty_tpl->tpl_vars['info']->value['userName'])&&$_smarty_tpl->tpl_vars['info']->value['userName']=='admin')){?>  disabled=disabled <?php }?> value="<?php if ((isset($_smarty_tpl->tpl_vars['info']->value['userName']))){?><?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>
 <?php }?>">
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">菜单：</label>
                    <div class="form-check">
                        <?php  $_smarty_tpl->tpl_vars['info2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuList1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info2']->key => $_smarty_tpl->tpl_vars['info2']->value){
$_smarty_tpl->tpl_vars['info2']->_loop = true;
?>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['menu'])&&in_array($_smarty_tpl->tpl_vars['info2']->value['_id'],$_smarty_tpl->tpl_vars['info']->value['menu'])){?>
                                <input class="form-check-input invalidCheck2" checked type="checkbox"  value="<?php echo $_smarty_tpl->tpl_vars['info2']->value['_id'];?>
"  required>
                                <?php }else{ ?>
                                <input class="form-check-input invalidCheck2" type="checkbox"  value="<?php echo $_smarty_tpl->tpl_vars['info2']->value['_id'];?>
"  required>
                                <?php }?>
                                <label class="form-check-label" for="invalidCheck2">
                                    <?php echo $_smarty_tpl->tpl_vars['info2']->value['menuName'];?>

                                </label>

                        <?php } ?>
                     </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">功能：</label>
                    <div class="form-check">
                        <?php  $_smarty_tpl->tpl_vars['info1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info1']->key => $_smarty_tpl->tpl_vars['info1']->value){
$_smarty_tpl->tpl_vars['info1']->_loop = true;
?>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['menu'])&&in_array($_smarty_tpl->tpl_vars['info1']->value['_id'],$_smarty_tpl->tpl_vars['info']->value['menu'])){?>
                                <input class="form-check-input invalidCheck2" checked type="checkbox"  value="<?php echo $_smarty_tpl->tpl_vars['info1']->value['_id'];?>
"  required>
                                <?php }else{ ?>
                                  <input class="form-check-input invalidCheck2" type="checkbox"  value="<?php echo $_smarty_tpl->tpl_vars['info1']->value['_id'];?>
"  required>

                                <?php }?>
                                <label class="form-check-label" for="invalidCheck2">
                                    <?php echo $_smarty_tpl->tpl_vars['info1']->value['menuName'];?>

                                </label>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-8 col-sm-offset-2">
                    <input type='hidden' name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" id="editId">
                    <button class="btn btn-info" onclick="checkInfo()"> 保存</button>
                </div>

            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    
<script>
    function toList(){
        location.href = "/admin/list";
    }
    function checkInfo() {
        var userName = $.trim($('#userName').val());
        var id = $.trim($('#editId').val());
        if(!userName){
            alert("登录名不能为空")
            return false;
        }
        if(!regPhone(userName)){
            alert('登录名必须是手机号');
            return false;
        }
        var chekBoxObj=$(".invalidCheck2");
        var len=chekBoxObj.length
        var menu='';
        for(var i=0; i<len; i++){
            if(chekBoxObj.eq(i).prop("checked")){
                menu+=chekBoxObj.eq(i).val() + ","
            }
        }
        menu=menu.substr(0,menu.length-1);
        $.ajax({
            url:'/admin/save',
            type:'post',
            data: "userName="+userName+"&id="+id+"&menu="+menu,
            async:false,
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
    function regPhone(phone){
        var preg=/^1\d{10}$/
        var sta=preg.test(phone);
        if(!sta){
            return false;
        }else{
            return phone;
        }
    }
</script>
    <?php }} ?>