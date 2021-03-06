<!DOCTYPE html>
<html class="ui-page-login">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Access-Control-Allow-Origin" content="">
		<meta http-equiv="content-security-policy">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title></title>
		<link href="../../CSS/mui.min.css" rel="stylesheet" />
		<link href="../../CSS/style.css" rel="stylesheet" />
		<style>
			.area {
				margin: 20px auto 0px auto;
			}
			
			.mui-input-group:first-child {
				margin-top: 20px;
			}
			
			.mui-input-group label {
				width: 28%;
			}
			
			.mui-input-row label~input,
			.mui-input-row label~select,
			.mui-input-row label~textarea {
				width: 72%;
			}
			
			.mui-checkbox input[type=checkbox],
			.mui-radio input[type=radio] {
				top: 6px;
			}
			
			.mui-content-padded {
				margin-top: 25px;
			}
			
			.mui-btn {
				padding: 10px;
			}
			
			.mui-input-row label~input,
			.mui-input-row label~select,
			.mui-input-row label~textarea {
				margin-top: 1px;
			}
			
			#u_code {
				width: 40%;
				float: left;
			}
			
			#get_code {
				float: left;
				margin: 8px 3px;
				background-color: transparent;
				/*background-color: red;*/
			}
			
			.hidden {
				display: none;
			}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">企业员工注册</h1>
		</header>
		<div class="mui-content">
			<form class="mui-input-group">

                <div class="mui-input-row">
					<label>企业</label>
					<input id='cmpNumber' type="text" class="mui-input-clear mui-input" placeholder="请输入企业编号">
                </div>

                <div class="mui-input-row">
					<label>姓名</label>
					<input id='name' type="text" class="mui-input-clear mui-input" placeholder="请输入您的姓名">
				</div>

				<div class="mui-input-row">
					<label>手机</label>
					<input id='phone' type="text" class="mui-input-clear mui-input" placeholder="请输入手机号">
				</div>

				<div class="mui-input-row">
					<label class="iconfont_log_reg icon-youjian">验证码</label>
					<input type="text" placeholder="短信验证码" id="u_code">
					<a id="get_code" disabled="true">获取验证码</a>
				</div>
				<div class="mui-input-row">
					<label>车牌</label>
					<input id='carNumber' type="text" class="mui-input-clear mui-input" placeholder="请输入车牌号">
				</div>

				<div class="mui-input-row pwd">
					<label>密码</label>
					<input id='password' type="password" class="mui-input-clear mui-input" placeholder="请输入密码">
				</div>
				<div class="mui-input-row pwd">
					<label>确认</label>
					<input id='password_confirm' type="password" class="mui-input-clear mui-input" placeholder="请确认密码">
				</div>

			</form>
			<div class="mui-content-padded">
				<button id='sendBtn' class="mui-btn mui-btn-block mui-btn-primary">提交</button>
			</div>
		</div>
		<script src="../JS/mui.js" type="text/javascript" charset="utf-8"></script>
		<script src="../JS/CONFIG.js" type="text/javascript" charset="utf-8"></script>
		<script src="../JS/app.js"></script>
		<script>
          //截取url参数的函数
			function getQueryString(name) {
				var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
				var r = window.location.search.substr(1).match(reg);
				if(r != null) return unescape(r[2]);
				return null;
			}
			var issend = true;
			var userId = getQueryString("openId"),
				txtId = false,
				codeFlag = 1;
            console.log("userId"+userId);
			(function($, doc) {
				$.init();
				txtId = "oauthLogin";
				userId = getQueryString("openId");
				
				var sendButton = doc.getElementById('sendBtn');
				var phoneBox = doc.getElementById('phone');
				var pw = doc.getElementById('password');
				var pw_confirm = doc.getElementById('password_confirm');
				var u_code = doc.getElementById("u_code");
                var cmpBox = doc.getElementById("cmpNumber");
                var nameBox = doc.getElementById("name");
				var carNumberBox = doc.getElementById("carNumber");
				var passwordConfirm = pw_confirm.value;
				sendButton.addEventListener('click', function() {
					if(cmpBox.value == '') {
						mui.toast('企业号不能为空');
						return;
					}
                    if(passwordConfirm != pw.value) {
						mui.toast('两次输入的密码不一致');
						return;
					}
                    if(phoneBox.value == '') {
						mui.toast('手机号不能为空');
						return;
					}
					if(pw.value == '') {
						plus.nativeUI.toast('密码不能为空');
						return;
					}
					if(u_code.value == '') {
						mui.toast('验证码不能为空');
						return;
					}
						var userInfo = new Object();
                        userId = getQueryString("openId");
						userInfo.telephone = phoneBox.value;
						userInfo.cpUserId = userId;
						userInfo.cpUserName = nameBox.value;
						userInfo.CMPId = cmpBox.value;
						userInfo.plateNumber = carNumberBox.value;
						userInfo.password = pw.value;
						userInfo.sex = "男";
						sendAjaxOauth(userInfo, u_code.value, pw.value);
				}, false);
				var get_codeBtn = doc.getElementById("get_code");
				get_codeBtn.addEventListener('tap', function(event) {
					console.log("点击获取验证码");
					var t = 60;
					if(issend) {
						//验证电话号码手机号码 
						var phoneObj = doc.getElementById('phone');
						var get_code = document.getElementById('get_code');
						var passwordConfirm = pw_confirm.value;
						if(phoneObj.value != "") {
							var phoneVal = phoneObj.value;
							var p1 = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
							var me = false;
							if(p1.test(phoneVal)) me = true;
							if(!me) {
								phoneObj.value = '';
								mui.toast('请输入正确的手机号码');
								phoneObj.focus();
								return false;
							} else if(pw.length < 6) {
								mui.toast('密码长度不够6');
								return false;
							} else {
								url = CONFIGS.LANCHUANG() + "userManager/repasswordByCode";
								mui.ajax(url, {
									data: {
										phone: phoneObj.value,
										codeFlag: codeFlag
									},
									dataType: "text",
									type: "POST",
									success: function(data) {
										data = JSON.parse(data);
										console.log(data.returnCode + "==" + codeFlag + "====" + JSON.stringify(data));
										if(data.returnCode == '1') {
											mui.toast('用户已存在！', {
												verticalAlign: 'center'
											});

											return false;
										}
										if(data.returnCode == '0') {
											mui.toast('验证码发送成功！', {
												verticalAlign: 'center'
											});
										} else {
											mui.toast('验证码发送失败！', {
												verticalAlign: 'center'
											});
										}
										for(i = 1; i <= t; i++) {
											window.setTimeout("update_a(" + i + "," + t + ")", i * 1000);
										}
									},
									error: function(error) {
										mui.toast('网络通信故障！', {
											verticalAlign: 'center'
										});
										return false;
									}
								});
							}
						} else {
							mui.toast('手机号码不能为空！', {
								verticalAlign: 'center'
							});
							return false;
						}
					}
				});

			}(mui, document));
			//电话号码登记
			function sendAjaxOauth(userInfo, code, pw) {
				app.CMPLogin(userInfo, code, pw, CONFIGS.LANCHUANG(), function(err) {
					if(err) { //登录失败
						mui.toast(err);
						return;
					} else { //登录成功，则关闭当前页面
						mui.back();
					}
				});
			}
			//验证码倒计时
			function update_a(num, t) {
				var get_code = document.getElementById('get_code');
				if(num == t) {
					get_code.innerHTML = "重新发送";
					issend = true;
				} else {
					var printnr = t - num;
					get_code.innerHTML = printnr + "秒后重发";
				}
			}
			
		</script>
	</body>

</html>