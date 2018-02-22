<?php
/**
 * Created by PhpStorm.
 * User: ming
 * Date: 2016/3/30
 * Time: 10:21
 */
header("Access-Control-Allow-Origin: *");

class ApiController extends BaseController{

    public function init(){
        $this->config = Yaf_Application::app()->getConfig();
        Yaf_Dispatcher::getInstance()->disableView();
    }

    public function doTradeAction(){
        $id = isset($_POST['id'])?trim($_POST['id']):'';
        $rtn = array();
        if(!$id){
            $rtn = array(
                'status'    =>'error',
                'msg'   =>'无效的参数'
            );
            echo json_encode($rtn);
            exit;
        }
        $userModel = new UserModel();
        $where = array(
            '_id'   => new MongoId($id)
        );
        $info  = $userModel->getInfo($where);
        $rtn = array(
            'status'    =>'success',
            'msg'   =>'成功',
            'money' =>$info['money']
        );
        echo json_encode($rtn);
        exit;
    }

    /**
     * 通过手机号获取用户userId
     */
    public function getUserIdAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $phone = isset($_POST['phone'])?trim($_POST['phone']):'';
        $sign = isset($_POST['sign'])?trim($_POST['sign']):'';
        $key='8d0d972086492997fd761c074c0bc8a0';
        $date=date('Ymd');
        if(!$phone||!$sign){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'无效的参数'
            );
            echo json_encode($rtn);
            exit;
        }
        if (md5($key.$date)!=$sign){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'签名错误'
            );
            echo json_encode($rtn);
            exit;
        }
        $userModel = new UserModel();
        $where = array(
            'user' => array(
                '$elemMatch'=>array(
                    'userName' => $phone
                )
            )
        );
        $info  = $userModel->getInfo($where);
        if ($info){
            $isChild = '';
            $remark = '';
            $passWord = '';

            foreach ($info['user'] as $v){
                if ($v['userName'] == $phone){
                    $isChild = $v['isChild'];
                    $remark = $v['remark'];
                    $passWord = $v['passWord'];
                }
            }
            $rtn = array(
                'status'    =>'success',
                'msg'   =>'成功',
                'userId' =>$info['userId'],
                'company' =>$info['company'],
                'remark' =>$remark,
                'isChild' =>$isChild,
                'passWord' =>$passWord
            );
        }else{
            $rtn = array(
                'status'    => 'failed',
                'msg'   => '用户不存在'
            );
        }

        echo json_encode($rtn);
        exit;
    }

    /**
     * 获取所有的userId
     */
    public function getIdsAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $page = isset($_POST['page'])?(trim($_POST['page'])?trim($_POST['page']):1):1;
        $sign = isset($_POST['sign'])?trim($_POST['sign']):'';
        $num = 100;
        $key='8d0d972086492997fd761c074c0bc8a0';
        $date=date('Ymd');
        $arr = array();
        if(!$sign||$page<1){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'无效的参数'
            );
            echo json_encode($rtn);
            exit;
        }
        if (md5($key.$date)!=$sign){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'签名错误'
            );
            echo json_encode($rtn);
            exit;
        }
        $userModel = new UserModel();
        $where = array();
        $list = array(
            'count'=>0,
            'info'=>array()
        );
        $count  = $userModel->getNum($where);
        // var_dump($count);
        if($count){
            $list['count'] = $count;
            $firstRow = ($page-1)*$num;
            $info = $userModel->getLists($where,$firstRow,$num);
            foreach ($info as $val){
                $arr['userId'] = $val['userId'];
                $arr['company'] = $val['company'];
                $list['info'][] = $arr;
            }
        }
        $rtn = array(
            'status'    =>'success',
            'msg'   =>'成功',
            'list' =>$list
        );
        echo json_encode($rtn);
        exit;
    }
    /**
     * 获取子账号信息列表
     */
    public function getListAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $userModel = new UserModel();
        $userId = isset($_POST['userId'])?trim($_POST['userId']):'';
        $sign = isset($_POST['sign'])?trim($_POST['sign']):'';
        $key='8d0d972086492997fd761c074c0bc8a0';
        $date=date('Ymd');
        if(!$sign||!$userId){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'无效的参数'
            );
            echo json_encode($rtn);
            exit;
        }
        if (md5($key.$date)!=$sign){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'签名错误'
            );
            echo json_encode($rtn);
            exit;
        }
        $where = array(
            'userId' => $userId
        );
        $info  = $userModel->getInfo($where);
        if ($info){
            $list = array();
            foreach ($info['user'] as $k=>$v){
                if($v['isChild']==1){;
                    $list[] = $v;
                }
            }
            $rtn = array(
                'status'    =>'success',
                'msg'   =>'成功',
                'list' =>$list
            );
            echo json_encode($rtn);
            exit;
        } else{
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'该用户不存在'
            );
            echo json_encode($rtn);
            exit;
        }
    }
    /**
     * 查询子账号信息
     */
    public function getAccountAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $userModel = new UserModel();
        $userName = isset($_POST['userName'])?trim($_POST['userName']):'';
        $sign = isset($_POST['sign'])?trim($_POST['sign']):'';
        $key='8d0d972086492997fd761c074c0bc8a0';
        $date=date('Ymd');
        if(!$sign||!$userName){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'无效的参数'
            );
            echo json_encode($rtn);
            exit;
        }
        if (md5($key.$date)!=$sign){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'签名错误'
            );
            echo json_encode($rtn);
            exit;
        }
        $where = array(
            'user.userName' => $userName
        );
        $info  = $userModel->getInfo($where);
        if ($info){
            $data = array(
                'userName'=>$userName
            );
            $rtn = array(
                'status'    =>'success',
                'msg'   =>'成功',
                'info' =>$data
            );
        }else{
            $rtn = array(
                'status'    => 'failed',
                'msg'   => '用户不存在'
            );
        }
        echo json_encode($rtn);
        exit;
    }
    /**
     * 子账号添加
     */
    public function editAccountAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $userModel = new UserModel();
        $UserUpLogModel = new UserUpLogModel();
        $userId = isset($_POST['userId'])?trim($_POST['userId']):'';
        $userName = isset($_POST['userName'])?trim($_POST['userName']):'';
        $YuserName = isset($_POST['oldUserName'])?trim($_POST['oldUserName']):'';
        $passWord = isset($_POST['passWord'])?trim($_POST['passWord']):'';
        $from = isset($_POST['from'])?trim($_POST['from']):'';
        $sign = isset($_POST['sign'])?trim($_POST['sign']):'';
        $remark = isset($_POST['remark'])?trim($_POST['remark']):'';
        $action = isset($_POST['action'])?trim($_POST['action']):'';
        $key='8d0d972086492997fd761c074c0bc8a0';
        $date=date('Ymd');
        if(!$sign||!$userId||!$userName||!$from||!$action){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'缺少必要参数'
            );
            echo json_encode($rtn);
            exit;
        }
        if($action!="add"&&$action!="update"){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'参数错误'
            );
            echo json_encode($rtn);
            exit;
        }
        if($action=="add"){
            if(!$passWord){
                $rtn = array(
                    'status'    =>'failed',
                    'msg'   =>'请添加密码'
                );
                echo json_encode($rtn);
                exit;
            }
        }else{  //修改
            if(!$YuserName){
                $rtn = array(
                    'status'    =>'failed',
                    'msg'   =>'缺少用户名'
                );
                echo json_encode($rtn);
                exit;
            }
        }
        if (md5($key.$date)!=$sign){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'签名错误'
            );
            echo json_encode($rtn);
            exit;
        }
        $where = array(
            'user.userName'=>$userName,
        );
        $num = $userModel->getNum($where);
        $oldInfo  = $userModel->getInfo(array('userId'=>$userId));
        //添加

        $upWhere = array();
        $data = array();
        if ($action=="add"){
            if ($num>0){
                $rtn = array(
                    'status'    =>'failed',
                    'msg'   =>'登陆名已占用!'
                );
                echo json_encode($rtn);
                exit;
            }
            $data['$addToSet'] = array(
                'user'=>array(
                    'userName'=>$userName,
                    'isChild'=>1,
                    'from'=>$from,
                    'passWord'=>$passWord,
                    'creatTime'=>date('Y-m-d H:i:s'),
                    'remark'=>$remark
                )
            );
            $upWhere['userId'] = $userId;
        }else{  //修改
            if ($YuserName!=$userName){
                if($num>0){
                    $rtn = array(
                        'status'    =>'failed',
                        'msg'   =>'登陆名已占用!'
                    );
                    echo json_encode($rtn);
                    exit;
                }
            }
            $data['$set']['user.$.userName'] = $userName;
            if($passWord!=''){
                $data['$set']['user.$.passWord'] = $passWord;
            }
            if($remark!=''){
                $data['$set']['user.$.remark'] = $remark;
            }
            $upWhere = array(
                'userId' => $userId,
                'user.userName' => $YuserName
            );
        }
        $res = $userModel->updateInfo($data,$upWhere);
        if ($res['updatedExisting']==true){
            if($action=='update'){
                $dataLog = array(
                    'oldInfo'=>$oldInfo,
                    'newInfo'=>array(
                        'user'=>array(
                            'userName'=>$userName,
                            'passWord'=>$passWord,
                            'remark'=>$remark,
                            'from' => $from
                        )
                    ),
                    'remark'=>'修改子账号'.$YuserName,
                    'upDate'=>date('Y-m-d H:i:s')
                );
                $UserUpLogModel->insert($dataLog);
            }
            $rtn = array(
                'status'    =>'success',
                'msg'   =>'操作成功'
            );
            echo json_encode($rtn);
            exit;
        }else{
            $rtn = array(
                'status'    =>'success',
                'msg'   =>'操作失败'
            );
            echo json_encode($rtn);
            exit;
        }

    }
    /**
     * 子账号删除
     */
    public function delAccountAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $userModel = new UserModel();
        $UserUpLogModel = new UserUpLogModel();
        $userId = isset($_POST['userId'])?trim($_POST['userId']):'';
        $userName = isset($_POST['userName'])?trim($_POST['userName']):'';
        $from = isset($_POST['from'])?trim($_POST['from']):'';
        $sign = isset($_POST['sign'])?trim($_POST['sign']):'';
        $key='8d0d972086492997fd761c074c0bc8a0';
        $date=date('Ymd');
        if(!$sign||!$userId||!$userName||!$from){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'缺少必要参数'
            );
            echo json_encode($rtn);
            exit;
        }

        if (md5($key.$date)!=$sign){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'签名错误'
            );
            echo json_encode($rtn);
            exit;
        }
        $where = array(
            'userId' => $userId,
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
                        'from' => $from
                    )
                ),
                'remark'=>'删除子账号'.$userName,
                'upDate'=>date('Y-m-d H:i:s')
            );
            $UserUpLogModel->insert($dataLog);
            $rtn = array(
                'status'    =>'success',
                'msg'   =>'删除成功'
            );
            echo json_encode($rtn);
            exit;
        }else{
            $rtn = array(
                'status'    =>'success',
                'msg'   =>'删除失败'
            );
            echo json_encode($rtn);
            exit;
        }
    }
    /**
     * 根据用户ID，返回提现列表
     *
     */
    public function getCashListAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $sign = isset($_POST['sign'])?trim($_POST['sign']):'';
        $userId = isset($_POST['userId'])?trim($_POST['userId']):'';
        $start = isset($_POST['start'])?trim($_POST['start']):'';
        $end = isset($_POST['end'])?trim($_POST['end']):'';
        $pageNo = isset($_POST['pageNo'])?intval($_POST['pageNo']):1;

        $key='8d0d972086492997fd761c074c0bc8a0';
        $date=date('Ymd');

        if(!$userId || !$sign){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'无效的参数!'
            );
            exit(json_encode($rtn));
        }

        if (md5($key.$date)!=$sign){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'签名错误'
            );
            echo json_encode($rtn);
            exit;
        }

        $applyModel = new ApplyModel();
        $where = array(
            'userId'    =>$userId
        );
        if($start && !$end){
            $where['createDate'] = array(
                '$gte'  =>$start
            );
        }
        if($end && !$start){
            $where['createDate'] = array(
                'lte'  =>$end
            );
        }
        if($start && $end){
            $where['createDate'] = array(
                '$gte'  =>$start,
                '$lte'  =>$end
            );
        }
        $num = $applyModel->getNum($where);
        $pageNum = 50;
        $firstNum = ($pageNo-1)*$pageNum;
        $lists = $applyModel->getLists($where,$firstNum,$pageNum);
        $rtnLists = array();
        foreach($lists as $info){
            $canUsed = sprintf("%01.2f",($info['getBalance']['canUsed']-$info['applyCash']*100)/100);
            $row = array(
                'userId'    =>$info['userId'],
                'userName'  =>$info['bankInfo']['userName'],
                'applyCash' =>$info['applyCash'],
                'status'    =>$info['status'],
                'createDate'    =>$info['createDate'],
                'errMsg'   =>($info['status']==4)?$info['err_msg']:'',
                'canUsed'   =>$canUsed
            );
            $rtnLists[] = $row;
        }
        $rtn = array(
            'status'    =>'success',
            'lists'     =>$rtnLists,
            'totalNum'  =>$num
        );
        exit(json_encode($rtn));
    }
}