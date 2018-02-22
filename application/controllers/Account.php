<?php
/**
 * 开户操作
 */
class AccountController extends BaseController{
    /*
     * 账户开户
     */
    public function createAction(){
        $this->_view->title = '账户开户';
        $bankList = $this->config->bank;
        $this->_view->bankList = $bankList;
        $this->_view->choiceBank = '';
    }
    /**
     * 添加账户处理
     */
    public function doAccountAction(){
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        $UserModel = new UserModel();
        $UserUpLogModel = new UserUpLogModel();
        $userName = $_POST['userName'];
        $company = $_POST['company'];
        $bank = +$_POST['bank'];
        $bankName = $_POST['bankName'];
        $card = $_POST['card'];
        $money = isset($_POST['money'])?+$_POST['money']:'';
        $YuserName = isset($_POST['YuserName'])?$_POST['YuserName']:'';
        $Ycard = isset($_POST['Ycard'])?$_POST['Ycard']:'';
        $headImg = $_POST['headImg'];
        $passwd =  isset($_POST['passwd'])?$_POST['passwd']:'';

        $result['status'] = 'failed';
        if($id){
            $_id = new MongoId($id);
        }else{
            $_id = new MongoId();
        }
        $strId = $_id->{'$id'};
        if(!$userName||!$company||!$bank||!$bankName||!$card){
            $result['msg'] = "缺少必要参数！";
            exit(json_encode($result));
        }else{
            if(!$id){
                if(!$passwd){
                    $result['msg'] = "缺少必要的参数！";
                    exit(json_encode($result));
                }
            }

            $newMoney = +sprintf("%01.2f", $money);
            $data = array(
                '_id'=>$_id,
                'userId'=>'bst'.$strId,
                'userName'=>$userName,
                'company'=>$company,
                'headImg'=>$headImg,
                'bank'=>$bank,
                'bankName'=>$bankName,
                'card'=>$card,
            );
            $where = array(
                'user.userName'=>$userName
            );
            $num = $UserModel->getNum($where);
            if($id){
                if ($YuserName!=$userName){
                    if($num>0){
                        $result['msg'] = "登陆名已占用！";
                        exit(json_encode($result));
                    }
                }
                $where = array(
                    '_id'   => $_id
                );
                $oldInfo  = $UserModel->getInfo($where);
                $dataLog = array(
                    'oldInfo'=>$oldInfo,
                    'newInfo'=>$data,
                    'remark'=>'修改主账号'.$YuserName,
                    'upDate'=>date('Y-m-d H:i:s')
                );
                $UserUpLogModel->insert($dataLog);
                if ($Ycard!=$card){
                    $data['uaId'] = $oldInfo['uaId'];
                    $accountInfo = saveAccount($data);//绑定银行卡
                    if (!$accountInfo){
                        $result['msg'] = "绑定银行卡失败！";
                        exit(json_encode($result));
                    }
                }
                $upData['$set'] = array(
                    'user.$.userName' => $userName,
                    'company'=>$company,
                    'headImg'=>$headImg,
                    'bank'=>$bank,
                    'bankName'=>$bankName,
                    'card'=>$card,
                    'uaId'=>$data['uaId']
                );
                $upWhere = array(
                    '_id'   => $_id,
                    'user.userName' => $YuserName,
                    'user.isChild'=>0,
                );
                if($passwd){
                    $upWhere['user.passWord'] = md5($this->config->userPassWordPrefix.$passwd);
                }

                $UserModel->updateInfo($upData,$upWhere);
                if ($oldInfo['headImg']!=$headImg||$oldInfo['company']!=$company){
                    $info = array(
                        'userId' => $oldInfo['userId'],
                        'company' => $company,
                        'headImg' => $headImg
                    );
                    $rtn = pushAccount($info);
                    if($rtn['status'] == true){
                        $result['status'] = 'success';
                        $result['msg'] = "编辑成功！";
                        $result['url'] = '/Account/list';
                        exit(json_encode($result));
                    } else {
                        $result['msg'] = $rtn['message'];
                        exit(json_encode($result));
                    }
                } else {
                    $result['status'] = 'success';
                    $result['msg'] = "编辑成功！";
                    $result['url'] = '/Account/list';
                    exit(json_encode($result));
                }
            }else{

                $data['money'] = $newMoney;
                $data['createDate'] = date('Y-m-d H:i:s');
                if($num>0){
                    $result['msg'] = "登陆名已占用！";
                    exit(json_encode($result));
                }
                $accountInfo = saveAccount($data);//绑定银行卡
                if ($accountInfo&&$accountInfo['status']==1){
                    $data['uaId'] = $accountInfo['data']['id'];
                }else {
                    $result['msg'] = isset($accountInfo['msg'])?"绑定银行卡失败，".$accountInfo['msg']:"绑定银行卡失败！";
                    exit(json_encode($result));
                }
                unset($data['userName']);
                $data['user'] = array(
                    array(
                        'userName'=>$userName,
                        'isChild'=>0,
                        'creatTime'=>date('Y-m-d H:i:s'),
                        'remark'=>'',
                        'passWord'=>md5($this->config->userPassWordPrefix.$passwd)
                    )
                );
                $UserModel->addUser($data);
                //充值
                if($newMoney>0) {
                    $logModel = new MoneyLogModel();
                    $logData = array(
                        'userId' => $data['userId'],
                        'money' => $newMoney,
                        'date' => date('Y-m-d H:i:s')
                    );
                    $logInfo = $logModel->insert($logData);
                    $info = array(
                        'userId' => $data['userId'],
                        'id' => $logInfo['_id']->{'$id'},
                        'money' => $newMoney
                    );
                    $rtn = addBalance($info);
                    if (!$rtn) {
                        $result['msg'] = "充值失败！";
                        exit(json_encode($result));
                    }
                }
                $res = pushAccount($data);
                if($res['status'] == true){
                    $result['status'] = 'success';
                    $result['msg'] = "保存成功！";
                    $result['url'] = '/Account/list';
                    exit(json_encode($result));
                } else {
                    $result['msg'] = $res['message'];
                    exit(json_encode($result));
                }
            }
        }
    }

