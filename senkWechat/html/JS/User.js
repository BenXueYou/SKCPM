var User = {
	//企业用户注册
	CmpEmpRegist:function(url,cmpId,openId,phone,name,phoneCode,psw,signId){
		var mask = mui.createMask();
		url = url + "";
		var postData = {
			COMPANYID:cmpId,
			openId:openId,
			phone:phone,
			name:name,
			phoneCode:phoneCode,
			psw:psw,
			signId:""
		};
		ajaxBase(url,false,postData,function(returnData){
			if (returnData) {

			} else {
				callback(fasle);
			}
		});
	},
	//判断用户当前状态
	UserState: function(url, userid, callback) {
		var mask = mui.createMask();
		url = url + "userManager/loadProfile";
		var postData = {
			userId: userid,
			signId:""
		};
		ajaxBase(url, false, postData, function(data) {
			console.log("用户状态：" + userid + "====" + JSON.stringify(data));
			if(!data) {
				callback(false);
				return;
			}
			if(data == null) {
				callback(99);
			}
			if(data.returnCode == 0) {
				var userInfo = data.detail.userInfo;
				var user = userInfo[0];
				console.log(user.chargeState);
				var users = JSON.parse(localStorage.getItem('$users') || '[]');
				users.splice(0, users.length);
				user.cpUserId = (user.cpUserId==null) || (user.cpUserId=="null")? userid:user.cpUserId;
				users.push(user);
				localStorage.setItem('$users', JSON.stringify(users));
				callback(user.chargeState);
			} else if(data.returnCode == 1) {
				callback(201);
			} else {
				callback(99);
			}
		});
	},
	//改变用户状态，取消用户标记
	UserChange: function(url, userid, callback) {
		var mask = mui.createMask();
		url = url + "scanCharge/resetUser";
		var result = "0";
		var postData = {
			userId: userid,
		};
		ajaxBase(url, false, postData, function(data) {
			if(data) {
				try {
					data = JSON.parse(data);
				} catch(data) {
					//TODO handle the exception
				}
				if(data.returnCode == 0) {
					callback(true);
				} else {
					alert("取消订单异常");
					callback(false);
				}
			} else {
				callback(false);
			}
		});
	},

	getPileChargeData: function(url, userid, callback) {
		var mask = mui.createMask();
		url = url + "/scanCharge/getChargeStatus";
		window.chargeData = false;
		var data = {
			userId: userid
		};
		ajaxBase(url, false, data, function(data) {
			console.log(userid + "====获取刷新的数据" + JSON.stringify(data));
			if(data) {
				var detail = data.detail;
				var chargeInfo = detail.chargeInfo;
				if(data.returnCode == 0) {
					var dataInfo = chargeInfo[0];
					var DataObj = new Object();
					DataObj.finish = dataInfo.command;
					if(dataInfo.voltageA == '0') { //电压都为零，桩离线
						mui.confirm("是否退出，强制退出则取消对本次充电的监控，同时可重新扫码开启", "检测到桩离线", ["是", "否"],
							function(e) {
								DataObj.on_off = e.index;
								DataObj.va = 0;
								DataObj.vb = 0;
								DataObj.vc = 0;
								DataObj.aa = 0;
								DataObj.ab = 0;
								DataObj.ac = 0;
								DataObj.chargeDuration = 0;
								DataObj.quantity = 0;
								DataObj.price = 0;
								DataObj.fee = 0;
								DataObj.dateTime = "----.--.-- --:--";
								console.log("检测到离线===" + DataObj.on_off);
								callback(DataObj);
							}, "div");

					} else { //检测到离线
						DataObj.on_off = true;
						//未检测到离线
						if(DataObj.finish == "finish") {
							//检测到充电结束
							DataObj.serialNo = dataInfo.serialNo;
							location.href = "chargeFinish.html?serialNo=" + DataObj.serialNo;
						} else {
							//检测到充电未结束
							DataObj.va = dataInfo.voltageA || 0;
							DataObj.vb = dataInfo.voltageB || 0;
							DataObj.vc = dataInfo.voltageC || 0;
							DataObj.aa = dataInfo.currentA || 0;
							DataObj.ab = dataInfo.currentB || 0;
							DataObj.ac = dataInfo.currentC || 0;
							DataObj.chargeDuration = dataInfo.chargeDuration || 0;
							DataObj.quantity = dataInfo.quantity || 0;
							DataObj.price = dataInfo.price || 0;
							DataObj.fee = dataInfo.fee || 0;
							DataObj.dateTime = getDateString() || 0;
						}
						callback(DataObj);
					}
				} else if(data.returnCode == 1) {
					plus.nativeUI.toast("数据未更新", {
						'verticalAlign': 'center'
					});
					callback(false);
					return;
				} else if(data.returnCode == 2) {
					//					plus.nativeUI.toast("您登录的账号异常");
					plus.nativeUI.toast("您登录的账号异常", {
						'verticalAlign': 'center'
					});
					callback(false);
					return;
				} else if(data.returnCode = 13) {
					plus.nativeUI.toast("充电桩设备号有误", {
						'verticalAlign': 'center'
					});
					callback(false);
					return;
				} else {
					plus.nativeUI.toast("充电桩通信数据异常", {
						'verticalAlign': 'center'
					});
					callback(false);
					return;
				}
			} else {
				callback(false);
			}
		});
	},

	userIsLogin: function() {
		//plus.storage.setItem('user', 'oR9d21lZxSloF2iQtPHjdRAdy-2o');//本地存储登录用户信息
		//var user = plus.storage.getItem('user'); //获取本地存储的登录用户信息
		var user = localStorage.getItem('$users') || "{}";
		if(user != "" && user != null && user != "null") {
			var userInfo = JSON.parse(user)[0];
          //  alert(JSON.stringify(userInfo));
			return userInfo;
		} else {
			return false;
		}
	},
	//获取用户本次充电账单结算信息
	getUserChargeData: function(url, userid, serialNo, callback) {
		window.res = false;
		var mydate = new Date();
		url = url + "/scanCharge/chargeRecorder";
		var postData = {
			userid: userid,
			serialNo: serialNo
		};
		ajaxBase(url, false, postData, function(data) {
			if(!data) {
				callback(false);
				return;
			}
			if(data.returnCode == 0) {
				var dto = data.dto;
				var dataInfo = dto;
				dataInfo.cpId = dto.cpId;
				dataInfo.chargeStartTime = dto.chargeStartTime;
				dataInfo.chargeTimeSpan = dto.chargeTimeSpan;
				dataInfo.chargeQuantity = dto.chargeQuantity;
				dataInfo.chargeMoney = dto.chargeMoney;
				dataInfo.transationId = dto.transationId;
				dataInfo.totalfee = dto.totalFee;
				dataInfo.serviceTip = dto.serviceTip;
				var chargeMoney = parseFloat(dataInfo.chargeMoney) + parseFloat(dataInfo.serviceTip);
				var refund = parseFloat(dataInfo.totalfee) - chargeMoney;
				if(parseFloat(refund) > 0) {
					dataInfo.refund = refund.toFixed(2);
				} else {
					dataInfo.refund = 0;
				}
				var chargeTimeSpan = dataInfo.chargeTimeSpan;
				if(chargeTimeSpan > 60) {
					var min = chargeTimeSpan / 60;
					var h = 0;
					if(min > 60) {
						min = min % 60;
						h = min / 60;
						h = h.toFixed(0);
					}
					var s = chargeTimeSpan % 60;
					var ts = min + h * 60;
					var t = ts.toFixed(0);
					dataInfo.chargeTimeSpan = t;
				} else {
					var t = chargeTimeSpan / 60;
					t = t.toFixed(0);
					dataInfo.chargeTimeSpan = t;
				}
				window.res = dataInfo;
				callback(dataInfo);
			} else if(data.returnCode == 1) {
				alert("充电桩超时，订单将会以充电记录的形式出现");
				callback(false);
			} else {
				callback(false);
			}
		});
	},
	UploadUserMsg: function(url, user, callback) {
		var mask = mui.createMask();
		url = url + "userManager/updateProfile",
			data = {
				name: user.cpUserName,
				IdentificationCode: user.vin,
				sex: user.sex,
				codeMode: "Android",
				userId: user.cpUserId,
				plateNumber: user.platform
			};
		//上传基本信息
		ajaxBase(url, true, data, function(e) {
			var data = e;
			//			console.log("修改个人资料：" + user.cpUserId + "====" + JSON.stringify(e));
			if(data == null) {
				callback(100);
			}
			if(data.returnCode == 0) { //修改成功
				var users = JSON.parse(localStorage.getItem('$users') || '[]');
				users.splice(0, users.length);
				users.push(user);
				localStorage.setItem('$users', JSON.stringify(users));
				callback(true);
			} else {
				callback(false);
			}
		});
		//上传头像
		uploaderHeadImg(user.headImgurl, user.cpUserId);

	}

}
var files = [];
var index = 1;
var newUrlAfterCompress;

