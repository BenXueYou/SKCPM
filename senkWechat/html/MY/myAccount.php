<?php

error_reporting(E_ERROR | E_PARSE);
header("content-type:text/HTML;charset=utf-8");
require_once "../../php/jssdk.php";
$appid = "wxe76a06a63e687acb";
$secret = "a594e4f4526e2b61863fc4b059b88a59";

if (!isset($_GET["code"]) &&  $_GET["code"] == "") {
	$APPID = 'wx031732af628faee0';
	$REDIRECT_URI = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
	$REDIRECT_URI = urlencode('http://sksenk.cn/senkWechat/html/MY/My_account.php');
	$scope = 'snsapi_base';
	//$scope='snsapi_userinfo';//需要授权
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
}
$jssdk = new JSSDK("wxe76a06a63e687acb", "a594e4f4526e2b61863fc4b059b88a59");
$signPackage = $jssdk->GetSignPackage();

?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<title></title>
	<link rel="icon" href="../../../img/logo.png" type="image/x-icon" />
	<link href="../../CSS/circle.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../JS/jquery-3.0.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../CSS/mui.min.css" />
	<link rel="stylesheet" href="../../CSS/common.css" type="text/css" charset="utf-8" />
	<style type="text/css">
		* {
			padding: 0;
			margin: 0;
		}

		body {
			background-color: #D3D3D3;
			/* background-color:#D8D8D6; */
		}

		.top {
			background-color: white;
			color: black;
			padding: 10px;
			margin-bottom: 15px;
		}

		.topmsg {
			text-align: center;
		}

		.topmsg_desc {
			padding: 0 10%;
		}

		.middle {
			display: none;
			background-color: white;
			color: black;
			margin-bottom: 15px;
			padding: 5px 15px 20px;
		}

		.money button {
			margin: 10px 1%;
			width: 20%;
			height: 30px;
		}

		.middleDetail {}

		#middle_input {
			width: 40vw;
			margin: auto;
			height：30px;
			line-height: 30px;
			font-size: 12px;
			text-align: center;
			-webkit-user-select: auto;
		}

		#pointOut {
			color: #1DB1FF;
			padding: 12px;
			font-size: 12px !important;
		}

		#bottom {
			width: 84%;
			height: 40px;
			padding: 0px;
			margin: 0 8%;
			background-color: #88D1FE;
			font-size: 18px;
			color: rgb(245, 245, 245);
			border: 1px solid deepskyblue;
		}

		.active {
			background: #299DFF;
			color: white;
		}

		.hidden {
			display: none;
		}

		#mask {
			position: absolute;
			left: 0px;
			top: -20px;
			width: 100%;
			height: 600px;
			background-color: rgba(80, 80, 80, 0.3);
		}

		label {
			margin: 0 15%;
		}

		#total {
			-webkit-user-select: text;
			text-align: right;
			padding: 0 1em;
			border: 0px;
			border-bottom: 1px solid #ECB100;
			border-radius: 0;
			font-size: 16px;
			width: 30%;
			outline: none;
		}

		html,
		body,
		div,
		p {
			/*background-color: #efeff4;*/
			background-color: transparent !important;
		}

		.myAccountBg {
			padding: 0.5em 1em;
			text-align: center;
		}

		.account {
			color: #EC7600;
		}

		.paybtn {
			background-color: #EC971F !important;
		}

		.btn {
			border: 1px solid lightgrey;
		}

		.topTitle {
			margin-top: -25px;
			color: orange;
			font-size: 16px;
		}

		#accountSum {
			font-size: 16px;
		}

		#bottom {
			margin-top: 20px;
		}
	</style>
</head>

