
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-control" content="no-cache">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
		<title>实时支付</title>
         <link rel="icon" href="../../../img/logo.png" type="image/x-icon"/>
         <link href="../../CSS/circle.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="../../JS/jquery-3.0.0.min.js" ></script>
        <script type="text/javascript" src="../../JS/cookie.js" ></script>
		<style type="text/css">
			*{padding: 0;margin: 0;}
				body{
				background-color:#D3D3D3;
				background-color:#D8D8D6;
			}
			.top{
				background-color:white ;
				color: black;
				padding:10px ;
				margin-bottom: 15px;
			}
			.topmsg{
				text-align: center;
			}
			.topmsg_desc{
				padding: 0 10%;
			}
			.middle{
				display: none;
				background-color:white ;
				color: black;
				margin-bottom: 15px;
				padding:5px 15px  20px;
			}
			.money button{
				margin: 10px 1%;
				width: 20%;
				height: 30px;
			}
			.middleDetail{
				width: 30px;
				margin: 10px 20%;
			}
            #middle_input{
            	width:50%;
                height：30px;
                line-height:30px;
                font-size:12px;

                text-align:center;
            }
			#pointOut{
				color: #1DB1FF;
				padding: 12px;
				font-size:12px!important;
			}
			#bottom{
				width: 50%;
				height: 50px;
				padding: 0px;
				margin:0 24.5%;
				background-color: #299DFF;
				font-size:18px ;
				color: white;
				border: 1px solid grey;
			}
			.active{background: #299DFF;}
			.hidden{
				display: none;
			}
             #mask{
            	position:absolute;
                left:0px;
                top:-20px;
                width:100%;
                height:600px;
                background-color:rgba(80,80,80,0.3);
            }
            label{
            	margin:0 15%;
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


		<div class="top">
			<div class="topmsg">订单信息</div>
			<div class="money topmsg_desc">
				<div>站点：<span id='cs'>--</span></div>
				<div>桩编号：<span id='cpid'>--</span></div>
				<div>桩类型：
                    <span class='hidden' id='type'>交流桩</span>
                    <div id="wrap" class="hidden">
                    	  <label><input name="cpVoltage" type="radio" value="12" />12V </label>
                      <label><input name="cpVoltage" type="radio" value="24" />24V </label>
                    </div>
                </div>
			</div>
		</div>
		<div class="top">
			<p class="topTitle">请选择金额</p>
			<div class="money">
				<button class="btn">10元</button>
				<button class="btn">20元</button>
				<button class="btn">30元</button>
				<button class="btn" value="4">自定义</button>
			</div>
		</div>
		<div class="middle">
			<p class="middleTitle">自定义金额</p>
			<span class="middleDetail"><input placeholder="请输入金额" id="middle_input"/>元</span>
		</div>
		<p id="pointOut" class="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如电量已充满或者其他意外情而停止充电，导致充电未完成系统会自动退回剩余充电金额到您的支付账户。(该退款可能会有延时，若延时超过8小时，请联系客服人员。)</p>
		<button id="bottom">确定</button>
	</body>
	<script type="text/javascript">

        //全局变量
        	var index;
			var money;
			var chargeWayIndex=0;
         	var cpid="";
            var urlM = "http://116.236.237.244:8080/SuperBackManage/";
			// var urlM = "http://139.129.194.195:8080/SuperBackManage/";
       		var openId;
            var payMode=4;
           	var appid="wx32a40fe9e54cc1c8";
           	var nonceStr;
           	var package;
           	var signType;
           	var paySign;
          	var timeStamp;
           	var chargeState=0;
            var outTradeNo=0;
			var dcChargeMode = 0;
			var payState = 0;

        //解析本地的URL，获取参数
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }
        //获取传参数
        cpid = getQueryString("cpid");
		cpid = "1401050000000001";
        openId = getQueryString("openId");
		openId = "oR9d21j7qfYgKMj0Lat1r1g8Y8Ng";
        chargeState = getQueryString("chargeState");
        var obj = getQueryString('cpObj');
		var cpObj = JSON.parse(unescape(obj));
		var cp = cpObj.cp;
		var cptype = cp[0].cptype;

      	//初始化界面
		initHtml();
		function initHtml(){
			$("#cs").val();
			$("#cpid").val([0].cpid);
			document.getElementById("cs").innerHTML = cp[0].location;
			document.getElementById('cpid').innerHTML = cp[0].cpid;
			$("#middle_input").attr("value","");
			if(cptype == '直流'){
				$('#type').addClass('hidden');
				$("#wrap").removeClass('hidden');
			}else{
				$('#type').removeClass('hidden');
				$("#wrap").addClass('hidden');
			}
		}

    //点击确定按钮发起订单支付流程。
		$(document).ready(function()
		{
			$("#bottom").click(function()
			{
                if(chargeWayIndex == 0){//是否选择自动充满
                   if(index == undefined){
                   		alert("你还未设置充电金额");
                   }else{
                        if(index == 3){//自定义输入
                              var inputData = document.getElementById("middle_input").value;
                              money = inputData.substring(0,2);
                        }else{
                             var x = $(".btn");//二级菜单对象
                             var indexy = index + chargeWayIndex*4;//二级菜单被选中的标记
                             var xhtmlObj = x[indexy];//二级菜单中携带信息
                             var xhtml = xhtmlObj.innerHTML;
                             money = xhtml.substring(0,xhtml.length-1);
                        }
                       if(isInteger(money) && money != 0 && money != ""){
						   var val_cpVoltage = $('#wrap input[name="cpVoltage"]:checked ').val();
						   if(cptype == '直流' && (val_cpVoltage != 12 && val_cpVoltage != 24)){
							   alert("直流桩，请选择桩类型");
							    return;
						    }else if(cptype == '直流' && val_cpVoltage == 24){
								dcChargeMode = 1;
							}else{
								dcChargeMode = 0;
							}
                         
						    $("#mask").removeClass("hidden");

							if(payState==0){//向微信统一下单
								getOrderToWechat(money);
							}else if(payState==10){//已下单重新支付
								sendPay();
							}else if(payState==100){
								//调起支付，检查支付结果
								if(getOrderWechatResult()){
									Loggert("first check Order======"+outTradeNo);
									setMode();
								}else{
									if(getOrderWechatResult()){
										Loggert("check Order again====="+outTradeNo);
										setMode();
									}else{
										Loggert("check Order result is failed======="+outTradeNo);
										refund();
									}
								}
							}else{
								alert("请退出重新扫码");
							}

                      		

                        }else{
                            alert("支付金额必须大于0且为整数");
                        }
                   }
                }
			});

 //下单
         function getOrderToWechat(e){
         	var ajax = $.ajax({
                type:"GET",
             	url:"../wx_pay/WechatPay/test/test_wxPayOrder.php",
                dataType:"json",
                data:{
                    openId:openId,
                    total_fee:money
                },
                success:function(data){
                    console.log(data);
                    //日志传输
                    Loggert("get wechat pay order success!!!"+JSON.stringify(data));
					alert("get wechat pay order success!!!"+JSON.stringify(data));
                    outTradeNo = data[0];
                    var order = data[1];
					console.log(JSON.stringify(data));
					appid = order.appId;
            		nonceStr = order.nonceStr;
                    package = order.package;
                    signType = order.signType;
                    paySign = order.paySign;
                    timeStamp = order.timeStamp;
                   //调起微信支付接口
				    payState = 10;
					if(appid == null || nonceStr == null || package==null || signType==null || paySign==null){
						alert("登录的账号异常！");
						return;
					}

                    sendPay();
                },
                error: function(jqXHR) {
            		 alert("下单发生错误");
                     console.log(jqXHR+"下单发生错误："+JSON.stringify(jqXHR));
					 Loggert("get wechat pay order error!!!"+JSON.stringify(jqXHR));
                }
            });
         }

         function sendPay(){
			Loggert("apply wechat pay order mobile API!!!"+outTradeNo);
            function onBridgeReady(){
                   WeixinJSBridge.invoke(
                       'getBrandWCPayRequest', {
                           "appId": appid,     //公众号名称，由商户传入
                           "timeStamp": timeStamp, //时间戳，自1970年以来的秒数
                           "nonceStr" : nonceStr, //随机串
                           "package" :  package,
                           "signType" : "MD5", //微信签名方式：
                           "paySign" : paySign //微信签名
                       },
                       function(res){
						    $("#mask").removeClass("hidden");
							payState=100;
							if(getOrderWechatResult()){
							    Loggert("first check Order======"+outTradeNo);
								setMode();
							}else{
								if(getOrderWechatResult()){
									Loggert("check Order again====="+outTradeNo);
									setMode();
								}else{
									Loggert("check Order result is failed======="+outTradeNo);
									refund();
								}
							}
                       }
                   );
                }
                if (typeof WeixinJSBridge == "undefined"){
                   if( document.addEventListener ){
                       document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                   }else if (document.attachEvent){
                       document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                       document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                   }
                }else{
                   onBridgeReady();
                }
            }
       $(".middleDetail input").focus(function(){
         index=3;
       	 $(".btn").removeClass("active");

       });

//支付成功返回的结果
		function getOrderWechatResult(){
			var result = false;
         	var ajax = $.ajax({
                type:"GET",
             	url:"wx_pay/WechatPay/getPayOrderRes.php",
                data:{
					out_trade_no:outTradeNo
                },
				async : false,
                success:function(data){
                    //日志传输
					if(data == "1" || data == 1){
						result = true;
						// Loggert("the getOrderWechatResult successs and tradeNo "+outTradeNo+"=openid="+openId);
					}else{
						// Loggert("the getOrderWechatResult failed and tradeNo "+outTradeNo+"=openid="+openId);
						result = false;
					}
                },
                error: function(jqXHR) {
					 $("#mask").addClass("hidden");
					 alert("订单查询失败,请记住该订单号并联系管理员"+outTradeNo);
					 Loggert("checkOrder ajax error tradeNo"+outTradeNo+"=openid="+openId);
                }
            });
			return result;
         }
   //设置充电方式
        function setMode(){
          ajax = $.ajax({
				  type: "GET", // 请求方式
				  url: urlM+"scanCharge/setChargeMode", // 请求地址
				  dataType:'json',  //jsonp:'callback',
				  async : false,
				  data:{
					deviceId:cpid,
					userId:openId,
					payMode:4,
					payValue:money,
					platform:1,
					out_trade_no:outTradeNo,
					dcChargeMode:dcChargeMode
				  },
				success: function(data) {
					 Loggert("setMode result tradeNo "+outTradeNo+"=openid="+openId);
                	//去掉蒙版
                	$("#mask").addClass("hidden");
					if(data.returnCode == 0) {
                         chargeState = 2;//开始充电
						//  Loggert("setMode success tradeNo "+outTradeNo+"=openid="+openId);
						 $("#mask").removeClass("hidden");
						 $("#middle_input").attr("value","");
						 payState=0;
                         location.href='test_charge.php?cpid='+cpid+'&openId='+openId+"&chargeState="+chargeState+"&payMode="+payMode+"&money="+money+"&outTradeNo="+outTradeNo;
						
					}else if(data.returnCode == 1){
						//  Loggert("setMode success and return fail tradeNo "+outTradeNo+"=openid="+openId);
                         alert("桩没有返回数据，操作超时,退出重新试试！！");
                    }else if(data.returnCode == 2){
						alert("桩编号错误，退出重新试试");
						// Loggert("setMode success and cpid is error tradeNo "+outTradeNo+"=openid="+openId);
                    }
					else if(data.returnCode == 13){
						// Loggert("setMode success and cpid is fault tradeNo "+outTradeNo+"=openid="+openId);
                        alert("充电桩通信故障，退出重新试试");
                    }else {
						alert("充电桩通信故障，退出重新试试");
						// Loggert("setMode success and error tradeNo "+outTradeNo+"=openid="+openId);
					}
				},
				error: function(jqXHR) {
                    $("#mask").addClass("hidden");
                    alert("网络通信异常，稍后退款");
					$("#mask").removeClass("hidden");
					Loggert("setMode ajax error tradeNo"+outTradeNo+"=openid="+openId);
					refund();
        		},
           	});
          }
/*
 *     请求退款
 */
    function refund(){

        var total = money * 100;
        var refund_fee = money * 100;
        if(outTradeNo && money){
            var ajax = $.ajax({
                type:"GET",
            	url:"refund.php",
                dataType:"json",
                data:{
                    out_trade_no:outTradeNo,
                    refrund_fee:refund_fee,
                    total_fee:total
                },
                success:function(data){
                     $("#mask").addClass("hidden");
            	     //alert("退款通知："+data[3].result_code);
					 payState=0;
					 alert("支付失败");
                     Loggert("refund success"+JSON.stringify(data)+"==out_trade_no==="+outTradeNo);
                    // WeixinJSBridge.call('closeWindow');
                },
                error: function(jqXHR) {
					 $("#mask").addClass("hidden");
					 payState=0;
            		 alert("退款发生错误："+JSON.stringify(jqXHR));
                     Loggert("refund Fail："+JSON.stringify(jqXHR)+"==out_trade_no==="+outTradeNo);
                     //WeixinJSBridge.call('closeWindow');
                }
            });
        }else{
            $("#mask").addClass("hidden");
            Loggert("refund money and tradeNo："+money+"=="+out_trade_no);
            alert("订单异常");
         }

    }

 //点击菜单设置充电方式
		   $(".btn").on("click",function(){
			$(this).addClass("active").siblings().removeClass("active");
              var sbtitle=$(".middle");
				if($(this).index() == "3"){
	     			if(sbtitle.length){
	       				sbtitle.show();
					}
               }else{
                    $("#middle_input").attr("value","");//sbtitle.hide();
                }
                index = $(this).index();
			});
		});
       //判断是否为整数
        function isInteger(obj) { return obj%1 === 0}

		//日志
        function Loggert(t){
         	var ajax = $.ajax({
                type:"GET",
            	url:urlM+"wechatUserManager/logger",
                dataType:"json",
                data:{
                  content:"returnWechatLogger"+t
                },
                success:function(data){console.log("成功");},
                error: function(jqXHR) {console.log("失败");}
            });
        }
	</script>
</html>
