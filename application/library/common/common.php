<?php

function writeJson($dirname,$file,$message) {
   // $dirname = '/opt/logs/Crontab/'.date('Ymd');
    if(!is_dir($dirname)) {
        mkdir($dirname, 0777, true);
    }
    $destination = $dirname.'/'.$file;
    file_put_contents($destination, $message);
}

//获取国美的佣金比例
 function CategoryRate($category_id){

     if($category_id==''){
         return 0;
     }
     $config = Yaf_Application::app()->getConfig();
     $charges=$config['charges'];
     $categoryGome=new CategoryGomeModel();
     $category= $categoryGome->getOne(array('category_id'=>$category_id));
     if(isset($charges[$category_id])){
         $category_rate=$charges[$category_id]/100;

     }elseif(isset($charges[$category['parent_id']])){

         $category_rate=$charges[$category['parent_id']]/100;
     }else{
         $category= $categoryGome->getOne(array('category_id'=>$category['parent_id']));
         $category_rate=isset($charges[$category['parent_id']]) ? $charges[$category['parent_id']]/100 : 0;
     }
    return $category_rate;
}

//写日志

function writeLogs($message,$type=''){
    
    $config = Yaf_Registry::get("config");
    
    $log_path=$config['logpath'];
    $path=date("Ymd");
    $log_path.='/'.$path;
    if(!is_dir($log_path)) {
        mkdir($log_path, 0777, true);
    }
    $debug=debug_backtrace();
    $log_name=$debug['1']['function'];
    if(!$type){
        $destination=$log_path."/".$log_name.".log";
    }else{
        $destination=$log_path."/".$type.".log";
    }
    $message=date("Y-m-d H:i:s")."\n".$message;

    file_put_contents($destination, $message.PHP_EOL, FILE_APPEND);
}
function getpage( $count, $pagesize = 10 )
{
    $p = new Page( $count, $pagesize );
    $p->setConfig( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>' );
    $p->setConfig( 'prev', '上一页' );
    $p->setConfig( 'next', '下一页' );
    $p->setConfig( 'last', '末页' );
    $p->setConfig( 'first', '首页' );
    $p->setConfig( 'theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%' );
    $p->lastSuffix = false; //最后一页不显示为总页数
    return $p;
}

/**
导出订单Excel方法
 * @author liufeng
 */
function export_data_one( $data )
{
    error_reporting( E_ALL ); //开启错误
    set_time_limit( 0 ); //脚本不超时
    date_default_timezone_set( 'Europe/London' ); //设置时间
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator()
        ->setLastModifiedBy()
        ->setTitle( "Office 2007 XLSX Test Document" )
        ->setSubject( "Office 2007 XLSX Test Document" )
        ->setDescription( "order List for Office 2007 XLSX, generated using PHP classes." )
        ->setKeywords( "office 2007 openxml php" )
        ->setCategory( "Test result file" );
    $objPHPExcel->setActiveSheetIndex( 0 )
        ->setCellValue( 'A1', '订单ID' )
        ->setCellValue( 'B1', '下单时间' )
        ->setCellValue( 'C1', '产品ID' )
        ->setCellValue( 'D1', '商品名称' )
        ->setCellValue( 'E1', '联盟平台' )
        ->setCellValue( 'F1', '状态' )
        ->setCellValue( 'G1', '订单金额' )
        ->setCellValue( 'H1', '数量' )
        ->setCellValue( 'I1', '商品金额' )
        ->setCellValue( 'J1', '预估佣金' )
        ->setCellValue( 'K1', '实际佣金' )
        ->setCellValue( 'L1', '预估返现' )
        ->setCellValue( 'M1', '已返金额' )
        ->setCellValue( 'N1', 'OpenID')
        ->setCellValue( 'O1', 'FeedBack');
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'A' )->setWidth( 40 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'B' )->setWidth( 25 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'C' )->setWidth( 40 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'D' )->setWidth( 50 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'E' )->setWidth( 10 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'F' )->setWidth( 10 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'G' )->setWidth( 10 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'H' )->setWidth( 10 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'I' )->setWidth( 10 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'J' )->setWidth( 10 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'K' )->setWidth( 10 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'L' )->setWidth( 10 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'M' )->setWidth( 10 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'N' )->setWidth( 30 );
    $objPHPExcel->getActiveSheet()->getColumnDimension( 'O' )->setWidth( 30 );

    $letter = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
    if ( $data ) {
        $i = 2;
        foreach ( $data as $key => $value ) {
            $j = 0;
            foreach ( $value as $k => $val ) {
                $index = $letter[ $j ] . "$i";
                if ( $letter[ $j ] == "A" ||$letter[ $j ] =="C") {
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit( $letter[ $j ] . $i, $val, PHPExcel_Cell_DataType::TYPE_STRING );
                } else {
                    $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( $index, $val );
                }
                $j++;
            }
            $i++;
        }
    }
    $time = date( 'Y-m-d', time() );
    $objPHPExcel->getActiveSheet()->setTitle( "订单报表数据" );
    $objPHPExcel->setActiveSheetIndex( 0 );
    header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
    header( 'Content-Disposition: attachment;filename=' . $time . 'Order.xls' );
    header( 'Cache-Control: max-age=0' );
    $objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );
    $objWriter->save( 'php://output' );
    exit;
}

