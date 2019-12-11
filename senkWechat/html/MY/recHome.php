<?php
require_once "../../php/jssdk.php";
$appid = "wxe76a06a63e687acb";
$secret = "a594e4f4526e2b61863fc4b059b88a59";
if (!isset($_GET["code"]) &&  $_GET["code"] == "") {
	$APPID = 'wxe76a06a63e687acb';
	$REDIRECT_URI = 'http://sksenk.cn/senkWechat/html/MY/recHome.php';
	$scope = 'snsapi_base';
	//$scope='snsapi_userinfo';//需要授权
	$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $APPID . '&redirect_uri=' . urlencode($REDIRECT_URI) . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect';
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
	//	解析json
	$user_obj = json_decode($res, true);
	//print_r($user_obj);
	$openid = $user_obj['openid'];
	//存入Session中 注意此时SAE中SESSION不可用。
	$_SESSION['user'] = $openid;
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<title>订单记录</title>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="../../CSS/mui.min.css">
	<link href="../../CSS/circle.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../JS/jquery-3.0.0.min.js"></script>
	<style>
		html,
		body {
			background-color: #efeff4;
		}

		.mui-bar~.mui-content .mui-fullscreen {
			top: 44px;
			height: auto;
		}

		.mui-pull-top-tips {
			position: absolute;
			top: -20px;
			left: 50%;
			margin-left: -25px;
			width: 40px;
			height: 40px;
			border-radius: 100%;
			z-index: 1;
		}

		.mui-bar~.mui-pull-top-tips {
			top: 24px;
		}

		.mui-pull-top-wrapper {
			width: 42px;
			height: 42px;
			display: block;
			text-align: center;
			background-color: #efeff4;
			border: 1px solid #ddd;
			border-radius: 25px;
			background-clip: padding-box;
			box-shadow: 0 4px 10px #bbb;
			overflow: hidden;
		}

		.mui-pull-top-tips.mui-transitioning {
			-webkit-transition-duration: 200ms;
			transition-duration: 200ms;
		}

		.mui-pull-top-tips .mui-pull-loading {
			-webkit-backface-visibility: hidden;
			-webkit-transition-duration: 400ms;
			transition-duration: 400ms;
			margin: 0;
		}

		.mui-pull-top-wrapper .mui-icon,
		.mui-pull-top-wrapper .mui-spinner {
			margin-top: 7px;
		}

		.mui-pull-top-wrapper .mui-icon.mui-reverse {
			/*-webkit-transform: rotate(180deg) translateZ(0);*/
		}

		.mui-pull-bottom-tips {
			text-align: center;
			background-color: #efeff4;
			font-size: 15px;
			line-height: 40px;
			color: #777;
		}

		.mui-pull-top-canvas {
			overflow: hidden;
			background-color: #fafafa;
			border-radius: 40px;
			box-shadow: 0 4px 10px #bbb;
			width: 40px;
			height: 40px;
			margin: 0 auto;
		}

		.mui-pull-top-canvas canvas {
			width: 40px;
		}

		.mui-slider-indicator.mui-segmented-control {
			background-color: #efeff4;
		}

		.my-menu-item {
			width: 48% !important;
			padding: 0 !important;
		}

		.onc {
			cursor: pointer;
			margin: 5px 9px;
			box-shadow: 4px 2px 10px #888888bd;
		}

		.hidden {
			display: none;
		}

		#mask {
			position: absolute;
			left: 0px;
			top: -20px;
			width: 100%;
			height: 630px;
			background-color: rgba(80, 80, 80, 0.3);
		}
	</style>
</head>

