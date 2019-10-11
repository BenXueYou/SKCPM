<?php
$appid = "wx0a766465ad74001e";
$appsecret = "49b67f9262e29328f83da924b68c1982";
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
               "url":"http://pxywechat.applinzi.com/html/SMCharging/scanCode.php"
            },
            {
               "type":"view",
               "name":"预约充电",
               "url":"http://pxywechat.applinzi.com/html/SMCharging/appointCharge.html"
            },
           {
                "type":"view",
                "name":"地图找桩",
                "url":"http://pxywechat.applinzi.com/html/SMCharging/webMap.html"
            }]
       },
       {
           "name":"热点资讯",
           "sub_button":[
            {
               "type":"view",
               "name":"最新动态",
               "url":"http://pxywechat.applinzi.com/html/shopHome/shopHome.html"
            },
            {
               "type":"view",
               "name":"产品资讯",
               "url":"http://pxywechat.applinzi.com/html/shopHome/ProductMsg.html"
            },
            {
                "type":"click",
                "name":"车友圈",
                "key":"即将上线，敬请期待！！！"
            }]
       },
       {
            "name":"个人中心",
            "sub_button":[
            {
                "type":"view",
                "name":"我的账户",
                "url":"http://pxywechat.applinzi.com/html/MY/My.html"
            },
            {
                "type":"view",
                "name":"技术支持",
                "url":"http://a105583.atobo.com.cn"
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