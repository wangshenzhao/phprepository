<?php /* Smarty version Smarty-3.1.13, created on 2018-02-09 15:45:28
         compiled from "E:\b2bstockAdmin\application\views\account\create.phtml" */ ?>
<?php /*%%SmartyHeaderCode:81905a77d141b94c63-50865657%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55dfc1a51f56eca7cd4c9664bf77b07cc65469cd' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\account\\create.phtml',
      1 => 1518062440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '81905a77d141b94c63-50865657',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77d141eb0b80_57356436',
  'variables' => 
  array (
    'bankList' => 0,
    'k' => 0,
    'choiceBank' => 0,
    'v' => 0,
    'id' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77d141eb0b80_57356436')) {function content_5a77d141eb0b80_57356436($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
                        <input type="text" class="required pattern form-control m-b" placeholder="手机号" value="" required="required" name="userName" id="userName">
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">密　　码：</label>
                    <div class="col-sm-6">
                        <input type="password" class="required pattern form-control m-b" placeholder="密码" value="" required="required" name="passwd" id="passwd">
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">公司名称：</label>
                    <div class="col-sm-6">
                        <input type="text" class="required pattern form-control m-b" placeholder="公司全称" value="" required="required" name="company" id="company">
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">用户头像：</label>
                    <div class="col-sm-6">
                        <div class="form-group headImg" style="margin-left: -1px;">
                            <?php echo $_smarty_tpl->getSubTemplate ("../layout/fileupload.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('isprivate'=>"false",'accept'=>"image/*",'file_type'=>"image",'progress'=>"false",'returnfieldid'=>"headImg",'thumbnail'=>"false"), 0);?>

                            <input type="hidden" class="form-control" value="" id="headImg" name="picture_url">
                        </div>
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">开户银行：</label>
                    <div class="col-sm-6">
                        <select class="form-control" required="required" name="bank" id="bank">
                            <option value="">--选择银行--</option>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bankList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['choiceBank']->value==$_smarty_tpl->tpl_vars['k']->value){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">银行名称：</label>
                    <div class="col-sm-6">
                        <input type="text" class="required pattern form-control m-b" placeholder="例：建设银行杭州拱宸桥支行" value="" required="required" name="bankName" id="bankName">
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">银行账号：</label>
                    <div class="col-sm-6">
                        <input type="text" class="required pattern form-control m-b" value="" required="required" name="card" id="card">
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">打款金额：</label>
                    <div class="col-sm-6">
                        <input type="text" class="required pattern form-control m-b" value="" required="required" name="money" id="money">
                    </div>
                </div>
                <div class="col-sm-8 col-sm-offset-2">
                    <input type='hidden' name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
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
    function toList(){
        location.href = "/Account/list";
    }
    function checkInfo() {
        var regNum = /^[0-9]*[1-9][0-9]*$/;
        var regMoney = /^(-?\d+)(\.\d+)?$/;
        var userName = $.trim($('#userName').val());
        var company =$.trim($('#company').val());
        var bank = $.trim($('#bank').val());
        var bankName = $.trim($('#bankName').val());
        var card = $.trim($('#card').val());
        var money = $.trim($('#money').val());
        var headImg = $('#headImg').val();
        var passwd = $('#passwd').val();
        if(!userName){
            alert("登录名不能为空")
            return false;
        }else {
             if(!regNum.test(userName)||userName.length !=11){
                 alert("请输入有效的手机号");
                 return false;
             }
         }
        if(!company){
            alert("公司名称不能为空")
            return false;
        }
        if(!headImg){
            alert("请上传用户头像")
            return false;
        }
        if(!bank){
            alert("请选择银行")
            return false;
        }
        if(!bankName){
            alert("银行名称不能为空")
            return false;
        }
        if(!card){
            alert("银行账号不能为空")
            return false;
        }else{
             if(!regNum.test(card)){
                 alert("请输入有效的银行账号");
                 return false;
             }
         }
        if(!passwd){
            alert("密码不能为空");
            return false;
        }
        if(passwd.length<6){
            alert("密码至少需要6位");
            return false;
        }
        if(!money){
            alert("打款金额不能为空")
            return false;
        }else{
             if(!regMoney.test(money)){
                 alert("打款金额格式错误");
                 return false;
             }else {
                $.ajax({
                    url:'/Account/doAccount',
                    type:'post',
                    async:false,
                    data:'passwd='+passwd+'&userName='+userName+"&company="+company+"&headImg="+headImg+"&bank="+bank+"&bankName="+bankName+"&card="+card+"&money="+money,
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