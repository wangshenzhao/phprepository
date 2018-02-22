<?php
/*
 * 大宗交易
 */
class AdminController extends BaseController{
    /*
     * 大宗交易列表
     */
    public function listAction(){
        $OrderModel = new AdminUserModel();
        //默认每页条目
        $where=array();
       $num = $this->config->page->list->number;
        $userName = isset($_REQUEST['userName'])?trim($_REQUEST['userName']):'';
        if($userName){
            $where['userName']=new \MongoRegex("/$userName/i");
        }

        $count=$OrderModel->getNum($where);
        //实例分页
        $pageObj=getpage($count,$num);
        //首条目
        $firstRow = $pageObj->firstRow;
        //查询订单
        $lists = $OrderModel->getList($where,$firstRow,$num);
        $this->_view->lists  = $lists;
        $this->_view->title = '管理员列表';
        $this->_view->userName = $userName;
        $this->_view->pages = $pageObj->show();
    }
    //创建管理员
    public function editAction(){
        $AdminUserModel = new AdminUserModel();
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        $info=array();
        if($id) {
            $info = $AdminUserModel->getOneInfo(array('_id' => new MongoId($id)));
        }
        $menuModel=new MenuModel();
       $allList= $menuModel->getAll(array('action'=>array('$nin'=>array('Admin','Createmenu'))));
        $list=array();
        $menuList=array();
        foreach($allList as $key=>$vak){
            if(isset($vak['stat']) && $vak['stat']==1){
                $menuList[$key]=$vak;
            }else{
                $list[$key]=$vak;
            }
        }
        $this->_view->title = '管理员编辑';
        $this->_view->info  = $info;
        $this->_view->active_id=1;
        $this->_view->tab_id=1;
        $this->_view->list=$list;
        $this->_view->menuList1=$menuList;
        $this->_view->id=$id;
    }
    public function saveAction(){
        $AdminUserModel = new AdminUserModel();
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';

        $userName = trim($_POST['userName']);
        $menu=trim($_POST['menu']);
        $result['status'] = 'failed';
        if($id){
            $_id = new MongoId($id);
        }
        $arrMenu=explode(',',$menu);
        if(!$userName){
            $result['msg'] = "缺少必要参数！";
            exit(json_encode($result));
        }else{
            if(!$id) {
                if ($AdminUserModel->getNum(array('userName' => $userName))) {
                    $result['msg'] = "对不起！该账户已经存在";
                    exit(json_encode($result));
                }
            }else{
               $info1= $AdminUserModel->getOneInfo(array('userName' => $userName));
                if($info1 && $info1['_id']->{'$id'} !=$id){
                    $result['msg'] = "对不起！该账户已经存在";
                    exit(json_encode($result));
                }
            }
            $data = array(
                'userName'=>$userName,
                'updateTime'=>date("Y-m-d H:i:s"),
                 'addTime'=>date("Y-m-d H:i:s"),
                'menu'=>$arrMenu
            );
        }
        if($id){
            unset($data['addTime']);
            $AdminUserModel->updateOne($data,array('_id'=>$_id));
        }else{
            $AdminUserModel->insert($data);
        }
        $result['status'] = 'success';
        $result['msg'] = "保存成功！";
        $result['url'] = '/Admin/list';
        exit(json_encode($result));
    }
    public function deluserAction(){
        $AdminUserModel = new AdminUserModel();
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        $result['status'] = 'failed';
        if(!$id){
            $result['msg'] = "缺少必要参数！";
            exit(json_encode($result));
        }
        if($AdminUserModel->remve(array('_id'=>new MongoId($id)))){
            exit(json_encode(array('status'=>'success','msg'=>'成功','url'=>'/Admin/list')));
        }

    }
}
