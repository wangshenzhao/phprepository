<?php
/**
 * 提现申请操作
 */
class CashmanageController extends BaseController{
    /*
     * 提现申请列表
     */
    public function listAction(){
        $ApplyModel = new ApplyModel();
        //默认每页条目
        $num = $this->config->page->list->number;
        //总条目数
        $userName = isset($_REQUEST['useName'])?trim($_REQUEST['useName']):'';
        $where = array();

        if($userName) {
            $where = array(
                'bankInfo.userName' => $userName
            );
        }
        $count=$ApplyModel->getNum($where);
        //实例分页
        $pageObj=getpage($count,$num);
        //首条目
        $firstRow = $pageObj->firstRow;
        //查询订单
        $lists = $ApplyModel->getLists($where,$firstRow,$num);
        $this->_view->userName = $userName;
        $this->_view->lists  = $lists;
        $this->_view->title = '提现申请列表';
        $this->_view->bankList = Tools::objectToArray($this->config->bank);
        $this->_view->statusList = Tools::objectToArray($this->config->cashStatus);
        $this->_view->pages = $pageObj->show();
    }
    /**
     *  审核信息
     */
    public function examineAction(){
        $ApplyModel = new ApplyModel();
        $ApplyLogModel = new ApplyLogModel();
        $strId = $_POST['id'];
        $status = +$_POST['status'];
        $result['status'] = 'failure';
        $arr = explode( ",", $strId );
        array_pop($arr);
        $num = count($arr);
        if (!$arr||!$status){
            $result['msg'] = "缺少必要参数！";
            exit(json_encode($result));
        }
        foreach ($arr as $id) {
            $where = array(
                '_id'=>new MongoId($id),
            );
            $info = $ApplyModel->getOneInfo($where);
            $data = array(
                'userId'    =>$info['userId'],
                'applyId'        =>$info['_id']->{'$id'},
                'money'     => +$info['applyCash']
            );
//            minusBalance($data);//陈杰提现接口，记账用
            $res = transferAccount($info);//刘磊转账接口
            $data['tradeId'] = isset($res['data'])?$res['data']['id']:"";
            $data['status'] = $status;
            $data['transferStatus'] = $res['status'];
            $data['msg'] = isset($res['msg'])?$res['msg']:"";
            $data['upTime'] = date('Y-m-d H:i:s');
            $ApplyLogModel->insert($data);

            if ($res&&$res['status']==1){
                $upData['tradeId'] = $res['data']['id'];
                $upData['status'] = $status;
                $ApplyModel->updateOne($upData,$where);
                if ($status==3){
                    $noteInfo['tvmid'] = $info['userId'];
                    $noteInfo['orderId'] = $info['_id']->{'$id'};
                    $noteInfo['note'] = "转账成功";
                    changeNote($noteInfo);  //更新陈杰接口
                }
            }else {
                $upData['err_msg'] = isset($res['msg'])?$res['msg']:"转账失败！";
                $ApplyModel->updateOne($upData,$where);
                if($num==1){
                    $result['msg'] = isset($res['msg'])?"转账失败:".$res['msg']:"转账失败！";
                    exit(json_encode($result));
                }
            }
        }
        $result['status'] = 'success';
        $result['msg'] = "审核成功！";
        exit(json_encode($result));
    }
    
}