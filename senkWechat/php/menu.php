<?php
$appid = "wxe76a06a63e687acb";
$appsecret = "a594e4f4526e2b61863fc4b059b88a59";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$output = https_request($url);
$jsoninfo = json_decode($output, true);
echo $jsoninfo;
$access_token = $jsoninfo["access_token"];
$jsonmenu = '{
      "button":[
       {
           "name":"我要充电",
           "sub_button":[
            {
               "type":"view",
               "name":"扫码充电",
               "url":"http://sksenk.cn/senkWechat/html/scanCharging/Home.php"
            },
            {
                "type":"view",
                "name":"订单记录",
                "url":"http://sksenk.cn/senkWechat/html/MY/recHome.php"
            },
            {
               "type":"view",
               "name":"地图找桩",
               "url":"http://sksenk.cn/senkWechat/html/Map/webMap.html"
            }
           ]

       },
       {
			  "name":"我要租车",
              "sub_button":[
               {
                  "type":"view",
  	              "name":"我的车型",
  	              "url":"http://wx.senk.com.cn/senkWechat/senk-shop/rent_car/CarList.html"
               },
               {
                 "type":"view",
                  "name":"租车服务",
                  "url":"http://wx.senk.com.cn/senkWechat/senk-shop/products/PileList.html"
               }]

       },
       {
              "name":"我的尚宽",
              "sub_button":[
               {
                  "type":"view",
                  "name":"走进尚宽",
                  "url":"http://wx.senk.com.cn/senkWechat/senk-shop/about_us/index.html"
               },
               {
                  "type":"view",
                  "name":"优秀案例",
                  "url":"http://wx.senk.com.cn/senkWechat/senk-shop/excllenct_case/excellent.html"
               },
               {
                  "type":"view",
                  "name":"优惠活动",
                  "url":"http://wx.senk.com.cn/senkWechat/senk-shop/about_us/saleList.html"
               },
               {
                  "type":"view",
                  "name":"合作加盟",
                  "url":"http://wx.senk.com.cn/senkWechat/senk-shop/JoinUs/join.html"
               },
                {
                  "type":"click",
                  "name":"联系我们",
                  "key":"联系电话：0351-7111110"
               }
           ]

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
