<?php /* Smarty version Smarty-3.1.13, created on 2018-02-06 15:10:12
         compiled from "E:\b2bstockAdmin\application\views\admin\list.phtml" */ ?>
<?php /*%%SmartyHeaderCode:244965a77fa6d35a1d6-95492149%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a71ca8ae7f3143dcb0b8c6ff15a1d5b10fba8c4f' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\admin\\list.phtml',
      1 => 1517900999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '244965a77fa6d35a1d6-95492149',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77fa6d38fe76_74544917',
  'variables' => 
  array (
    'userName' => 0,
    'lists' => 0,
    'info' => 0,
    'pages' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77fa6d38fe76_74544917')) {function content_5a77fa6d38fe76_74544917($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
                        <span>管理员列表</span>
                    </li></ol>
            </div>
            <h2 class="font-light m-b-xs">
                管理员列表            </h2>
            <small>管理员列表</small>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12 animated-panel bounceIn animate" style="animation-delay: 0.2s;">
            <div class="content" style="padding: 25px 40px 40px 10px">
                <form role="search" class="form-inline" method="get" action="/admin/list">
                    <!--                    <input type="hidden" name="active_id" value="0">-->
                    <div class="form-group">
                        <div>
                            <label for="startTime">用户名：</label>
                            <input type="text" class="form-control" name="userName" value="<?php echo $_smarty_tpl->tpl_vars['userName']->value;?>
">
                        </div>
                    </div>
                    <button type="submit" name="search" class="btn btn btn-primary ">搜索</button>
                </form>
                <div style="text-align: right;margin-right: -30px;">
                    <button class="btn w-xs btn-info " onclick="toCreate()">创建管理员</button>
                </div>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr style="background: lavender;align: center;">
                            <th>用户名</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        <tbody class="goods-body">
                        <?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value){
$_smarty_tpl->tpl_vars['info']->_loop = true;
?>
                        <tr class="tr-bd" >
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['userName'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['addTime'];?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['info']->value['userName']!='admin'){?>
                                <a href="/admin/edit?id=<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
">编辑</a>
                                <a href="javascript:void(0)" onclick="delOne(this,'<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
')">删除</a>
                                <?php }?></td>
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

<script language="JavaScript" type="text/javascript">
    //删除数据
    function delOne(event,id){
        if(!id){
            return false;
        }

        if(!confirm("您确定要删除吗？")){
            return false;
        }
        $.ajax({
            url:'/Admin/deluser',
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
    function toCreate(){
        location.href="/Admin/edit";
    }
    var totalPages;
    var pageSize = 10;
    $(function () {
        $('#sTime,#fTime').datepicker();
    });

    function check(nickName,id) {
        $('#tradeList').empty();
        $('#pagination').empty();
        $('#pagination').removeData("twbs-pagination");
        $('#pagination').unbind('page');

        getDetail(nickName,id,1);
        //翻页效果
        $('#pagination').twbsPagination({
            totalPages: totalPages,
            onPageClick: function (event, page) {
                getDetail(nickName,id,page);
            }
        });
        $('#Modal').modal();
    }

    function getDetail(nickName,id,page) {
        $.ajax({
            url:'/Trade/detail',
            type:'post',
            data:'orderId='+id+'&page='+page,
            dataType:'json',
            success:function(data){
                if(data.status == 'success'){
                    var str = '';
                    var pageStr ='';
                    var count = data.count;
                    $.each(data.data.info,function(i,item){
                        str +=  '<tr class="tr-bd" >' + '<td title="'+nickName+'">'+nickName+'</td>'
                            + '<td> ' + item.price + '</td>'
                            + '<td> ' + item.currentTurnoverCount + '</td>'
                            + '<td> ' + item.currentTotalprice + '</td>'
                            + '<td> ' + item.addTime + '</td>'
                            + '<td> ' + item.name + '</td></tr>';
                    });
                    $('#tradeList').html(str);
                    if($.trim($('#pagination').html())==''){
                        totalPages = Math.ceil(count/pageSize);
                        if(totalPages>1){
                            for(var i=1;i<=totalPages;i++){
                                pageStr += '<li class="page"><a href="#">'+i+'</a></li>';
                            }
                            $('#pagination').html(pageStr);
                        }
                    }
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