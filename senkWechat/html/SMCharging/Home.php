  <?php

	error_reporting(E_ERROR | E_PARSE);
	header("content-type:text/HTML;charset=utf-8");
	require_once "../../php/jssdk.php";
	require_once "../../php/wechatUserInfo.php";
	$appid = "wxe76a06a63e687acb ";
	$secret = "a594e4f4526e2b61863fc4b059b88a59";

	if (!isset($_GET["code"]) &&  $_GET["code"] == "") {
		$APPID = 'wxe76a06a63e687acb';
		/***************************************************************************/
		//echo $_SERVER['HTTP_HOST'];
		$REDIRECT_URI = urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
		print($REDIRECT_URI);
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
  	<button class="scanBtnClass"></button>
  	<p class="middle_input">或<a style="color: blue; text-decoration: underline;" onclick="hrefBtn()">输入桩编号</a></p>
  	<h5 style="width:100%;text-align:center;margn:auto;">扫描桩上的二维码启动充电</h5>
  	<script type="text/javascript" src="../JS/mui.js"></script>
  	<script type="text/javascript" src="../JS/CONFIG.js"></script>
  	<script type="text/javascript" src="../JS/Order.js"></script>
  	<script type="text/javascript" src="../JS/Pile.js"></script>
  	<script type="text/javascript" src="../JS/User.js"></script>
  	<script type="text/javascript">
  		//定义全局变量
  		var openId = '<?php echo $openid; ?>';
  		// var userid = openId = "oR9d21lZxSloF2iQtPHjdRAdy-2o";
  		// var userid = openId = "safasjfdnsakm2322";
  		// var userid = openId = "safasjfdnsakm2322";
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
  			User.getUserState(CONFIGS.URLManage().getUserInfoApi, openId, function(user) {
  				if (user && user.chargeState === 0) {
  					//用户空闲状态可以扫码
  					wxScanAPI();
  				} else if (user && user.chargeState === 1) {
  					//用户已产生订单，获取订单信息，且直接进入充电界面,获取当前桩的信息
  					location.href = 'charging.php?cpObj=' + JSON.stringify(user);
  				} else {
  					location.href = "../MY/getPhone.html?openId=" + openId;
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
  				jsApiList: ["scanQRCode", ] // 所有要调用的 API 都要加到这个列表中     
  			});
  			wx.ready(function() {
  				wx.scanQRCode({
  					needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
  					scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
  					success: function(res) {
  						// 当needResult 为 1 时，扫码返回的结果
  						var result = res.resultStr;
  						//设备号添加两个0
  						getPileBaseInfo(result);
  					}
  				});
  			});
  			wx.error(function(res) {
  				alert("扫码错误" + JSON.stringify(res));
  			});
  		}
  		/**
		   *    "cpId": "4101220000000002",
				"location": "中牟县张家庄镇吕坡村",
				"cpType": 0,
				"cpPhase": 0,
				"cpName": "2#双枪直流桩",
				"rateId": 1,
				"chargeFee": 2
		   */
  		function getPileBaseInfo(deviceId) {
  			Pile.pileState(CONFIGS.URLManage().getCpileStateoApi, deviceId, function(data) {
				debugger;  
				if (data) {
  					console.log(data);
  					data.deviceId = deviceId;
  					data.openId = openId;
  					location.href = "chargePay.php?obj=" + encodeURIComponent(JSON.stringify(data));
  				} else {
  					console.log('请求错误');
  				}
  			});
  		}
  		//输入设备号界面跳转
  		function hrefBtn() {
  			User.getUserState(CONFIGS.URLManage().getUserInfoApi, openId, function(user) {

  				if (user && user.chargeState === 0) {
  					//用户空闲状态可以扫码
  					mui.prompt('输入设备号', '设备号+枪号"0*"', '提示', ["取消", "确定"], function(data) {
  						if (data.index) {
  							deviceId = data.value;
  							// deviceId = "140105000000014300";
  							getPileBaseInfo(deviceId);
  						}
  					}, 'div');
  				} else if (user && user.chargeState === 1) {
  					//用户已产生订单，获取订单信息，且直接进入充电界面,获取当前桩的信息
  					location.href = 'charging.php?cpObj=' + JSON.stringify(user);
  				} else {
  					location.href = "../MY/getPhone.html?openId=" + openId;
  				}
  			});
  		}
  	</script>
  </body>

  </html>