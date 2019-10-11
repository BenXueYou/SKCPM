
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
        <link href="../CSS/circle.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="../JS/jquery-3.0.0.min.js" ></script>
        <script type="text/javascript" src="../JS/cookie.js" ></script>
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
	<script src="../JS/my-js/payOrder.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="../senk-shop/js/my-js/logs.js" ></script>
	<script type="text/javascript">
  <?
     	require_once "wx_pay/lib/WxPay.config.php";
     	$url = WxPayConfig::TESTURL;
     	$openid = "oR9d21lZxSloF2iQtPHjdRAdy-2o";
  ?>
        //全局变量
          	var index;
			var money;
			var chargeWayIndex=0;
         	var cpid="";
            var urlM = '<?php echo $url; ?>';
       		var openId;
            var payMode=4;
           	var chargeState=0;
            var outTradeNo=0;
			var dcChargeMode = 0;
			var payState = 0;
			var OP="";
			var Order="";
			var OD="";

        //解析本地的URL，获取参数
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }
        
$(document).ready(function(){
    
    //获取传参数

        openId = getQueryString("openId");
        var obj = getQueryString('cpObj');
		var cpObj = JSON.parse(unescape(obj));
		console.log(JSON.stringify(cpObj));
		var cp = cpObj.cp;
		var cptype = cp[0].cptype;
		var cpid =  cp[0].cpid;
		var cs = cp[0].location;
		//初始化界面
		initHtml(cs,cpid,cptype);
		$("#bottom").click(function()
		{
			if(index == undefined){
				alert("你还未设置充电金额");
				
			}else{
	          	if(index == 3){//自定义输入
	           		var inputData = document.getElementById("middle_input").value;
	                money = inputData.substring(0,2);
	            }else{
	           		var x = $(".btn");//菜单对象
                    var indexy = index + chargeWayIndex*4;//菜单被选中的下标记
                    var xhtmlObj = x[indexy];//菜单中携带信息
                    var xhtml = xhtmlObj.innerHTML;
                    money = xhtml.substring(0,xhtml.length-1);
                }
               if(isInteger(money) && money != 0 && money != ""){//检查输入的金额是否合法
                	     var val_cpVoltage = $('#wrap input[name="cpVoltage"]:checked ').val();
                	     //检查充电桩的类型
				     if(cptype == '直流' && (val_cpVoltage != 12 && val_cpVoltage != 24)){
				     	  alert("直流桩，请选择桩类型");
						  return;
				     }else if(cptype == '直流' && val_cpVoltage == 24){
							dcChargeMode = 1;
					 }else{
						dcChargeMode = 0;
					 }
                    //检查是否有未提交的订单
				    $("#mask").removeClass("hidden");
				    Order = new OrderPay(openId,money,money,urlM);
					if(payState==0){//向微信统一下单
						getOrderToWechat(money,cpid);
					}else if(payState==10){//已下单重新支付
						sendPay(OP,Order);
					}else if(payState==100){
						//检查支付结果
						if(Order.getOrderWechatResult(cpid,openId,money,dcChargeMode)){
							console.log("first check Order======"+outTradeNo);
							if(Order.orderSetMode(cpid,openId,money,dcChargeMode))
                         	location.href='charge.php?cpid='+cpid+'&openId='+openId+"&chargeState="+chargeState+"&payMode="+payMode+"&money="+money+"&outTradeNo="+outTradeNo;
						}else{
							console.log("支付失败");
						}
					}else{
						alert("请退出重新扫码");
					}
               }else{
                        alert("支付金额必须大于0且为整数");
               }
           }
      });
});
        
function initHtml(cs,cpid,cptype){
	document.getElementById("cs").innerHTML = cs;
	document.getElementById('cpid').innerHTML = cpid;
	$("#middle_input").attr("value","");
	if(cptype == '直流'){
		$('#type').addClass('hidden');
		$("#wrap").removeClass('hidden');
	}else{
		$('#type').removeClass('hidden');
		$("#wrap").addClass('hidden');
	}
}

//生成订单并支付

function getOrderToWechat(total,cpid){
	alert(cpid);
	OD = new OrderPay(openId,total,total,urlM);
	OP = Order.getWechatUnifiedOrder(openId,total,cpid);
	if(OP != "")
	patState=10;
	var payRes = Order.orderSetMode(cpid,openId,money,dcChargeMode);
	if(payRes){
           location.href='charge.php?cpid='+cpid+'&openId='+openId+"&chargeState="+chargeState+"&payMode="+payMode+"&money="+money+"&outTradeNo="+outTradeNo; 	
	}else{
		console.log("订单提交失败");
	}
//	sendPay(OP,OD);
	
}
     function sendPay(OP,order){
     	console.log("apply wechat pay order mobile API!!!"+outTradeNo);
        function onBridgeReady(){
              WeixinJSBridge.invoke(
                'getBrandWCPayRequest', {
                           "appId": OP.appId,     //公众号名称，由商户传入
                           "timeStamp": OP.timeStamp, //时间戳，自1970年以来的秒数
                           "nonceStr" : OP.nonceStr, //随机串
                           "package" :  OP.package,
                           "signType" : "MD5", //微信签名方式：
                           "paySign" : OP.paySign //微信签名
                       },
                 function(res){
                       	patState=100;
						if(res.err_msg == "get_brand_wcpay_request:ok" ){
							var payRes = order.orderSetMode(cpid,openId,money,dcChargeMode);
							if(payRes){
                         		location.href='charge.php?cpid='+cpid+'&openId='+openId+"&chargeState="+chargeState+"&payMode="+payMode+"&money="+money+"&outTradeNo="+outTradeNo; 	
							}else{
								console.log("订单提交失败");
								var log = new setLoggle("openid==="+openId+"==out_trade_no=="+outTradeNo+"====des=="+"订单提交失败","../admin/logs/log_info.php");
							}
						} // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。 
       					else{
       						var payRes = order.getOrderWechatResult(cpid,openId,money,dcChargeMode);
       						if(payres){
       							if(order.orderSetMode(cpid,openId,money,dcChargeMode)){
       								location.href='charge.php?cpid='+cpid+'&openId='+openId+"&chargeState="+chargeState+"&payMode="+payMode+"&money="+money+"&outTradeNo="+outTradeNo; 
       							}else{
       								alert("支付失败");
       							}
       						}else{
       							alert("支付失败");
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

//点击菜单设置充电方式
		$(".btn").on("click",function(){

			$(this).addClass("active").siblings().removeClass("active");
              var sbtitle=$(".middle");
				if($(this).index() == "3"){
	     			if(sbtitle.length){
	       				sbtitle.show();
					}
               }else{
                    $("#middle_input").attr("value","");//
                    sbtitle.hide();
                }
                index = $(this).index();
			
		});
//判断是否为整数
      function isInteger(obj) { return obj%1 === 0}       
	</script>
</html>
