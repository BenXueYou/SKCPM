  <?php
    
    require_once "../config.php/jssdk.php";
    $appid = "wx32a40fe9e54cc1c8";
    $secret = "cba6f2171a8a0fb4a2c3012c65f007d3";
   	session_start();
	 
	if(!isset($_GET["code"]) &&  $_GET["code"] == ""){
		$APPID='wx32a40fe9e54cc1c8';
		$REDIRECT_URI='http://www.senk.net.cn/senkWechat/scanCharge/scanCode.php';
		$scope='snsapi_base';
		//$scope='snsapi_userinfo';//需要授权
		$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
		header("Location:".$url);
	}else{
		$code = $_GET["code"];
		$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
		$res = httpGet($get_token_url);
		$user_obj = json_decode($res,true);
		$openid = $user_obj['openid'];
		$wechatUrl = "http://139.129.194.195:8080/SuperBackManage/wechatUserManager/registerUser?openId=".$openid;
	    $obj = httpGet($wechatUrl);
		//存入Session中 注意此时SAE中SESSION不可用。
		$_SESSION['user'] = $openid;
	}
/*
   * httpGet
   * 参数：接口
   * 
   * */	
function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
}
        $jssdk = new JSSDK("wx32a40fe9e54cc1c8","cba6f2171a8a0fb4a2c3012c65f007d3");
        $signPackage = $jssdk->GetSignPackage();
?>
       
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=8">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="Cache" content="no-cache">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
        <link href="../CSS/circle.css" rel="stylesheet" type="text/css"/>   
        <script type="text/javascript" src="../JS/jquery-3.0.0.min.js" ></script>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script type="text/javascript" src="../JS/cookie.js" ></script>
		<title>扫码充电</title>
		<style type="text/css">
			body{padding: 0;margin: 0;position:relative;}
			h2{
                margin-top:30px;
				text-align: center;
				color: #299DFF;
				
			}
			.middle_image{
                margin:60px auto 0px;
                width:150px;
                height:180px;
                background:white url(../senk_img/scan_charging_img_2.png) no-repeat;
                background-origin: content-box;
				background-clip: content-box;
				background-size: 100% 100%;
				text-align: center;
			}
			button{
				height: 60px;
                background: url(../senk_img/扫描.png) no-repeat center;
				background-clip: content-box;
				background-origin: content-box;
				background-size: contain;
				line-height: 50px;
				width: 40%;
				outline: none;
				border: 1px solid #299DFF;
				border-radius: 5px;
				margin: 50px 30% 10px;
				font-size: 20px;
				padding: 10px 0;
			}
			p{
				text-align: center;
				color:rgb(105,105,105);
			}
            .hidden{
            	display:none;
            }
             #mask{
            	position:absolute;
                left:0px;
                top:-20px;
                width:100%;
                height:800px;
                background-color:rgba(80,80,80,0.3);
            }
		</style>
	</head>
	<body>
		<h2>扫描桩上的二维码启动充电</h2>
        <div class="middle_image"></div>
		<button></button>
        <p class="middle_input">或<a style="color: blue; text-decoration: underline;">输入桩编号</a></p>
        <div class="hidden" id="mask">
            <div class="m-load2">
                <div class="line">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="circlebg"></div>
            </div>
        </div>

	</body>
	<script type="text/javascript" src="../JS/my-js/UserState.js" ></script>
    <script type="text/javascript" src="../senk-shop/js/my-js/logs.js" ></script>
    <script type="text/javascript" src="../JS/my-js/payOrder.js" ></script>
    <script type="text/javascript" src="../JS/my-js/PileState.js" ></script>
    <script type="text/javascript">
    var USR;     
