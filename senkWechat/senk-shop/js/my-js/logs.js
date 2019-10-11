
/*
 
 * 前端日志工具类
 * 作用：前端JS执行出错，向后端发送日志数据
 * 调用方式：var log = new setLoggle("JS日志走了");   
 * */


function setLoggle(msg,url){
	var carList = false;
	$.ajax({url:url,
	type:"POST",
	datatype:"json",
	async:false,
	data:{
		msg:msg
	},
	success:function(data){
		if(data == true || data == "1" || data == 1){
			carList = true;
		}else{
			carList = false;
		}
	},
	error:function(jqXHR){
		console.log(JSON.stringify(jqXHR.responseText));
		carList = false;
	}
	});
	return carList;
}
