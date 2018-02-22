<?php
ini_set('date.timezone','Asia/Chongqing');
define("APP_PATH",  dirname(__FILE__));
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
include_once APP_PATH.'/application/library/common/common.php';
$app->bootstrap()->getDispatcher()->dispatch(new Yaf_Request_Simple());