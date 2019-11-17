<?php
// require_once "../../php/jssdk.php";
// $jssdk = new JSSDK("wx031732af628faee0", "5e8ccf52a81d427752241374212af303");
// $signPackage = $jssdk->GetSignPackage();
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<title></title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<link rel="stylesheet" type="text/css" href="../../CSS/mui.min.css" />
	<link rel="stylesheet" type="text/css" href="../../CSS/charge.css" />
	<link href="../../CSS/circle.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.hidden {
			display: none;
		}
	</style>
</head>

<body style="background-color: rgba(0,0,0,1);">
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
	<header class="mui-bar mui-bar-nav">
		<h1 class="mui-title">充电监控</h1>
		<a class="txt mui-icon mui-pull-right" onclick="userChange()">强制退出</a>
	</header>
	<div class="mui-content">
		<div class="">
			<div class="canvas-wrap">
				<canvas class="divs" id="myCanvas" width="300" height="150" style="">您的浏览器不支持canvas！</canvas>
				<span id="MSG" onclick="actiondo()">开始充电</span>
			</div>
			<script src="../JS/jquery-3.0.0.min.js" type="text/javascript" charset="utf-8"></script>
			<script>
				var canvas = document.getElementById('myCanvas'),
					width = canvas.width,
					height = canvas.height,
					ctx = canvas.getContext('2d');
				ctx1 = canvas.getContext('2d');
				var step, startAngle, endAngle, add = Math.PI * 2 / 100;
				ctx.shadowOffsetX = 0; // 设置水平位移
				ctx.shadowOffsetY = 0; // 设置垂直位移
				ctx.shadowBlur = 10; // 设置模糊度
				ctx.lineWidth = 3.0;
				ctx1.shadowOffsetX = 0; // 设置水平位移
				ctx1.shadowOffsetY = 0; // 设置垂直位移
				ctx1.shadowBlur = 10; // 设置模糊度
				ctx1.lineWidth = 3.0;
				counterClockwise = false;
				var x;
				var y;
				var radius;
				var animation_interval = 20,
					n = 50;
				var varName, tempEndAngle, tempAngle = Math.PI;;

				function actiondo(on_off) {
					if (on_off == false) {
						clearInterval(varName);
						varName = null;
						step = 1;
						startAngle = Math.PI;
						endAngle = 0;
						tempAngle = Math.PI;
						tempEndAngle = 0;
						ctx.clearRect(0, 0, 300, 300);
						ctx1.clearRect(300, 300, 0, 0);
						return;
					}
					step = 1;
					startAngle = Math.PI;
					ctx.strokeStyle = '#299DFF'; //圆圈颜色
					//ctx1.strokeStyle = '#299DFF'; //圆圈颜色         
					//ctx.shadowColor = '#' + ('00000' + (Math.random() * 0x1000000 << 0).toString(16)).slice(-6); //设置阴影颜色
					//ctx1.shadowColor = '#' + ('00000' + (Math.random() * 0x1000000 << 0).toString(16)).slice(-6); //设置阴影颜色

					//圆心位置
					x = Math.floor(150);
					y = Math.floor(150);
					radius = Math.floor(150.0);
					varName = setInterval(function() {
						if (step <= n) {
							endAngle = startAngle + add;
							tempEndAngle = tempAngle - add;
							ctx.beginPath();
							ctx1.beginPath();
							ctx.arc(x, y, radius, startAngle, endAngle, counterClockwise);
							//startAngle = endAngle;
							ctx.arc(Math.floor(150), Math.floor(150), Math.floor(120.0), endAngle, startAngle, counterClockwise);
							//ctx1.arc(Math.floor(150), Math.floor(150), Math.floor(100.0),tempAngle,tempEndAngle,counterClockwise);;
							ctx.lineWidth = 3.0;
							ctx.stroke();
							ctx1.stroke();
							startAngle = endAngle;
							tempAngle = tempEndAngle;
							step++;
						} else {
							varName = null;
							step = 1;
							startAngle = Math.PI;
							endAngle = 0;
							ctx.clearRect(0, 0, 300, 300);
							ctx1.clearRect(300, 300, 0, 0);

						}
					}, 100);
				}
			</script>
			<div id="mid">
				<div style="overflow: hidden;">
					<div class="mid_top_right" style="margin:0px 30px; text-align:left;" id="cpid">充电桩编号：----</div>
					<div class="mid_top_left" style="">
						<span class="ch">充电单价(元/度)：</span>
						<span class="ch" id="price">0.00</span>
					</div>
					<div class="mid_top_left" style=" ">
						<span class="ch">充电计时(分)：</span>
						<span class="ch" id="time">0.00</span>
					</div>
					<div class="mid_top_left" style="">
						<span class="ch">计费金额(元)：</span>
						<span class="ch" id="fee">0.00</span>
					</div>
					<div class="mid_top_left" style="">
						<span class="ch">已充电量(度)：</span>
						<span class="ch" id="quantity">0.00</span>
					</div>
				</div>
				<div style="overflow:hidden">
					<div class="l mid_top_left">
						<div id="" class="cptype" style="visibility: hidden;">电压(伏)：</div>
						<div id="" class="">电压(伏)：</div>
						<div id="">电流(安)：</div>
					</div>
					<div class="m">
						<div id="" class="cptype">A相</div>
						<div id="V">0.00</div>
						<div id="A">0.00</div>
					</div>
					<div class="r cptype">
						<div id="">B相</div>
						<div id="V1">0.00</div>
						<div id="A1">0.00</div>
					</div>
					<div class="rc cptype">
						<div id="">C相</div>
						<div id="V2">0.00</div>
						<div id="A2">0.00</div>
					</div>
				</div>
				<div class="mid_top_left" style=" text-align:left;">
					<span class="mid_top_right">当前时间：</span>
					<span class="mid_top_right" id="date">--.--.-- --:--</span>
				</div>
			</div>
			<div id="bot">
				<button id="chargeSwitch" onclick="chargeSwitch()">开始充电</button>
				<button id="refreshBtn" onclick="getChargeData();">刷新</button>
			</div>
		</div>
	</div>
	<script src="../JS/mui.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/CONFIG.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/Order.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/Pile.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/User.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		mui.init();
		//获取参数
		function getQueryString(name) {
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
			var r = window.location.search.substr(1).match(reg);
			if (r != null) return decodeURIComponent(r[2]);
			return null;
		}
		var user = User.userIsLogin();
		var userid = user.userId;
		var flag = null;
		var flagCount = 0;
		var t, deviceId, cptype = 0;
		let objStr = getQueryString("cpObj");
		let objData = JSON.parse(objStr);
		console.log(objData);
		deviceId = objData.deviceId;
		document.getElementById("cpid").innerHTML = "充电桩：" + deviceId;
		cptype = objData.cptype;
		if (!cptype) { //直流桩
			console.log("直流桩");
			var tmp = mui(".cptype");
			for (var i = 0; i < tmp.length; i++) {
				tmp[i].classList.add("hidden");
			}
		} else { //交流桩
			console.log("这是交流桩");
		}
		plusReady();

		function plusReady() {
			var user = User.userIsLogin();
			var openId = user.openId;
			User.getUserState(CONFIGS.URLManage().getUserInfoApi, openId, function(user) {
				if (user.chargeState === 0) {
					//用户空闲状态可以扫码
					flag = false;
				} else if (user.chargeState === 1) {
					//开启动画，开始刷新数据
					flag = true;
					actiondo(true);
					getChargeData();
					getData();
					document.getElementById("chargeSwitch").innerHTML = "结束充电";
					document.getElementById("MSG").innerHTML = "正在充电";
				} else {
					alert('无法使用');
				}
			});
		}

		function chargeSwitch() {
			flag = !flag;
			if (flag) {
				$("#mask").removeClass("hidden");
				$("#chargeSwitch").addClass("disabled");
				Pile.pileStart(CONFIGS.URLManage().startChargeApi, userid, deviceId, function(res) {
					$("#mask").addClass("hidden");
					$("#chargeSwitch").removeClass("disabled");
					if (e) {
						//开始充电且启动成功
						actiondo(true);
						getData();
						document.getElementById("chargeSwitch").innerHTML = "结束充电";
						document.getElementById("MSG").innerHTML = "正在充电";
					} else {
						console.log("启动枪失败");
						flag = !flag; //启动失败，标记位回位
					}
				});
			} else {
				mui.confirm("是否结束本次充电", "您点击了停止充电", ["否", "是"], function(e) {
					if (e.index == "0") {
						flag = !flag;
						return;
					} //点击了否
					$("#mask").removeClass("hidden");
					$("#chargeSwitch").addClass("disabled");
					var user = User.userIsLogin();
					var userid = user.userId;
					Pile.pileStop(CONFIGS.URLManage().stopChargeApi, userid, function(res) {
						console.log(res);
						$("#mask").addClass("hidden");
						$("#chargeSwitch").removeClass("disabled");
						if (res) {
							actiondo(false);
							document.getElementById("chargeSwitch").innerHTML = "开始充电";
							document.getElementById("MSG").innerHTML = "开始充电";
							//获取流水号
							Pile.getSerialNo(CONFIGS.URLManage().getSerialNoApi, user.userId, function(res) {
								if (res) {
									location.href = "finishCharge.php?serialNo=" + res;
								} else {
									alert("获取流水号失败");
									WeixinJSBridge.call('closeWindow');
								}
							});
						} else {
							flag = !flag; //停止失败/没有获取到流水号，标记位回位
							flagCount++;
							if (flagCount > 2) {
								userChange();
							} else {
								alert("停止失败");
							}
						}
					});
				}, "div");
			}
		}
		//定时器事件
		function getData() {
			console.log("启动定时器");
			clearTimeout(t); //先清除之前的定时器，再重新初始化开启
			t = setInterval(function() {
				if (flag) {
					getChargeData();
				} else {
					//清除定时器
					clearTimeout(t);
					console.log("清除定时器");
				}
			}, 10000);
		}
		//获取实时数据
		function getChargeData() {
			User.getPileChargeData(CONFIGS.URLManage().getRealTimeData, user.userId, function(DataInfo) {
				if (DataInfo) {
					document.getElementById("V").innerHTML = DataInfo.voltageA;
					document.getElementById("V1").innerHTML = DataInfo.voltageB;
					document.getElementById("V2").innerHTML = DataInfo.voltageC;
					document.getElementById("A").innerHTML = DataInfo.currentA;
					document.getElementById("A1").innerHTML = DataInfo.currentB;
					document.getElementById("A2").innerHTML = DataInfo.currentC;
					document.getElementById("fee").innerHTML = DataInfo.fee;
					document.getElementById("time").innerHTML = DataInfo.chargeDuration;
					document.getElementById("quantity").innerHTML = DataInfo.quantity;
					document.getElementById("price").innerHTML = DataInfo.price;
					document.getElementById("date").innerHTML = DataInfo.dateTime;
					if (!deviceId) {
						deviceId = DataInfo.deviceId;
						document.getElementById("cpid").innerHTML = "充电桩：" + deviceId;
					}

				}
			});
		}
		//强制退出事件
		function userChange() {
			User.UserChange(CONFIGS.LANCHUANG(), userid, function(e) {
				if (e) {
					WeixinJSBridge.call('closeWindow');
				}
			});
		}
		if (typeof window.addEventListener != "undefined") {
			window.addEventListener("popstate", function(e) {

				mui.confirm("", "是否退出", ["否", "是"], function(e) {
					if (e.index == "1") {
						WeixinJSBridge.call('closeWindow');
					}
				});

			}, false);
		} else {
			window.attachEvent("popstate", function(e) {
				mui.confirm("", "是否退出", ["否", "是"], function(e) {
					if (e.index == "1") {
						WeixinJSBridge.call('closeWindow');
					}
				});
			});
		}
		pushHistory();

		function pushHistory() {
			var state = {
				title: "title",
				url: "#"
			};
			window.history.pushState(state, "title", "#");
		}
	</script>
</body>

</html>