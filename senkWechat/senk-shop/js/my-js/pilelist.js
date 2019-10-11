/*
 
 * 获取数据
 * 获取数据库表内所有车型对象
 * 
 * */
function getPileList(contain){
	var pileList = null;
	$.ajax({url:"../../admin/pileList/getPileList.php",
	type:"GET",
	datatype:"json",
	async:false,
	data:{
		
	},
	success:function(data){
		var res =JSON.parse(data);
		console.log(typeof(res)+"======"+JSON.stringify(res)+"===="+res.returnCode);
		if(res.returnCode == 0){
			pileList = res.detail;
			console.log(JSON.stringify(pileList));
		}else if(res.returnCode == 1){
			alert("没有找到数据");
			document.getElementById(contain).innerHTML = "没有找到数据";
			pileList = false;
		}else{
			alert("你的账号没有权限");
			document.getElementById(contain).innerHTML = "你的账号没有权限";
			pileList = false;
		}
	},
	error:function(jqXHR){
		console.log(JSON.stringify(jqXHR.responseText));
		document.getElementById(contain).innerHTML = jqXHR.responseText;
		alert("服务器没有响应");
		pileList = false;
	}

	});
	return pileList;
}
/*
 
 * 获取数据
 * 获取数据库内所有车型的数据
 * 
 * */
function getPileModel(contain){
	var pileList = null;
	$.ajax({url:"../../admin/pileList/getListModel.php",
	type:"GET",
	datatype:"json",
	async:false,
	data:{
		
	},
	success:function(data){
		var res =JSON.parse(data);
		console.log(typeof(res)+"======"+JSON.stringify(res)+"===="+res.returnCode);
		if(res.returnCode == 0){
			pileList = res.detail;
			console.log(pileList);
		}else if(res.returnCode == 1){
			alert("没有找到数据");
			document.getElementById(contain).innerHTML = "没有找到数据";
			pileList = false;
		}else{
			alert("你的账号没有权限");
			document.getElementById(contain).innerHTML = "你的账号没有权限";
			pileList = false;
		}
	},
	error:function(jqXHR){
		console.log(JSON.stringify(jqXHR.responseText));
		document.getElementById(contain).innerHTML = jqXHR.responseText;
		alert("服务器没有响应");
		pileList = false;
	}

	});
	return pileList;
}



