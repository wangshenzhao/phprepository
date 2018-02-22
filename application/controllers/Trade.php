<?php
/*
 * 大宗交易
 */
class TradeController extends BaseController{
    /*
     * 大宗交易列表
     */
    public function listAction(){
        $OrderModel = new OrderModel();
        //默认每页条目
       $num = $this->config->page->list->number;
        //总条目数
        $name = isset($_REQUEST['name'])?trim($_REQUEST['name']):'';
        $code = isset($_REQUEST['code'])?trim($_REQUEST['code']):'';
        $startTime = isset($_REQUEST['startTime'])?trim($_REQUEST['startTime']):'';
        $endTime = isset($_REQUEST['endTime'])?trim($_REQUEST['endTime']):'';

        if (!$startTime){
            $startTime = date('Y-m-d 00:00:00');
        }
        if (!$endTime){
            $endTime = date('Y-m-d 23:59:59');
        }
        $where = array(
            'createTime'=>array(
                '$gte'=>strtotime($startTime)*1000,
                '$lte'=>strtotime($endTime)*1000
            )
        );
        if ($name) {
            $where['name'] = $name;
        }
        if ($code){
            $where['code'] = $code;
        }
        $count=$OrderModel->getNum($where);
        //实例分页
        $pageObj=getpage($count,$num);
        //首条目
        $firstRow = $pageObj->firstRow;
        //查询订单
        $lists = $OrderModel->getList($where,$firstRow,$num);
        $this->_view->name = $name;
        $this->_view->code = $code;
        $this->_view->startTime = $startTime;
        $this->_view->endTime = $endTime;
        $this->_view->lists  = $lists;
        $this->_view->title = '大宗交易列表';
        $this->_view->typeList = Tools::objectToArray($this->config->tradeType);
        $this->_view->statusList = Tools::objectToArray($this->config->tradeStatus);
        $this->_view->pages = $pageObj->show();
    }
    public function detailAction(){
        $UserModel = new UserModel();
        $OrderModel = new OrderModel();
        $OrderLogModel = new OrderLogModel();
        //默认每页条目
       $num = $this->config->page->list->number;
        //总条目数
        $orderId = isset($_REQUEST['orderId'])?trim($_REQUEST['orderId']):'';
        $page = isset($_REQUEST['page'])?trim($_REQUEST['page']):1;

        if(!$orderId) {
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'缺少必要参数'
            );
            echo json_encode($rtn);
            exit;
        }
        $where = array(
            'orderId' => $orderId,
            'action' => 3   //1：生产订单；2：撤单；3：报单
        );
        $count=$OrderLogModel->getNum($where);
        if (!$count){
            $rtn = array(
                'status'    =>'failed',
                'msg'   =>'没有查到信息'
            );
            echo json_encode($rtn);
            exit;
        }
        //实例分页
        $pageObj=getpage($count,$num);
        //首条目
        $firstRow = ($page-1)*$num;
        //查询订单
        $lists = $OrderLogModel->getList($where,$firstRow,$num);
        $info = array();
        foreach ($lists as $v){
            $v['price'] = $v['price']/100;
            $v['currentTotalprice'] = isset($v['currentTotalprice'])?$v['currentTotalprice']/100:0;
            $v['addTime'] = date('Y-m-d H:i:s',$v['addTime']/1000);
            $v['name'] = $UserModel->getCompany(array('userId'=>$v['tvmid']));
            $info[] = $v;
        }

        $list = array(
            'info' => $info,
            'modalPages' => $pageObj->show()
        );

        $rtn = array(
            'status'    => 'success',
            'data'  => $list,
            'count'    =>$count,
            'msg'   => '成功'
        );
        echo json_encode($rtn);
        exit;
    }
}