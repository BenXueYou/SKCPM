<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=8">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="Cache" content="no-cache">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
		<title>手动输入桩编号</title>
	   	<link href="../../CSS/circle.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="../JS/jquery-3.0.0.min.js" ></script>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<style type="text/css">
		    body{
			    background: white;
		    }
		    div{
				text-align: center;
			}
			#logo{
				margin: 10% auto;
				width: 120px;
				height: 120px;
			}
			#intext{
				margin-top: 30px;
				height: 30px;
				margin-bottom: 30px;
			}
			#intext input{
				width: 60%;
				height: 30px;
				font-size: 16px;
				color: black;
				text-align: center;
				border: 1px solid gray;
			}
			#btn{
				text-align: center;
				margin: 0 auto;
			}
			#btn button{
				background-color: coral ;
				width: 30%;
				margin-top:10%;
                height:40px;
				color: white;
                font-size:16px;
				border-radius:5px ;
			}
             .hidden{
            	display:none;
            }
             #mask{
            	position:absolute;
                left:0px;
                top:-20px;
                width:100%;
                height:600px;
                background-color:rgba(80,80,80,0.3);
            }
		</style>
	</head>
	<body>
		<div id="logo">
			<img src="../../img/logo.png"/>
		</div>
		<div id="intext">
			<input type="text" id="inputTxt" placeholder="输入桩设备编号" />
		</div>
		<div id="btn">
			<button value="确定">确定</button>
		</div>
         <div class="hidden" id="mask">
            <div class="m-load2">
                <div class="line">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="circlebg"></div>
            </div>
        </div>
	</body>
    <script src="../JS/CONFIG.js" type="text/javascript" charset="utf-8"></script>
	<script src="../JS/mui.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
        //定义全局变量
       //var urlM = "http://116.236.237.244:8080/SuperBackManage/";
       var urlM = CONFIGF.LANCHUANG();
       var openId;
       var cpid;
       var deviceId = cpid;
       var chargeState = 0;
       var money = 0;

     //解析本地的URL，获取参数
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }
     openId = getQueryString("openId");
        
     alert("openid======"+openId);



//监听按钮
/*
1.先监控用户状态
2.获取桩的设备号
3.获取编号请求桩的状态
*/
  		$("button").click(function(){
             //获取用户充电状态

               deviceId = document.getElementById("inputTxt").value;
                    //alert('devicedId===='+deviceId);
            		if(deviceId == null || deviceId == "" || deviceId == undefined ){
                        alert("设备号为空");
                        return;
                    }
                    else if(deviceId.length <18){
                        alert("设备号错误");
                    }
            		else {
                          $("#mask").removeClass("hidden");
                          getUserState(openId);
                    }
        });

       //请求用户状态
       function getUserState(openId){
        ajax = $.ajax({
				type:"GET", // 请求方式
				url:urlM+"wechatUserManager/getUserState", // 请求地址
				dataType:'json',
				data:{
            openId:openId
				},
				success: function(data) { //data就是返回的json数据
                    if(data.returnCode==0){
                        //用户正在充电状态
                        if((data.chargeState == "1") || (data.chargeState == "2")){
						  chargeState = data.chargeState;
                          //根据openId获取充电单信息，进入充电界面
                          getCpid(chargeState);
                        	$("#mask").addClass("hidden");
                        }else{
							chargeState = data.chargeState;
                            $("#mask").addClass("hidden");
                            //根据设备号设置充电订单
                           sendCpIdToSever(deviceId);
                        }

                    }else if(data.returnCode==1){
                        $("#mask").addClass("hidden");
                     	alert("未匹配到openId");
                    }else{

                        $("#mask").addClass("hidden");
                    	alert("参数错误");
                    }
				},
				error: function(jqXHR) {
                    console.log("发生错误"+jqXHR.status);
                    $("#mask").addClass("hidden");
                    alert("请求用户状态发生错误,服务器异常");
        		},
      	 });
     }


        //根据openId，获取订单信息
        function getCpid(e){
            var ajax = $.ajax({
            	type:"GET",
                url:urlM+"scanCharge/getPileBaseInfo",
            	data:{
                	userId:openId,
                    platform:1
                },
            	success:function(data){
                	if(data.returnCode == 0){

                        var detail = data.detail;
                        if(JSON.stringify(detail) == "{}"){alert("没有获取到充电数据"); return;}
                        var cp = detail.cp;
                        var obj = cp[0];
                        cpid = obj.cpid;
                        var state = 1;
                       //进入充电界面
						 location.href='charging.php?cpid='+cpid+'&openid='+openId+'&chargeState='+e+'&payMode=3&money=0'+'&out_trade_no=0';

					          }else{
                        $("#mask").addClass("hidden");
                    	alert("没有找到充电桩");
                    }
                },
                error: function(jqXHR) {
                    console.log("发生错误"+jqXHR.status);
                    $("#mask").addClass("hidden");
                    alert("请求桩编号发生错误");
        		},
            });
        }

       //请求桩的状态
        function sendCpIdToSever(e){
        	 ajax = $.ajax({
				type:"GET", // 请求方式
				url:urlM+"scanCharge/isChargePile", // 请求地址
				dataType:'json',
				data:{
                    deviceId:e
				},
				success: function(data) {
                    //alert(e +"请求桩的状态："+JSON.stringify(data));
                    //判断该桩处于空闲状态，可以被使用则进入支付界面
                    if(data.returnCode==0){
                    	$("#mask").addClass("hidden");
                      var cpObj = data.detail;
                      location.href='chargePay.php?cpid='+e+'&openid='+openId+'&chargeState='+chargeState+'&payMode=3'+'&money=0'+'&cpObj='+escape(JSON.stringify(cpObj));
                    }else if(data.returnCode==4){
                    	$("#mask").addClass("hidden");
                     	alert("没有插枪");
                    }else if(data.returnCode==5){
                        $("#mask").addClass("hidden");
                     	alert("没有授权");
                    }else if(data.returnCode==2){
                        $("#mask").addClass("hidden");
                     	alert("没有找到桩设备编号");
                    }else if(data.returnCode==3){
                        $("#mask").addClass("hidden");
                     	alert("该桩正在被使用");
                    }else{
                    	$("#mask").addClass("hidden");
                    	alert("参数错误");
                    }

				},
				error: function(jqXHR) {
                    console.log("发生错误"+jqXHR.status);
                    alert("请求桩状态发生错误："+ jqXHR.status);
                    $("#mask").addClass("hidden");
        		},
      	 });

     }
     </script>
</html>
