<?php
/**
 * Created by PhpStorm.
 * User: gcl
 * Date: 2015/4/2
 * Time: 17:27
 */

class BaseController extends Yaf_Controller_Abstract {
	
	protected $_view;
	protected $config;
    protected $redis;
    protected $myredis;
    public function init(){


        $this->config = Yaf_Application::app()->getConfig();
        $this->userId = Yaf_Session::getInstance()->get('userId');
        $this->adminUserName = Yaf_Session::getInstance()->get('userName');
        $this->_view->adminUserName = isset($this->adminUserName)?$this->adminUserName:null;
        $this->_view->userId = isset($this->userId)?$this->userId:null;
        if(!$this->userId){
//            echo $this->getRequest()->getActionName(),'   ',$this->getRequest()->getControllerName();exit;
            if( $this->getRequest()->getControllerName()!='Login' && $this->getRequest()->getControllerName()!='api') {
                $dispatcher = Yaf_Dispatcher::getInstance();
                $method = $dispatcher->getRequest()->getMethod();
                if($method=='CLI'){ //脚本不需要登录
                    echo "Do not need to login\n";
                }else{
                    $this->redirect("/Login/login");
                }
            }
        }else{
            if(!in_array($this->getRequest()->getControllerName(),array('Util','Index','Login'))) {
                $this->getMenu($this->adminUserName);
            }
        }

    }
    
    function success($message='',$jumpUrl='/Assess/index') {
        return $this->Jump($message,1,$jumpUrl);
    }
    function error($message='',$jumpUrl='/Assess/index') {
        return $this->Jump($message,0,$jumpUrl);
    }
    function Jump($message,$status=1,$jumpUrl=''){
        if($status) {
            $waitSecond = 1;
        }else {
            $waitSecond = 3;
        }
        $content = '<meta charset="utf-8"><link rel="stylesheet" href="/public/vendor/bootstrap/dist/css/bootstrap.css"/><link rel="stylesheet" href="/public/css/style.css"><div class="color-line"> </div>';
        $content .='<div class="splash"><div class="color-line"></div><div class="splash-title" style="margin-top:200px;">';
        $content .='<center><h4>'.$message.'</h4><br><p> <a id="href" href="'.$jumpUrl.'">跳转</a> 等待时间： <b id="wait">'.$waitSecond.'</b> s</p><br>';
        $content .='<img src="http://mtq.dev.tvm.cn/static/images/loading-bars.svg" width="64" height="64" /></center></div></div>';
        $content .='<script src="/vendor/jquery/dist/jquery.min.js"></script><script src="/vendor/bootstrap/dist/js/bootstrap.min.js"></script><script type="text/javascript">';
        $content .='(function(){var wait = document.getElementById(\'wait\'),href = document.getElementById(\'href\').href;var interval = setInterval(function(){var time = --wait.innerHTML;';
        $content .='if(time <= 0) {location.href = href;clearInterval(interval);};}, 1000);})();</script>';
        echo  $content;
        exit;
    }
    /**
     * 连接redis
     */
    function conncet_myredis(){
        if(!$this->myredis) {
            $redisConfig = $this->config->myredis;
            $this->myredis= new Redis();
            $client = $this->myredis->connect($redisConfig->host,$redisConfig->port);
            $db = $this->myredis->select($redisConfig->db);
        }
        return ;
    }
    /**
     * 获取菜单
     *
     */
    public function getMenu($name=''){
        $method=$this->getRequest()->getActionName();
        $action=$this->getRequest()->getControllerName();
        //权限不限制的配置
        $menuData=array(
            'Account'=>array('doaccount','addchild','dochild','delchild','doaddmoney','edit','changechild'),
        );
        $menuModel=new MenuModel();
        $admin=new AdminUserModel();
        if(isset($menuData[$action]) && in_array(strtolower($method),$menuData[$action])){
            $this->_view->menuList= $menuModel->getAll(array());
            return true;
        }
        if($name=='admin'){
            $this->_view->menuList= $menuModel->getAll(array());

            return true;
        }
        $userInfo=$admin->getOneInfo(array('_id'=>new MongoId($this->userId)));
        $method= strtolower($method);
        $menuArr=$menuModel->getInfo(array('action'=>$action,'method'=>$method));
        //获取用户信息
        foreach($userInfo['menu'] as $val){
            $arr[]=new MongoId($val);
        }
        if($menuArr && in_array($menuArr['_id']->{'$id'},$userInfo['menu'])){

            $menuList=$menuModel->getAll(array('_id' => array('$in' => $arr)));
            $this->_view->menuList=$menuList;
            return true;
        }else{
            //判断是不是ajax请求
            if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
                // ajax 请求的处理方式
                echo json_encode(array('status'=>'failed','msg'=>'对不起您没有权限'));
            }else{
                // 正常请求的处理方式
                $info=$menuModel->getInfo(array('_id' => array('$in' => $arr),'stat'=>1));
                $url="/".$info['action']."/".$info['method'];
                $this->error('您没有权限访问',$url);
            };
            exit ;


        }
    }

}
?>