function uploaderHeadImg(fileSrc, userId) {
	//	fileSrc = "file://"+fileSrc;
	console.log("图片路径=" + fileSrc);
	var dstname = "_downloads/" + getUid() + ".jpg"; //设置压缩后图片的路径  
	plus.zip.compressImage({
			src: fileSrc,
			dst: dstname,
			overwrite: true,
			quality: 20
		},
		function(event) {
			console.log("Compress success:" + event.target);
			appendFile(dstname); //添加图片
			var urlStr = CONFIGS.LANCHUANG() + "userManager/uploadPortrait";
//			plus.nativeUI.showWaiting();
			var task = plus.uploader.createUpload(urlStr, {
					method: "POST"
				},
				function(t, status) { //上传完成  
//					plus.nativeUI.closeWaiting();
					if(status == 200) {
						console.log(t.responseText);
						var result = JSON.parse(t.responseText);
						mui.toast(result.message);

					} else {
						console.log("上传失败：" + status);
					}
				}
			);

			for(var i = 0; i < files.length; i++) {
				var f = files[i];
				task.addFile(f.path, {
					key: f.name
				});
				console.log(JSON.stringify(files[i]));
			}
			task.addData('userId', "78503239");
			task.start();
		},
		function(error) {
			console.log(error);
			return src;
			//alert("Compress error!");  
		});

}

