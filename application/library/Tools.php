<?php

class Tools{


    /**
     * @param        $url
     * @param string $method
     * @param null   $postFields
     * @param null   $header
     *
     * @return mixed
     * @throws Exception
     */
    public static function curl($url, $method = 'GET', $postFields = null, $header = null) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_NONE);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https")
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        switch ($method)
        {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if (!empty($postFields))
                {
                    if (is_array($postFields) || is_object($postFields))
                    {
                        if (is_object($postFields))
                            $postFields = Tools::object2array($postFields);
                        $postBodyString = "";
                        $postMultipart = false;
                        foreach ($postFields as $k => $v)
                        {
                            if ("@" != substr($v, 0, 1))
                            { //判断是不是文件上传
                                $postBodyString .= "$k=" . urlencode($v) . "&";
                            }
                            else
                            { //文件上传用multipart/form-data，否则用www-form-urlencoded
                                $postMultipart = true;
                            }
                        }
                        unset($k, $v);
                        if ($postMultipart)
                        {
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                        }
                        else
                        {
                            curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
                        }
                    }
                    else
                    {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                    }
                }
                break;
            default:
                if (!empty($postFields) && is_array($postFields))
                    $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($postFields);
                break;
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($header) && is_array($header))
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $response = curl_exec($ch);
        if (curl_errno($ch))
        {
            throw new Exception(curl_error($ch), 0);
        }
        curl_close($ch);

        return $response;
    }

    /**
     * 判断是否为相应平台的订单，只有相应平台的订单才入库并发kafka
     * @param $data
     * @return bool
     */

    public static function isMathOrder($data){
        $config = Yaf_Registry::get("config");
        $platforms = $config->platforms;
        $yyyappId = $config->qaYYYappId;
        $publicId = $config->qaPublicId;
        $qaAppId = array($yyyappId,$publicId);

        $str = "\n yyyapp_id".$data['yyyapp_id']." platforms".$platforms;

        if($platforms == 'QA' && !in_array($data['yyyapp_id'],$qaAppId)){
            return false;
        }
        if($platforms!='QA' && in_array($data['yyyapp_id'],$qaAppId)){
            return false;
        }
        $str .= ' isMath ='.true." \n";
        //writeLogs($str);
        return true;
    }


    public static function getRedis(){
        $myredis = Yaf_Registry::get('redis');
        try{
            if($myredis) {
                $myredis->ping();
            }else{
                throw new Exception('no connect redis');
            }
        }catch (Exception $e){
            $config = Yaf_Registry::get("config");
            $redisConfig = $config->myredis;
            $myredis= new Redis();
            $client = $myredis->connect($redisConfig->host,$redisConfig->port);
            $db = $myredis->select($redisConfig->db);
            Yaf_Registry::set("redis", $myredis);
        }
        return $myredis;
    }

    /**
     * 发送数据到kafka
     * @param $kafka
     * @param $msg
     * @param $topic
     */
    public static function sendMsgForKafka($kafka,$msg,$topic){

        if(!self::isMathOrder($msg)){
            return;
        }
        $myredis = self::getRedis();

        self::sendStatusToKafka($kafka,$msg,$topic,$myredis);
    }


    /**
     * 发送上下架信息到kafka
     * @param $kafka
     * @param $msg
     * @param $topic
     */
    public static function sendStatusToKafka($kafka,$msg,$topic,$redis=null){

        if(!$redis){
            $redis = self::getRedis();
        }
        Yaf_loader::import("Kafka/autoloader.php");
        try {
            $produce = \Kafka\Produce::getInstance(null, null, $kafka);
            $produce->setRequireAck(-1);
            $produce->setMessages($topic, 0, json_encode($msg));
            $result = $produce->send();
            writeLogs($topic . '     offset   ' . $result[$topic][0]['offset'] . '    ' . var_export($msg, true));
        }catch (Exception $e){
            $lMsg = array(
                'topic' =>$topic,
                'msg'   =>$msg
            );
            $redis->lpush('sendKafkaError',json_encode($lMsg));
            writeLogs($topic . '    ' . var_export($msg, true),"sendKafkaError");
        }
    }

    /**
     * 将xml转成数组
     * @param string $Xml_Data
     * @return array
     */
    public static function xmlToArray($Xml_Data,$is_attributes='')
    {
        if(!$Xml_Data){ return 'Xml Data is empty!';}
        $Res_Xml = xml_parser_create("utf-8");
        xml_parser_set_option($Res_Xml,XML_OPTION_CASE_FOLDING,false);
        xml_parser_set_option($Res_Xml,XML_OPTION_SKIP_WHITE,1);
        xml_parser_set_option($Res_Xml,XML_OPTION_TARGET_ENCODING,"utf-8");
        $Result_Array = array();
        if (!xml_parse_into_struct($Res_Xml,$Xml_Data,$Result_Array)){return "XML error";};
        xml_parser_free($Res_Xml);

        //初始化变量
        if ($is_attributes){
            $get_attributes = array(1);
        }
        $xml_array = array();
        $parents = array();
        $opened_tags = array();
        $arr = array();
        $priority = "";

        $current = &$xml_array;			  //xml_array变量引用
        $repeated_tag_index = array();    //将拥有相同名称的多个标签组成一个数组
        foreach($Result_Array as $data)
        {
            unset($attributes,$value);   //删除现有的值           
            extract($data);
            $result = array();
            $attributes_data = array();
            if(isset($value))
            {
                if($priority == 'tag')
                {
                    $result = $value;
                }
                else
                {
                    $result['value'] = $value;
                }
            }

            if(isset($attributes) and $get_attributes)
            {
                foreach($attributes as $attr => $val)
                {
                    if($priority == 'tag')
                    {
                        $attributes_data[$attr] = $val;
                    }
                    else
                    {
                        $result['attr'][$attr] = $val;
                    }
                }
            }

            if($type == "open")
            {
                $parent[$level-1] = &$current;
                if(!is_array($current) or (!in_array($tag, array_keys($current))))
                {
                    $current[$tag] = $result;
                    if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    $current = &$current[$tag];
                }
                else
                {
                    if(isset($current[$tag][0]))
                    {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        $repeated_tag_index[$tag.'_'.$level]++;
                    }
                    else
                    {
                        $current[$tag] = array($current[$tag],$result);
                        $repeated_tag_index[$tag.'_'.$level] = 2;
                        if(isset($current[$tag.'_attr']))
                        {
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
                    }
                    $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                    $current = &$current[$tag][$last_item_index];
                }

            }
            elseif($type == "complete")
            {
                if(!isset($current[$tag]))
                {
                    $current[$tag] = $result;
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $attributes_data)
                    {
                        $current[$tag. '_attr'] = $attributes_data;
                    }
                }
                else
                {
                    if(isset($current[$tag][0]) and is_array($current[$tag]))
                    {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        if($priority == 'tag' and $get_attributes and $attributes_data)
                        {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                        $repeated_tag_index[$tag.'_'.$level]++;
                    }
                    else
                    {
                        $current[$tag] = array($current[$tag],$result);
                        $repeated_tag_index[$tag.'_'.$level] = 1;
                        if($priority == 'tag' and $get_attributes)
                        {
                            if(isset($current[$tag.'_attr']))
                            {
                                $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                                unset($current[$tag.'_attr']);
                            }
                            if($attributes_data)
                            {
                                $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                            }
                        }
                        $repeated_tag_index[$tag.'_'.$level]++;
                    }
                }
            }
            elseif($type == 'close')
            {
                $current = &$parent[$level-1];
            }
        }
//        $xml_array  = $this->iconv_arr($xml_array);
        return($xml_array);
    }
    /**
     * 查找数组中value值为$child的对应key值
     * @param $child
     * @param $stack
     * @return array|bool
     */
    public  static function getParentStackComplete($child, $stack) {
        $return = array();
        foreach ($stack as $k => $v) {
            if (is_array($v)) {
                // If the current element of the array is an array, recurse it
                // and capture the return stack
                $stack = self::getParentStackComplete($child, $v);

                // If the return stack is an array, add it to the return
                if (is_array($stack) && !empty($stack)) {
                    $return[$k] = $stack;
                }
            } else {
                // Since we are not on an array, compare directly
                if ($v == $child) {
                    // And if we match, stack it and return it
                    $return[$k] = $child;
                }
            }
        }

        // Return the stack
        return empty($return) ? false: $return;
    }

    public static function objectToArray($object){
        foreach($object as $k=>$v){
            $array[$k] = $v;
        }
        return $array;
    }

    //添加生产json文件

    public static function putJson($data,$config){

      $data=self::getUpDatas($data);
        self::putObject($data);
        writeJson(APP_PATH.$config['pathJson'],$data['_id'].".json",json_encode($data));

    }

    public static function getUpDatas($data){
        $config = Yaf_Application::app()->getConfig();
        if(is_string($data['_id'])){
            $_id=$data['_id'];
        }else{
            $_id=$data['_id']->{'$id'};
        }
        $data['product_img']=$data['picture_url'];
        if(isset($data['update_time']))  unset($data['update_time']) ;
        if(isset($data['create_time'])) unset($data['create_time']);
        if(isset($data['order_update'])) unset($data['order_update']);
        if(isset($data['history_backCash'])) unset($data['history_backCash']);
        $data['_id']=$_id;

        $data['used_stock']=isset($data['used_stock']) ? intval($data['used_stock']) : 0;
        switch($data['from']){
            case 'yhd':

                if(!isset($data['tracker_u'])){
                    $data['tracker_u'] = $config['yhd']['tracker_u'];
                }
                break;

            case 'gome':
                $data['sid']=$config['sid'];
                $data['wid']=$config['wid'];
                break;

        }
       return $data;
    }

    public static function putjsonfile($data){
        $Datas=self::getUpDatas($data);

        self::putObject($Datas);

    }

    //上传阿里云存储
    public static function putObject($content)
    {
        $config = Yaf_Application::app()->getConfig()->OSS;

        if(is_string($content['_id'])){
            $_id=$content['_id'];
        }else{
            $_id=$content['_id']->{'$id'};
        }
        writeLogs('数据'.var_export($content,true),'jsonLujing');
        $time = hexdec(substr($_id,0,8));
        $path = date('H_i',$time);
        $ossClient = new \OSS\OssClient($config['ACCESS_ID'],$config['ACCESS_KEY'],$config['ENDPOINT'],false);
        writeLogs('文件路径地址' .  $path."/".$_id.".json",'jsonLujing');
        $object = $path."/".$_id.".json";
//        print_r($object."</br>");
        $options = array();
        try {
            $ossClient->putObject($config['BUCKET'], $object, json_encode($content), $options);
        } catch (OssException $e) {
            writeLogs('上传失败','jsonLujing');
            return false;
        }
        writeLogs('上传成功','jsonLujing');

        return true;
    }

    //根据objectID读取阿里云json
    public function readObject($_id){
        $config = Yaf_Application::app()->getConfig()->OSS;
        //根据_id拼出json目录
        $time = hexdec(substr($_id,0,8));
        $path =$config['BUCKET'].'.'.$config['ENDPOINT'].'/'.date('H_i',$time)."/".$_id.".json";
//$path = 'http://tvmtest.oss-cn-hangzhou.aliyuncs.com/14_01_11/570678837df86ec02c000031.json';
        $json = self::curl($path);
        $result = json_decode($json);
        return $result;
    }

    public static function putImage(){
        $config = Yaf_Application::app()->getConfig()->OSS;
        $ossClient = new \OSS\OssClient($config['ACCESS_ID'],$config['ACCESS_KEY'],$config['ENDPOINT'],false);
        $object = "images_test/a.jpg";
        $content = "/opt/www/cps_admin/public/images/goods-vip.jpg";
        try {
            $ossClient->uploadFile($config['BUCKET'], $object, $content);
        } catch (OssException $e) {
            echo '上传失败';
            return false;
        }
        echo '上传成功';

        return true;
    }

    //上传阿里云存储
    public static function putImg($content,$object)
    {
        $config = Yaf_Application::app()->getConfig()->OSS;
        $ossClient = new \OSS\OssClient($config['ACCESS_ID'],$config['ACCESS_KEY'],$config['ENDPOINT'],false);
        try {
            $ossClient->uploadFile($config['BUCKET'], $object, $content);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }
}