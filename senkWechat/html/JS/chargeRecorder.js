var ChargeRecord = {
	getChargeRecord: function(urlM, openId, index, callback) {
		var urlStr = urlM + "userManager/chargeRecorderByUserId";
		var Ajax = $.ajax({
			type: "GET",
			url: urlStr,
			dataType: 'json',
			data: {
				userId: openId,
				currentPage: index,
				pageSize: 20,
				platform: 1
			},
			success: function(data) {
				 console.log("充电记录="+data+"==="+JSON.stringify(data));
				if(data.returnCode == 0) {
					var arr = data.detail;
                    var chargeRecorder = arr.chargeRecorder;
                   
					callback(chargeRecorder);
				} else {
					alert("没有抓到数据");
					callback(false);
				}
			},
			error: function(jqXHR) {
				alert("服务器通信异常");
				callback(false);
				console.log(JSON.stringify(jqXHR));
			}
		});
	},
	getPayRecord: function(urlM, openId, index, callback) {
		
		console.log( urlM + "wechatUserManager/wechatPayRecord");
		
		console.log(openId+"===="+index+"==");
		
		var resArr = false;
		var Ajax = $.ajax({
			type: "GET",
			url: urlM + "wechatUserManager/wechatPayRecord",
			dataType:'json',
			data: {
				openId: openId,
				currentPage: index,
				pageSize: 20
			},
			success: function(data) {
				console.log("支付记录="+JSON.stringify(data));
				if(data.returnCode == 0) {
					var arr = data.detail;
					var payRecorder = arr.payRecord;
					payRecordArr = payRecorder;
					resArr = payRecorder;
					console.log("支付记录="+resArr);
					callback(resArr);
				} else {
					alert("没有抓到数据");
					callback(false);
				}
			},
			error: function(jqXHR) {
				alert("服务器通信异常");
				callback(false);
				console.log(JSON.stringify(jqXHR));
			}
		});
	}
}