    /**
     * 子账号管理
     */
    public function childlistAction(){
        $this->_view->title = '子账号管理';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        if(!$id){
            echo $this->error('无效数据','/Account/list');
            exit;
        }
        $UserModel = new UserModel();
        $where = array(
            '_id'   => new MongoId($id)
        );
        $info  = $UserModel->getInfo($where);
        $list = array();
        if ($info){
            foreach ($info['user'] as $k => $v){
                if($v['isChild']==1){
                    $list[$k]['userName'] = $v['userName'];
                    $list[$k]['creatTime'] = $v['creatTime'];
                    $list[$k]['remark'] = $v['remark'];
                }
            }
        }
        $this->_view->list = $list;
        $this->_view->id = $id;
    }
    /**
     * 添加子账号
     */
    public function addchildAction(){
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        if(!$id){
            echo $this->error('无效数据','/Account/list');
            exit;
        }
        $info = array();
        $title = "添加子账号";
        $this->_view->id = $id;
        $this->_view->title = $title;
        $this->_view->info = $info;
    }    
    /**
     * 处理子账号
     */
    public function dochildAction(){
        $UserModel = new UserModel();
        $id = $_REQUEST['id'];
        $userName = $_REQUEST['userName'];
        $passWord = $_REQUEST['passWord'];
        $remark = $_REQUEST['remark']?$_REQUEST['remark']:'';
        $result['status'] = 'failed';
        if(!$userName||!$passWord){
            $result['msg'] = "缺少必要参数！";
            exit(json_encode($result));
        }
        $where = array(
            'user.userName'=>$userName
        );
        $num = $UserModel->getNum($where);
        if ($num>0){
            $result['msg'] = "登陆名已占用！";
            exit(json_encode($result));
        }
        $passWord = md5($this->config->userPassWordPrefix.$passWord);
        $data['$addToSet'] = array(
            'user'=>array(
                'userName'=>$userName,
                'isChild'=>1,
                'creatTime'=>date('Y-m-d H:i:s'),
                'remark'=>$remark,
                'passWord'=>$passWord
            )
        );
        $upWhere = array(
            '_id' => new MongoId($id)
        );
        $UserModel->updateInfo($data,$upWhere);
        $result['status'] = 'success';
        $result['msg'] = "保存成功！";
        $result['url'] = '/Account/childlist?id='.$id;
        exit(json_encode($result));
    }
    /**
     * 删除子账号
     */
    public function delchildAction(){
        $UserUpLogModel = new UserUpLogModel();
        $userModel = new UserModel();
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        $userName = $_REQUEST['userName'];
        if(!$id){
            echo $this->error('无效数据','/Account/list');
            exit;
        }
        $where = array(
            '_id'   => new MongoId($id),
            'user' => array(
                '$elemMatch'=>array(
                    'userName' => $userName,
                    'isChild' => 1
                )
            )
        );
        $oldInfo  = $userModel->getInfo($where);
        $data['$pull'] = array(
            'user'=>array(
                'userName'=>$userName,
                'isChild' =>1
            )
        );
        $res = $userModel->updateInfo($data,$where);
        if ($res['updatedExisting']==true){
            $dataLog = array(
                'oldInfo'=>$oldInfo,
                'newInfo'=>array(
                    'user'=>array(
                        'userName'=>$userName,
                        'from' => 'admin'
                    )
                ),
                'remark'=>'删除子账号'.$userName,
                'upDate'=>date('Y-m-d H:i:s')
            );
            $UserUpLogModel->insert($dataLog);
            $result['status'] = 'success';
            $result['msg'] = "删除成功！";
            $result['url'] = '/Account/childlist?id='.$id;
            exit(json_encode($result));
        }else {
            $result['status'] = 'failed';
            $result['msg'] = "删除失败！";
            $result['url'] = '/Account/childlist?id='.$id;
            exit(json_encode($result));
        }
    }
    /*
     * 修改账户
     */
    public function editAction(){
        $this->_view->title = '账户编辑';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        if(!$id){
            echo $this->error('无效数据','/Account/list');
            exit;
        }
        $UserModel = new UserModel();
        $where = array(
            '_id'   => new MongoId($id)
        );
        $info  = $UserModel->getInfo($where);
        if ($info['user']){
            foreach ($info['user'] as $v){
                if($v['isChild']==0){
                    $info['userName'] = $v['userName'];
                }
            }
        }
        $this->_view->info = $info;
        $bankList = $this->config->bank;
        $this->_view->bankList = $bankList;
        $this->_view->id = $id;

    }
    /*
     * 账户列表
     */
    public function listAction(){
        $UserModel = new UserModel();
        //默认每页条目
        $num = $this->config->page->list->number;
        //总条目数
        $userName = isset($_REQUEST['useName'])?trim($_REQUEST['useName']):'';
        $where = array();
        if($userName) {
            $where = array(
                'user.userName' => $userName
            );
        }
        $where['user.isChild'] = 0;
        $count=$UserModel->getNum($where);
        //实例分页
        $pageObj=getpage($count,$num);
        //首条目
        $firstRow = $pageObj->firstRow;
        //查询订单
        $shieldAccounts = Tools::objectToArray($this->config->shieldAccounts);
        $protectAccounts = Tools::objectToArray($this->config->protectAccounts);
        $isShield = false;
        if(in_array($this->userId,$shieldAccounts)){
            $isShield = true;
        }
        $lists = $UserModel->getLists($where,$firstRow,$num);
        $info = array();
        if ($lists){
            foreach ($lists as $k=>$val){
                foreach ($val['user'] as $v) {
                    if ($isShield){
                        if(in_array($val['userId'],$protectAccounts)){
                            break;
                        } 
                    }
                    if ($v['isChild']==0){
                        unset($val['user']);
                        $val['userName'] = $v['userName'];
                        $info[] = $val;
                    }
                }
            }
        }
        $this->_view->bankList = Tools::objectToArray($this->config->bank);
        $this->_view->userName = $userName;
        $this->_view->lists  = $info;
        $this->_view->pages = $pageObj->show();
        $this->_view->title = '账户列表';
    }


