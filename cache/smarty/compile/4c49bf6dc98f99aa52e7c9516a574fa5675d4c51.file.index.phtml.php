<?php /* Smarty version Smarty-3.1.13, created on 2018-02-06 16:28:22
         compiled from "E:\b2bstockAdmin\application\views\createmenu\index.phtml" */ ?>
<?php /*%%SmartyHeaderCode:97215a77d4a43ca946-40853525%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4c49bf6dc98f99aa52e7c9516a574fa5675d4c51' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\createmenu\\index.phtml',
      1 => 1517905425,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '97215a77d4a43ca946-40853525',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77d4a43db8b0_59572241',
  'variables' => 
  array (
    'info' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77d4a43db8b0_59572241')) {function content_5a77d4a43db8b0_59572241($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="/public/js/jquery.js"></script>
<div class="normalheader transition animated fadeIn" style="margin-bottom:30px;">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="#">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>
            <h2 class="font-light m-b-xs">菜单编辑</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 right animated-panel zoomIn" style="animation-delay: 0.1s;">
        <div style="text-align: right;margin-right: 40px;">
            <button class="btn w-xs btn-info " onclick="MenuList()">菜单列表列表</button>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12 animated-panel bounceIn animate" style="animation-delay: 0.2s;">
            <div class="hpanel">
                <div class="panel-body form-horizontal">
                    <div class="form-group"><label class="col-sm-2 control-label">菜单名称：</label>
                        <div class="col-sm-6">
                            <input type="text" class="required pattern form-control m-b" placeholder="菜单名称" required="required" name="menuName" id="menuName1" <?php if (isset($_smarty_tpl->tpl_vars['info']->value['menuName'])){?> value="<?php echo $_smarty_tpl->tpl_vars['info']->value['menuName'];?>
" <?php }?>>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">类名称：</label>
                        <div class="col-sm-6">
                            <input type="text" class="required pattern form-control m-b" placeholder="类名称" required="required" name="action" id="action1" <?php if (isset($_smarty_tpl->tpl_vars['info']->value['action'])){?> value="<?php echo $_smarty_tpl->tpl_vars['info']->value['action'];?>
" <?php }?>>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">方法名称：</label>
                        <div class="col-sm-6">
                            <input type="text" class="required pattern form-control m-b" placeholder="类名称" required="required" name="method" id="method1" <?php if (isset($_smarty_tpl->tpl_vars['info']->value['method'])){?> value="<?php echo $_smarty_tpl->tpl_vars['info']->value['method'];?>
" <?php }?>>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">菜单类型：</label>
                        <div class="col-sm-6">
                            <select class="form-control" required="required" name="stat" id="stat1">
                                <option value="">--请选择--</option>
                                <option value="1" <?php if (isset($_smarty_tpl->tpl_vars['info']->value['stat'])&&$_smarty_tpl->tpl_vars['info']->value['stat']==1){?> selected <?php }?>>主菜单</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-8 col-sm-offset-2">
                        <button class="btn btn-info" onclick="checkInfo()"> 保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
    function MenuList(){
        location.href = "/Createmenu/list";
    }
    function checkInfo() {
        var menuName = $.trim($('#menuName1').val());
        var action =$.trim($('#action1').val());
        var method = $.trim($('#method1').val());
        var stat = $.trim($('#stat1').val());
        if(!menuName){
            alert("菜单名称不能空")
            return false;
        }
        if(!action){
            alert("类名称不能为空")
            return false;
        }
        if(!method){
            alert("方法名称不能为空")
            return false;
        }
        $.ajax({
            url:'/Createmenu/create',
            type:'post',
            async:false,
            data:'menuName='+menuName+"&action="+action+"&method="+method+"&stat="+stat,
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