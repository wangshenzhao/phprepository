<?php
/**
 * 设置初始账号
 */
class TestController extends Yaf_Controller_Abstract{


    public function aAction(){
        Yaf_Dispatcher::getInstance()->disableView();


        $time_start = $this->microtime_float();
//        echo $time_start;
        $buffer = ini_get('output_buffering');
        echo str_repeat('&nbsp;',$buffer+1);
        $i = 1;
        while($i<10000){
            $micro_date = microtime();
            $date_array = explode(" ", $micro_date);
            $date = date("Y-m-d H:i:s", $date_array[1]);
            echo " $date:" . $date_array[0],"<br>";
            $i++;
            flush();
            usleep(10000);
        }
        ob_end_flush();
    }

    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

}