$(document).ready(function(){
      <?
     	require_once "wx_pay/lib/WxPay.config.php";
     	$url = WxPayConfig::TESTURL;
     	$openid = "oR9d21lZxSloF2iQtPHjdRAdy-2o";
     ?>
       var flag = "DEBUG";
     //定义全局变量
       var urlM = "<?php echo $url?>";
       var openId = '<?php echo $openid;?>';
       var cpid;
       var deviceId = cpid;
       var chargeState = 0;
       var money = 0;
       var tradeNo = 0;
       console.log(urlM + "====" + openId);
       var User = new UserState(openId,chargeState,tradeNo,money,"4",urlM);
       var Order = new OrderPay(openId,tradeNo,money,urlM);
       var Pile = new PileMsg(openId,tradeNo,money,urlM);
       USR = User;
       $("button").click(function(){
             Mask(true);
			 var usCgs = User.getChargeState();
			 var log = new setLoggle("检测用户状态："+openId+":"+usCgs,"../admin/logs/log_info.php");
			 if(usCgs == 1 || usCgs == "1" || usCgs == 2 || usCgs == "2"){
			 	cpid = Pile.getPayOrderPile();
			 	Mask(false);
			    location.href='charge.php?cpid='+cpid+'&openid='+openId+'&chargeState='+e+'&money='+money+'&out_trade_no='+tradeNo;
			 }else{
			 	Mask(false);
			 	if (flag == 'DEBUG') {
			 		cpid = "140105000000000500";
		            cpObj = Pile.getPileMsg(cpid);
					if(cpObj != 0){
						Mask(false);
						var log = new setLoggle("检测用户状态："+openId+":"+"跳转支付界面","../admin/logs/log_info.php");
						location.href='pay.php?openid='+openId+'&cpid='+cpid+'&cpObj='+escape(JSON.stringify(cpObj));
				    }else{
						var log = new setLoggle("检测用户状态："+openId+":"+"二维码有误","../admin/logs/log_info.php");
				    }
			 	} else{	//扫码
			 		wxScanAPI(User,Pile);
 			    }
			 }
      });
      
 //输入设备号界面跳转
     $("a").click(function(){
        	 var usCgs = USR.getChargeState();
        	 if(usCgs == 1 || usCgs == "1" || usCgs == 2 || usCgs == "2"){
			 cpid = Pile.getPayOrderPile();
			 Mask(false);
			 location.href='charge.php?cpid='+cpid+'&openid='+openId+'&chargeState='+e+'&money='+money+'&out_trade_no='+tradeNo; 
		}else{
			 location.href = 'scan_input.html?openid='+openId;
		}	
    });  
 });

 /*
  * 控制加载效果
  * 参数：add_del 值为true 添加蒙版效果；值为false 移除蒙版效果
  * 
  * */      
function Mask(add_del){
 	if(add_del){
        	$("#mask").removeClass("hidden");
     }else{
        $("#mask").addClass("hidden");
    }
}
 //调起微信扫码接口  
<?php $signPackage["appId"] = "0";?>
<?php $signPackage["timestamp"] = "1";?>
<?php $signPackage["nonceStr"] = "2";?>
<?php $signPackage["signature"] = "3";?>
 function wxScanAPI(u,o){
 	wx.config({
 		debug: false,
 		appId: '<?php echo $signPackage["appId"];?>',
   		timestamp: '<?php echo $signPackage["timestamp"];?>',
   		nonceStr: '<?php echo $signPackage["nonceStr"];?>',
   		signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: ["scanQRCode",]          // 所有要调用的 API 都要加到这个列表中     
	});
    wx.ready(function () {
         wx.scanQRCode({
         	needResult: 1,                  // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
            scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
            success: function (res) { 
	            var result = res.resultStr;
	            deviceId = result;
	            //判断设备号长度是否符合
	            if(result.length >= 18){
	            		Mask(true);
	                cpObj = O.getPayOrderPileMsg(deviceId);
					if(cpObj != 0){
					   	Mask(false);
					    location.href='pay.php?openid='+openId+'&cpid='+deviceId+'&cpObj='+escape(JSON.stringify(cpObj));
					}else{
					   var log = new setLoggle("检测用户状态："+openId+":"+cpObj);
				    }
	            }else{
	                  alert("二维码错误");
	            }
             }
          });       
    });
    wx.error(function(res){
       // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
        alert("扫码错误"+JSON.stringify(res));       
    });           
}
     </script>
</html>

	
