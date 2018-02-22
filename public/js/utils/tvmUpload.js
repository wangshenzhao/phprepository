var totalPages;
var pageRows = 8;//每页显示条数
var tvmUpload = {
    returnfieldid:'',
    isMulti:false,
    minsize:'',
    file_type:'',
    img_min_height:'',
    img_min_width:'',
    ismaterial:false,
    materialtype:'',
    configInfo:{},
    imgSplit:'|||',

	init:function(returnfieldid,isMulti,minsize,file_type,img_min_height,img_min_width,ismaterial,materialtype,configInfo){
            this.returnfieldid =returnfieldid;
            this.isMulti = isMulti;
            this.minsize = minsize;
            this.file_type = file_type;
            this.img_min_height = img_min_height;
            this.img_min_width = img_min_width;
            this.ismaterial = ismaterial;
            this.materialtype = materialtype;
            this.configInfo = configInfo;
            imgSplit = tvmUpload.imgSplit;
	        var panel_id   = 'fileupload-panel-'+returnfieldid;
            var _this = this;
			$(function(){

            if(ismaterial == 'true'){
                $('#otherOption-'+returnfieldid).show();
            }
            if(isMulti == 'true'){
            	$('.marginstyle').css('margin-top','20px');
                $('.hand').css('height','84px');
            }
            $('#baseUpload-'+returnfieldid).click(function(){
                $("#fileupload-panel-"+returnfieldid+".fileupload-panel .hand").click();
            });
            $('#historyUpload-'+returnfieldid).click(function(){
                _this.materialLib();
            });
	        $("#fileupload-panel-"+returnfieldid+".fileupload-panel .hand").on("click", function() {
	        	var img_num = $('#fileupload-panel-'+returnfieldid+' .thumbnail-list .close_icon').length;
//	        	if(img_num > 2){
//                	alert("最多只能上传3张图片！");
//                	return false;
//                }
	        	$("#fileupload-panel-"+returnfieldid+".fileupload-panel input:file").click();
	        });

	        $("#fileupload-panel-"+returnfieldid+".fileupload-panel input:file").on("change", function(event) {
	            var icon_url = URL.createObjectURL(event.target.files[0]);
	            if(event.target.files[0].type.indexOf('image') >= 0) {

	            }
	            $("#fileupload-panel-"+returnfieldid+".fileupload-panel .thumbnail-wapper").css("border-color", "white");
                _this.setThumbnail('fileupload-panel-'+returnfieldid+'',icon_url);
                _this.uploadFile();
	        });
	        if($.trim($('#'+returnfieldid).val()).length > 0) {
	            if(isMulti == 'true') {
	                var currentImgList = $.trim($('#'+returnfieldid).val()).split(imgSplit);
	                currentImgList.forEach(function(imgUrl){
	                   if(imgUrl && imgUrl.length > 0) {
                           _this.appendImgThumbnail(returnfieldid, imgUrl);
	                   }
	                });
	            } else {
                    _this.setThumbnail('fileupload-panel-'+returnfieldid, $.trim($('#'+returnfieldid).val()));
	                $("#prog-"+returnfieldid).val(100);
	            }
	        }



	        if(isMulti == 'true') {
	            $('body').on('click', '#fileupload-panel-'+returnfieldid+' .thumbnail-list .close_icon i.absolute', function() {
//	            	console.log("删除图片");
	                // delete this image
	                var currentImgSrc = $(this).closest('.close_icon').find('img').attr('src');
	                $('#fileupload-panel-'+returnfieldid+' .thumbnail-list .close_icon').each(function(){
	                    if($(this).closest('.close_icon').find('img').attr('src')==currentImgSrc)    {
	                        $(this).remove();
	                        return false;
	                    }
	                });
	               if( $('#fileupload-panel-'+returnfieldid+' .thumbnail-list .close_icon').length == 0) {
	                   $('#fileupload-panel-'+returnfieldid+' .thumbnail-list').hide();
	                   $('#'+returnfieldid).val('');
	               }

	                $('#'+returnfieldid).val($('#'+returnfieldid).val().replace(currentImgSrc,''));
	                $('#'+returnfieldid).val($('#'+returnfieldid).val().replace(imgSplit+imgSplit,imgSplit));
	            });
	        }


	    });
	},
    materialLib:function(){
            var _this = this;
            $('.sweet-alert,.sweet-overlay').css('display','none');
            _this.getMaterials(_this.materialtype,_this.returnfieldid,1);
            //翻页效果
            $('#pagination-goods').twbsPagination({
                totalPages: totalPages,
                onPageClick: function (event, page) {
                    _this.getMaterials(_this.materialtype,_this.returnfieldid,page);
                }
            });
            $('#goodsModal').modal();
    },
     appendImgThumbnail:function(id, imgUrl) {
    	var currentImgObj = '<div class="close_icon" style="cursor:pointer;height:100px;width:100px;float:left;margin-right:15px;position:relative"><i class="btn btn-info btn-circle checked_prc fa fa-times absolute" style="left: 77px;position: relative;top: 22px;height: 18px;width: 18px;padding: 0;"></i><img style="width:100%;height:100%;padding-bottom: 5px;" src="'+imgUrl+'" /></div>';
        $(currentImgObj).insertBefore($('#fileupload-panel-'+id+' .thumbnail-list .clearFix'));
        $('#fileupload-panel-'+id+' .thumbnail-list').show();
        return false;
    },

     setThumbnail:function(id, url) {
        $("#"+id+".fileupload-panel .hand").css("background-image", 'url(' + url + ')');
        $("#"+id+".fileupload-panel .hand").text('');
        //$("#"+id+".fileupload-panel .img-thumbnails").show();
        //$("#"+id+".fileupload-panel .hand").hide();



    },
    clearThumbnail:function(id, url){
    	$("#fileupload-panel-"+id+".fileupload-panel .hand").css("background-image", 'url(' + url + ')');
        //$("#fileupload-panel-"+id+".fileupload-panel .img-thumbnails").hide();
        //$("#fileupload-panel-"+id+".fileupload-panel .hand").show();
		$("#prog-"+id).val(0);
		$("#"+id).val('');
        $("#upload-"+id).html("+");
    },
     clearPreview:function(id,url){
        $("#prog-"+id).val(0);
        $("#fileupload-panel-"+id+".fileupload-panel .img-thumbnails").css("background-image", 'none');
        $("#fileupload-panel-"+id+".fileupload-panel .thumbnail-wapper").css("border-color", "gray");


        var currentFile = $("#fileupload-panel-"+id+".fileupload-panel input:file");
        currentFile.replaceWith(currentFile.clone(true));

        $("#fileupload-panel-"+id+".fileupload-panel .img-thumbnails").hide();
        $("#fileupload-panel-"+id+".fileupload-panel .hand").show();
        $("#fileupload-panel-"+id+".fileupload-panel .hand").css("background-image", 'url(' + url + ')');
        $("#fileupload-panel-"+id+".fileupload-panel .hand").html('<div style="line-height:75px;" id="upload-'+id+'">+</div>');
//        $("#upload-"+id).html("+");
    },
    getMaterials:function(type,id,page){
	    $.ajax({
	        url: 'getMaterial',
	        type: 'post',
	        data:'type='+type+'&page='+page,
	        dataType: 'json',
	        success: function (data) {
	            if (data.status=='success'){
	                //查询成功
	            	var count = data.count;
	                var str ='',pagination='';
	               	$.each(data.data,function(i,item){
	               		str +='<div class="col-xs-6 col-md-3" style="position:relative" >' +
	                    '<img src="'+item.img_url+'" width="150" height="150" class="thumbnail" data-scid="'+item.uid+'" data-id="'+id+'" data-url="'+item.img_url+'" >'+'</div>';
	                });
	               	if($.trim($('#pagination-goods').html())==''){
	                    totalPages = Math.ceil(count/pageRows);
	                    if(totalPages>1){
	                        for(var i=1;i<=totalPages;i++){
	                            pagination += '<li class="page"><a href="#">'+i+'</a></li>';
	                        }
	                        $('#pagination-goods').html(pagination);
	                    }
	                }
	               	$('#goodsLists').html(str);

	            }
	        },
	        async: false
	    });
	},
    uploadFile:function(){
        returnfieldid = this.returnfieldid;
        configInfo = this.configInfo;
        isMulti = this.isMulti;
        file_type = this.file_type;
        minsize = this.minsize;
        var url = '/public/images/lotu.jpg';
        var img_num = $('#fileupload-panel-'+returnfieldid+' .thumbnail-list .close_icon').length;
//        if(img_num > 2){
//            alert("最多只能上传3张图片！");
//            return false;
//        }
        var _this = this;

        if($(this).text() == '+') {
            $("#fileupload-panel-"+returnfieldid+".fileupload-panel .hand").click();
            return;
        }

        $('#myFile-'+returnfieldid).upload("/Util/fileUpload", {
            auth:isprivate,
            uploadFieldName:'myFile-'+returnfieldid,
            file_type:file_type,
            minsize:minsize,// width * height,
            config:JSON.stringify(configInfo)
        },function(success) {
        	console.log("success is ",success);
            if(success.indexOf('{')!=-1) {
                var retObj = $.parseJSON(success);
                if(retObj.status!='success'){
                	if(isMulti == 'true') {
                		_this.clearPreview(returnfieldid,url);                        
                	}else{
                		_this.clearThumbnail(returnfieldid,url);
                	}
                	alert(retObj.msg);
                    return;
                }else{
                    if(isMulti == 'true') {
//                    	console.log("returnfieldid is",returnfieldid);
//                    	console.log("retObj.url is",retObj.url);
                        if(retObj.status == 'success'){
                            _this.appendImgThumbnail(returnfieldid, retObj.url);
                            _this.clearPreview(returnfieldid,url);
                            $('#'+returnfieldid).val($('#'+returnfieldid).val() +imgSplit+retObj.url);
                            $('#'+returnfieldid).val($('#'+returnfieldid).val().replace(imgSplit+imgSplit,imgSplit));
                        }else{
//                            _this.clearThumbnail(returnfieldid,url);
                            $('#'+returnfieldid).val($('#'+returnfieldid).val().replace(imgSplit+retObj.url,''));
                            $('#'+returnfieldid).val($('#'+returnfieldid).val().replace(imgSplit+imgSplit,imgSplit));
                            alert(retObj.msg);
                            return;
                        }
                    } else {
                        if(retObj.status == 'success'){
                            $('#'+returnfieldid).val(retObj.url);
                            _this.setThumbnail(returnfieldid,retObj.url);
                            $("#prog-"+returnfieldid).val(100);
                        }else{
                            _this.clearThumbnail(returnfieldid,url);
                            $('#'+id).attr('value','');
                            alert(retObj.msg);
                            return;
                        }

                    }
                }
            }
        }, $("#prog-"+returnfieldid));
    }
};



