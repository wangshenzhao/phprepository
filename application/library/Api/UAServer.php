<?php
namespace Api;

\Yaf_loader::import("Curl/Curl.php");
class UAServer
{
    /**
     * UAServer 登录
     * @param $tvmid 当前用户的tvmid，用户phone
     * @param $password 登录密码
     * @param bool $license 是否使用应用的license(true|false)
     * @param string $format (json|xml)
     * @return array [msg=success|error, access_token, lastLoginTime, expiration_time,phone(登录用户的TvmId), email,username, isAdmin, license,groups,concurrentnumber,telephone]
     */
    public function login($tvmid, $password, $license = false, $format = 'json')
    {
        $uaserver = \Yaf_Registry::get("config")->uaserver;
        $apiUrl = $uaserver->host . '/login';
        $data = array(
            'tvmid' => $tvmid,
            'validateCode' => md5($password), //md5(password)
            'app' => $uaserver->appid, //应用的ID
            'format' => $format,
            'license' => $license
        );
        return self::doGet($apiUrl, $data);
    }

    /**
     * UAServer 退出
     * @param $tvmid 当前用户的tvmid
     * @param string $app 用户登录的应用ID
     * @param string $access_token 要退出的应用ID(值可为空)
     * @param string $format [json|xml]
     * @return array [msg=success,logout=true|false,userid,appid],　无值时，退出失败
     */
    public static function logout($tvmid, $app = '', $access_token = '', $format = 'json')
    {
        $uaserver = \Yaf_Registry::get("config")->uaserver;
        $apiUrl = $uaserver->host . '/logout';
        $data = array(
            'tvmid' => $tvmid,
            'app' => $uaserver->appid,
            'access_token' => $access_token,
            'format' => $format
        );
        return self::doGet($apiUrl, $data);
    }

    /**
     * 获取license
     * @param $tvmid
     * @param $format xml|json
     * @return array [msg(success 或失败原因), access_token(当前登录的session值), license(当前应用的license)]
     */
    public static function getLicense($tvmid, $format)
    {
        $apiUrl = C('ua_server.host') . '/getappls';
        $data = array(
            'tvmid' => $tvmid,
            'app' => C('ua_server.appid'),
            'format' => $format
        );
        return self::doGet($apiUrl, $data);
    }

    /**
     * 获取用户全部应用
     * @param $tvmid
     * @param int $onlineapp 在线/全部应用(标识0)
     * @param string $format
     * @return array {applist:[{appid,uuid,sessionvalue}],msg}
     */
    public static function getApps($tvmid, $onlineapp = 0, $format = 'json')
    {
        $apiUrl = C('ua_server.host') . '/getapp';
        $data = array(
            'tvmid' => $tvmid,
            'onlineapp' => $onlineapp,
            'format' => $format
        );
        return self::doGet($apiUrl, $data);
    }

    /**
     * 更新UAServer 上的用户信息
     * @param $tvmid
     * @param $param 可选项[username, address, postcode,gender,birthday,tel,{file[fileName]}]，仅更新时传参，否则不传该参数
     * @param string $format json|xml
     * @return array [msg=success|信息]
     */
    public static function modifyUser($tvmid, $param, $format = 'json')
    {
        $apiUrl = C('ua_server.host') . '/modifyui';
        $data = array(
            'tvmid' => $tvmid,
            'format' => $format
        );

        if (isset($param['username'])) {
            $data['username'] = $param['username'];
        }

        if (isset($param['address'])) {
            $data['address'] = $param['address'];
        }

        if (isset($param['postcode'])) {
            $data['postcode'] = $param['postcode'];
        }

        if (isset($param['gender'])) {
            $data['gender'] = $param['gender'];//1-女，0-男
        }

        if (isset($param['birthday'])) {
            $data['birthday'] = $param['birthday'];//yyyy-MM-dd
        }

        if (isset($param['tel'])) {
            $data['tel'] = $param['tel'];//8至50 (-0-9)
        }

        if (isset($param['file'])) {//有file时，仅file部分为post提交，其他参数，均以get方式提交
            $file = $param['file'];
            $data['fileName'] = $file['name'];
            $apiUrl .= '?' . http_build_query($data);
            return self::doPost($apiUrl, array('fileName' => new \CURLFile($file['tmp_name'], $file['type'], $file['name'])));//post file
        } else {//无file时, 所有参数均以GET提交
            return self::doGet($apiUrl, $data);
        }
    }

