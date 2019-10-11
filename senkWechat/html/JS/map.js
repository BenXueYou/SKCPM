//全局变量
var lng = ""; //经度
var lat = ""; //纬度
var urlM = CONFIGS.SCATESTURL();
//站点ID
var CSID;
//窗体
var infwin;
//保存站点名数组
var markerNames = new Array();
//保存大头针标识
var markers = new Array();
var flag = 0;

//获取当前经纬度
var map, geolocation;
//加载地图，调用浏览器定位服务
map = new AMap.Map('container', {
	resizeEnable: true,
});
//点击空白处关闭窗口
map.on('click', function() {
	if(infwin)
		var isOn = infwin.getIsOpen();
	window.closeInfoWindow();
})

//搜索事件
var auto = new AMap.Autocomplete({
	input: "tipinput"
});
AMap.event.addListener(auto, "select", select); //注册监听，当选中某条记录时会触发
function select(e) {
	if(e.poi && e.poi.location) {
		map.setZoom(10);
		map.setCenter(e.poi.location);
	}
}
//定位获取经纬度
map.plugin('AMap.Geolocation', function() {
	geolocation = new AMap.Geolocation({
		enableHighAccuracy: true, //是否使用高精度定位，默认:true
		timeout: 10000, //超过10秒后停止定位，默认：无穷大
		buttonOffset: new AMap.Pixel(10, 60), //定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
		zoomToAccuracy: true, //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
		buttonPosition: 'RB'
	});
	map.addControl(geolocation);
	geolocation.getCurrentPosition();
	AMap.event.addListener(geolocation, 'complete', onComplete); //返回定位信息
	AMap.event.addListener(geolocation, 'error', onError); //返回定位出错信息
});

//解析定位结果
function onComplete(data) {
	lng = data.position.getLng();
	lat = data.position.getLat();
	getFindSMPByMap(lng, lat);
	console.log("获取经度：" + lng + "纬度：" + lat);

}
//解析定位错误信息
function onError(data) {
	alert('定位失败');
}
//点击跳转列表页
function csBtnFun() {
	if(lng && lat) {
		window.closeInfoWindow();
		plus.webview.open("html/pilelist.html?longitude=" + lng + "&latitude=" + lat, "", {}, "slide-in-right", 200);
	}
}
//点击进入详情页
function stepToDetail(e) {
	console.log(e);
	//	plus.webview.open("html/pileModule/piledetail.html?csid=" + e + "&lng=" + lng + "&lat=" + lat, "piledetail", {}, "slide-in-right", 200);
	window.closeInfoWindow();
	mui.openWindow({
		url: "html/pileModule/piledetail.html",
		id: "piledetail",
		styles: {
			top: "0px",
			bottom: "0px"
		},
		extras: {
			lat: lat,
			lng: lng,
			csid: e
		},
		createNew: false,
		show: {
			autoShow: true, //页面loaded事件发生后自动显示，默认为true
			aniShow: "slide-in-right", //页面显示动画，默认为”slide-in-right“；
			duration: "200" //页面动画持续时间，Android平台默认100毫秒，iOS平台默认200毫秒；
		},
		waiting: {
			autoShow: true, //自动显示等待框，默认为true
			title: '正在加载...', //等待对话框上显示的提示内容
			options: {

			}
		}
	});
}

function stepToRentCar(e) {
	window.closeInfoWindow();
	plus.webview.open("html/carModule/cardetail.html?", "cardetail", {}, "slide-in-right", 200);
}

//根据经纬度请求站列表
function getFindSMPByMap(lg, la) {
	var ajax = $.ajax({
		type: "GET",
		url: urlM + "mapSearchPile/findSMPByMap",
		dataType: "json",
		data: {
			longitude: lg,
			latitude: la
		},
		success: function(data) {
			if(data.returnCode == 0) {
				var detail = data.detail;
				var csList = detail.csList;
				for(var h = 0; h < csList.length; h++) {
					addMarker(csList[h], h);
				}
			}
		},
		error: function(jqXHR) {
			alert("网络请求站列表发生错误");
		},
	});
}
//创建大头针
function addMarker(csinfo, h) {
	var lngd = csinfo['longitude'];
	var latd = csinfo['latitude']
	var marker = new AMap.Marker({
		icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
		position: [lngd, latd]
	});
	//添加到地图上
	marker.setMap(map);
	//保存大头针，压入数组markers
	markers.push(marker);
	getInfoWindow(csinfo, marker, h);
}

function getInfoWindow(csinfo, marker, j) {
	$.ajax({
		type: "get",
		url: urlM + "mapSearchPile/findSMPInfoById",
		async: true,
		data: {
			type: "cs",
			id: csinfo['csid'],
			longitude: csinfo['longitude'],
			latitude: csinfo['latitude']
		},
		success: function(data) {
			if(data.returnCode == 0) {
				var detail = data.detail;
				var cs = detail.cs;
				addInfoWindow(cs[0], marker, j);
			} else {

			}
		},
		error: function(xhr) {
			alert("网络请求站点信息发生错误");
		}
	});
}

