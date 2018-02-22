<?php /* Smarty version Smarty-3.1.13, created on 2018-02-09 14:46:49
         compiled from "E:\b2bstockAdmin\application\views\account\list.phtml" */ ?>
<?php /*%%SmartyHeaderCode:304515a77cf94d27fc5-19461592%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '598ff3551583afa1431a829bd1d427c47a97ef18' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\account\\list.phtml',
      1 => 1518158079,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '304515a77cf94d27fc5-19461592',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77cf951f6485_69389058',
  'variables' => 
  array (
    'userName' => 0,
    'userId' => 0,
    'lists' => 0,
    'info' => 0,
    'bankList' => 0,
    'pages' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77cf951f6485_69389058')) {function content_5a77cf951f6485_69389058($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
                <form role="search" class="form-inline" method="get" action="/Account/list">
                    <input type="hidden" name="active_id" value="0">
                    <input type="hidden" name="tid" value="0">
                    <div class="form-group">
                        <label>用户名：</label>
                        <input type="text" name="useName" class="form-control" placeholder="用户名" value="<?php if (isset($_smarty_tpl->tpl_vars['userName']->value)){?><?php echo $_smarty_tpl->tpl_vars['userName']->value;?>
<?php }?>">

                    </div>
                    <button type="submit" name="search" class="btn btn btn-primary ">筛选</button>
                </form>
                <div style="text-align: right;margin-right: -30px;">
                    <?php if (getMatter($_smarty_tpl->tpl_vars['userId']->value,"Account","create")==true){?>
                    <button class="btn w-xs btn-info " onclick="toCreate()">账户开户</button>
                    <?php }?>
                </div>
            </div>

            <div class="hpanel">

                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr style="background: lavender;" >
                            <th>用户头像</th>
                            <th>用户名称</th>
                            <th>公司名称</th>
                            <th>开户银行</th>
                            <th>银行名称</th>
                            <th>银行帐户</th>
                            <th>充值余额(元)</th>
                            <th>帐户可用(元)</th>
                            <th>开户时间</th>
                            <th>操作</th>
                        </tr>
                        <tbody class="goods-body">
                        <?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value){
$_smarty_tpl->tpl_vars['info']->_loop = true;
?>
                        <tr class="tr-bd" >
                            <td>
                                <img src="<?php echo $_smarty_tpl->tpl_vars['info']->value['headImg'];?>
"  class="img-rounded" width="60px;" height="60px;">
                            </td>
                            <td  title="<?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>
"><?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>

                            </td>
                            <td ><?php echo $_smarty_tpl->tpl_vars['info']->value['company'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['bankList']->value[$_smarty_tpl->tpl_vars['info']->value['bank']];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['bankName'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['card'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['money'];?>
</td>
                            <th>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['userId'])){?>
                                    <?php echo getBalanceInfo($_smarty_tpl->tpl_vars['info']->value['userId']);?>

                                <?php }?>
                            </th>
                            <td>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['createDate'])){?>
                                    <?php echo $_smarty_tpl->tpl_vars['info']->value['createDate'];?>

                                <?php }?>
                            </td>
                            <td>
                                <?php if (getMatter($_smarty_tpl->tpl_vars['userId']->value,"Account","edit")==true){?>
                                <a href="/Account/edit?id=<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
">修改信息</a>&nbsp;
                                <?php }?>
                                <?php if (getMatter($_smarty_tpl->tpl_vars['userId']->value,"Account","addMoney")==true){?>
                                <a href="/Account/addMoney?id=<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
">充值</a>&nbsp;
                                <?php }?>
                                <?php if (getMatter($_smarty_tpl->tpl_vars['userId']->value,"Account","childlist")==true){?>
                                <a href="/Account/childlist?id=<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
">子账号管理</a>
                                <?php }?>
                                <?php if (getMatter($_smarty_tpl->tpl_vars['userId']->value,"Account","changePass")==true){?>
                                <a   data-target="#myModal8" onclick="changePassModel('<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>
')">重置密码</a>
                                <?php }?>
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


<div class="modal fade hmodal-info " id="myModal8" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header">
                <h4 class="modal-title">重置密码</h4>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" id="pass">
                    <div class="form-group"><label class="col-sm-4 control-label">用户名</label>
                        <div class="col-sm-8" id="userName">

                        </div>
                        <input type="hidden" class="form-control" name="userName" value="">
                        <input type="hidden" class="form-control" name="id" value="">
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-4 control-label">新密码</label>
                        <div class="col-sm-8"><input type="password" class="form-control" name="password1"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-4 control-label">确认密码</label>
                        <div class="col-sm-8"><input type="password" class="form-control" name="password2"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="chanagePass();">确认</button>
            </div>
        </div>
    </div>
</div>



<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
    function toCreate(){
        location.href = "/Account/create";
    }
    function changePassModel(id,userName){
        $('#userName').html(userName);
        $(':input[name="userName"]').val(userName);
        $(':input[name="id"]').val(id);
        $(':input[name="password1"]').val('');
        $(':input[name="password2"]').val('');
        $('#myModal8').modal();
    }
    function chanagePass(){
        var pass1 = $(':input[name="password1"]').val();
        var pass2 = $(':input[name="password2"]').val();
        if(pass1!=pass2){
            alert("新密码和确认密码不一致");
            return false;
        }
        if(pass1.length<6){
            alert("密码至少需要6位");
            return false;
        }
        var data = $('#pass').serialize();
        console.log('formData',data);
        $.ajax({
            url:'/Account/changePass',
            type:'post',
            data:data,
            dataType:'json',
            success:function(data){
                if(data.status == 'success'){
                    toastr.options = {
                        "positionClass": "toast-top-center",//弹出窗的位置
                    };
                    toastr.info('操作成功');
                    $('#myModal8').modal('hide');
                }else{
                    swal({
                        title: "操作失败",
                        text: "原因："+data.msg
                    });

                }
            },
            async:false
        });

    }
</script><?php }} ?>