var vedioUpload = {
	init:function(returnfieldid,minsize,file_type){
	        var panel_id   = 'fileupload-panel-'+returnfieldid;

		$(function(){
	        $("#"+panel_id+" input:file").on("change", function(event) {
	            var icon_url = URL.createObjectURL(event.target.files[0]);
	            // console.log("icon_url's tmp_url is ",icon_url);
	            // tvmUpload.setThumbnail(panel_id,icon_url);
	            $("#ad_"+returnfieldid).text('开始上传').click();
	        });
	        if($.trim($('#'+returnfieldid).val()).length > 0) {
                $("#prog-"+returnfieldid).val(100);
	        }
        	$("#ad_"+returnfieldid).on("click", function() {
	        	var _this = $(this);
	        	if($(this).text() == '上传文件') {
	                $("#"+panel_id+" input:file").click();
	                return;
	            }
//                var fileObj =  $("#"+panel_id+" input:file");
//                console.log("fileObj is",fileObj);
//                var fileSize = fileObj[0].files[0].size;
//                if(fileSize>50*1024*1024){
//                    alert("上传视频过大，视频不能超过50M！");
//                }

            	$('#myFile-'+returnfieldid).upload("/Util/fileupload", {
	                uploadFieldName:'myFile-'+returnfieldid,
	                file_type:file_type,
	                minsize:minsize
            	},function(success) {
            		if(success.indexOf('{')!=-1) {
                        var retObj = $.parseJSON(success);
                        if(retObj.status!='success'){
                            tvmUpload.clearThumbnail(returnfieldid);
                            alert(retObj.msg);
                            $(_this).html("<i class='fa fa-upload'></i><span class='bold'>上传文件</span>");
                            return;
                        }else{
		                	if(retObj.status == 'success'){
		                		$(_this).html("<i class='fa fa-upload'></i><span class='bold'>上传文件</span>");
				                $('#'+returnfieldid).val(retObj.url);
				                $("#prog-"+returnfieldid).val(100);
			            	}else{
			            		tvmUpload.clearThumbnail(returnfieldid);
			            		$('#'+id).attr('value','');
			            		alert(retObj.msg);
			            		$(_this).html("<i class='fa fa-upload'></i><span class='bold'>上传文件</span>");
			            		return;
			            	}
    	            	}
                    }
            	}, $("#prog-"+returnfieldid));
        	});
    	});
	},
	clearThumbnail:function(id){
		$("#prog-"+id).val(0);
		$('#'+id).val('');
		$("#ad_"+id).text('上传文件');
    }

};



