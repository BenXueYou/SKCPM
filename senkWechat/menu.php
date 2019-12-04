<?php
$appid = "wxe76a06a63e687acb";
$appsecret = "a594e4f4526e2b61863fc4b059b88a59";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$output = https_request($url);
$jsoninfo = json_decode($output, true);

$access_token = $jsoninfo["access_token"];


$jsonmenu = '{
      "button":[
       {
           "name":"充电助手",
           "sub_button":[
            {
               "type":"view",
               "name":"扫码充电",
               "url":"http://sksenk.cn/senkWechat/html/SMCharging/Home.php"
            },
            {
               "type":"view",
               "name":"预约充电",
               "url":"http://sksenk.cn/senkWechat/html/SMCharging/appointCharge.html"
            },
           {
                "type":"view",
                "name":"地图找桩",
                "url":"http://sksenk.cn/senkWechat/html/SMCharging/webMap.html"
            }]
       },
       {
           "name":"我的商城",
           "sub_button":[
            {
               "type":"view",
               "name":"最新动态",
               "url":"http://sksenk.cn/senkWechat/html/shopHome/shopHome.html"
            },
            {
               "type":"view",
               "name":"产品资讯",
               "url":"http://sksenk.cn/senkWechat/html/shopHome/ProductMsg.html"
            },
            {
                "type":"click",
                "name":"车友圈",
                "key":"即将上线，敬请期待！！！"
            }]
       },
       {
            "name":"关于尚宽",
            "sub_button":[
            {
                "type":"view",
                "name":"我的账户",
                "url":"http://sksenk.cn/senkWechat/html/MY/My.html"
            },
            {
                "type":"view",
                "name":"技术支持",
                "url":"http://sksenk.cn/senkWechat/"
            },
            {
                "type":"view",
                "name":"联系客服",
                "url":"http://a105583.atobo.com.cn"
            }]
        }]
    }';
    

$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

?>