    public function addmoneyAction (){
        $this->_view->title = '账户充值';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        if(!$id){
            echo $this->error('无效数据','/Account/list');
            exit;
        }
        $UserModel = new UserModel();
        $where = array(
            '_id'   => new MongoId($id)
        );
        $info  = $UserModel->getInfo($where);
        $info['userName'] = '';
        if ($info['user']){
            foreach ($info['user'] as $v){
                if($v['isChild']==0){
                    $info['userName'] = $v['userName'];
                }
            }
        }
        $this->_view->info = $info;
        $this->_view->id = $id;
    }

    public function doAddMoneyAction(){
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        $money = isset($_REQUEST['money'])?$_REQUEST['money']:0;
        if(!$id){
            $result['msg'] = "无效的参数！";
            exit(json_encode($result));
        }
        if($money<0){
            $result['msg'] = "金额不能为负！";
            exit(json_encode($result));
        }
        $UserModel = new UserModel();
        $where = array(
            '_id'   => new MongoId($id)
        );
        $info  = $UserModel->getInfo($where);
        $newMoney = $info['money'] + $money;
        $newMoney = sprintf("%01.2f", $newMoney);

        //先充值，后改库
        $logModel = new MoneyLogModel();
        $data = array(
            'userId'    =>'bst'.$id,
            'money'     =>$money,
            'date'      =>date('Y-m-d H:i:s')
        );
        $logInfo = $logModel->insert($data);
        $info = array(
            'userId'    =>'bst'.$id,
            'id'        =>$logInfo['_id']->{'$id'},
            'money'     =>$money
        );

        $rtn = addBalance($info);
        if(!$rtn){
            $result['status'] = 'error';
            $result['msg'] = "充值失败！";
        }
        $where['money'] = $newMoney;
        $rtn = $UserModel->updateUser($where);
        if($rtn){
            $result['status'] = 'success';
            $result['msg'] = "编辑成功！";
            $result['url'] = '/Account/list';
        }
        exit(json_encode($result));
    }

