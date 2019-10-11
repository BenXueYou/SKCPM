/*
 
 * 获取数据
 * 获取数据库表内合作加盟条例
 * 
 * */


function getJoinUsData(contain){
	var carList = null;
	$.ajax({url:"../../admin/JoinUs/joinUs.php",
	type:"GET",
	datatype:"json",
	async:false,
	data:{
		
	},
	success:function(data){
		var res =JSON.parse(data);
		console.log(typeof(res)+"======"+JSON.stringify(res)+"===="+res.returnCode);
		if(res.returnCode == 0){
			carList = res.detail;
			console.log(carList);
		}else if(res.returnCode == 1){
			alert("没有找到数据");
			document.getElementById(contain).innerHTML = "没有找到数据";
			carList = false;
		}else{
			alert("你的账号没有权限");
			document.getElementById(contain).innerHTML = "你的账号没有权限";
			carList = false;
		}
	},
	error:function(jqXHR){
		console.log(JSON.stringify(jqXHR.responseText));
		document.getElementById(contain).innerHTML = jqXHR.responseText;
		alert("服务器没有响应");
		carList = false;
	}

	});
	return carList;
}
