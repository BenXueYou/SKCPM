/*
 
 * 获取数据
 * 获取数据库表内所有优惠活动
 * 
 * */


function getSaleList(contain){
	var caseList = null;
	$.ajax({url:"../../admin/newsList/saleList.php",
	type:"GET",
	datatype:"json",
	async:false,
	data:{
		
	},
	success:function(data){
		
		var res =JSON.parse(data);
		console.log(typeof(res)+"======"+JSON.stringify(res)+"===="+res.returnCode);
		if(res.returnCode == 0){
			caseList = res.detail;
			console.log(caseList);
		}else if(res.returnCode == 1){
			alert("没有找到数据");
			document.getElementById(contain).innerHTML = "没有找到数据";
			caseList = false;
		}else{
			alert("你的账号没有权限");
			document.getElementById(contain).innerHTML = "你的账号没有权限";
			caseList = false;
		}
	},
	error:function(jqXHR){
		console.log(JSON.stringify(jqXHR.responseText));
		document.getElementById(contain).innerHTML = jqXHR.responseText;
		alert("服务器没有响应");
		caseList = false;
	}

	});
	return caseList;
}
