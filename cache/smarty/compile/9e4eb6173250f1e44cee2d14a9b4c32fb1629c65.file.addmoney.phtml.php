<?php /* Smarty version Smarty-3.1.13, created on 2018-02-05 14:09:12
         compiled from "E:\b2bstockAdmin\application\views\account\addmoney.phtml" */ ?>
<?php /*%%SmartyHeaderCode:237885a77f508595bb7-43741380%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9e4eb6173250f1e44cee2d14a9b4c32fb1629c65' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\account\\addmoney.phtml',
      1 => 1517305628,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '237885a77f508595bb7-43741380',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info' => 0,
    'id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77f5087f5ed0_81461771',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77f5087f5ed0_81461771')) {function content_5a77f5087f5ed0_81461771($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="/public/js/jquery.js"></script>
<div class="normalheader transition animated fadeIn" style="margin-bottom:30px;">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="#">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>
            <h2 class="font-light m-b-xs">账户充值</h2>
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
                <div class="form-group"><label class="col-sm-2 control-label">登  录  名：</label>
                    <div class="col-sm-6">
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>

                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">累计充值金额：</label>
                    <div class="col-sm-6">
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['money'];?>

                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">可用余额：</label>
                    <div class="col-sm-6">
                        <?php if (isset($_smarty_tpl->tpl_vars['info']->value['userId'])){?>
                            <?php echo getBalanceInfo($_smarty_tpl->tpl_vars['info']->value['userId']);?>

                        <?php }?>
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">充值金额：</label>
                    <div class="col-sm-6">
                        <input type="text" class="required pattern form-control m-b" placeholder="请输入数字" value="" required="required" name="money" id="money">
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
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
    function toList(){
        location.href = "/Account/list";
    }
    function checkInfo() {
        var regMoney = /^(-?\d+)(\.\d+)?$/;
        var money = $.trim($('#money').val());

        if(!money){
            alert("打款金额不能为空")
            return false;
        }else{
             if(!regMoney.test(money)){
                 alert("打款金额格式错误");
                 return false;
             }else {
                $.ajax({
                    url:'/Account/doAddMoney',
                    type:'post',
                    async:false,
                    data:"money="+money+'&id='+$('#editId').val(),
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
    }
</script><?php }} ?>