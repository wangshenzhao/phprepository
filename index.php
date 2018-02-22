<?php

ini_set('date.timezone','Asia/Chongqing');
define("APP_PATH",  dirname(__FILE__));
include_once APP_PATH.'/application/library/common/common.php';
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
$app->bootstrap()->run();
