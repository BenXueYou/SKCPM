var Pile = {
	//获取所有充电站信息
	getPileList: function(url, callback) {
		url = url + "mapSearchPile/findSMPByList";
		var res = false;
		mui.ajax(url, {
			data: {
				longitude: 121,
				latitude: 31,
			},
			type: "GET",
			timeout: 10000,
			dataType: "json",
			crossDomain: true,
			success: function(data) {
				console.log(JSON.stringify(data));
				if(data.returnCode == 0) {
					var detail = data.detail;
					res = detail.csList;
					callback(res);
				} else {
					//获取数据失败
					mui.alert("获取数据失败");
					callback(res);
				}
			},
			error: function(jqxhr) {
				mui.alert("获取站点数据");
				console.log("请求桩列表====" + jqxhr);
				callback(res);
			},
		});
	},
	//:根据扫码的设备号获取枪的状态
	pileState: function(url, cpid, callback) {

		var mask = mui.createMask();
		url = url + "scanCharge/isChargePile";
		//alert(cpid + "==url==" + cpid.length);
		window.res = 0;
		mui.ajax(url, {
			data: {
				deviceId: cpid
			},
			dataType: "JSON",
			type: "GET",
			crossDomain: true,
			timeout: 10000, //超时时间：10秒
			beforeSend: function() {
				mask.show(); //显示遮罩层  
			},
			complete: function() {
				mask.close(); //关闭遮罩层 
			},
			success: function(data) {
				console.log("===" + JSON.stringify(data));
				dataObj = JSON.parse(data);
				if(dataObj.returnCode == 0) {
					var detail = dataObj.detail;
					if(JSON.stringify(detail) == "{}") {
						mui.alert("该桩不在运营范围");
						callback(false);
						return;
					} else {
						window.res = dataObj.detail;
						callback(window.res);
					}
				} else if(dataObj.returnCode == 4) {
					mui.alert("没有插枪");
					callback(false);
				} else if(dataObj.returnCode == 5) {
					mui.alert("没有授权");
					callback(false);
				} else if(dataObj.returnCode == 2) {
					mui.alert("系统提示："+dataObj.message);
					callback(false);
				} else if(dataObj.returnCode == 3) {
					mui.alert("该枪正在被使用");
					callback(false);
				} else {
					mui.alert("参数错误");
					callback(false);
				}
			},
			error: function(jqx, error, type) {
				//alert(jqx + "====" + error + "====" + type);
				alert("网络异常，请稍后再试");
				callback(false);
			}
		});
	},
	//当桩正在被使用，则根据用户id，获取该正在充电的桩的信息(cpid)
	pileMsg: function(url, openid, callack) {
		url = url + "scanCharge/getPileBaseInfo";
		var cpid = false;
		mui.ajax(url, {
			data: {
				userId: openid,
				platform: 1
			},
			dataType: "JSON",
			type: "GET",
			crossDomain: true,
			timeout: 10000, //超时时间：10秒
			success: function(data) {
				console.log(data);
				data = JSON.parse(data);
				if(data.returnCode == 0) {
					var detail = data.detail;
					if(JSON.stringify(detail) == "{}") {
						mui.alert("没有获取到数据");
						callack(false);
					}
					var cp = detail.cp;
					var obj = cp[0];
					cpid = obj.cpid;
					callack(obj);
				} else {
					mui.alert("没有找到充电桩");
					callack(false);
				}
			},
			error: function(xhr, type, error) {
				mui.alert("网络异常");
				callack(false);
			}
		});

	},

	pileStart: function(url, openid, deviceId, callback) {
		var mask = mui.createMask();
		url = url + "scanCharge/startCharge";
		var result = false;
		mui.ajax(url, {
			data: {
				userId: openid,
				deviceId: deviceId,
			},
			dataType: "JSON",
			crossDomain: true,
			//async:false,
			timeout: 35000,
			beforeSend: function() {
				//plus.nativeUI.showWaiting("等待充电桩回复...", {});
				mask.show(); //显示遮罩层  
			},
			complete: function() {
				//plus.nativeUI.closeWaiting();
				mask.close(); //关闭遮罩层 
				//				callback(result);
			},
			success: function(data) {
				data = JSON.parse(data);
				console.log("启动充电枪回复：====" + data + "=====" + openid + "===" + data.returnCode);
				//				data = JSON.parse(data);
				if(data.returnCode == 0) {
					result = true;
					callback(true);
					return;
				} else if(data.returnCode == 4) {
					mui.alert("充电桩没有插枪！");

				} else if(data.returnCode == 6) {
					mui.alert("充电桩离线，稍后再试！");
				} else {
					mui.alert("充电桩启动失败,请重试");
				}
				callback(result);
			},
			error: function(xhr, type, error) {
				console.log("启动充电枪回复：" + openid + "====" + JSON.stringify(error) + "====" + JSON.stringify(type) + "====");
				mui.alert("网络异常");
				callback(false);
			}
		});
	},

	pileStop: function(urlstr, openid, callback) {
		var mask = mui.createMask();
		var url = urlstr + "scanCharge/stopCharge";
		var result = false;
		mui.ajax(url, {
			data: {
				userId: openid,
				platform: 1
			},
			dataType: "JSON",
			type: "GET",
			//async: false,
			crossDomain: true,
			timeout: 15000,
			beforeSend: function() {
				//plus.nativeUI.showWaiting("充电桩停止中...", {});
				mask.show(); //显示遮罩层  
			},
			complete: function() {
				//plus.nativeUI.closeWaiting();
				mask.close(); //关闭遮罩层 
//				callback(result);
			},
			success: function(data) {
				console.log("停止充电枪回复：" + openid + "====" + data + "====");
				data = JSON.parse(data)
				if(data.returnCode == 0) {
					result = true;
					callback(true);
				} else {
					mui.alert("充电桩停止失败,请重试");
					callback(false);
				}
			},
			error: function(xhr, type, error) {
				console.log("停止充电枪回复：" + openid + "====" + JSON.stringify(error) + "====" + JSON.stringify(type) + "====");
				mui.alert("网络异常");
				callback(false);
				mask.close();
			}
		});
	},

	getSerialNo: function(url, openid, callback) {
		var mask = mui.createMask();
		url = url + "scanCharge/getSerialNo";
		console.log("========获取流水号====" + url);
		var result = false;
		mui.ajax(url, {
			data: {
				userId: openid,
				platform: 1
			},
			dataType: "JSON",
			type: "GET",
			//async: false,
			crossDomain: true,
			timeout: 15000,
			beforeSend: function() {
				//plus.nativeUI.showWaiting("充电账单获取中...", {});
				mask.show(); //显示遮罩层  
			},
			complete: function() {
				//plus.nativeUI.closeWaiting();
				mask.close(); //关闭遮罩层 
				callback(result);
			},
			success: function(data) {
				console.log("账单获取回复：" + openid + "====" + data + "====");

				data = JSON.parse(data);
				//data就是返回的json数据
				if(data.returnCode == 0) {
					result = data.serialNo;
					callback(data.serialNo);
				} else if(data.returnCode == 1) {
					mui.alert("账单获取失败，账单请查看充电记录");
					callback(false);
				} else {
					mui.alert("网络延迟，账单请查看充电记录");
					callback(false);
				}
			},
			error: function(xhr, type, error) {
				mui.alert("网络异常，账单以充电记录为准");
				console.log("账单获取回复：" + openid + "====" + JSON.stringify(error) + "====" + JSON.stringify(type) + "====");
				callback(false);
			}
		});
	},
}

function closeMask() {
	mask.close();
}

function getSerialNo(url, openid, callback) {

}