function addInfoWindow(cs, marker, j) {
	//实例化信息窗体
	var title = '<div style="display:flex;justify-content: space-between;">' +
		'<h4>' + cs["name"] + '</h4>' +
		'<span style="margin-left:10px;font-size:11px;color:#F00;">距离:23</span>' +
		'<button style="height:20px; margin:0 0 0 30px;background-color:white;outline:none;border:0px solid #299dff;border-radius:5px;color:#299dff" value = "' +
		j + '" class="navBtn">导航</button>' +
		'</div>';

	content = [];
	var midbox = '<div style="display:flex; justify-content:space-between;">' +
		'<img src="images/cs.png"/>' +
		'<div>' +
		"直流桩：" + cs['dcisnum'] + "/" + cs['dcnum'] + '&nbsp&nbsp&nbsp' + "交流桩：" + cs['acisnum'] + "/" + cs['acnum'] + "<br />" +
		"沪A0903Z:" + "续航（157公里）" + "<br />" +
		//		"停车费:" + "根据现场实际情况而定" + "<br />" +
		"充电费:" + 1.2 + "元/度&nbsp&nbsp&nbsp" +
		"服务费:" + 0.8 + "元/度&nbsp&nbsp&nbsp" +
		'</div>' +
		'</div>' +
		'<div style="display:flex; justify-content:space-between;">' +
		'<button style="width:25%;height:24px;margin:3px 5% 0px;padding:2px 5px; font-size:12px;color:#299DFF;bordr:0px;" onclick="stepToDetail(' + cs['csid'] + ')">充电</button>' +
		'<button style="width:25%;height:24px;margin:3px 5% 0px;padding:2px 5px; font-size:12px;color:#299DFF;bordr:0px;" onclick="stepToRentCar(' + cs['csid'] + ')">租车</button>' +
		'</div>' + '<div style="display:flex; justify-content:space-between;">' +
		"地址：" + cs['location'] +
		'</div>';
	content.push(midbox);
	//将站点名字保存在数组中
	markerNames.push(cs["name"]);
	var infoWindow = new AMap.InfoWindow({
		isCustom: true, //使用自定义窗体
		content: createInfoWindow(title, content.join("<br/>")),
		offset: new AMap.Pixel(30, -50)
	});
	AMap.event.addListener(marker, 'click', function() {
		infoWindow.open(map, marker.getPosition());
	});
}
$(document).on('click', '.navBtn', function(e) {
	var j = $(this).val();
	var emarker = markers[j];
	//	emarker.markOnAMAP({
	//		position: emarker.getPosition(),
	//		name: markerNames[j] //name属性在移动端有效
	//	});
	window.closeInfoWindow();
	//	mui.openWindow({
	//		url: "html/navOnAPP.html",
	//		id: "navOnAPP",
	//		styles: {
	//			top: "0px",
	//			bottom: "0px"
	//		},
	//		extras: {
	//			marker: emarker,
	//			name:markerNames[j] 
	//		},
	//		createNew: false,
	//		show: {
	//			autoShow: true, //页面loaded事件发生后自动显示，默认为true
	//			aniShow: "slide-in-right", //页面显示动画，默认为”slide-in-right“；
	//			duration: "200" //页面动画持续时间，Android平台默认100毫秒，iOS平台默认200毫秒；
	//		},
	//		waiting: {
	//			autoShow: true, //自动显示等待框，默认为true
	//			title: '正在加载...', //等待对话框上显示的提示内容
	//			options: {
	//
	//			}
	//		}
	//	});

});

//构建自定义信息窗体
function createInfoWindow(title, content) {
	var info = document.createElement("div");
	info.className = "info";
	//		console.log('测试是否循环调用窗口'+title);
	//可以通过下面的方式修改自定义窗体的宽高
	// 定义顶部标题
	var top = document.createElement("div");
	var titleD = document.createElement("div");
	var closeX = document.createElement("img");
	top.className = "info-top";
	titleD.innerHTML = title;
	closeX.src = "http://webapi.amap.com/images/close2.gif";
	closeX.onclick = closeInfoWindow;

	top.appendChild(titleD);
	top.appendChild(closeX);
	info.appendChild(top);

	// 定义中部内容
	var middle = document.createElement("div");
	middle.className = "info-middle";
	middle.style.backgroundColor = 'white';
	middle.innerHTML = content;
	info.appendChild(middle);

	// 定义底部内容
	var bottom = document.createElement("div");
	bottom.className = "info-bottom";
	bottom.style.position = 'relative';
	bottom.style.top = '0px';
	bottom.style.margin = '0 auto';
	bottom.style.backgroundColor = 'red';
	var sharp = document.createElement("img");
	sharp.src = "http://webapi.amap.com/images/sharp.png";
	bottom.appendChild(sharp);
	info.appendChild(bottom);
	return info;
}

//关闭信息窗体
function closeInfoWindow() {
	map.clearInfoWindow();
}