<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>充电完成</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<link rel="stylesheet" type="text/css" href="../../CSS/mui.min.css" />
	<link rel="stylesheet" type="text/css" href="../../CSS/chargeFinish.css" />
	<script src="../JS/CONFIG.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<header class="mui-bar mui-bar-nav">
		<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		<h1 class="mui-title">充电结束</h1>
	</header>
	<div class="mui-content" style="background-color: white;">
		<div id="top">
			<div id="label">
				<div class="text"><span>充电完成</span></div>
			</div>
		</div>
		<div id="mid">
			<div class="ch"><span>账单编号：</span><span class="value" id="bill" style="font-size:14px">----</span></div>
			<div class="ch"><span>消费金额：</span><span class="value" id="money">0.00</span><span class="ch_span">元</span></div>
			<div class="ch"><span>充电时长：</span><span class="value" id="time">0</span><span class="ch_span">分钟</span></div>
			<div class="ch"><span>充电电量：</span><span class="value" id="quantity">0.0</span><span class="ch_span">度</span></div>
			<div class="ch"><span>基础电费：</span><span class="value" id="chargeMoney">0.00</span><span class="ch_span">元</span></div>
			<div class="ch"><span>服务用费：</span><span class="value" id="refund_fee">0.00</span><span class="ch_span">元</span></div>
			<div class="ch"><span>开始时间：</span><span class="value" id="date" style="font-size:14px;">--.--.-- --:--:--</span></div>
			<div class="ch box"><span>综合评价：</span><span class="value" id="chargeMoney">
					<div class="icons mui-inline" style="margin-left: 6px;">
						<i data-index="1" class="mui-icon mui-icon-star-filled"></i>
						<i data-index="2" class="mui-icon mui-icon-star-filled"></i>
						<i data-index="3" class="mui-icon mui-icon-star-filled"></i>
						<i data-index="4" class="mui-icon mui-icon-star-filled"></i>
						<i data-index="5" class="mui-icon mui-icon-star-filled"></i>
					</div>
				</span><span class="ch_span"></span>
			</div>
		</div>

		<div id="upload" style="hidden">
			<button id="botBtn" onclick="stepfun()">提交</button>
		</div>
	</div>
	<script src="../JS/mui.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/Order.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/Pile.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/User.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/My.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript">
		mui.init({
			swipeBack: true
		});

		var starIndex = 5,
			serialNo = getQueryString("serialNo");
			plusReady();
		

		function getQueryString(name) {
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
			var r = window.location.search.substr(1).match(reg);
			if (r != null) return unescape(r[2]);
			return null;
		}
		
		mui(document).on('tap', 'i', function() {
			var index = parseInt(this.getAttribute("data-index"));
			console.log("starIndex==" + index);
			var parent = this.parentNode;
			var children = parent.children;
			if (this.classList.contains("mui-icon-star")) {
				for (var i = 0; i < index; i++) {
					children[i].classList.remove('mui-icon-star');
					children[i].classList.add('mui-icon-star-filled');
				}
			} else {
				for (var i = index; i < 5; i++) {
					children[i].classList.add('mui-icon-star')
					children[i].classList.remove('mui-icon-star-filled')
				}
			}
			starIndex = index;
		});

		function plusReady() {
			var user = User.userIsLogin();
			var userid = user.userId;
			User.getUserChargeData(CONFIGS.URLManage().getOrderBySerialNoApi, userid, serialNo, function(e) {
				var dataInfo = e;
				serialNo = dataInfo.transationId;
				document.getElementById("bill").innerHTML = serialNo || 0;
				document.getElementById("money").innerHTML = dataInfo.totalfee || 0;
				document.getElementById("quantity").innerHTML = dataInfo.chargeQuantity || 0;
				var chargeMoney = dataInfo.chargeMoney;
				document.getElementById("chargeMoney").innerHTML = dataInfo.chargeMoney || 0;
				document.getElementById("date").innerHTML = dataInfo.chargeStartTime || 0;
				document.getElementById("refund_fee").innerHTML = dataInfo.serviceTip || 0;
				document.getElementById("time").innerHTML = dataInfo.chargeTimeSpan || 0;
			});
		}
		//获取传参数

		function stepfun() {
			//				serialNo = "123456789000";
			console.log("评价等级==" + starIndex + "=流水号==" + serialNo);
			My.MyEvaluationFun(CONFIGS.LANCHUANG(), serialNo, starIndex, function(e) {
				if (e) {
					console.log("提交成功");
					WeixinJSBridge.call('closeWindow');
				} else {
					console.log("提交失败");
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