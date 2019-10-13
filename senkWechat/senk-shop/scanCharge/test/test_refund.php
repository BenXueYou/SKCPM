 <?php
    require_once "wx_pay/lib/test/test_WxPay.Api.php";
   $out_trade_no = $_GET["out_trade_no"];
  
   $total = $_GET["refrund_fee"];
   $total_fee = $_GET["total_fee"];
/*
$out_trade_no = "148437618220170712163510";
$total_fee = '1';
$total = '1';
*/
//$total_fee = '1';
//$total = '1';

    if(!$out_trade_no && !$total && !$total_fee)return;
    $input = new WxPayRefund();
    $input->SetOut_trade_no($out_trade_no);
    $input->SetTotal_fee($total_fee);
    $input->SetRefund_fee($total);
    $input->SetOut_refund_no("sk".rand(1000,9999).date("YmdHis"));
    $input->SetOp_user_id(WxPayConfig::MCHID);
	printf_info(WxPayApi::refund($input));


    function printf_info($data)

    {
        $arr = array();
 
        if($GLOBALS['out_trade_no'] && $GLOBALS['total']  && $GLOBALS['total_fee']){
            array_push($arr, $GLOBALS['out_trade_no']);
            array_push($arr, $GLOBALS['total']);
            array_push($arr, $GLOBALS['total_fee']);
            array_push($arr, $data);
            echo json_encode($arr);
        }else{
             array_push($arr, "refund_fee or total_fee error");
             array_push($arr, $GLOBALS['out_trade_no']);
             echo json_encode($arr);
        }
    }


	$wechatLoggerUrl = "http://139.129.194.195:8080/SuperBackManage/wechatUserManager/logger?content=refundToWeChat";
	$obj = httpGet($wechatLoggerUrl);

    function httpGet($url) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);

        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        //echo var_dump($res);
        return $res;
  }





?>
