  <?php

	error_reporting(E_ERROR | E_PARSE);
	header("content-type:text/HTML;charset=utf-8");
	require_once "../../php/jssdk.php";
	require_once "../../php/wechatUserInfo.php";
	$appid = "wx031732af628faee0";
	$secret = "5e8ccf52a81d427752241374212af303";

	if (!isset($_GET["code"]) &&  $_GET["code"] == "") {
		$APPID = 'wx031732af628faee0';
		/***************************************************************************/
		//echo $_SERVER['HTTP_HOST'];
		$REDIRECT_URI = urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
		//$REDIRECT_URI = urlencode('https://www.gxbie.com/LanChangWechat/html/SMCharging/Home.php');
		/***************************************************************************/
		//$scope='snsapi_base';
		$scope = 'snsapi_userinfo'; //需要授权
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $APPID . '&redirect_uri=' . $REDIRECT_URI . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect';
		header("Location:" . $url);
	} else {
		$code = $_GET["code"];
		$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $get_token_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$res = curl_exec($ch);
		curl_close($ch);
		$user_obj = json_decode($res, true);
		$openid = $user_obj['openid'];
		$access_token = $user_obj['access_token'];
		$user = new USER($openid, $access_token);
		//$user->saveUserInfo();
	}
	$jssdk = new JSSDK("wx031732af628faee0", "5e8ccf52a81d427752241374212af303");
	$signPackage = $jssdk->GetSignPackage();

	?>
  <!DOCTYPE html>
  <html>

  <head>
  	<meta http-equiv="Content-Type" content="charset=UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=8">
  	<meta http-equiv="Access-Control-Allow-Origin" content="">
  	<meta http-equiv="content-security-policy">
  	<meta http-equiv="Expires" content="0">
  	<meta http-equiv="Pragma" content="no-cache">
  	<meta http-equiv="Cache-control" content="no-cache">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  	<script type="text/javascript" src="../JS/jquery-3.0.0.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="../../CSS/mui.min.css" />
  	<link rel="stylesheet" type="text/css" href="../../CSS/scanCode.css" />
  	<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
  	<title>扫码充电</title>
  	<style type="text/css">

  	</style>
  </head>

  <body>
  	<div class="middle_image"></div>
  	<button style="background-color:white;"></button>
  	<p class="middle_input">或<a style="color: blue; text-decoration: underline;" onclick="hrefBtn()">输入桩编号</a></p>
  	<h5 style="width:100%;text-align:center;margn:auto;">扫描桩上的二维码启动充电</h5>
  	<script type="text/javascript" src="../JS/CONFIG.js"></script>
  	<script type="text/javascript" src="../JS/mui.js"></script>
  	<script type="text/javascript" src="../JS/Order.js"></script>
  	<script type="text/javascript" src="../JS/Pile.js"></script>
  	<script type="text/javascript" src="../JS/User.js"></script>
  	<script type="text/javascript">
  		//定义全局变量
  		var urlM = CONFIGS.LANCHUANG();
  		var openId = '<?php echo $openid; ?>';
  		// var userid = openId = "1832785020180122";//oR9d21lZxSloF2iQtPHjdRAdy-2o
  		// var userid = openId = "oR9d21lZxSloF2iQtPHjdRAdy-2o";
  		var userid = openId;
  		var deviceId, cpid;
  		deviceId = cpid;
  		var chargeState, money, tradeNo = 0;
  		mui.init({
  			swipeBack: true //启用右滑关闭功能
  		});
  		//监听扫码按钮
  		$("button").click(function() {
  			//验证用户信息
  			User.UserState(CONFIGS.LANCHUANG(), userid, function(user_state) {
  				console.log("user_state===" + user_state);
  				if (user_state == 0) {
  					//用户空闲状态可以扫码
  					wxScanAPI();
  				} else if (user_state == 1) {
  					//用户已产生订单，获取订单信息，且直接进入充电界面,获取当前桩的信息
  					Pile.pileMsg(CONFIGS.LANCHUANG(), userid, function(e) {
  						if (e != null && e != "null") {
  							location.href = 'charging.php?cpid=' + e.cpid + "&cptype=" + e.cptype;
  						} else {
  							mui.toast('账号异常', {
  								duration: 'long',
  								type: 'div'
  							});
  						}
  					});
  				} else if (user_state == 201) {
  					mui.toast('请完善信息', {
  						duration: 'long',
  						type: 'div'
  					});

  					location.href = '../MY/getPhone.html?openId=' + openId;
  				} else if (user_state == 99 || user_state == 100) { //账号异常
  					mui.toast('账号异常', {
  						duration: 'long',
  						type: 'div'
  					});
  					location.href = '../../MY/getPhone.html?userId=' + openId;
  				} else if (user_state == 101) { //网络信号不稳定，服务器未响应
  					mui.toast('网络信号不稳定，服务器未响应', {
  						duration: 'long',
  						type: 'div'
  					});
  				} else {

  				}
  			});
  		});
  		//调起微信扫码接口    
  		function wxScanAPI() {
  			wx.config({
  				debug: false,
  				appId: '<?php echo $signPackage["appId"]; ?>',
  				timestamp: '<?php echo $signPackage["timestamp"]; ?>',
  				nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
  				signature: '<?php echo $signPackage["signature"]; ?>',
  				jsApiList: ["scanQRCode", ] //// 所有要调用的 API 都要加到这个列表中     
  			});
  			wx.ready(function() {
  				wx.scanQRCode({
  					needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
  					scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
  					success: function(res) {
  						// 当needResult 为 1 时，扫码返回的结果
  						var result = res.resultStr;
  						//设备号添加两个0
  						deviceId = result;
  						//判断设备号长度是否符合
  						location.href = "chargePay.php?cpid=" + result;
  					}
  				});
  			});
  			wx.error(function(res) {
  				alert("扫码错误" + JSON.stringify(res));
  			});
  		}
  		//输入设备号界面跳转
  		function hrefBtn() {
  			User.UserState(CONFIGS.LANCHUANG(), userid, function(user_state) {
  				//alert("输入设备号user_state===" + user_state);
  				if (user_state == 0) { //空闲状态
  					//用户空闲状态可以扫码
  					location.href = "scanCode.php?openId=" + userid;
  				} else if (user_state == 99 || user_state == 201) { //账号异常
  					mui.toast('账号异常', {
  						duration: 'long',
  						type: 'div'
  					});

  					location.href = '../MY/getPhone.html?openId=' + openId;

  				} else if (user_state == 101) { //网络信号不稳定，服务器未响应
  					mui.toast('网络信号不稳定，服务器未响应', {
  						duration: 'long',
  						type: 'div'
  					});
  				} else { //
  					//用户已产生订单，获取订单信息，且直接进入充电界面,获取当前桩的信息
  					Pile.pileMsg(CONFIGS.LANCHUANG(), userid, function(e) {
  						if (e != null && e != "null") {
  							location.href = 'charging.php?cpid=' + e.cpid + "&cptype=" + e.cptype;
  						} else {

  						}
  					});
  				}
  			});
  		}
  		//日志
  		function Loggert(t) {
  			var ajax = $.ajax({
  				type: "GET",
  				url: urlM + "wechatUserManager/logger",
  				dataType: "json",
  				data: {
  					content: "returnWechatLogger" + openId + "====" + t
  				},
  				success: function(data) {
  					console.log("成功");
  				},
  				error: function(jqXHR) {
  					console.log("失败");
  				}
  			});
  		}
  	</script>
  </body>

  </html>