    public function changePassAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $id =  isset($_POST['id'])?$_POST['id']:'';
        $pass = isset($_POST['password1'])?$_POST['password1']:'';
        $userName = isset($_POST['userName'])?$_POST['userName']:'';
        $UserUpLogModel = new UserUpLogModel();
        if(!$id || !$pass || !$userName){
            echo json_encode(array("status"=>"error","msg"=>"无效的参数"));
            exit;
        }
        $UserModel = new UserModel();
        $where = array(
            '_id'   => new MongoId($id)
        );
        $where['user.userName'] = $userName;

        $setData = array(
            'user.$.passWord'   =>md5($this->config->userPassWordPrefix.$pass)
        );
        $oldInfo  = $UserModel->getInfo($where);
        $updateRtn = $UserModel->updateOne($setData,$where);
        if ($updateRtn['updatedExisting']) {
            $logData = array(
                'userName'  =>$userName,
                'passWord'  =>md5($this->config->userPassWordPrefix.$pass)
            );
            $dataLog = array(
                'oldInfo'=>$oldInfo,
                'newInfo'=>$logData,
                'remark'=>'修改密码',
                'upDate'=>date('Y-m-d H:i:s')
            );
            $UserUpLogModel->insert($dataLog);

            $rtn = array(
                    'status' =>'success',
                    'msg'   =>'修改成功'
            );
        } else {
            $rtn = array(
                    'status' =>'error',
                    'msg'   =>$updateRtn['err']
            );
        }
        echo json_encode($rtn);
        exit;

    }
    public function changeChildAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $UserUpLogModel = new UserUpLogModel();
        $id =  isset($_POST['changeId'])?$_POST['changeId']:'';
        $userName = isset($_POST['changeUserName'])?$_POST['changeUserName']:'';
        $oldUserName = isset($_POST['changeOldUserName'])?$_POST['changeOldUserName']:'';
        $remark = isset($_POST['changeRemark'])?$_POST['changeRemark']:'';
        if(!$id || !$oldUserName || !$userName){
            echo json_encode(array("status"=>"error","msg"=>"无效的参数"));
            exit;
        }
        $UserModel = new UserModel();
        $where = array(
            '_id'   => new MongoId($id)
        );
        $where['user.userName'] = $oldUserName;
        $oldInfo  = $UserModel->getInfo($where);

        $setData = array(
            'user.$.userName'   =>$userName,
            'user.$.remark'     =>$remark
        );
        $updateRtn = $UserModel->updateOne($setData,$where);
        if ($updateRtn['updatedExisting']) {
            $dataLog = array(
                'oldInfo'=>$oldInfo,
                'newInfo'=>$setData,
                'remark'=>'修改子帐号信息'.$oldUserName,
                'upDate'=>date('Y-m-d H:i:s')
            );
            $UserUpLogModel->insert($dataLog);

            $rtn = array(
                'status' =>'success',
                'msg'   =>'修改成功'
            );
        } else {
            $rtn = array(
                'status' =>'error',
                'msg'   =>$updateRtn['err']
            );
        }
        echo json_encode($rtn);
        exit;
    }
}
