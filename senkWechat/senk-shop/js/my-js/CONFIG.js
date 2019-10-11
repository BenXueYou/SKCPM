
//图片工具类
/*
 * 获取图片路径
 * 
 * */
function IMGSrcHead(){
	
	
}

IMGSrcHead.prototype.imgSrcHead=function(){
	return "http://139.129.194.195:80/img/";
//	return "http://192.168.8.66:80/img/";
}

IMGSrcHead.prototype.contentImgSrcHead=function(){
	return "src=\"http://139.129.194.195:8080";
//	return "src=\"http://192.168.8.66:9399/";
}


IMGSrcHead.prototype.testImgSrcHead=function(){
	return "http://192.168.8.66:80/img/";
}

IMGSrcHead.prototype.testContentImgSrcHead=function(){
	return "src=\"http://192.168.8.66:8080/SuperBackManage";
}

//接口主路径

function URLManage(){
	
}

URLManage.prototype.URLM = function(){
	return "http://139.129.194.195:8080/SuperBackManage/";
}
URLManage.prototype.TESTM = function(){
	return "http://116.236.137.244:8080/SuperBackManage/";
}
