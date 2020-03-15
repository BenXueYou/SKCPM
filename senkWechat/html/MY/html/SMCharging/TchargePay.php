<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<title></title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<meta http-equiv="Access-Control-Allow-Origin" content="">
	<meta http-equiv="content-security-policy">
	<link rel="stylesheet" type="text/css" href="../../CSS/mui.min.css" />
	<style type="text/css">
		.box {
			display: flex;
			justify-content: space-between;
			padding: 10px 20px;
		}

		.content-txt-center {
			/*text-align: center!important;*/
			margin: 5px auto;
			padding: 5px 8px;
		}

		.tips-txt {
			color: dodgerblue;
			font-size: 12px;
			text-indent: 12px;
		}

		.card-title,
		.card-address {
			width: 100%;
			text-align: center;
		}

		.hidden {
			display: none;
		}
	</style>
</head>

<body>
	<header class="mui-bar mui-bar-nav">
		<h1 class="mui-title">设置充电模型</h1>
	</header>
	<div class="mui-content">
		<div class="mui-card">
			<div class="mui-card-header content-txt-center" style="font-size: 18px; ">
				<h4 class="card-title" style=""></h4>
			</div>
			<div class="mui-card-content">
				<div class="box">
					<div class="mui-card-content-left">

					</div>
					<div class="mui-card-content-right">

					</div>
				</div>
				<div class="box dc-box hidden">
					<label class="">直流桩请选择：</label>
					<div class="mui-input-row mui-radio ">
						<label>12V:</label>
						<input name="radio" type="radio" value="12" checked>
					</div>
					<div class="mui-input-row mui-radio ">
						<label>24V:</label>
						<input name="radio" type="radio" value="24" check>
					</div>
				</div>

			</div>
			<div class="mui-card-footer content-txt-center" style="">
				<h6 class="card-address" style="color: gray;font-size: 14px;width: 100%; text-align: center!important;"></h6>
			</div>
			<div id="slider" class="mui-slider">
				<div class="mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
					<a target="0" class="mui-control-item" href="#item1">自动充满</a>
					<a target="1" class="mui-control-item" href="#item2">按电量充</a>
					<a target="2" class="mui-control-item" href="#item3">按时间充</a>
					<a target="3" class="mui-control-item" href="#item4">按金额充</a>
				</div>
				<div id="sliderProgressBar" class="mui-slider-progress-bar mui-col-xs-3"></div>
				<div class="mui-slider-group">
					<div id="item1" class="mui-slider-item mui-control-content mui-active">
						<ul class="mui-table-view">
							<li class="">
								<div class="mui-card">
									<div class="mui-card-content">
										<div class="mui-card-content-inner">
											您的账户余额为：<span id="mode4">0.00</span>元
										</div>
									</div>
								</div>
							</li>
							<li class="tips-txt content-txt-center">系统会根据您账户余额进行结算。余额不足则会自动停止充电</li>
						</ul>

					</div>
					<div id="item2" class="mui-slider-item mui-control-content">
						<ul class="mui-table-view">
							<li class="">
								<div class="mui-card">
									<div class="mui-card-content">
										<div class="mui-card-content-inner">
											<label>充电电量(度)：</label>
											<div class="mui-numbox" data-numbox-min='1'>
												<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>
												<input id="mode1" class="mui-input-numbox" type="number" />
												<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="tips-txt content-txt-center">如电量已充满或者其他意外情而停止充电，导致充电未完成。系统恢复会根据当前充电记录自动结算。</li>
						</ul>
					</div>
					<div id="item3" class="mui-slider-item mui-control-content">

						<ul class="mui-table-view">
							<li class="">
								<div class="mui-card">
									<div class="mui-card-content">
										<div class="mui-card-content-inner">
											<label>时长(分)：</label>
											<div class="mui-numbox" data-numbox-min='10'>
												<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>
												<input id="mode2" class="mui-input-numbox" type="number" />
												<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="tips-txt content-txt-center">如电量已充满或者其他意外情而停止充电，导致充电未完成。系统恢复会根据当前充电记录自动结算。</li>
						</ul>
					</div>
					<div id="item4" class="mui-slider-item mui-control-content">
						<ul class="mui-table-view">
							<li class="">
								<div class="mui-card">
									<div class="mui-card-content">
										<div class="mui-card-content-inner">
											<label>充电金额(元)：</label>
											<div class="mui-numbox" data-numbox-min='1'>
												<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>
												<input id="mode3" class="mui-input-numbox" type="number" />
												<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>
											</div>
											<!--<div class="mui-input-row">-->
										</div>
									</div>
								</div>
							</li>
							<li class="tips-txt content-txt-center" style="">如电量已充满或者其他意外情而停止充电，导致充电未完成。系统恢复会根据当前充电记录自动结算。</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="mui-bar-footer mui-content-padded">
			<button type="button" id="setmode-btn" data-loading-text="订单提交中" class="mui-btn mui-btn-block mui-btn-primary">提交订单</button>
		</div>
	</div>
	<script src="../JS/mui.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="../JS/CONFIG.js"></script>
	<script type="text/javascript" src="../JS/Order.js"></script>
	<script type="text/javascript" src="../JS/Pile.js"></script>
	<script src="../JS/User.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		mui.init();
		plusReady();
		//	默认充电方式为1，按时间充。
		var chargeWay = 0;
		//  直流桩类型默认为0，当直流桩为24V时，则为1
		var dcChargeMode = 0;
		var cptype = 0 //默认交流桩
		var deviceId;
		var openId;

		function plusReady() {
			var user = User.userIsLogin();
			document.getElementById("mode4").innerHTML = user.balance;
			let objStr = getQueryString('obj');
			console.log(objStr);
			let objData = JSON.parse(objStr) || {};
			deviceId = objData.deviceId;
			openId = objData.openId;
			mui(".card-title")[0].innerText = "充电桩：" + objData.cpName;
			mui(".mui-card-content-left")[0].innerText = "桩类型：" + (objData.cpPhase == 1 ? '三相' : '单相') + (objData.cpType == 1 ? '交流' : '直流');
			//alert(objData.cpType);
			if (objData.cpType === 0) {
				mui(".dc-box")[0].classList.remove("hidden");
				cptype = 1;
			} else {
				cptype = 0;
				mui(".dc-box")[0].classList.add("hidden");
			}
			mui(".mui-card-content-right")[0].innerText = "桩费率：" + objData.chargeFee + "元/度";
			mui(".mui-card-footer")[0].innerText = "地址：" + objData.location;
		}
		var cpTyeVolage = 0;
		var dcChargeMode = 0;

		function getCheckRadioValue(name) {
			var rdsObj = document.getElementsByName(name);
			for (var i = 0; i < rdsObj.length; i++) {
				if (rdsObj[i].checked) {
					cpTyeVolage = rdsObj[i].value;
				}
			}
			if (cpTyeVolage == "24") {
				dcChargeMode = 1;
			}
			return dcChargeMode;
		}
		//菜单点击事件
		mui(document.body).on('tap', ".mui-control-item", function() {
			chargeWay = this.target;
		});
		//菜单滑动事件
		document.getElementById('slider').addEventListener('slide', function(e) {
			chargeWay = e.detail.slideNumber;
		});
		mui(document.body).on('tap', '#setmode-btn', function(e) {
			mui(this).button('loading');
			setTimeout(function() {
				mui(this).button('reset');
				var chargeValue = getParams(chargeWay);
				var dcChargeMode = getCheckRadioValue("radio");
				var out_trade_no = CONFIGS.GETOUTTRADENO(deviceId);
				if (chargeValue <= 0) {
					mui.alert("您设置的充电参数有误");
					return
				}
				var user = User.userIsLogin();
				if (user.chargeState) { //判断用户是否登录
					//没有登录
					mui.openWindow('../MY/getPhone.html', 'login.html', {}, 'slide-in-bottom', 200);
					return;
				}
				if (user.balance <= 0) {
					mui.alert("账户余额不足");
					mui.openWindow('../MY/myAccount.php?openId=' + user.cpUserId, 'pay.html', {}, 'slide-in-bottom', 200);
					return;
				}
				var data = {
					"dcChargeMode": dcChargeMode,
					"deviceId": deviceId,
					"endChargeFlag": 0,
					"gun": deviceId.substr(deviceId.length - 2, 2),
					"payMode": chargeWay,
					"payValue": chargeValue,
					"remainSum": user.balance,
					"startChargeFailDesp": "",
					"startChargeFlag": 0,
					"userId": user.userId,
					"cptype": cptype,
					"openId": openId,
					"chargeWay": 0
				};
				Pile.pileStart(CONFIGS.TURLManage().startChargeApi, data, function(e) {
					if (e && e.success) {
						mui.openWindow("Tcharging.php?cpObj=" +
							encodeURIComponent(JSON.stringify(data)), "Tcharging.php", {}, "slide-in-right", 200);
					} else {
						alert(e.errorMessage);
					}
				});
			}.bind(this), 2000);
		});

		function getParams(e) {
			var res = 0;
			switch (e) {
				case 1:
					res = document.getElementById("mode1").value;
					break;
				case 2:
					res = document.getElementById("mode2").value;
					break;
				case 3:
					res = document.getElementById("mode3").value;
					break;
				default:
					res = document.getElementById("mode4").innerHTML;
					break;
			}
			return res;
		}
		//获取参数
		function getQueryString(name) {
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
			var r = window.location.search.substr(1).match(reg);
			if (r != null) return decodeURIComponent(r[2]);
			return null;
		}
	</script>
</body>

</html>
