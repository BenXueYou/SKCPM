<?php
 require_once "../config.php/test_jssdk.php";
 $jssdk = new JSSDK("wx32a40fe9e54cc1c8","cba6f2171a8a0fb4a2c3012c65f007d3");
 $signPackage = $jssdk->GetSignPackage();
?>
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
		<title>正在充电</title>
        <link rel="icon" href="../../../img/logo.png" type="image/x-icon"/>
        <link href="../../CSS/circle.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="../../JS/jquery-3.0.0.min.js" ></script>
        <script type="text/javascript" src="../../JS/radialIndicator.js" ></script>
		<style type="text/css">
        body{
            position:relative;
            background-color: rgb(245,245,245);
            margin:0px;
            padding:0px;
        }
		#top{
			margin: 20px auto 0px;
			width: 200px;
			height: 150px;

		}
		.rad-prg{
            text-align:center;
            position: relative;
        }
       .rad-con{
            position: absolute;
            z-index: 1;
            top:0px;
            left: 15%;
            text-align: center;
            width:150px;
            height: 120px;
            padding: 10px;
            font-family: "microsoft yahei";
       }
       .rad-con p{
            text-align:center;
            position:absolute;
            top:35%;
            left:25%;
       }
       #top #label div{
			/*background-color:red ;*/
			text-align: center;
			position: absolute;
			width: 90%;
			bottom: 10px;
			left: 5%;
		}
		span{
			font-size: 15px;
			color: black;
			font: '微软雅黑';
		}
		#mid{
            width: 100%;
			background-color:rgb(254,254,254) ;
			text-align: center;
			padding:10px 0px;
            border: 1px solid lightgray;
            margin-bottom:80px;
	    }
       .l{
			display: inline-block;
			width: 100px;
			float: left;
			line-height: 25px;
		}
	   .m,.r,.rc{
			display: inline-block;
			width: 18%;
			float: left;
		}
	   .m,.r,.rc div{
			line-height: 25px;
		}
       .mid_top_left{
            display:block;
            overflow:hidden;
            margin-left:30px;
       }
      .ch{
           width:100px;
           text-align:left;
           margin:5px 0;
           line-height:25px;
      }
      .mid_top_right{
          overflow:hidden;
      }
      .mid_mid{
        text-align:left;
      }
      .chh{
        padding:3px 10px 3px 0px;
        text-align:left;
      }
     .chhs{
        width:30%;
        line-height:20px;
        text-align:center;
        padding-left:30px;
     }
    .chhA{
        padding:0px 10px 0px 0px;
        text-align:left;
    }
	#bot{
		width:100%;
        text-align:center;
        position:fixed;
        bottom:20px;
	}
	#stop{
		width: 65%;
		height: 40px;
		border-radius: 5px;
		background-color:lightgreen;
        color:white;
        font-size:15px;
    }
	#refresh{
		width: 25%;
		height: 40px;
		border-radius: 5px;
		background-color:rgb(106,142,244) ;
		margin-left:2% ;
        color:white;
        font-size:15px
	}
    .disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.6;
	}
    .hidden{
        display:none;
      }
    #mask{
      	position:absolute;
        left:0px;
        top:-20px;
        width:100%;
        height:630px;
        background-color:rgba(80,80,80,0.3);
      }
		</style>
	</head>
	<body>
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
		<div id="top">
			<div class="prg-cont rad-prg" id="indicatorContainer">
               <div class="rad-con">
                 <p id = "msg">开始充电</p>
               </div>
		    </div>
        </div>
		<div id="mid">
			<div style="overflow: hidden;">
              <div class="mid_top_right" style="margin:0px 30px; text-align:left;" id="cpid">充电桩编号：----</div>
                <div class="mid_top_left" style=" text-align:left;">
                    <span class="ch" >充电单价(元/度)：</span>
                    <span class="ch" id="price">0.00</span>
                </div>
                <div class="mid_top_left" style=" text-align:left;">
                   <span class="ch" >充电计时(分)：</span>
                   <span class="ch" id="time">0.00</span>
                </div>
                <div class="mid_top_left" style=" text-align:left;">
                    <span class="ch" >计费金额(元)：</span>
                    <span class="ch" id="fee">0.00</span>
                </div>
                <div class="mid_top_left" style=" text-align:left;">
                    <span class="ch" >已充电量(度)：</span>
                    <span class="ch" id="quantity">0.00</span>
                </div>
            </div>
         <div style="overflow:hidden">
              	<div class="l mid_top_left">
				<div id="" style="visibility: hidden;">电压(伏)：</div>
                <div id="" class="">电压(伏)：</div>
				<div id="">电流(安)：</div>
		 </div>
		<div class="m">
			<div id="">A相</div>
			<div id="V">0.00</div>
			<div id="A">0.00</div>
		</div>
		<div class="r">
			<div id="">B相</div>
			<div id="V1">0.00</div>
			<div id="A1">0.00</div>
		</div>
		<div class="rc">
			<div id="">C相</div>
			<div id="V2">0.00</div>
			<div id="A2">0.00</div>
		</div>
     </div>
     <div class="mid_top_left" style=" text-align:left;">
        <span class="mid_top_right">当前时间：</span>
        <span class="mid_top_right" id="date">--.--.-- --:--</span>
     </div>
	 </div>
		<div id="bot">
			<button id="stop" onclick="stopCount()">开始充电</button>
			<button id="refresh" class="" onclick="refreshCount()">退款</button>
		</div>
	</body>
    <script type="text/javascript">
        //全局变量
         var Ajaxs;
         var payMode = 4;
         var openId;
         var cpid = 0;
         var money = 0;
         var c = 0.01;
       	 var t;
         var timer_is_on = 0;//定时器关闭
    	// var urlM = "http://116.236.237.244:8080/SuperBackManage/";
         var urlM = "http://139.129.194.195:8080/SuperBackManage/";
         var h = 0, min = 0 , s = 1;
         var chargeState;
         var out_trade_no;//商户订单号
         var serialNo;//流水号
         var wrongCount = 0;
         var btn = 0;

         var failCount = 0;
         var sDate;
      //动画初始值
      $('#indicatorContainer').radialIndicator({
                barColor: '#007aff',
                barWidth: 5,
                initValue: 0,
                roundCorner : false,
                percentage: true,
                displayNumber: false,
                radius: 70
       });
    	//解析本地的URL，获取参数
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }
        //获取传参数
       cpid = getQueryString("cpid");
       openId = getQueryString("openId");
       payMode = getQueryString("payMode");
       money = getQueryString("money");
       out_trade_no = getQueryString("outTradeNo");
       document.getElementById("cpid").innerHTML = "充电桩编号:"+cpid;
       

       //日志
        function Loggert(t){
         	var ajax = $.ajax({type:"GET",url:urlM+"wechatUserManager/logger",dataType:"json",
                data:{content:"returnWechatLogger"+openId+"===="+t},
                success:function(data){console.log("成功");},
                error: function(jqXHR) {console.log("失败");}
            });
        }
