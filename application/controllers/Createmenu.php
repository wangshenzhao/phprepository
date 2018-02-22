<?php
/**
 * 开户操作
 */
class CreatemenuController extends BaseController{


    /*
     * 账户开户
     */
    public function indexAction()
    {
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        $menuModel=new MenuModel();
        $info=array();
        if($id) {
            $info = $menuModel->getInfo(array('_id' => new MongoId($id)));
        }
       $this->_view->title="修改菜单";
        $this->_view->active_id=1;
        $this->_view->info=$info;
        $this->_view->tab_id=1;
        return ;
    }
    /**
     * 添加菜单
     *
     */
    public function createAction(){
        $menuModel=new MenuModel();
        $menuName = trim($_POST['menuName']);
        $action = trim($_POST['action']);
        $method = strtolower(trim($_POST['method']));
        $stat = isset($_POST['stat']) ? intval(trim($_POST['stat'])) : 0 ;
       $data=array('menuName'=>$menuName,'action'=>$action,'method'=>$method,'stat'=>$stat);
         if($menuModel->upSert(array('action'=>$action,'method'=>$method),$data)){
             exit(json_encode(array('status'=>'success','url'=>'/Createmenu/list','msg'=>'修改成功')));
         }else{
             exit(json_encode(array('status'=>'failed','msg'=>'修改失败')));
         }

    }
    /**
     * 菜单列表
     *
     */
    public function listAction(){
        $OrderModel = new MenuModel();
        //默认每页条目
        $where=array();
        $num = $this->config->page->list->number;
        $count=$OrderModel->getNum($where);
        //实例分页
        $pageObj=getpage($count,$num);
        //首条目
        $firstRow = $pageObj->firstRow;
        //查询订单
        $lists = $OrderModel->getLists($where,$firstRow,$num);
        $this->_view->lists  = $lists;
        $this->_view->title = '菜单列表';
        $this->_view->pages = $pageObj->show();
    }
    /**
     * 删除
     */
    public function delmenuAction(){
        $AdminUserModel = new MenuModel();
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
