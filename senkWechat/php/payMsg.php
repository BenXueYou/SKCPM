<?php
$appid = "wxe76a06a63e687acb";
$appsecret = "a594e4f4526e2b61863fc4b059b88a59";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
$output = https_request($url);
$jsoninfo = json_decode($output, true);
$access_token = $jsoninfo["access_token"];
$openId = $_GET["openId"];
$total_fee = $_GET["total_fee"];
$time = $_GET["dataTime"];
$jsonmenu = '{
        "touser":"'.$openId.'",
        "template_id":"VPlLa0_uQ07OjwKwk28T4-gi1JA4D-00ezHHCpps1uY",
        "url":"http://weixin.qq.com/download",
        "topcolor":"#FF0000",
        "data":{
	        "first": {
                       "value":"充电完成！",
                       "color":"#173177"
                   },
                   "keyword1":{
                       "value":"扫码充电",
                       "color":"#173177"
                   },
                   "keyword2": {
                       "value":"充电消费'.$total_fee.'元",
                       "color":"#173177"
                   },
                   "keyword3": {
                       "value":"'.$time.'",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"欢迎下次再来！",
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
