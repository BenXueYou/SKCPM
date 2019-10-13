<?php
 require_once "../config.php/jssdk.php";
 $jssdk = new JSSDK("wx32a40fe9e54cc1c8","cba6f2171a8a0fb4a2c3012c65f007d3");
 $signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-control" content="no-cache">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
		<title>充电完成</title>
        <script type="text/javascript" src="../JS/jquery-3.0.0.min.js" ></script>
        <script type="text/javascript" src="../JS/radialIndicator.js" ></script>
        <link href="../CSS/circle.css" rel="stylesheet" type="text/css"/>
		<style type="text/css">
			body{background-color: rgb(245,245,245);}
			#top{
				margin: 0 auto;
				width: 250px;
				height: 190px;
			}
			#label{
                background:no-repeat;
                background-image: url(../senk_img/charging03.png);
				height: 100%;
				overflow: hidden;
				text-align: center;
				/*vertical-align: middle;*/
			}
			#top #label div{
				/*background-color:red ;*/
				margin-top: 165px;
			}
			span{
				font-size: 15px;
				color: black;
				font: '微软雅黑'; 
				/*line-height: 30px;*/
			}
			#mid{
				margin-top: 5%;
				background-color:rgb(251,251,251) ;
				text-align: center;
				overflow: hidden;
               
			}
			.ch{
				width: 90%;
				float: left;
				margin:1% 0 1% 10%;
                overflow: hidden;
                position:relative;
				/*padding: 5%;*/    
			}
			.ch span{
				display: block;
				float: left;
				/*background-color: red;*/
				margin-left:0px;
				margin-top: 1%;
				font-size: 15px;
                text-align: center;
			}
            .ch_span{
                float:right;
                position:absolute;
                right:30%;  
            }
            .value{
            	line-height:20px;
            }
            
			#bot{
				text-align: center;
				margin-top: 5%;
			}
			#drop{
				text-align: center;
				overflow: hidden;	
			}
			#stop{
				display: block;
				padding: 15px 1%;
				width: 20%;
                font-size:15px;
			 	color: black;
				/*background-color:rgb(247,192,68) ;*/
				float: left;
			}
			#clink{
				float: left;
				width: 60%;
				background-color:rgb(106,142,244) ;
                position: relative;
			}
			
			
			#upload{
				text-align: center;
			}
			#upload button{
				background-color: orange;
				width: 40%;
				height: 50px;
				line-height: 30px;
				margin: 50px auto;
				font-size: 15px;
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
			<div id="label">
				<div class = "text"><span>充电完成</span></div>
			</div>
		</div>
		<div id="mid">
			
            <div class="ch" ><span>账单编号：</span><span class="value" id="bill" style="font-size:14px">----</span></div>
            <div class="ch" ><span>支付金额：</span><span class="value" id="money">0.00</span><span class="ch_span">元</span></div>
			<div class="ch" ><span>充电时长：</span><span class="value" id="time">0</span><span class="ch_span">分钟</span></div>
			<div class="ch" ><span>充电电量：</span><span class="value" id="quantity">0.0</span><span class="ch_span">度</span></div>
            <div class="ch" ><span>已充金额：</span><span class="value" id="chargeMoney">0.00</span><span class="ch_span">元</span></div>  
            <div class="ch" ><span>退回金额：</span><span class="value" id="refund_fee">0.00</span><span class="ch_span">元</span></div>
            <div class="ch" ><span>开始时间：</span><span class="value" id="date" style="font-size:14px;">--.--.-- --:--:--</span></div>
			
		</div>
		<div id="upload" style="display:none">
			<button id="botBtn" onclick="stepfun()">完成</button>
		</div>
     
	</body>
    <script type="text/javascript">
        
  //全局变量
        var money = 0;//支付金额
        var serialNo;//流水号
        var userId;
        
      //解析本地的URL，获取参数
        function getQueryString(name) { 
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
            var r = window.location.search.substr(1).match(reg); 
            if (r != null) return unescape(r[2]); return null; 
        } 
        //获取传参数
        serialNo = getQueryString("serialNo");
        userId = getQueryString("userId");
        
        
        if(serialNo && userId){
            
             $("#mask").removeClass("hidden");
        	 refreshView();
            	
        }
        
       
        
        //点击提交跳转 
        function stepfun(){
            alert("关闭窗口");
            wx.config({
              	  debug: false,
                  appId: '<?php echo $signPackage["appId"];?>',
    			  timestamp: '<?php echo $signPackage["timestamp"];?>',
    			  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
   			      signature: '<?php echo $signPackage["signature"];?>',
                  jsApiList: ["closeWindow",]// 所有要调用的 API 都要加到这个列表中     
            });
            wx.closeWindow();
            wx.error(function(res){
                // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            	alert("关闭窗口错误"+JSON.stringify(res));
            });
            location.href='saoma.php';
 
        }
        
        function refreshView(){
         ajax = $.ajax({
				type: "GET", // 请求方式
				url: "http://139.129.194.195:8080/SuperBackManage/scanCharge/chargeRecorder", // 请求地址
				dataType:'json',  //jsonp:'callback', 
				data:{
                    
                    serialNo:serialNo,
                    userId:userId,
                    platform:1
                    
				},
				success: function(data) { //data就是返回的json数据

					console.log("json="+JSON.stringify(data));
                    $("#mask").addClass("hidden");
                    
					if(data.returnCode == 0) {
                        var dto = data.dto;
                        var cpId = dto.cpId;
                        var chargeStartTime = dto.chargeStartTime;
                        var chargeTimeSpan = dto.chargeTimeSpan;
                        var chargeQuantity = dto.chargeQuantity;
                        var chargeMoney = dto.chargeMoney;
                        var transationId = dto.transationId;
                        var totalfee = dto.totalFee;
                        var serviceTip = dto.serviceTip;
                        
                        chargeMoney = parseFloat(chargeMoney) + parseFloat(serviceTip);
                         var refund = parseFloat(totalfee) - chargeMoney;
                         console.log('已冲金额'+chargeMoney+"退回金额====\n"+refund);
                        if(parseFloat(refund)>0){  
                       
                        console.log('退回金额====\n'+refund);
                        	document.getElementById("refund_fee").innerHTML = refund.toFixed(2);	
                        }else{
                          	document.getElementById("refund_fee").innerHTML = 0;	
                        }
                        
                        if(chargeTimeSpan>60){
                            var min = chargeTimeSpan/60;
                            var h = 0;
                            if(min > 60){
                            	min = min % 60;
                                h = min / 60;
                                h = h.toFixed(0);
                            }
                            var s = chargeTimeSpan % 60;
                            var ts = min + h*60;
                            var t = ts.toFixed(0);                           
                        	document.getElementById("time").innerHTML = t;
                            
                        }else{
                        	
                            var t = chargeTimeSpan / 60;
                            t = t.toFixed(0);
                        	document.getElementById("time").innerHTML = t;
                        }
                        
						document.getElementById("bill").innerHTML = transationId;
                        document.getElementById("money").innerHTML = totalfee; 
                        document.getElementById("quantity").innerHTML = chargeQuantity;
                        chargeMoney = parseFloat(chargeMoney);
                        console.log("已冲金额"+chargeMoney);
                        document.getElementById("chargeMoney").innerHTML = chargeMoney.toFixed(2);
                        document.getElementById("date").innerHTML = chargeStartTime;
					}else if(data.returnCode == 1){
                          alert("充电桩超时，订单将会以充电记录的形式出现");       
                    }else {
						
					}
				},
				error: function(jqXHR) {
                    
                    //alert("json="+JSON.stringify(jqXHR));
                     $("#mask").addClass("hidden");
                     alert("服务器异常");
       		    },
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
        if (typeof window.addEventListener != "undefined") {
          window.addEventListener("popstate", function (e) {
            WeixinJSBridge.call('closeWindow');
          }, false);
        } else {
          window.attachEvent("popstate", function (e) {
            WeixinJSBridge.call('closeWindow');
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
                  wx.closeWindow();
                }, false);
              } else {
                window.attachEvent("popstate", function(e) {
                  wx.closeWindow();
                });
              }
            });

	</script>
</html>
