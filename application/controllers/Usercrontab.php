<?php
/**
 * 设置初始账号
 */
class UserCrontabController extends Yaf_Controller_Abstract{
    public function createAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $AdminUser = new AdminUserModel();
        $data = array(
            'userName'=>'admin',
            'passWord'=>md5('123456'),
            'addTime'=>date('Y-m-d H:i:s')
        );
        $AdminUser->insert($data);
        echo "Added successfully!\n";
    }
    public function delAdminUserAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $AdminUser = new AdminUserModel();
        $result = $AdminUser->del();
        echo "Delete admin_user(".$result['n'].") table successfully!\n";
    }
    public function delUserAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $UserModel = new UserModel();
        $result = $UserModel->del();
        echo "Delete user(".$result['n'].") table successfully!\n";
    }
    public function getTradeStatusAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $config = Yaf_Application::app()->getConfig();
        $url = $config->deposit->queryurl;
        $applyModel = new ApplyModel();
        $where = array(
            'status'    =>2
        );
        $num = $applyModel->getNum($where);
        $pageNum = 50;
        $pages = ceil($num/$pageNum);
        writeLogs('getTradeStatusAction');
        for($i=1;$i<=$pages;$i++){
            $lists = $applyModel->getLists($where,($i-1)*$pageNum,$pageNum);
            foreach($lists as $info){
                $upData = array();
                if(isset($info['tradeId']) && $info['tradeId']) {
                    $queryData = array(
                        'id' => $info['tradeId']
                    );
                    $rtn = Tools::curl($url, 'POST', json_encode($queryData));
                    $rtnArr = json_decode($rtn, true);
                    writeLogs($url . '    params=' . var_export($queryData, true) . ' return=' . var_export($rtnArr,true));

                    $noteInfo = array(
                        'orderId'    =>$info['_id']->{'$id'},
                        'tvmid'        =>$info['userId'],
                    );

                    if ($rtnArr['status']) {
                        if ($rtnArr['data']['trade_status'] == 2) {
                            $upData['status'] = 3;
                            $noteInfo['note'] = '转账成功';
                        } else if ($rtnArr['data']['trade_status'] == 4) {
                            $upData['status'] = 4;
                            $noteInfo['note'] = '转账失败 '.$rtnArr['data']['err_msg'];
                            $upData['err_msg'] = $noteInfo['note'];
                        }
                        if ($upData) {
                            $upWhere = array(
                                '_id' => new MongoId($info['_id']->{'$id'})
                            );
                            $applyModel->updateOne( $upData,$upWhere);
                            writeLogs('id= ' . $info['_id']->{'$id'} . ' updateInfo ' . var_export($upData,true), 'updateApply');
                            //通知陈杰处修改提现文字
                            changeNote($noteInfo);

                        }
                    }
                }
            }
        }
    }

    public function testAction(){
        Yaf_Dispatcher::getInstance()->disableView();
        $userModel = new UserModel();
        $userModel->testArray();
    }
}
