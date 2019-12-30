<?php
$appid = "wxe76a06a63e687acb";
$appsecret = "a594e4f4526e2b61863fc4b059b88a59";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
$output = https_request($url);
$jsoninfo = json_decode($output, true);
$access_token = $jsoninfo["access_token"];
$openId = $_GET["openId"];
$total_fee = $_GET["total_fee"];
$time = $_GET["dateTime"];
$order_id = $_GET["order_id"];
$jsonmenu = '{
        "touser":"'.$openId.'",
        "template_id":"VJ9JjvSNRGfPv_CW9yXlBppGKzSKr8N1NhXdfu07BUw",
        "url":"http://weixin.qq.com/download",
        "topcolor":"#FF0000",
        "data":{
	        "first": {
                       "value":"尊敬的用户，您好！您的支付订单已收到",
                       "color":"#173177"
                   },
                   "keyword1":{
                       "value":"'.$time.'",
                       "color":"#173177"
                   },
                   "keyword2": {
                    "value":"'.$total_fee.'元",
                    "color":"#173177"
                   },
                   "keyword3": {
                       "value":"'.$order_id.'",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"感谢您的购买，请凭该购买通知到服务区扫码充电！",
                       "color":"#173177"
                   }
	        }
    }';


$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
