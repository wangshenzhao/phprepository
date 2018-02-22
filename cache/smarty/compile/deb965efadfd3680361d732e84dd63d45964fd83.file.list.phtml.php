<?php /* Smarty version Smarty-3.1.13, created on 2018-02-05 14:13:35
         compiled from "E:\b2bstockAdmin\application\views\cashmanage\list.phtml" */ ?>
<?php /*%%SmartyHeaderCode:223035a77f60f5c5632-52865981%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'deb965efadfd3680361d732e84dd63d45964fd83' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\cashmanage\\list.phtml',
      1 => 1517305629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '223035a77f60f5c5632-52865981',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'userName' => 0,
    'lists' => 0,
    'info' => 0,
    'bankList' => 0,
    'statusList' => 0,
    'pages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77f60f88bd28_08875888',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77f60f88bd28_08875888')) {function content_5a77f60f88bd28_08875888($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_smartTruncate')) include 'E:\\b2bstockAdmin\\application\\library\\Smarty\\plugins\\modifier.smartTruncate.php';
?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script src="/public/js/choiceCategory.js"></script>
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
                    <li>
                        <span>提现列表</span>
                    </li></ol>
            </div>
            <h2 class="font-light m-b-xs">
                提现列表            </h2>
            <small>提现列表</small>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12 animated-panel bounceIn animate" style="animation-delay: 0.2s;">
            <div class="content" style="padding: 25px 40px 40px 10px">
                <form role="search" class="form-inline" method="get" action="/Cashmanage/list">
                    <div class="form-group">
                        <input type="hidden" name="active_id" value="0">
                        <input type="hidden" name="tid" value="0">
                        <label>用户名：</label>
                        <input type="text" name="useName" class="form-control" placeholder="用户名" value="<?php if (isset($_smarty_tpl->tpl_vars['userName']->value)){?><?php echo $_smarty_tpl->tpl_vars['userName']->value;?>
<?php }?>">

                    </div>

                    <button type="submit" name="search" class="btn btn btn-primary ">筛选</button>
                </form>
            </div>
            <div class="" style="margin-bottom: 20px;">
                <button class="btn btn-success" id="batch_order">批量审核</button>
            </div>
            <div style="margin-bottom: 5px;">【22：30~06:00】此时段为维护期，禁止审核</div>
            <div class="hpanel">
                <div class="panel-body">
                    <table class="table table-bordered" >
                        <tr style="background: lavender;">
                            <th>
                                <div class="icheckbox_square-green" id="choosAll"></ins></div>
                            </th>
                            <th>用户名称</th>
                            <th>公司名称</th>
                            <th>开户银行</th>
                            <th>银行名称</th>
                            <th>银行帐户</th>
                            <th>开户时间</th>
                            <th>充值余额(元)</th>
                            <th>帐户可用(元)</th>
                            <th>提现金额</th>
                            <th>申请时间</th>
                            <th>状态</th>
                            <th>错误原因</th>
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
                                <?php if ($_smarty_tpl->tpl_vars['info']->value['status']==1){?>
                                <div style="position: relative;margin-top:-5px;" ids="<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
" class="icheckbox_square-green" onclick="Bt_chooseMe(this);">
                                    <ins class="iCheck-helper"></ins>
                                </div>
                                <?php }?>
                            </td>
                            <td  title="<?php echo $_smarty_tpl->tpl_vars['info']->value['bankInfo']['userName'];?>
"><?php echo $_smarty_tpl->tpl_vars['info']->value['bankInfo']['userName'];?>

                            </td>
                            <td ><?php echo $_smarty_tpl->tpl_vars['info']->value['bankInfo']['company'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['bankList']->value[$_smarty_tpl->tpl_vars['info']->value['bankInfo']['bank']];?>
</td>
                            <td title=<?php echo $_smarty_tpl->tpl_vars['info']->value['bankInfo']['bankName'];?>
><?php echo smarty_modifier_smartTruncate($_smarty_tpl->tpl_vars['info']->value['bankInfo']['bankName'],6);?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['bankInfo']['card'];?>
</td>
                            <td>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['bankInfo']['createDate'])){?>
                                <?php echo $_smarty_tpl->tpl_vars['info']->value['bankInfo']['createDate'];?>

                                <?php }?>
                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['bankInfo']['money'];?>
</td>
                            <th>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['bankInfo']['userId'])){?>
                                <?php echo getBalanceInfo($_smarty_tpl->tpl_vars['info']->value['bankInfo']['userId']);?>

                                <?php }?>
                            </th>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['applyCash'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['createDate'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['statusList']->value[$_smarty_tpl->tpl_vars['info']->value['status']];?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['info']->value['status']!=3&&isset($_smarty_tpl->tpl_vars['info']->value['err_msg'])){?>
                                    <?php echo $_smarty_tpl->tpl_vars['info']->value['err_msg'];?>

                                <?php }?>
                            </td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['info']->value['status']==1){?>
                                    <span class="btn btn-sm btn-success" style="margin: 2px;" onclick="examine('<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
',<?php echo $_smarty_tpl->tpl_vars['info']->value['applyCash'];?>
,2);">审核</span>
                                    <span class="btn btn-sm btn-success" style="margin: 2px;" onclick="examine('<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
',<?php echo $_smarty_tpl->tpl_vars['info']->value['applyCash'];?>
,3);">线下打款</span>
<!--                                <span type="button" class="btn-sm btn-danger" onclick="examine('<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
',<?php echo $_smarty_tpl->tpl_vars['info']->value['applyCash'];?>
,3);">拒绝</span>-->
                                <?php }elseif($_smarty_tpl->tpl_vars['info']->value['status']==4){?>
                                    <span class="btn btn-sm btn-success" style="margin: 2px;" onclick="examine('<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
',<?php echo $_smarty_tpl->tpl_vars['info']->value['applyCash'];?>
,3);">线下打款</span>
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

<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
    var Order_JS = {
        init: function () {
            this.Bt_chooseAll();
            this.Bt_batch_order();
        },
        Bt_chooseAll: function () {
            $("#choosAll").on("click", function () {
                if ($(this).hasClass("checked")) {
                    $(this).removeClass("checked");
                } else {
                    $(this).addClass("checked");
                }
                $(".icheckbox_square-green").each(function (i, n) {
                    if (i > 0) {
                        if ($(n).hasClass("checked")) {
                            $(n).removeClass("checked");
                        } else {
                            $(n).addClass("checked");
                        }
                    }
                });
            });
        }, //全选效果
        Bt_batch_order: function () {
            $("#batch_order").on("click", function () {
                var str = '';
                var status = 2;
                $('.icheckbox_square-green.checked').each(function (i, n) {
                    if ($(n).attr('ids')) {
                        str += $(n).attr('ids') + ',';
                    }
                });
                if (str.length > 0) {
                    var data = {
                        id: str,
                        status:status
                    };
                    doExamine(data);
                } else {
                    swal({
                        title: "请选择审批数据",
                        text: "请选择要审批的数据",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: "取消",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "确定"
                    });
                }
            });
        }
    };
    Order_JS.init();
    function Bt_chooseMe(obj) {
        if ($(obj).hasClass("checked")) {
            $(obj).removeClass("checked");
        } else {
            $(obj).addClass("checked");
        }
    }
    function examine(id,applyCash,status) {
        swal({
                title: "审批金额为"+applyCash+"元?",
                text: "是否要审批通过",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    var data = {
                        id: id + ',',
                        status:status
                    };
                    doExamine(data);
                }
            }
        );
    }
    function doExamine(data) {
        $.ajax({
            type: "POST",
            url: '/Cashmanage/examine',
            data: data,
            dataType: 'json',
            success: function (msg) {
                if (msg.status == "success") {
                    swal({
                        title: msg.msg,
                        type: "success"
                    });
                    location.reload();
                }
                if (msg.status == "failure") {
                    swal({
                        title: msg.msg,
                        text:msg.text,
                        type: "error"
                    });
                    return;
                }
                if (msg.status == "warning") {
                    swal({
                        title: msg.msg,
                        type: "warning"
                    });
                    location.reload();
                }
            }
        });
    }
</script><?php }} ?>