<?php /* Smarty version Smarty-3.1.13, created on 2018-02-05 11:36:34
         compiled from "E:\b2bstockAdmin\application\views\layout\fileupload.phtml" */ ?>
<?php /*%%SmartyHeaderCode:131515a77d1424c26c8-64811758%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b38db7f74bd216915bdaa75b1625a3222ac9a18f' => 
    array (
      0 => 'E:\\b2bstockAdmin\\application\\views\\layout\\fileupload.phtml',
      1 => 1517305629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '131515a77d1424c26c8-64811758',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'returnfieldid' => 0,
    'accept' => 0,
    'multi' => 0,
    'minsize' => 0,
    'isprivate' => 0,
    'thumbnail' => 0,
    'img_min_height' => 0,
    'img_min_width' => 0,
    'imgsize' => 0,
    'file_type' => 0,
    'ismaterial' => 0,
    'materialtype' => 0,
    'maxsize' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5a77d1428e3058_64443813',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a77d1428e3058_64443813')) {function content_5a77d1428e3058_64443813($_smarty_tpl) {?><div class="marginLeft" style="margin-left:-94px;">
    <div class="fileupload-panel" id="fileupload-panel-<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
" style="margin-left: 97px; ">
        <div class="thumbnail-list" style="float:left;display: none;margin-bottom:.5em;">
            <div class="clearFix"></div>
        </div>
        <input type="file" id="myFile-<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
" accept="<?php echo $_smarty_tpl->tpl_vars['accept']->value;?>
" name="myFile-<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
" style="float:left;width:60px;height:60px;display: none;"/>
        <div style="float:left;">
            <div class="marginstyle">
                <div class="thumbnail-wapper" style="float:left;">
                    <div  style="width:100px;text-align:center;font-size:4em;line-height:1.25em;color:black;border: 1px solid #ccc;">
                        <div class="hand" style="height:75px;background-repeat:no-repeat;background-position-y: center;background-size: 100% 100%;cursor:pointer;background-image:url('/public/images/lotu.jpg');">
                            <div id="upload-<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
" style="line-height:75px;">+</div>
                        </div>
                        <div style="font-size: 12px;line-height: 30px;display: none" id="otherOption-<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
">
                            <div style="background: #e4e5e7;height:30px;">
                                <div style="float: left;width: 50%;border-right: 1px solid #ccc;height: 30px; cursor:pointer;">
                                    <p id="baseUpload-<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
" >本地</p>
                                </div>
                                <div style="float: left;width: 50%;height: 30px;cursor:pointer; ">
                                    <p id="historyUpload-<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
">历史</p>
                                </div>
                            </div>
                        </div>

                    </div>
<!--                    <div class="img-thumbnails" style="background-repeat:no-repeat;height:100px;width:100px;background-size: 100% 100%;display:none;background-position-y: center;">-->
<!--                    </div>-->
                    	<div class="clearFix"></div>
                </div>
<!--                <div style="float:left;margin-left:10px;margin-top:115px;" >-->
<!--                    <button class="btn btn-success"  type="button" id="upload-<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
"><i class="fa fa-upload"></i><span class="bold">上传文件</span></button>-->
<!--                </div>-->
                <div class="clearFix"></div>
            </div>
            <div class="clearFix"></div>
			<progress id="prog-<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
" value="0" min="0" max="100" class="progress-small" style="background:#F9F9F9;width:100px;margin-bottom:5px 0px 5px 0px"></progress>
        </div>
		<div class="clearFix"></div>
    </div>
</div>
    <script type="text/javascript" src="/public/js/utils/fileupload.js"></script>
    <script type="text/javascript" src="/public/js/utils/tvmUpload.js"></script>
    <script>
    
        var rId = '<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
';
        console.log("<?php echo $_smarty_tpl->tpl_vars['returnfieldid']->value;?>
 is ",rId);
        var isMulti = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['multi']->value)===null||$tmp==='' ? "[multi]" : $tmp);?>
';
        var minsize = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['minsize']->value)===null||$tmp==='' ? "[minsize]" : $tmp);?>
';
        var isprivate = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['isprivate']->value)===null||$tmp==='' ? "[isprivate]" : $tmp);?>
';
        var thumbnail = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['thumbnail']->value)===null||$tmp==='' ? "[thumbnail]" : $tmp);?>
';
        var img_min_height = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['img_min_height']->value)===null||$tmp==='' ? "[img_min_height]" : $tmp);?>
';
        var img_min_width = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['img_min_width']->value)===null||$tmp==='' ? "[img_min_width]" : $tmp);?>
';
        var imgsize = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['imgsize']->value)===null||$tmp==='' ? "[imgsize]" : $tmp);?>
';
        var file_type = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['file_type']->value)===null||$tmp==='' ? "[file_type]" : $tmp);?>
';
        var ismaterial = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['ismaterial']->value)===null||$tmp==='' ? "[ismaterial]" : $tmp);?>
';
        var materialtype = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['materialtype']->value)===null||$tmp==='' ? "[materialtype]" : $tmp);?>
';
        var maxsize = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['maxsize']->value)===null||$tmp==='' ? "[maxsize]" : $tmp);?>
';
        var configInfo ={
            "imgsize":imgsize,
            "maxsize":maxsize
        };
        if(img_min_height&&img_min_width){
            $(".img-thumbnails").css('height',img_min_height);
            $(".img-thumbnails").css('width',img_min_width);
        }
        tvmUpload.init(rId,isMulti,minsize,file_type,img_min_height,img_min_width,ismaterial,materialtype,configInfo);
    </script><?php }} ?>