/*
	此处为防止用户点击浏览器刷新按钮，造成chargeState状态不同步后台实际状态，需重新加载用户状态。
*/
       //请求用户状态
     getUserState(openId);
     function getUserState(openId){
        $("#mask").removeClass("hidden");
        $("#bot").addClass("disabled");
        var ajax = $.ajax({type:"GET",url:urlM+"wechatUserManager/getUserState",dataType:'json',data:{openId:openId},
            success: function(data) {
                if(data.returnCode==0){
				    chargeState = data.chargeState;
                    // chargeState = 2;
                    Loggert('init html success cpid==='+cpid+'===openid=='+openId+'==payMode==='+payMode+'==money=='+money+'==out_trade_no=='+out_trade_no);
                    isChargeState();//判断用户状态
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
                alert("服务器通信异常");
        	},
      	});
      }
   //判断当前的状态
    function isChargeState(){
    	if(chargeState == 1 ){//非空闲状态
        	 Loggert("Now,there is charging state!!!");
        	 timer_is_on = 1;
       		 startCount();
        }else if(chargeState == 2 ){
             timer_is_on = 0;
             removeMask();
        }
        else{
            //添加蒙版
            addMask();
            // alert(chargeState);
        }
    }
        //启动动画函数
       function sCharging(val){
             var radObj = $('#indicatorContainer').data('radialIndicator');
             radObj.animate(1500);
       }
       //定时器事件
       function timedCount(){
          //检测定时器状态
          if(timer_is_on == 1 && chargeState == 1){
           //请求实时数据
            getdata();
            t = setTimeout(function(){ timedCount() }, 10000);
          }
        }
        //启动动画开始刷新
        function startCount(){
            if (timer_is_on == 1) {
                timedCount();
                sCharging(100);//启动动画
            }
        }

        //添加蒙版
        function addMask(){
            $("#mask").removeClass("hidden");
            $("#bot").addClass("disabled");
            $("#stop").addClass("disabled");
            $("#refresh").addClass("disabled");
        }
        //移除蒙版
        function removeMask(){
            $("#mask").addClass("hidden");
            $("#bot").removeClass("disabled");
            $("#stop").removeClass("disabled");
            $("#refresh").removeClass("disabled");
        }
        //点击左边按钮的方法
        //判断：定时器关闭状态，则开始充电
		function stopCount() {
			if(timer_is_on == 0){
                //添加蒙版
                addMask();
                btn = 1;
                Loggert("wechat startCharge click button");
                startCharge();//开始充电
            }else{//结束充电
                x = confirm( "是否确定结束充电?");
                count = 0;
                if(x == true){
                    //添加菊花蒙版
                    addMask();
                    timer_is_on = 0;
                    Loggert("wechat stopCharge click button");
                    stopCharge(count);//发送停止充电的命令
                }
		 }
       }
        //点击右边按钮刷新
		function refreshCount(){
            //alert("测试环境"+chargeState+"canshu=="+openId);
            if(chargeState == 1){
                 getdata();
            }else if(chargeState == 2){
          		 x = confirm( "是否确定退款?");
               if(x == true){
                   addMask();
                   changeState();
                }else{}
            }else{
                alert("已经结束充电");
                getSerialNo();
            }
		}
       //开始充电
        function startCharge(){
        ajax = $.ajax({type: "GET",url: urlM+"scanCharge/startCharge",dataType:'json',data:{userId:openId,platform:1},
			success: function(data) {
                 removeMask();
                 console.log("json="+JSON.stringify(data));
                //  data.returnCode = 0;
                 if(data.returnCode == 0) {
                     timer_is_on = 1;
                     chargeState = 1;
           			 document.getElementById("stop").innerHTML = "结束充电";
                     document.getElementById("msg").innerHTML = "正在充电";
                     document.getElementById("refresh").innerHTML = "刷新";
       			     startCount();//开始充电计时
                     sDate = new Date();//记录开始充电的时间
                     Loggert("startCharge Success!!!："+openId+"========"+money+"=="+out_trade_no);
                 }else if(data.returnCode == 4){
                     alert("充电桩没有插枪！");
                     Loggert("charge Pile is out-gun!!!："+openId+"========"+money+"=="+out_trade_no);
                 }else if(data.returnCode == 6){
                     alert("充电桩离线，稍后再试！");
                     Loggert("charge Pile is off-line!!!："+openId+"========"+money+"=="+out_trade_no);
                 }else{
                     alert("充电桩启动失败,请重试");
                     Loggert("startCharge failed!!!："+openId+"========"+money+"=="+out_trade_no);
                }
			},
			error: function(jqXHR) {
                failCount = failCount + 1;
                    removeMask();
					if(failCount == 3){
                         alert("此次充电检测到异常，可以点击退款按钮退款");
                         failCount = 0;
                     }else{
                         alert("操作超时,请重试");
                         Loggert("jqXHR===="+JSON.stringify(jqXHR));
                         alert("jqXHR===="+JSON.stringify(jqXHR));
                         console.log("jqXHR===="+JSON.stringify(jqXHR));
                    }
       		    },
      		 });
		}
          //停止充电
       var stopFlags = 0;
       function stopCharge(count){
            timer_is_on = 0;//关闭定时器
            var endDate = new Date();
            var ajaxs = $.ajax({type: "GET",url: urlM+"scanCharge/stopCharge",dataType:'json',data:{userId:openId,platform:1},
              success: function(data) { //data就是返回的json数据
               removeMask();
               timer_is_on = 1;
               if(data.returnCode == 0){
                   clearTimeout(t);
                   timer_is_on = 0;
                   chargeState = 0;
                   document.getElementById("stop").innerHTML = "开始充电";
                   document.getElementById("msg").innerHTML = "开始充电";
                   document.getElementById("refresh").innerHTML = "退款";
                   count =0;
                   addMask();
                   getSerialNo(endDate);
                   var radObj = $('#indicatorContainer').data('radialIndicator');
                   radObj.animate(0);
                   Loggert("stopCharge Success!!!："+openId+"========"+money+"=="+out_trade_no);
                   return;
               }else if(data.returnCode == 1){
                   alert("充电桩停止错误，请重试");
                   stopFlags = stopFlags+1;
                   var seDate = endDate.getTime()-sDate.getTime();
                   var seDateMin = seDate/(1000*60);
                   if(stopFlags>2 && seDateMin < 2){
                     chargeState = 2;
                     timer_is_on = 0;
                     addMask();
                     changeState();
                   }else if(stopFlags>2 && seDateMin > 2){
                     addMask();
                     changeUserState();
                   }else{

                   }
                   Loggert("stopCharge returnCode == 1!!!："+openId+"========"+money+"=="+out_trade_no);
               }else {
                   alert("充电桩停止失败,请重试");
                   Loggert("stopCharge failed!!!："+openId+"========"+money+"=="+out_trade_no);
                   removeMask();
                   
               }
             },
             error: function(jqXHR) {
                   timer_is_on = 1;
                   // alert("发生错误json="+JSON.stringify(jqXHR));
                   alert("网络发生错误");
                   Loggert("stopCharge ajax error!!!："+openId+"========"+money+"=="+out_trade_no);
                   removeMask();
                   var seDate = endDate.getTime()-sDate.getTime();
                   var seDateMin = seDate/(1000*60);
                   if(stopFlags>2 && seDateMin < 2){
                     chargeState = 2;
                     timer_is_on = 0;
                     addMask();
                     changeState();
                   }else if(stopFlags>2 && seDateMin > 2){
                     addMask();
                     changeUserState();
                   }else{
                       
                   }
       		    },
       		});

         }

          //获取流水号
          function getSerialNo(endDate){
            	var ajax = $.ajax({type: "GET",url: urlM+"scanCharge/getSerialNo",dataType:'json',data:{userId:openId,platform:1},
                    success: function(data) { //data就是返回的json数据
                        removeMask();
                        timer_is_on = 1;
                        Loggert("get getSerialNo==="+JSON.stringify(data));
                        if(data.returnCode == 0) {
                            serialNo = data.serialNo;
                            location.href = "chargeFinish.php?serialNo="+serialNo+"&userId="+openId;
                        }else if(data.returnCode == 1){
                            addMask();
                            alert(data.message);
                            var seDate = endDate.getTime()-sDate.getTime();
                            var seDateMin = seDate/(1000*60);
                            if (seDateMin < 2) {
                               chargeState=2;
                               timer_is_on = 0;//关闭定时器
                               changeState();
                               return;
                             }else{
                                changeUserState();
                             }
                        }else {
                            alert("网络延迟，账单请查看充电记录");
                            addMask();
                           var seDate = endDate.getTime()-sDate.getTime();
                           var seDateMin = seDate/(1000*60);
                           if (seDateMin < 2) {
                             chargeState=2;
                             timer_is_on = 0;//关闭定时器
                             changeState();
                           }else{
                            changeUserState();
                           }
                        }
                    },
                    error: function(jqXHR) {
                        timer_is_on = 0;
                        removeMask();
                        Loggert("php======="+JSON.stringify(jqXHR));
                        alert("网络异常，账单以充电记录为准");
                        var seDate = endDate.getTime()-sDate.getTime();
                        var seDateMin = seDate/(1000*60);
                        if (seDateMin < 2) {
                             chargeState=2;
                             timer_is_on = 0;//关闭定时器
                             addMask();
                             changeState();
                        }else{
                             WeixinJSBridge.call('closeWindow');
                        }
                    },
                });

            }

/*
 *     请求退款
 *     判断用户状态为已付款但未启动充电的状态才可以退款，即chargeState=2的前提下
 */
    function refund(){
        if(chargeState != 2) return;
         //上线环境
        var total = money * 100;
        var refund_fee = money * 100;
        $("#mask").removeClass("hidden");
        if(out_trade_no && total && refund_fee){
            var ajax = $.ajax({
                type:"GET",
            	url:"refund.php",
                dataType:"json",
                data:{
                    out_trade_no:out_trade_no,
                    refrund_fee:refund_fee,
                    total_fee:total
                },
                success:function(data){
                     addMask();
                     Loggert("refund success"+JSON.stringify(data));
                     if(data[3].result_code == "SUCCESS"){
                        sendRefundRes(out_trade_no,money,money,"SUCCESS");
                     }else if(data[3].result_code == "FAIL"){
                        // alert("退款通知："+data[3].result_code);
                        sendRefundRes(out_trade_no,money,money,"FAIL");
                        
                     }
                     else{
                        // alert("退款通知："+data[3].result_code);
                        sendRefundRes(out_trade_no,money,money,"FAIL");
                        
                     }
                },
                error: function(jqXHR) {
            		 alert("退款发生错误,退出公众号，重试");
                     Loggert("refund Fail："+JSON.stringify(jqXHR));
                     WeixinJSBridge.call('closeWindow');
                }
            });
        }else{
            $("#mask").addClass("hidden");
            Loggert("refund error money and tradeNo："+money+"=="+out_trade_no);
            sendRefundRes(out_trade_no,money,money,"FAIL");
            alert("订单异常");
         }
    }
       //重置用户状态
     function changeState(){
         var ajax = $.ajax({
             type: "GET", // 请求方式
             url: urlM+"scanCharge/resetOpenIdState", // 请求地址
             dataType:'json',
             data:{
                 openId:openId
             },
             success: function(data) { //data就是返回的json数据
             //返回订单号以及订单金额
                 var detail = data.detail;
                 var info = detail.info;
                 out_trade_no = info[0].tradeNo;
                 money = info[0].payMoney;
                 refund();
                 Loggert("user cancel order");
                
             },
             error: function(jqXHR) {
                 alert("订单取消发生异常，请联系客服");
                 WeixinJSBridge.call('closeWindow');
                
             },
         });
     }

        //网络请求ajax 刷新数据
	function getdata(){
        if(timer_is_on != 1) return;
		Ajaxs = $.ajax({type: "GET",url: urlM+"/scanCharge/getChargeStatus",dataType:'json',async: false,timeout:0,data:{userId:openId,platform:1},
		success: function(data) {
            console.log("json="+JSON.stringify(data));
            Loggert("json="+JSON.stringify(data));
            var detail = data.detail;
            var chargeInfo = detail.chargeInfo;
			if(data.returnCode == 0) {
                var chargeData = chargeInfo[0];
                removeMask();
                var radObj = $('#indicatorContainer').data('radialIndicator');
                radObj.animate(100);
                document.getElementById("V").innerHTML =  chargeData.voltageA;
                document.getElementById("V1").innerHTML = chargeData.voltageB;
                document.getElementById("V2").innerHTML = chargeData.voltageC;
				document.getElementById("A").innerHTML = chargeData.currentA;
                document.getElementById("A1").innerHTML = chargeData.currentB;
                document.getElementById("A2").innerHTML = chargeData.currentC;
				document.getElementById("fee").innerHTML = chargeData.fee;
                document.getElementById("time").innerHTML = chargeData.chargeDuration;
				document.getElementById("quantity").innerHTML = chargeData.quantity;
                document.getElementById("price").innerHTML = chargeData.price;
                var ts = new Date();
                var td = ts.getDate();//day
                var ty = ts.getFullYear();//
                var tm = ts.getMonth() + 1;
                var th = ts.getHours();
                var tmin = ts.getMinutes();
                var tsd = ts.getSeconds();
                var dtime = ty+"-"+(tm<10 ? "0" + tm : tm)+"-"+(td<10 ? "0"+ td : td)+"&nbsp"+(th<10 ? "0"+ th : th)+":"+(tmin<10 ? "0" + tmin : tmin)+":"+(tsd<10 ? "0" +tsd : tsd);
				document.getElementById("date").innerHTML = dtime;
                document.getElementById("msg").innerHTML = "正在充电";
                document.getElementById("stop").innerHTML = "结束充电";
                document.getElementById("refresh").innerHTML = "刷新";
                var abc = chargeData.command=="finish";
                var cba = chargeData.voltageA == 0 && chargeData.voltageB == 0 && chargeData.voltageC == 0;
                if(abc == true){
                    location.href = "chargeFinish.php?serialNo="+chargeData.serialNo+"&userId="+openId;
                    return;
                }
                if(cba == true){
                    var xl = confirm("检测到充电桩离线，是否立即结束充电？");
                    if(xl == true){
                        changeState();
						alert("稍后会根据账单结算退款");
                        return;
                    }else{
                        alert("请耐心等待");
                        return;
                    }
                }
			}else if(data.returnCode == 1){
                $("#mask").addClass("hidden");
                $("#bot").removeClass("disabled");
                getdata();
                return;
            }else if(data.returnCode == 2){
                alert("参数错误");
                removeMask();
                Loggert("canshucuowu ==："+openId+"========"+money+"=="+out_trade_no);
                return;
            }else if(data.returnCode = 13){
                alert("没有找到充电桩");
                removeMask();
                Loggert("no cpid == ："+openId+"========"+money+"=="+out_trade_no);
                return;
            }else {
				alert("充电桩故障");
                removeMask();
                Loggert("pile is wrong!!!："+openId+"========"+money+"=="+out_trade_no);
                return;
			}
		},
		error: function(jqXHR) {
            $("#mask").addClass("hidden");
            $("#bot").removeClass("disabled");
            alert("网络通信出现异常,未获取到实时数据!");
            //WeixinJSBridge.call('closeWindow');
        },
       });
    }
    if (typeof window.addEventListener != "undefined") {
        window.addEventListener("popstate", function (e) {
            if(btn == 0){
                x = confirm("是否确认退出");
                if(x == true){
                    WeixinJSBridge.call('closeWindow');
                }else{

                }
            }else{
           	    WeixinJSBridge.call('closeWindow');
            }
        }, false);
    } else {
          window.attachEvent("popstate", function (e) {
             if(btn == 0){
                x = confirm("是否确认退出");
                if(x == true){
                     WeixinJSBridge.call('closeWindow');
                }
            }else{
           	 WeixinJSBridge.call('closeWindow');
            }
          });
    }
    pushHistory();
    function pushHistory() {
        var state = {
            title: "title",
            url: "#"
        };
        window.history.pushState(state, "title", "#");
    }

    $(function() {
        wx.config({
            debug: false,
            appId: '<?php echo $signPackage["appId"];?>',
    		timestamp: '<?php echo $signPackage["timestamp"];?>',
    		nonceStr: '<?php echo $signPackage["nonceStr"];?>',
   			signature: '<?php echo $signPackage["signature"];?>',
            jsApiList: [// 所有要调用的 API 都要加到这个列表中
                "closeWindow",
            ]
        });
        wx.ready(function() {
            wx.hideOptionMenu();
        });
        if (typeof window.addEventListener != "undefined") {
            window.addEventListener("popstate", function(e) {
                if(btn == 0){
                    x = confirm("是否确认退出");
                    if(x == true){
                        wx.closeWindow();
                        return;
                    }
                    }else{
                        wx.closeWindow();
                    }
            }, false);
        } else {
            window.attachEvent("popstate", function(e) {
                if(btn == 0){
                    x = confirm("是否确认退出");
                    if(x == true){
                        wx.closeWindow();
                        return;
                    }
                }
                wx.closeWindow();
            });
        }
    });


//点击退款按钮确认用户状态
  function getChargeState(openId){
        ajax = $.ajax({type:"GET", url:urlM+"wechatUserManager/getUserState", dataType:'json',data:{openId:openId},
        success: function(data) {
            if(data.returnCode==0){
                chargeState = data.chargeState;
                //检查订单信息
                changeState();
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
            alert("网络故障，服务器通信异常");
        },
      });
    }
        //充电过程中检测到离线
        function changeUserState(){
        	var ajax = $.ajax({
                type: "GET",
                url: urlM+"scanCharge/resetOpenIdState",
                dataType:'json',
                data:{
                    openId:openId
                },
                success: function(data) {
                    removeMask();
                    var detail = data.detail;
                    var info = detail.info;
                    Loggert("change User State");
                    WeixinJSBridge.call('closeWindow');
                },
                error: function(jqXHR) {
                    removeMask();
                    alert("订单结算发生异常，请联系客服");
                },
            });
         }

 //完成退款改变订单状态
        function sendRefundRes(out_trade_no,money,refund_fee,status){
            var des = status
            status = status=="FAIL"?0:1;//转成数字
            var now=new Date();
            var timeStamp = now.getFullYear()+"-"+
                            (now.getMonth()+1)+"-"+now.getDate()+" "+
                            now.getHours()+":"+
                            now.getMinutes()+":"+
                            now.getSeconds();
            var Ajax = $.ajax({
                    type:"GET",
                    url: urlM + "scanCharge/updateRefund",
                    dataType:'json',
                    async : false,
                    data:{
                        tradeNo:out_trade_no,
                        refundTime:timeStamp,
                        money:refund_fee,
                        status:status,
                        desp:des
                    },
                    success: function(data) {
                        console.log(JSON.stringify(data));
                        status = status==1?"成功":"失败";
                        alert("退款通知："+status);
                        WeixinJSBridge.call('closeWindow');
                    },
                    error: function(jqXHR) {
                        Loggert("请求发生错误,服务器通信异常");
                        WeixinJSBridge.call('closeWindow');
                    },
            });
    }
	</script>
</html>