<body>
	<div class="mui-content">
		<div id="slider" class="mui-slider mui-fullscreen">
			<div id="sliderSegmentedControl" class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
				<div class="">
					<a class="my-menu-item mui-control-item mui-active" href="#item2mobile">
						充电记录
					</a>
					<!-- <a class="mui-control-item my-menu-item " href="#item1mobile">
						支付记录
					</a> -->
				</div>
			</div>
			<div class="mui-slider-group">
				<div id="item2mobile" class="mui-slider-item mui-control-content mui-active">
					<div id="scroll1" class="mui-scroll-wrapper">
						<div class="mui-scroll">
							<ul class="mui-table-view my-left-view">
								<li class="mui-table-view-cell">
									<!--<div class="hidden" id="mask">
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
								        </div>-->
									<!--<marquee direction="left" align="bottom" height="25" width="98%" 
					onmouseout="this.start()" onmouseover="this.stop()" 
					scrollamount="2" style="color:#ff0000;" scrolldelay="1">
					退款已申请，在本界面点击该订单，则可以重新发起退款；退款成功，可能会延迟到账，延迟5小时请联系客服人员。订单的最终状态以微信支付凭证为准。
				    </marquee>-->
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- <div id="item1mobile" class="mui-slider-item mui-control-content">
					<div class="mui-scroll-wrapper">
						<div class="mui-scroll">
							<ul class="mui-table-view my-right-view">
								<li class="mui-table-view-cell">
								</li>
							</ul>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	</div>
	<script src="../../CSS/mui.min.js"></script>
	<script src="./js/mui.pullToRefresh.js"></script>
	<script src="./js/mui.pullToRefresh.material.js"></script>
	<script src="../JS/chargeRecorder.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/CONFIG.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" charset="UTF-8">
		var urlM = CONFIGS.URLManage().getChargeRecordApi;
		var openId = 'safasjfdnsakm2322';
		var openId = '<?php echo $openid; ?>';
		var payRecordArr = new Array();
		var chargeRecordArr = new Array();
		var chargeState = 0,
			totalPages = 1,
			pages = 1;
		mui.init();
		(function($) {
			//阻尼系数
			var deceleration = mui.os.ios ? 0.003 : 0.0009;
			$('.mui-scroll-wrapper').scroll({
				bounce: false,
				indicators: true, //是否显示滚动条
				deceleration: deceleration
			});
			$.ready(function() {
				//循环初始化所有下拉刷新，上拉加载。
				var ul = $('.my-left-view')[0];
				// var ul2 = $('.my-right-view')[0];
				var pages = 1;
				// getPayRecord(urlM, openId, pages, function(dom) {
				// 	if (dom && dom != "null") {
				// 		ul1.appendChild(dom);
				// 	} else {

				// 	}
				// });
				getChargeRecorder(urlM, openId, pages, function(dom) {
					if (dom && dom != "null") {
						ul.appendChild(dom);
					} else {

					}
				});

				$.each(document.querySelectorAll('.mui-slider-group .mui-scroll'), function(index, pullRefreshEl) {
					$(pullRefreshEl).pullToRefresh({
						down: { //下拉刷新
							callback: function() {
								var self = this;
								pages = 1;
								setTimeout(function() {
									var ul = self.element.querySelector('.mui-table-view');
									ul.innerHTML = "";
									// if (!index) {
									getChargeRecorder(urlM, openId, pages, function(dom) {
										if (dom && dom != "null") {
											ul.insertBefore(dom, ul.firstChild);
										}
									});
									// } else {
									// 	getPayRecord(urlM, openId, pages, function(dom) {
									// 		if (dom && dom != "null") {
									// 			ul.insertBefore(dom, ul.firstChild);
									// 		}
									// 	});
									// }
									self.endPullDownToRefresh();
								}, 1000);
							}
						},
						up: { //上拉
							callback: function() {
								var self = this;
								pages++;
								if(totalPages < pages){
									mui.alert('没有更多数据了');
									return
								};
								setTimeout(function() {
									var ul = self.element.querySelector('.mui-table-view');
									// if (!index) {
									getChargeRecorder(urlM, openId, pages, function(dom) {
										if (dom && dom != "null") {
											ul.appendChild(dom, ul.firstChild);
										}
									});
									// } else {
									// getPayRecord(urlM, openId, pages, function(dom) {
									// 	if (dom && dom != "null") {
									// 		ul.appendChild(dom, ul.firstChild);
									// 	}
									// });
									// }
									self.endPullUpToRefresh();
								}, 1000);
							}
						}
					});
				});
			});

			function getPayRecord(urlM, openId, index, callback) {
				var fragment;
				let data = {
					"model": {
						"openId": openId,
					},
					"pageIndex": index,
					"pageSize": 10,
					"queryCount": true,
					"start": 0
				};
				ChargeRecord.getPayRecord(urlM, data, function(data) {
					fragment = document.createDocumentFragment();
					var arr = data;
					var li;
					if (!data) {
						li = document.createElement('li');
						li.innerHTML = "";
						return;
					}
					for (var i = 0; i < data.length; i++) {
						li = document.createElement('li');
						li.className = 'mui-table-view-cell onc';
						li.setAttribute('value', i);
						li.value = i;
						if (arr[i].refundStatus == 0) {
							li.innerHTML = "订&nbsp;&nbsp;单&nbsp;号：" + arr[i].transactionId +
								"<br>支付金额：" + arr[i].payMoney +
								"<br>订单状态：" + "已支付" +
								"<br>支付时间：" + arr[i].payTime;
						} else if (arr[i].refundStatus == 1) {
							arr[i].reunfundMoney = arr[i].reunfundMoney == "null" ? 0 : arr[i].reunfundMoney;
							li.innerHTML = "订&nbsp;&nbsp;单&nbsp;号：" + arr[i].transactionId +
								"<br>支付金额：" + arr[i].payMoney +
								"<br>消费金额：" + (arr[i].payMoney - arr[i].reunfundMoney) +
								"<br>订单状态：" + "已结算" +
								"<br>支付时间：" + arr[i].payTime;
						} else {
							li.innerHTML = "订&nbsp;&nbsp;单&nbsp;号：" + arr[i].transactionId +
								"<br>支付金额：" + arr[i].payMoney +
								"<br>订单状态：" + "结算中（点击重新发起结算）" +
								"<br>支付时间：" + arr[i].payTime;
						}
						fragment.appendChild(li);
					}

					callback(fragment);
				});
			}

			function getChargeRecorder(urlM, openId, index, callback) {
				var fragment;
				let data = {
					"model": {
						"openId": openId,
					},
					"pageIndex": index,
					"pageSize": 10,
					"queryCount": true,
					"start": 0
				};
				ChargeRecord.getChargeRecord(urlM, data, function(data) {
					var chargeRecorder = data.model;
					data = data.model;
					totalPages = data.totalPage;
					fragment = document.createDocumentFragment();
					var li;
					if (!data) {
						li = document.createElement('li');
						li.innerHTML = "";
						return;
					}
					for (var i = 0; i < data.length; i++) {
						li = document.createElement('li');
						li.className = 'mui-table-view-cell onc';
						li.setAttribute('value', i);
						li.value = i;
						var ttt = chargeRecorder[i].timeSpan;
						var tt = ttt / 60;
						li.innerHTML = "流&nbsp;水&nbsp;号:" + chargeRecorder[i].transationId +
							"<br>充&nbsp;&nbsp;电&nbsp;桩：" + chargeRecorder[i].cpId +
							"<br>充电时长(分)：" + tt.toFixed(2) +
							"<br>充电金额(元)：" + chargeRecorder[i].chargeMoney +
							"<br>充电电量(度)：" + chargeRecorder[i].chargeQuantity +
							"<br>开始时间：" + chargeRecorder[i].chargeStartTime;
						fragment.appendChild(li);
					}
					callback(fragment);
				});
			}
		})(mui);
	</script>
</body>

</html>