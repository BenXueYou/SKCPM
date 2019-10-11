var CONFIGS = {
	WXPAYSERVER: function() {
		return "http://gxbie.com/LanChuang/wechatPay/unifiedOrder?payid=";
		
	},
	ALIPAYSERVER: function() {
		return "https://gxbie.com/LanChuang/wechatPay/alipayUnifiedOrder?payid=";
		
	},
	/*	广西蓝创Server*/
	LANCHUANG: function() {
		return "https://gxbie.com/LanChuang/" //天翼云平台
	},
	URLManage:function(){
		const URLObj = {
			
		};
		return URLObj;
	},
	GETOUTTRADENO: function(cpid) {
		var indexNo = cpid.substr(0, 6) + cpid.substr(-6, 6);
		var ts = new Date();
		var td = ts.getDate(); //day
		var ty = ts.getFullYear();//
		var tm = ts.getMonth() + 1;
		var th = ts.getHours();
		var tmin = ts.getMinutes();
		var tsd = ts.getSeconds();
		var out_trade_no = "lc" + indexNo + ty + (tm < 10 ? "0" + tm : tm) + (td < 10 ? "0" + td : td) + (th < 10 ? "0" + th : th) + (tmin < 10 ? "0" + tmin : tmin) + (tsd < 10 ? "0" + tsd : tsd);
		return out_trade_no;
	}
} 