<?php

class LoginController extends BaseController
{
    private $verify = null;
    public function _initialize()
    {
        $config = array(
            'imageW' => 120,
            'imageH' => 40,
            'fontSize' => 16,
            'length' => 4,
            'useCurve' => false
        );
        $this->verify = new Verify($config);
        $this->verify->codeSet = '0123456789';
    }
    public function loginAction(){
        if (Yaf_Session::getInstance()->get('userId')) {
            $this->redirect('/Index/index');
        }
    }
    /**
     * 登录处理
     */
	public function doLoginAction()
    {
        $AdminUser = new AdminUserModel();
        $userName = $this->inputFilter($_POST['username']);
        $passWord = $this->inputFilter($_POST['password']);
        
        $result['status'] = 'failed';
        $where = array(
            'userName'=>$userName
        );
        $info = $AdminUser->getOneInfo($where);
        if(!$info || empty($info)){
            $result['msg'] = "用户名或密码错误！";
            exit(json_encode($result));
        }
        if($userName=='admin') {
            if ($info && ($info['passWord'] == md5($passWord))) {
                $result['status'] = 'success';
                $result['msg'] = "登录成功！";
                $data = array(
                    'userId' => $info['_id']->{'$id'},
                    'userName' => $info['userName']
                );
                $this->setSession($data);
                $result['url'] = '/Account/list';
            } else {
                $result['msg'] = "用户名或密码错误！";
            }
        }else{
            //获取口令
            $code=Yaf_Session::getInstance()->get('code');
            $codeTime=Yaf_Session::getInstance()->get($userName);
            if(!$code){
                $result['msg'] = "验证码错误！";
                exit(json_encode($result));
            }
            if( time()-$codeTime>60*30){
                $result['msg'] = "验证码过期！";
                exit(json_encode($result));
            }

            if ($info &&  ($code ==$passWord)) {
                Yaf_Session::getInstance()->__unset('code');
                Yaf_Session::getInstance()->__unset($userName);
                $result['status'] = 'success';
                $result['msg'] = "登录成功！";
                $data = array(
                    'userId' => $info['_id']->{'$id'},
                    'userName' => $info['userName']
                );
                $this->setSession($data);
                $result['url'] = '/Account/list';
            } else {
                $result['msg'] = "用户名或密码错误！";
            }
        }
        exit(json_encode($result));

    }
	/**
	 * 退出登录
	 */
    public function logoutAction(){
        Yaf_Session::getInstance()->__unset('userId');
       $userName= Yaf_Session::getInstance()->get('userName');
        Yaf_Session::getInstance()->__unset('userName');
        Yaf_Session::getInstance()->__unset($userName);
        echo $this->success('退出成功！','/Login/login');
        exit;
    }

    private function inputFilter($input)
    {
        return htmlspecialchars(strip_tags($input));
    }
    private function setSession($data){
        Yaf_Session::getInstance()->set('userId',$data['userId']);
        Yaf_Session::getInstance()->set('userName',$data['userName']);	//昵称
        Yaf_Session::getInstance()->__unset($data['userName']);
        Yaf_Session::getInstance()->__unset($data['userName'].'code');
    }
    /**
     * 获取验证码
     */
    public function captchaAction()
    {
        $this->verify->entry();//生成并输出验证码
//        Yaf_Dispatcher::getInstance()->disableView();
    }
    /**
     * 发送验证码
     */
    public function smsSendAction(){
        $mobile=trim($_POST['mobile']);
        $result['status'] = 'failed';
        $codeTime=Yaf_Session::getInstance()->get($mobile);
        if($codeTime && time()-$codeTime<30*60){
            $result['msg']='验证码已经发送，有效期30分钟';
            exit(json_encode($result));
        }
        $num='';
        for($i=0;$i<6;$i++) {
            $randnum = rand(0, 9); // 10+26;
            $num.=$randnum;
        }
        $msg="您的登陆验证码为：".$num."，5分钟之内使用有效，谢谢！";
       $stat= sendMsg($mobile,$msg);
        if($stat['result']){
            Yaf_Session::getInstance()->set($mobile.'code',$num);
            Yaf_Session::getInstance()->set($mobile,time());
            $result['status']='success';
            $result['msg']='发送成功';
        }else{
            $result['msg']='发送失败';
        }
        exit(json_encode($result));
    }

}