function PutOutExcel($data){
    error_reporting( E_ALL ); //开启错误
    set_time_limit( 0 ); //脚本不超时

// PHP文件句柄，php://output 表示直接输出到浏览器

    $fp = fopen('php://output', 'a');

    $time = date( 'Y-m-d', time() );
    header( 'Content-Type: application/vnd.ms-excel.openxmlformats-officedocument.spreadsheetml.sheet');
    header( 'Content-Disposition: attachment;filename=' . $time . 'Order.xls' );
    header( 'Cache-Control: max-age=0' );

// 输出Excel列头信息

    $head = array('订单ID','下单时间','产品ID','商品名称','联盟平台','状态','订单金额','数量','商品金额','预估佣金','实际佣金','预估返现','已返金额','OpenID','FeedBack');

    foreach ($head as $i => $j) {
// CSV的Excel支持GBK编码，一定要转换，否则乱码
        $head[$i]= iconv('utf-8', 'gbk', $j);
    }
// 写入列头

    fputcsv($fp, $head,"\t");

// 计数器
    $cnt = 0;

// 每隔$limit行，刷新一下输出buffer，节约资源
    $limit = 10000;
    foreach($data as $key => $value){

        $cnt ++;

        if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
            ob_flush();
            flush();
            $cnt = 0;
        }

        foreach($value as $v){
            $row[]= iconv('utf-8', 'gbk',$v);
        }
        fputcsv($fp,$row,"\t");
        unset($row);
    }


}

/**
 * 查询当前余额
 * @param $id
 * @return int
 */

function getBalanceInfo($id){
    $config = Yaf_Application::app()->getConfig();
    $url = $config->balance->url.$id;
    $rtn = file_get_contents($url);
    $rtnArr = json_decode($rtn,true);
    $money = 0;
    if($rtnArr['status']=='success'){
        $money = $rtnArr['data']['canUsed'];
        $money = sprintf("%01.2f", $money/100);
    }
    return $money;
}

/**
 * 修改提现时文字备注
 * @param $info
 * @return bool
 * @throws Exception
 */
function changeNote($info){

    $userId = $info['tvmid'];
    $id = $info['orderId'];
    $note = $info['note'];
    $sign = strtoupper(md5('orderId='.$id.'&tvmid='.$userId.'&key=tvmingsjklajdklajdlbcdajsld123123'));
    $data = array(
        'tvmid' =>$userId,
        'orderId'   =>$id,
        'typeNote'  =>$note,
        'sign'  =>$sign
    );
    $config = Yaf_Application::app()->getConfig();
    $url = $config->balance->noteurl;
    $rtn = Tools::curl($url,'POST',$data);
    writeLogs($url . '    params=' . var_export($data, true).' return='.$rtn);
    $rtnArr = json_decode($rtn,true);
    if($rtnArr['status']=='success'){
        return true;
    }
    return false;
}


/**
 * 充值接口
 * @param $info 充值数据
 * @return bool 充值数据是否正确接收
 * @throws Exception
 */
function addBalance($info){

    $userId = $info['userId'];
    $id = $info['id'];
    $money = $info['money'];
    $money = $money*100;//单位是分
    $sign = strtoupper(md5('orderId='.$id.'&tvmid='.$userId.'&key=tvmingsjklajdklajdlbcdajsld123123'));
    $data = array(
        'tvmid' =>$userId,
        'orderId'   =>$id,
        'money' =>$money,
        'sign'  =>$sign
    );
    $config = Yaf_Application::app()->getConfig();
    $url = $config->balance->addurl;
    $rtn = Tools::curl($url,'POST',$data);
    writeLogs($url . '    params=' . var_export($data, true).' return='.$rtn);
    $rtnArr = json_decode($rtn,true);
    if($rtnArr['status']=='success'){
        return true;
    }
    return false;
}

function minusBalance($info){

    $userId = $info['userId'];
    $id = $info['id'];
    $money = $info['money'];
    $money = $money*100;//单位是分
    $sign = strtoupper(md5('orderId='.$id.'&tvmid='.$userId.'&key=tvmingsjklajdklajdlbcdajsld123123'));
    $data = array(
        'tvmid' =>$userId,
        'orderId'   =>$id,
        'money' =>$money,
        'sign'  =>$sign
    );
    $config = Yaf_Application::app()->getConfig();
    $url = $config->balance->minusurl;
    $rtn = Tools::curl($url,'POST',$data);
    $rtnArr = json_decode($rtn,true);
    if($rtnArr['status']=='success'){
        return true;
    }
    return false;
}

