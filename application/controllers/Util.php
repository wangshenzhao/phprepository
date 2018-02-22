<?php
error_reporting(0);
ini_set( 'display_errors', 0 );

class UtilController extends BaseController {
    protected $config;
    public function fileUploadAction() {
        $this->config = Yaf_Application::app()->getConfig();
        Yaf_Dispatcher::getInstance()->disableView();
        $verb = $_SERVER['REQUEST_METHOD'];
        if($verb == 'POST') {
            try {
                $app_root           = $_SERVER['DOCUMENT_ROOT'];
                $save_to            = 'files';//$_POST['save_to'];                // '/Public/user-uploads'
                $upload_root        = $this->config->uploadRoot;
                $uploadFieldName    = $_POST['uploadFieldName'];
                $file_type          = $_FILES[$uploadFieldName]['type'];
                $auth               = $_POST['auth'];
                $minsize			= $_POST['minsize'];
				$file_type			= $_POST['file_type'];
                $otherConfigStr = $_POST['config'];
                if($otherConfigStr){
                    $otherConfig = json_decode($otherConfigStr,true);
                }
                $maxFileSize = ini_get('upload_max_filesize');
                $maxSize = ini_get('post_max_size');
                $maxFileSizeInt = $this->return_bytes($maxFileSize);
                $maxSizeInt = $this->return_bytes($maxSize);
                $minValue = min($maxFileSizeInt,$maxSizeInt);

                if($_FILES[$uploadFieldName]['size']>$minValue){
                    echo json_encode(array('status'=>'faild','msg'=>'上传文件超过上限'));
                    exit;
                }



				if ($minsize!="[minsize]"){
					$minsize = explode('*', $minsize);
					$min_width = $minsize[0];
					$min_height = $minsize[1];
				}
                if(mb_ereg_match('image/*', $file_type)) {
                    $save_to = 'images';
                }

                if(mb_ereg_match('video/*', $file_type)) {
                    $save_to = 'videos';
                }

                if ($auth == 'true') {
                    $upload_root = '/private/user-uploads';
                }

//                $save_to = $upload_root.'/'.$save_to;
                if(!isset($uploadFieldName)) {
                    $uploadFieldName = 'myFile';
                }
//                var_dump($_FILES);
                //echo file_exists($_FILES[$uploadFieldName]['tmp_name']);

                $info       = pathinfo($_FILES[$uploadFieldName]['name']);
                $extension = $info['extension'];
				if ($file_type == 'image'){
					$img_type = array('bmp','jpg','png','gif','.jpeg');
					if(!in_array($extension,$img_type)){
						echo json_encode(array('status'=>'faild','msg'=>'请上传图片类型！'));
                        return;
					}
				}
				if ($file_type == "video"){
					$video_type = array('avi','wma','rmvb','rm','flash','mp4');
					if(!in_array($extension,$video_type)){
						echo json_encode(array('status'=>'faild','msg'=>'请上传视频类型文件！'));
                        return;
					}
				}
                if ($file_type == "audio"){
					$video_type = array('mp3','m4a');
					if(!in_array($extension,$video_type)){
						echo json_encode(array('status'=>'faild','msg'=>'请上传音频类型文件！'));
                        return;
					}
				}
                if (isset($extension) && strlen($extension)) {
                    $extension = '.' .$extension;
                }
				
                $now        = date_create();
                $foldername = date('Ymd');
                $folder     = $app_root . $save_to . '/' . $foldername;
                $save_to    = $this->config->cdnUrl;
                if(!file_exists($folder)) {
                    $oldmask = umask(0);
                    mkdir($folder, 0777, true);
                    //mkdir('/var/www/business'.'/Public/user-uploads/images', 0777, true);
                    umask($oldmask);
                }
                $fileName   = '/'. date_timestamp_get($now).'-'.mt_rand(10000,65535) . $extension;
                $target     = $folder . $fileName;
                if(file_exists($_FILES[$uploadFieldName]['tmp_name'])) {
                    if(!file_exists($folder)) {
                    	echo json_encode(array('status'=>'faild','msg'=>'没有权限，创建文件夹失败！'));
//                        echo 'error1:'.$_FILES[$uploadFieldName]['tmp_name'];
                        return;
                    }
                    $imgUrl = $foldername.$fileName;
                    rename($_FILES[$uploadFieldName]['tmp_name'],$target);
                    Tools::putImg($target,$imgUrl);
                    if(!file_exists($target)) {
                    	echo json_encode(array('status'=>'faild','msg'=>'创建文件失败！'));
                        return;
                    } else {
                        chmod($target,0777);
                        $size = filesize($target);
                        $img_info = getimagesize($target);                        
                        $img_width = $img_info[0];
                        $img_height = $img_info[1];
                        $fileSizeLimit = $this->config->fileSizeLimit;
                        if ($file_type == "video"||$file_type == "audio"){
                            $limitFileSize = $fileSizeLimit->$file_type;
                        	if ($size > $this->return_bytes($limitFileSize)){	//不能超过5M
                        		echo json_encode(array('status'=>'faild','msg'=>'上传失败！上传文件过大，文件不能超过'.$limitFileSize.'！'));
	                        }else{
	                        	echo json_encode(array('status'=>'success','url'=>$save_to.'/'.$foldername.$fileName));
	                        }
                        }
                        if ($file_type == "image"){
                            $limitFileSize = $fileSizeLimit->$file_type;
	                        if ($size> $this->return_bytes($limitFileSize)){	//不能超过300KB
								echo json_encode(array('status'=>'faild','msg'=>'上传失败！上传文件过大，图片不能超过'.$limitFileSize.'！'));
	                        }else {

                                if($otherConfig){
                                    if(isset($otherConfig['imgsize']) && $otherConfig['imgsize']!='[imgsize]'){
                                        //判断尺寸
                                        $targetWH = explode("*",$otherConfig['imgsize']);
                                        if($img_width>$targetWH[0] || $img_height>$targetWH[1]){
                                            echo json_encode(array('status'=>'faild','msg'=>'尺寸不符合要求'));
                                            exit;
                                        }
                                    }
                                    if(isset($otherConfig['maxsize']) && $otherConfig['maxsize'] !='[maxsize]' && $size>$otherConfig['maxsize']){
                                        echo json_encode(array('status'=>'faild','msg'=>'文件大小不符合要求'));
                                        exit;
                                    }
                                }

	                        	if ($minsize == "[minsize]"){
	                        		echo json_encode(array('status'=>'success','url'=>$save_to.'/'.$foldername.$fileName));
//	                        		echo $save_to.'/'.$foldername.$fileName;
	                        	}else{
		                        	if ($img_height<$min_height||$img_width<$min_width){
		                        		echo json_encode(array('status'=>'faild','msg'=>'上传图片尺寸过小，建议图片尺寸为'.$min_width.'*'.$min_height));
//	                        			echo "min_size";
	                        		}else{
	                        			$url = $save_to.'/'.$foldername.$fileName."_".$min_width."_".$min_height."_0".$extension;
	                        			echo json_encode(array('status'=>'success','url'=>$url));
			                        }
	                        	}
		                        
	                        }
                        }
                    }
                } else {
                	echo json_encode(array('status'=>'faild','msg'=>'上传文件失败！'));
                }
            } catch (Exception $e) {
            	echo json_encode(array('status'=>'faild','msg'=>$e->getMessage()));
//                echo $e->getMessage();
            }
        }
    }

    public function return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val{strlen($val)-1});
        switch($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }

}

?>