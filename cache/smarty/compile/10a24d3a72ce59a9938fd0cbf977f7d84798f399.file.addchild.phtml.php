<?php /* Smarty version Smarty-3.1.13, created on 2018-02-05 13:08:08
         compiled from "E:\b2bstockAdmin\application\views\account\addchild.phtml" */ ?>
<?php /*%%SmartyHeaderCode:295995a77e6b864cfe3-17011551%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10a24d3a72ce59a9938fd0cbf977f7d84798f399' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\account\\addchild.phtml',
      1 => 1517800293,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '295995a77e6b864cfe3-17011551',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77e6b897af91_50721241',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77e6b897af91_50721241')) {function content_5a77e6b897af91_50721241($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="/public/js/jquery.js"></script>
<div class="normalheader transition animated fadeIn" style="margin-bottom:30px;">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="#">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>
            <h2 class="font-light m-b-xs">账户开户</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 right animated-panel zoomIn" style="animation-delay: 0.1s;">
        <div style="text-align: right;margin-right: 40px;">
            <button class="btn w-xs btn-info " onclick="toList('<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
')">子账户列表</button>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12 animated-panel bounceIn animate" style="animation-delay: 0.2s;">
            <div class="hpanel">
                <div class="panel-body form-horizontal">
                    <div class="form-group"><label class="col-sm-2 control-label">登录名：</label>
                        <div class="col-sm-6">
                            <input type="text" class="required pattern form-control m-b" style="width:230px;" placeholder="手机号" value="" required="required" name="userName" id="userName">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">备&nbsp;&nbsp;&nbsp;&nbsp;注：</label>
                        <div class="col-sm-6">
                            <input type="text" class="required pattern form-control m-b" style="width:230px;" placeholder="" value="" required="required" name="remark" id="remark">
                        </div>
                    </div>
                    <div class="col-sm-8 col-sm-offset-2">
                        <input type='hidden' name="id" id="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
                        <button class="btn btn-info" onclick="checkInfo()"> 保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
    function toList(id){
        location.href = "/Account/childlist?id="+id;
    }
    function checkInfo() {
        var id = $('#id').val();
        var regNum = /^[0-9]*[1-9][0-9]*$/;
        var userName = $.trim($('#userName').val());
        var remark = $.trim($('#remark').val());
        if (!id){
            alert("无效数据");
            return false;
        }
        if(!userName){
            alert("登录名不能为空");
            return false;
        }        
        if(!regNum.test(userName)||userName.length !=11){
            alert("请输入有效的手机号");
            return false;
        } else {
            $.ajax({
                url:'/Account/dochild',
                type:'post',
                async:false,
                data:'id='+id+'&userName='+userName+'&remark='+remark,
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
    }
</script><?php }} ?>