<body style="background-image: url(../../img/accountBg.jpg);">
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

	<header class="mui-bar mui-bar-nav" style="background-color: transparent;">

		<h1 class="mui-title">我的账户</h1>
		<a class="mui-icon-right-nav mui-pull-right" onclick="listOrder()"><span class="mui-icon mui-icon-bars"></span></a>
	</header>
	<div class="mui-content">
		<div id="dcontent" class="dcontent">
			<div class="myAccountBg">
				<img src="../../img/myAccount.png" style="margin-top:-20px;" />
				<h3 class="account" id="accountSum">
					您当前余额为：0.0
				</h3>
				<hr color="#EEE" style="margin-top:10px;" />
			</div>
			<p style="padding: 0 1em;text-align:left;">

			</p>
			<br />
			<div class="top">
				<p class="topTitle">✅&nbsp;请选择金额</p>
				<div class="money">
					<button class="btn">20元</button>
					<button class="btn">30元</button>
					<button class="btn">50元</button>
					<button class="btn" value="4">自定义</button>
				</div>
			</div>
			<div class="middle">
				<p class="middleTitle">其他金额</p>
				<div class="middleDetail"><input placeholder="请输入金额" id="middle_input" />元</div>
			</div>
			<button id="bottom">确定</button>
			<!--<button id="transfer">余额提现</button>-->

			<script src="../JS/CONFIG.js" type="text/javascript" charset="utf-8"></script>
			<script src="../JS/mui.js" type="text/javascript" charset="utf-8"></script>
			<script type="text/javascript" src="../JS/Order.js"></script>
			<script type="text/javascript" src="../JS/User.js"></script>
			<script type="text/javascript">
				//全局变量
				var index, money;
				var chargeWayIndex = 0;
				var cpid = "";
				var payMode = 4;
				var appid = "wxe76a06a63e687acb";
				var nonceStr;
				var package, signType, paySign, timeStamp, Order, user;
				var chargeState = 0;
				var outTradeNo = 0;
				var dcChargeMode = 0;
				var payState = 0;
				var urlM = CONFIGS.LANCHUANG();
				var openId = '<?php echo $openid; ?>';
				var userid = openId;
				var user = User.userIsLogin();
				User.getUserState(CONFIGS.URLManage().getUserInfoApi, openId, function(user) {
					console.log("-----" + user);
					user = user;
					initHtml();
				});

				function initHtml() {
					try {
						var accountSum = user.balance;
						document.getElementById("accountSum").innerHTML = "余额：" + parseFloat(accountSum).toFixed(2);

					} catch (e) {
						//TODO handle the exception
						document.getElementById("accountSum").innerHTML = "余额：¥ " + "0.00";
					}
				}
				//点击确定按钮发起订单支付流程。
				$("#bottom").click(function() {
					if (chargeWayIndex == 0) { //是否选择自动充满
						if (index == undefined && payState == 0) {
							alert("你还未设置充电金额");
						} else {
							if (index == 3) { //自定义输入
								var inputData = document.getElementById("middle_input").value;
								money = inputData.substring(0, 2);
							} else {
								var x = $(".btn"); //二级菜单对象
								var indexy = index + chargeWayIndex * 4; //二级菜单被选中的标记
								var xhtmlObj = x[indexy]; //二级菜单中携带信息
								var xhtml = xhtmlObj.innerHTML;
								money = xhtml.substring(0, xhtml.length - 1);
							}
							if (isInteger(money) && money != 0 && money != "") {
								//向微信统一下单
								$("#mask").removeClass("hidden");
								if (payState == 0) { //向微信统一下单
									outTradeNo = CONFIGS.GETOUTTRADENO(cpid);
									let orderParams = {
										openId: openId,
										outTradeNo: outTradeNo,
										money: money
									};
									Order.getOrderToWechat(orderParams, function(order) {
										$("#mask").addClass("hidden");
										if (order) {
											if (order == "100" || order == "false") {
												location.href = "getPhone.html?openId=" + openId;
												return;
											} else {
												Order = order;
												sendPay(order);
											}

										} else {
											alert("下单失败");
											console.log("测试版本，暂不支持充值");
										}
									})
								} else if (payState == 10) { //已下单重新支付
									sendPay(Order);
								} else if (payState == 100) {
									getOrderWechatResult(function(e) {
										if (e) {
											mui.back();
										} else {
											$("#mask").addClass("hidden");
											alert("您已取消了支付，请退出重新支付");
										}
									});
								} else {
									alert("请退出重新支付");
								}
							} else {
								alert("支付金额必须大于0且为整数");
							}
						}
					}
				});

				$("#transfer").click(function() {
					if (user.accountSum > 0 && user.accountSum != "") {
						//向微信统一下单
						$("#mask").removeClass("hidden");
						outTradeNo = CONFIGS.GETOUTTRADENO(cpid);
						Order.getUserMoneyFromWechat(CONFIGS.LANCHUANG(), openId, outTradeNo, money, function(order) {
							$("#mask").addClass("hidden");
							if (order) {
								Order = order;
								console.log(order);
							} else {
								console.log("下单失败");
								alert("暂不支持充值");
							}
						})
					}
				});
				//支付
				function sendPay(order) {
					if (typeof WeixinJSBridge == "undefined") {
						if (document.addEventListener) {
							document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
						} else if (document.attachEvent) {
							document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
							document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
						}
					} else {
						onBridgeReady();
					}
				}

				function onBridgeReady() {
					WeixinJSBridge.invoke(
						'getBrandWCPayRequest', {
							"appId": appid, //公众号名称，由商户传入
							"timeStamp": Order.timeStamp, //时间戳，自1970年以来的秒数
							"nonceStr": Order.nonceStr, //随机串
							"package": Order.package,
							"signType": "MD5", //微信签名方式：
							"paySign": Order.paySign //微信签名
						},
						function(res) {
							$("#mask").removeClass("hidden");
							payState = 100;
							if (res.err_msg == "get_brand_wcpay_request:ok") {
								mui.back();
							} else {
								getOrderWechatResult(function(e) {
									if (e) {
										mui.back();
									} else {
										alert("支付失败");
										$("#mask").addClass("hidden");
									}
								});
							}
						}
					);
				}

				$(".middleDetail input").focus(function() {
					index = 3;
					$(".btn").removeClass("active");

				});

				//支付成功返回的结果
				function getOrderWechatResult(callback) {
					var ajax = $.ajax({
						type: "GET",
						url: "wx_pay/WechatPay/getPayOrderRes.php",
						data: {
							out_trade_no: outTradeNo
						},
						success: function(data) {
							//日志传输
							if (data == "1" || data == 1) {
								callback(true);
							} else {
								callback(false);
							}
						},
						error: function(jqXHR) {
							$("#mask").addClass("hidden");
							callback(false);
							alert("订单查询失败,请记住该订单号并联系管理员" + outTradeNo);
							Loggert("checkOrder ajax error tradeNo" + outTradeNo + "=openid=" + openId);
						}
					});
				}
				//点击菜单设置充电方式
				$(".btn").on("click", function() {
					$(this).addClass("active").siblings().removeClass("active");
					var sbtitle = $(".middle");
					if ($(this).index() == "3") {
						if (sbtitle.length) {
							sbtitle.show();
						}
					} else {
						$("#middle_input").attr("value", "");
						sbtitle.hide();
					}
					index = $(this).index();
				});

				//判断是否为整数
				function isInteger(obj) {
					return obj % 1 === 0
				}

				function listOrder() {
					mui.openWindow({
						url: 'My_record.html',
						id: 'My_record',
						preload: true,
						show: {
							aniShow: 'pop-in'
						},
						styles: {
							popGesture: 'hide'
						},
						waiting: {
							autoShow: false
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
							content: "returnWechatLogger" + t
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