var My = {
	//我的收藏
	MyCollectionFun: function(url, userid, csid, collectStatus, callback) {
		url = url + "userManager/collect";
		var postData = {
			cpUserId: userid,
			csId: csid,
			collectStatus: collectStatus
		};
		AjaxBase(url, false, postData, function(data) {
			console.log("我的收藏=" + data + "=====" + JSON.stringify(data));
			if(!data) {
				callback(false);
				return;
			}
			callback(true);
			

		});
	},
	//收藏列表
	MyCollectionList: function(url, userid, callback) {
		url = url + "userManager/collectList";
		var postData = {
			cpUserId: userid
		};
		AjaxBase(url, false, postData, function(data) {
			if(!data) {
				callback(false);
				return;
			}
			//			callback(true);
			console.log("我的收藏=" + data + "=====" + JSON.stringify(data));
			if(data.detail) {
				callback(data.detail.csList);
			} else {

			}

		});
	},
	//我的评价
	MyEvaluationFun: function(url, serialNo, starRank, callback) {
		
		console.log(starRank);		
		url = url + "userManager/evalute";
		var postData = {
			transationId: serialNo,
			evalute: starRank
		};
		AjaxBase(url, false, postData, function(data) {

			console.log("我的评价=" + data + "=====" + JSON.stringify(data));
			if(!data) {
				callback(false);
				return;
			}
			callback(true);

		});
	}
}

function AjaxBase(url, asyn, data, callback) {
	var mask = mui.createMask();
	mui.ajax(url, {
		data: data,
		type: 'get',
		timeout: 30000,
		beforeSend: function() {
			mask.show(); //显示遮罩层  
		},
		complete: function() {
			plus.nativeUI.closeWaiting();
			mask.close(); //关闭遮罩层  
		},
		success: function(e) {
			//			console.log("AjaxBase"+e);
			callback(e);
		},
		error: function(xhr, type, error) {
			console.log(xhr + "---" + type + "---" + error);
			callback(false);
		}
	});
}