/**
 * 绑定银行账号
 */
function saveAccount($info){
    $AccountLogModel = new AccountLogModel();
    $id = isset($info['uaId'])?$info['uaId']:'';
    $tvmid = $info['userId'];
    $account = $info['card'];
    $bankName = $info['bankName'];
    $name = $info['company'];
    $tel = $info['userName'];
    
    $data = array(
        'tvmid' =>$tvmid,
        'bank_name'   =>$bankName,
        'account' =>$account,
        'name'  =>$name,
        'tel' =>$tel
    );
    if ($id){
        $data['id'] = $id;
    }
    $config = Yaf_Application::app()->getConfig();
    $url = $config->deposit->url."/SaveAccount";
    $rtn = Tools::curl($url,'POST',json_encode($data));
    $rtnArr = json_decode($rtn,true);
    $data['rtnData'] = $rtnArr;
    $data['addTime'] = date('Y-m-d H:i:s');
    $AccountLogModel->insert($data);;
    return $rtnArr;
}

/**
 * 转账接口
 */
function transferAccount($info){
    $TransferLogModel = new TransferLogModel();
    $config = Yaf_Application::app()->getConfig();
    $tvmid = $info['bankInfo']['userId'];
    $orderId  = $info['_id']->{'$id'};
    $psId = $config->deposit->psId;
    $key = $config->deposit->key;
    $uaId = $info['bankInfo']['uaId'];  //绑定银行卡后返回的id
    $payPrice = $info['applyCash']*100;//单位是分
    $agent_pay_memo = '审批通过';   //备注
    $str = '';

    $data = array(
        'tvmid' =>$tvmid,
        'order_id'   =>$orderId,
        'pay_price' =>$payPrice,
        'ua_id' =>$uaId,
        'ps_id' =>+$psId,
        'agent_pay_memo' =>$agent_pay_memo
    );
    if ($config->platforms=='DEV'){
        $data['debug'] = 1;
        $data['sign'] = '';
    }else {
        ksort($data, SORT_STRING);  //ASCII码从小到大排序（字典序）
        foreach ($data as $k=>$v){
            $str .= "&".$k."=".$v;
        }
        $str = substr($str,1);
        $str.= "&key=".$key;
        $sign = strtoupper(md5($str));
        $data['sign'] = $sign;
    }
    $url = $config->deposit->url."/BankPay";
    $rtn = Tools::curl($url,'POST',json_encode($data));
    $rtnArr = json_decode($rtn,true);
    $data['rtnData'] = $rtnArr;
    $data['addTime'] = date('Y-m-d H:i:s');
    //记录操作日志
    $TransferLogModel->insert($data);
    return $rtnArr;
}

/**
 * 将用户信息上传给玉川
 */
function pushAccount($info){
    $config = Yaf_Application::app()->getConfig();
    $yyyappid = $config->rts->yyyappid;
    $rkey = $config->rts->rkey;
    $url = $config->rts->url;
    $systoken = $config->rts->systoken;
    $userId = $info['userId'];  //bst5a1277b4ca7b4e0e358b4567
    $time = time();
    $str='yyyappid='.$yyyappid.'&openid='.$userId.'&sigExpire='.$time.'&rkey='.$rkey;
    $sign = md5(md5($str));
    $data = array(
        'tvmid' => $userId,
        'nickname' => $info['company'],
        'systoken' => $systoken,
        'head_img' => $info['headImg'],
        'sigExpire' => $time,
        'wxTokenSig' => $sign
    );
    $rtn = Tools::curl($url,'POST',$data);
    writeLogs($url . '    params=' . var_export($data, true).' return='.$rtn);
    $rtnArr = json_decode($rtn,true);
    return $rtnArr;
}

function getMatter($userId,$action,$method){
    if(!$userId || !$action || !$method){
        return false;
    }
    $menuModel=new MenuModel();
   $info=$menuModel->getInfo(array('action'=>$action,'method'=>strtolower($method)));
    //获取该用户的信息
    $userMode=new AdminUserModel();
    $userInfo=$userMode->getOneInfo(array('_id'=>new MongoId($userId)));
    if($userInfo && $userInfo['userName']=='admin'){
        return true;
    }
   if($userInfo && $info && isset($userInfo['menu']) && in_array($info['_id']->{'$id'},$userInfo['menu'])){
       return true;
   }else{
       return false;
   }
}

