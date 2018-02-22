<?php /* Smarty version Smarty-3.1.13, created on 2018-02-05 14:16:38
         compiled from "E:\b2bstockAdmin\application\views\trade\list.phtml" */ ?>
<?php /*%%SmartyHeaderCode:239075a77f6c62fec39-15077372%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0e59f562b429abd2b54d1e476208e7593f0e7d7' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\trade\\list.phtml',
      1 => 1517305629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '239075a77f6c62fec39-15077372',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'startTime' => 0,
    'endTime' => 0,
    'name' => 0,
    'code' => 0,
    'lists' => 0,
    'info' => 0,
    'typeList' => 0,
    'statusList' => 0,
    'pages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77f6c6450a38_36512424',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77f6c6450a38_36512424')) {function content_5a77f6c6450a38_36512424($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../layout/header.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
                        <span>大宗交易列表</span>
                    </li></ol>
            </div>
            <h2 class="font-light m-b-xs">
                大宗交易列表            </h2>
            <small>交易列表</small>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12 animated-panel bounceIn animate" style="animation-delay: 0.2s;">
            <div class="content" style="padding: 25px 40px 40px 10px">
                <form role="search" class="form-inline" method="get" action="/Trade/list">
                    <!--                    <input type="hidden" name="active_id" value="0">-->
                    <div class="form-group">
                        <div id="sTime" data-date="2012-03-12" data-date-format="yyyy-mm-dd 00:00:00" class="input-daterange">
                            <label for="startTime">开始时间：</label>
                            <input type="text" class="form-control" id="startTime" name="startTime" value="<?php echo $_smarty_tpl->tpl_vars['startTime']->value;?>
">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="fTime" data-date="2012-03-12" data-date-format="yyyy-mm-dd 23:59:59" class="input-daterange">
                            <label for="endTime">结束时间：</label>
                            <input type="text" class="form-control" id="endTime" name="endTime" value="<?php echo $_smarty_tpl->tpl_vars['endTime']->value;?>
">
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label>用&nbsp;户&nbsp;名&nbsp;：</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
">
                    </div>
                    <div class="form-group">
                        <label>频&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;道：</label>
                        <input type="text" name="code" class="form-control"  value="<?php echo $_smarty_tpl->tpl_vars['code']->value;?>
">
                    </div>
                    <button type="submit" name="search" class="btn btn btn-primary ">搜索</button>
                </form>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr style="background: lavender;align: center;">
                            <th width="8%"></th>
                            <th width="8%">频道</th>
                            <th width="10%">单价(元)</th>
                            <th width="10%">报单数量(秒)</th>
                            <th width="10%">已成数量(秒)</th>
                            <th width="10%">报单总价(元)</th>
                            <th width="10%">报价方向</th>
                            <th width="10%">报价时间</th>
                            <th width="10%">交易用户</th>
                            <th width="7%">状态</th>
                            <th width="7%">操作</th>
                        </tr>
                        <tbody class="goods-body">
                        <?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['info']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value){
$_smarty_tpl->tpl_vars['info']->_loop = true;
?>
                        <tr class="tr-bd" >
                            <td><img src="<?php echo $_smarty_tpl->tpl_vars['info']->value['codeInfo']['headImg'];?>
" class="img-rounded" width="60px;" height="60px;"></td>
                            <td title=<?php echo $_smarty_tpl->tpl_vars['info']->value['codeInfo']['nickName'];?>
><?php echo $_smarty_tpl->tpl_vars['info']->value['codeInfo']['nickName'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['price']/100;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['count'];?>
</td>
                            <td>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['turnoverCount'])){?>
                                    <?php echo $_smarty_tpl->tpl_vars['info']->value['turnoverCount'];?>

                                <?php }?>

                            </td>
                            <td>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['totalprice'])){?>
                                    <?php echo $_smarty_tpl->tpl_vars['info']->value['totalprice']/100;?>

                                <?php }?>
                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['typeList']->value[$_smarty_tpl->tpl_vars['info']->value['type']];?>
</td>
                            <td>
                                <?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['info']->value['createTime']/1000);?>

                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['statusList']->value[$_smarty_tpl->tpl_vars['info']->value['status']];?>
</td>
                            <td>
                                <?php if (isset($_smarty_tpl->tpl_vars['info']->value['turnoverCount'])){?>
                                    <button type="button" class="btn btn-success btn-sm"  onclick="check('<?php echo $_smarty_tpl->tpl_vars['info']->value['codeInfo']['nickName'];?>
','<?php echo $_smarty_tpl->tpl_vars['info']->value['_id'];?>
');" >详情</button>
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
<!--账户记录弹窗-->
<div class="modal fade " id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 1000px;">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 10px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <small class="font-bold" style="font-size:100%;">交易详情列表</small>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <table class="table table-bordered" >
                        <tr style="background: lavender;">
                            <th>频道</th>
                            <th>单价（元）</th>
                            <th>交易数量（秒）</th>
                            <th>交易金额（元）</th>
                            <th>报价时间</th>
                            <th>交易用户</th>
                        </tr>
                        <tbody class="goods-body" id="tradeList">
                        
                        </tbody>
                    </table>
                    <div class="col-sm-8 pull-right pages" >
                        <ul id="pagination" class="pagination-sm pagination"></ul>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../layout/footer.phtml", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script language="JavaScript" type="text/javascript">
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