    /**
     * 修改密码
     * @param $tvmid 当前用户的tvmid
     * @param $oldPwd 旧密码 (md5)
     * @param $newPwd 新密码 (8-20位(a-z0-9_),base64编码)
     * @param string $format
     * @return array [modify=true|false, msg]
     */
    public static function modifyPassword($tvmid, $oldPwd, $newPwd, $format = 'json')
    {
        $apiUrl = C('ua_server.host') . '/modifypwd';
        $data = array(
            'tvmid' => $tvmid,
            'old' => md5($oldPwd), //md5值
            'new' => base64_encode($newPwd),//(a-z0-9_)
            'format' => $format
        );
        return self::doGet($apiUrl, $data);
    }

    /**
     * @param $tvmid 当前用户tvmid
     * @param $password 用户
     * @param string $format
     * @return array [msg ...]
     */
    public static function getUserInfo($tvmid, $password, $format = 'json')
    {
        $apiUri = C('ua_server.host') . '/getui';
        $data = array(
            'tvmid' => $tvmid,
            'validateCode' => md5($password),
            'format' => $format
        );

        return self::doGet($apiUri, $data);
    }

    /**
     * token 验证
     * @param $tvmid 当前用户的tvmid
     * @param $token UAServer token
     * @param $appid 应用 id
     * @param bool $license 应用的license
     * @param string $format json|xml
     * @return array [msg,check(true|false), expiration_time,license]
     */
    public static function checkToken($tvmid, $token, $license = false, $format = 'json')
    {
        $apiUrl = C('ua_server.host') . '/check';
        $appid = C('ua_server.appid');
        $data = array(
            'tvmid' => $tvmid,
            'string' => base64_encode(gzcompress($tvmid . '|' . $token . '|' . $appid)), //zlib 压缩 tvmid|token|appid
            'license' => $license,
            'format' => $format
        );
        return self::doGet($apiUrl, $data);
    }

    /**
     *  手机短信验证
     * @param $mobile 手机号码
     * @param string $format
     * @return null {status:,message:}  status=0时成功，其他为失败
     * @throws Exception
     */
    public static function getVCode($mobile, $format = 'json')
    {
        $apiUrl = C('ua_server.host') . '/validatetvmid';
        $param = array(
            'tvmid' => $mobile,
            'format' => $format
        );
        return self::doGet($apiUrl, $param);
    }

    /**
     * 重置密码
     * @param $mobile
     * @param $vcode
     * @param string $format
     * @return null  返回新密码 status=0时，message为新密码
     * @throws Exception
     */
    public static function resetPwd($mobile, $vcode, $format = 'json')
    {
        $apiUri = C('ua_server.host') . '/resetpassword';
        $param = array(
            'tvmid' => $mobile,
            'vcode' => $vcode,
            'format' => $format
        );
        return self::doGet($apiUri, $param);
    }

    /**
     * @param $apiUri
     * @param $data
     * @return mixed array , json解析异常时为null
     * @throws \ErrorException
     * @throws \Exception
     */
    private static function doGet($apiUri, $data)
    {
        $curl = new \Curl\Curl();
        $response = $curl->get($apiUri, $data);
        $raw = $curl->raw_response;
        $error = $curl->error_message;
        $curl->close();

//        \Think\Log::write(sprintf('[%s] %s', $apiUri, $raw), \Think\Log::INFO);
        if ($error) {
            throw new \Exception('cURL exception:' . $error);
        } else {
            return json_decode($raw, true);
        }
    }

    private static function doPost($apiUri, $data, $isJson = false)
    {
        $curl = new \Curl\Curl();
        if ($isJson)
            $curl->setHeader('Content-Type', 'application/json;charset=utf-8');
        $response = $curl->post($apiUri, $data);
        $error = $curl->error_message;
        $raw = $curl->raw_response;
        $curl->close();
//        \Think\Log::write(sprintf('[%s] %s', $apiUri, $raw), \Think\Log::INFO);
        if ($error) {
            throw new \Exception('cURL exception:' . $error);//curl 异常
        } else {
            return json_decode($raw, true);
        }
    }

    private static function log($info)
    {

    }
}
