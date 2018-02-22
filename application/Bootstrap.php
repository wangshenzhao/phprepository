<?php

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{

	protected $config;
	
    public function _initConfig() {
        $this->config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set("config", $this->config);
    }

    public function _initDefaultName(Yaf_Dispatcher $dispatcher) {
        $request = $dispatcher->getRequest();
        $method = $request->getMethod();
        if($method!='CLI'){
            $dispatcher->setDefaultModule("Index")->setDefaultController("Index")->setDefaultAction("index");
        }
    }

	public function _initError(Yaf_Dispatcher $dispatcher) {
		if ($this->config->application->debug)
		{
			define('DEBUG_MODE', false);
			ini_set('display_errors', 'On');
		}
		else
		{
			define('DEBUG_MODE', false);
			ini_set('display_errors', 'Off');
		}
	}

//    public function  _initDb(){
//        $dbConfig = $this->config->db;
//        $db = new PDO('mysql:host='.$dbConfig->master->ip.';dbname='.$dbConfig->dbname,$dbConfig->master->username,$dbConfig->master->password);
//        Yaf_Registry::set("db", $db);
//    }

    /***
    **创建mongo的链接
    **
    **
    ***/
    public function  _initMongoDb(){
        $dbConfig = $this->config->mongodb;
        $client = new MongoClient($dbConfig->server);
        $db = $client->selectDB($dbConfig->db);
        Yaf_Registry::set("mongo", $db);
    }
    /***
    ***初始化Smart模板
    ***
    ***/
	public function _initView(Yaf_Dispatcher $dispatcher) {
	    //在这里注册自己的view控制器，例如smarty,firekylin
        //Yaf_Dispatcher::getInstance()->disableView();//关闭其自动渲染

	    $view= new Smarty_Adapter(null, $this->config->smarty);

        $view->registerFunction('function', 'getBalanceInfo', 'getBalanceInfo');

	    Yaf_Dispatcher::getInstance()->setView($view);
	    
	    //$smarty = new Smarty_Adapter(null, $this->config->smarty);

		//$dispatcher->setView($smarty);
	}
}