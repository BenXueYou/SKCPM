/**
 * 演示程序当前的 “注册/登录” 等操作，是基于 “本地存储” 完成的
 * 当您要参考这个演示程序进行相关 app 的开发时，
 * 请注意将相关方法调整成 “基于服务端Service” 的实现。
 **/
(function($, owner) {
	/**
	 * 用户登录
	 **/
	owner.login = function(loginInfo, url, callback) {
		callback = callback || $.noop;
		loginInfo = loginInfo || {};
		loginInfo.account = loginInfo.account || '';
		loginInfo.password = loginInfo.password || '';
		if(loginInfo.account.length < 5) {
			return callback('账号最短为 5 个字符');
		}
		if(loginInfo.password.length < 6) {
			return callback('密码最短为 6 个字符');
		}

		url = url + "userManager/loginUser";
		var data = {
			phone: loginInfo.account,
			password: loginInfo.password
		};
		owner.ajaxMainFun(url, data, true, function(data) {
			console.log("登录结果==" + data);
			
			if(data == "网络通信异常"){
				callback("网络通信异常");
			}else if(data.returnCode == 0) {
				var user = data.detail.userInfo;
				var userInfo = user[0];
				owner.createState(userInfo, callback);
			} else if(data.returnCode == 1) {
				callback(data.message);
			} else if(data == "101") {
				callback(101);
			} else {
				callback("您还未注册账号");
			}
		});

	};

	owner.createState = function(user, callback) {
		var state = owner.getState();
		state.account = user.cpUserId;
		state.token = "token123456789";
		owner.setState(state);
		//删除已经存储的用户信息
		var users = JSON.parse(localStorage.getItem('$users') || '[]');
		users.splice(0, users.length);
		//添加用户信息
		users.push(user);
		localStorage.setItem('$users', JSON.stringify(users));
		return callback();
	};

	/*
	 *第三方登录的注册 
	 * */
	owner.OAuth = function(userInfo,code,pw,url, callback) {
		allback = callback || $.noop;
		userInfo = userInfo || {};
		userInfo.cpUserName = userInfo.cpUserName || '';
		userInfo.cpUserId = userInfo.cpUserId || '';
		url = url + "userManager/weChatLogin";
		var data = {
			openId: userInfo.cpUserId,
			cpUserName: userInfo.cpUserName,
			sex:userInfo.sex,
			phone:userInfo.telephone,
			code:code,
			password:pw
		};
		console.log(userInfo.cpUserId+"password===="+pw);
		owner.ajaxMainFun(url, data, true, function(data) {
			console.log("登录结果==" + JSON.stringify(data));
				if(data == "网络通信异常"){
					callback("网络通信异常");
				}else if(data.returnCode == 0) {
					userInfo.accountSum = 0;
					userInfo = data.detail.userInfo;
					console.log("返回的信息"+JSON.stringify(data));
					owner.createState(userInfo[0], callback);
				}else if(data.returnCode == 1 || 2){
					callback(data.message);
				}else {
					callback("登录失败");
				}
		});
	}
/**
 *  userId = getQueryString("openId");
    userInfo.telephone = phoneBox.value;
    userInfo.cpUserId = userId;
    userInfo.cpUserName = nameBox.value;
    userInfo.CMPId = cmpBox.value;
	userInfo.plateNumber = carNumberBox.value;
	userInfo.password = pw.value;
	userInfo.sex = "男";
	sendAjaxOauth(userInfo, u_code.value, pw.value);
 */
	//企业用户注册
	owner.CMPLogin = function(userInfo,code,pw,url, callback) {
		allback = callback || $.noop;
		userInfo = userInfo || {};
		userInfo.cpUserName = userInfo.cpUserName || '';
		userInfo.cpUserId = userInfo.cpUserId || '';
		url = url + "userManager/weChatLogin";
		var data = {
			openId: userInfo.cpUserId,
			cpUserName: userInfo.cpUserName,
			sex:userInfo.sex,
			phone:userInfo.telephone,
			CMPID:userInfo.CMPID,
			plateNumber:userInfo.plateNumber,
			code:code,
			password:userInfo.password
		};
		console.log(userInfo.cpUserId+"password===="+pw);
		owner.ajaxMainFun(url, data, true, function(data) {
			console.log("登录结果==" + JSON.stringify(data));
				if(data == "网络通信异常"){
					callback("网络通信异常");
				}else if(data.returnCode == 0) {
					userInfo.accountSum = 0;
					userInfo = data.detail.userInfo;
					console.log("返回的信息"+JSON.stringify(data));
					owner.createState(userInfo[0], callback);
				}else if(data.returnCode == 1 || 2){
					callback(data.message);
				}else {
					callback("登录失败");
				}
		});
	}

	/**
	 * 新用户注册
	 **/
	owner.reg = function(regInfo, url, callback) {
		url = url + "userManager/registerUser";
		callback = callback || $.noop;
		regInfo = regInfo || {};
		regInfo.account = regInfo.account || '';
		regInfo.password = regInfo.password || '';
		if(regInfo.account.length < 5) {
			return callback('用户名最短需要 5 个字符');
		}
		if(regInfo.password.length < 6) {
			return callback('密码最短需要 6 个字符');
		}
		mui.ajax(url, {
			data: {
				phone: regInfo.account,
				password: regInfo.password,
				code: regInfo.code
			},
			type: "POST",
			async: false,
			timeout: 10000,
			success: function(data) {
				if(data.returnCode == 0) {
					callback();
				} else {
					callback("验证码错误");
				}
			},
			error: function(xhr, type, error) {
				callback("服务器响应异常");
			}
		});
	};

	/**
	 * 获取当前状态
	 **/
	owner.getState = function() {
		var stateText = localStorage.getItem('$state') || "{}";
		return JSON.parse(stateText);
	};

	/**
	 * 设置当前状态
	 **/
	owner.setState = function(state) {
		state = state || {};
		localStorage.setItem('$state', JSON.stringify(state));
		var settings = owner.getSettings();
		settings.gestures = '';
		owner.setSettings(settings);
	};

	var checkEmail = function(email) {
		email = email || '';
		return(email.length > 3 && email.indexOf('@') > -1);
	};
	var checkPhone = function(email) {
		phone = phone || '';
		return(phone.length > 3 && phone.indexOf('@') > -1);
	};

	/**
	 * 找回密码
	 **/
	owner.forgetPassword = function(url, phone, password, code, callback) {
		console.log(url + "===" + phone + "==" + password + "===" + code);
		var mask = mui.createMask();
		url = url + "userManager/resetPassword";
		mui.ajax(url, {
			data: {
				phone: phone,
				password: password,
				code: code
			},
			type: "GET",
			timeout: 10000,
			beforeSend: function() {
				plus.nativeUI.showWaiting("加载中...", {});
				mask.show(); //显示遮罩层  
			},
			complete: function() {
				plus.nativeUI.closeWaiting();
				mask.close(); //关闭遮罩层 
			},
			success: function(data) {

				console.log(data);
				callback();
			},
			error: function(xhr, type, error) {
				callback("服务器未响应");
			}
		});
	};

	/**
	 * 获取应用本地配置
	 **/
	owner.setSettings = function(settings) {
		settings = settings || {};
		localStorage.setItem('$settings', JSON.stringify(settings));
	}

	/**
	 * 设置应用本地配置
	 **/
	owner.getSettings = function() {
		var settingsText = localStorage.getItem('$settings') || "{}";
		return JSON.parse(settingsText);
	}
	/**
	 * 获取本地是否安装客户端
	 **/
	owner.isInstalled = function(id) {
		if(id === 'qihoo' && mui.os.plus) {
			return true;
		}
		if(mui.os.android) {
			var main = plus.android.runtimeMainActivity();
			var packageManager = main.getPackageManager();
			var PackageManager = plus.android.importClass(packageManager)
			var packageName = {
				"qq": "com.tencent.mobileqq",
				"weixin": "com.tencent.mm",
				"sinaweibo": "com.sina.weibo"
			}
			try {
				return packageManager.getPackageInfo(packageName[id], PackageManager.GET_ACTIVITIES);
			} catch(e) {}
		} else {
			switch(id) {
				case "qq":
					var TencentOAuth = plus.ios.import("TencentOAuth");
					return TencentOAuth.iphoneQQInstalled();
				case "weixin":
					var WXApi = plus.ios.import("WXApi");
					return WXApi.isWXAppInstalled()
				case "sinaweibo":
					var SinaAPI = plus.ios.import("WeiboSDK");
					return SinaAPI.isWeiboAppInstalled()
				default:
					break;
			}
		}
	}
	owner.ajaxMainFun = function(url, data, asyn, callback) {
		var mask = mui.createMask();
		mui.ajax(url, {
			data: data,
			type: "GET",
			timeout: 10000,
			crossDomain:true,
			beforeSend: function() {
//				plus.nativeUI.showWaiting("加载中...", {});
				mask.show(); //显示遮罩层  
			},
			complete: function() {
//				plus.nativeUI.closeWaiting();
				mask.close(); //关闭遮罩层 
			},
			success: function(data) {
				callback(data);
			},
			error: function(xhr, type, error) {
				console.log(type + "==" + error);
				callback("网络通信异常");
			}
		});
	}
}(mui, window.app = {}));