//向文件数组中添加图片
function appendFile(p) {
	files.push({
		path: p,
		name: "uploadkey_" + index
	});
	index++;
}
// 产生一个随机数  
function getUid() {
	return Math.floor(Math.random() * 100000000 + 10000000).toString();
}
//压缩图片，这个比较变态的方法，无法return  
function compressImage(src, dstname) {

}

function ajaxBase(url, asyn, data, callback) {
	var mask = mui.createMask();
	mui.ajax(url, {
		data: data,
		type: 'POST',
		timeout: 10000,
		crossDomain:true,
		beforeSend: function() {
//			plus.nativeUI.showWaiting("加载中...", {});
			mask.show(); //显示遮罩层  
		},
		complete: function() {
//			plus.nativeUI.closeWaiting();
			mask.close(); //关闭遮罩层  
		},
		success: function(e) {
			callback(e);
		},
		error: function(xhr, type, error) {
			console.log(xhr + "---" + type + "---" + error);
			callback(false);
		}
	});
}

function getDateString() {
	var ts = new Date();
	var td = ts.getDate(); //day
	var ty = ts.getFullYear(); //
	var tm = ts.getMonth() + 1;
	var th = ts.getHours();
	var tmin = ts.getMinutes();
	var tsd = ts.getSeconds();
	var dtime = ty + "-" + (tm < 10 ? "0" + tm : tm) + "-" + (td < 10 ? "0" + td : td) + "&nbsp" + (th < 10 ? "0" + th : th) + ":" + (tmin < 10 ? "0" + tmin : tmin) + ":" + (tsd < 10 ? "0" + tsd : tsd);
	return dtime;
}

function CurentTime() {
	var now = new Date();
	var year = now.getFullYear(); //年
	var month = now.getMonth() + 1; //月
	var day = now.getDate(); //日
	var hh = now.getHours(); //时
	var mm = now.getMinutes() - GetRandomNum(3.0, 1.0); //分
	var clock = year + "-";

	if(month < 10)
		clock += "0";

	clock += month + "-";

	if(day < 10)
		clock += "0";

	clock += day + " ";

	if(hh < 10)
		clock += "0";

	clock += hh + ":";
	if(mm < 10) clock += '0';
	clock += mm;
	return(clock);
}

//随机数
function GetRandomNum(Min, Max) {
	var Range = Max - Min;
	var Rand = Math.random();
	return(Min + Math.round(Rand * Range));
}