class Page{
    public $firstRow; // 起始行数
    public $listRows; // 列表每页显示行数
    public $parameter; // 分页跳转时要带的参数
    public $totalRows; // 总行数
    public $totalPages; // 分页总页面数
    public $rollPage   = 11;// 分页栏每页显示的页数
    public $lastSuffix = true; // 最后一页是否显示总页数

    private $p       = 'p'; //分页参数名
    private $url     = ''; //当前链接URL
    private $nowPage = 1;

    // 分页显示定制
    private $config  = array(
            'header' => '<span class="rows">共 %TOTAL_ROW% 条记录</span>',
            'prev'   => '<<',
            'next'   => '>>',
            'first'  => '1...',
            'last'   => '...%TOTAL_PAGE%',
            'theme'  => '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
    );

    /**
     * 架构函数
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
    */
    public function __construct($totalRows, $listRows=20, $parameter = array()) {
        '' && $this->p = ''; //设置分页参数名称
        /* 基础设置 */
     
        $this->totalRows  = $totalRows; //设置总记录数
        $this->listRows   = $listRows;  //设置每页显示行数
        $this->parameter  = empty($parameter) ? $_GET : $parameter;
        $this->nowPage    = empty($_GET[$this->p]) ? 1 : intval($_GET[$this->p]);
        $this->nowPage    = $this->nowPage>0 ? $this->nowPage : 1;
        $this->firstRow   = $this->listRows * ($this->nowPage - 1);
    }

    /**
     * 定制分页链接设置
     * @param string $name  设置名称
     * @param string $value 设置值
     */
    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * 生成链接URL
     * @param  integer $page 页码
     * @return string
     */
    private function url($page){
       
        return str_replace(urlencode('[PAGE]'), $page, $this->url);
    }

    /**
     * 组装分页链接
     * @return string
     */
    public function show() {
        if(0 == $this->totalRows) return '';
   
        /* 生成URL */
        $this->parameter[$this->p] = '[PAGE]';
        $_url = $_SERVER["REQUEST_URI"];
  
        $_par = parse_url($_url);
     
        if (isset($_par['query'])) {
            parse_str($_par['query'],$_query);
            unset($_query['page']);
            $_url = $_par['path'];
        }
      
        //$this->url = U(ACTION_NAME, $this->parameter);
       
  
        $i=0;
       foreach($this->parameter as $key=>$val){
          
           if($i==0){
               $_url.="?".$key."=".urlencode($this->parameter[$key]);
           }else{
               $_url.="&".$key."=".urlencode($this->parameter[$key]);
           }
           $i++;
       }
       $this->url=$_url;
     
     
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
       
        if(!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
 
        /* 计算分页临时变量 */
        $now_cool_page      = $this->rollPage/2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row  = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<a class="prev" href="' . $this->url($up_row) . '">' . $this->config['prev'] . '</a>' : '';

        //下一页
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<a class="next" href="' . $this->url($down_row) . '">' . $this->config['next'] . '</a>' : '';

        //第一页
        $the_first = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage - $now_cool_page) >= 1){
            $the_first = '<a class="first" href="' . $this->url(1) . '">' . $this->config['first'] . '</a>';
        }

        //最后一页
        $the_end = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages){
            $the_end = '<a class="end" href="' . $this->url($this->totalPages) . '">' . $this->config['last'] . '</a>';
        }

        //数字连接
        $link_page = "";
        for($i = 1; $i <= $this->rollPage; $i++){
            if(($this->nowPage - $now_cool_page) <= 0 ){
                $page = $i;
            }elseif(($this->nowPage + $now_cool_page - 1) >= $this->totalPages){
                $page = $this->totalPages - $this->rollPage + $i;
            }else{
                $page = $this->nowPage - $now_cool_page_ceil + $i;
            }
            if($page > 0 && $page != $this->nowPage){

                if($page <= $this->totalPages){
                    $link_page .= '<a class="num" href="' . $this->url($page) . '">' . $page . '</a>';
                }else{
                    break;
                }
            }else{
                if($page > 0 && $this->totalPages != 1){
                    $link_page .= '<span class="current">' . $page . '</span>';
                }
            }
        }

        //替换分页内容
        $page_str = str_replace(
                array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'),
                array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages),
                $this->config['theme']);
        return "<div>{$page_str}</div>";
    }




}


//发送短信方法
function sendMsg($mobile,$msg) {
    $config = Yaf_Application::app()->getConfig();
    $rkey = $config->sendMsg->rkey;
    $url = $config->sendMsg->url.'/apis/sms/sendSms';
    $str = 'mobile='. $mobile . '&rkey=' . $rkey;
    $sign = md5(md5($str));
    $msgInfo = array (
        'mobile' => $mobile,
        'msg'    => $msg,
        'sign'   => $sign,
        'type'   => 4
    );
    $res = Tools::curl($url,'POST',$msgInfo);
    $resArr = json_decode($res,true);
    return $resArr;
}



