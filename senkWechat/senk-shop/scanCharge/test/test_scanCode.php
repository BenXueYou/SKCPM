  <?php
    require_once "../config.php/test_jssdk.php";
	  $appid ="wx32a40fe9e54cc1c8";
    $secret ="cba6f2171a8a0fb4a2c3012c65f007d3";
    $code = $_GET["code"];  
    $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';  
    $ch = curl_init();  
    curl_setopt($ch,CURLOPT_URL,$get_token_url);  
    curl_setopt($ch,CURLOPT_HEADER,0);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, TRUE); // 从证书中检查SSL加密算法是否存在
    $res = curl_exec($ch);  
    curl_close($ch);  
 //	解析json
  $user_obj = json_decode($res,true); 
   $openid = $user_obj['openid'];
//存入Session中 注意此时SAE中SESSION不可用。
   $_SESSION['user'] = $openid;
	if($openid == null){	
        $openId = 0;
        exit;      
    }
//调用接口处理openID	
	$wechatUrl = "http://139.129.194.195:8080/SuperBackManage/wechatUserManager/registerUser?openId=".$openid;
	$obj = httpGet($wechatUrl);
    function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
  }
 
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
        <link href="../CSS/circle.css" rel="stylesheet" type="text/css"/>   
        <script type="text/javascript" src="../JS/jquery-3.0.0.min.js" ></script>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script type="text/javascript" src="../JS/cookie.js" ></script>
		<title>扫码充电</title>
		<style type="text/css">
			body{padding: 0;margin: 0;position:relative;}
			h2{
        margin-top:30px;
				text-align: center;
				color: #299DFF;	
			}
			.middle_image{
        margin:60px auto 0px;
        width:150px;
        height:180px;
        background:white url(../senk_img/scan_charging_img_2.png) no-repeat;
        background-origin: content-box;
				background-clip: content-box;
				background-size: 100% 100%;
				text-align: center;
			}
			button{
				height: 60px;
        background: url(../senk_img/扫描.png) no-repeat center;
				background-clip: content-box;
				background-origin: content-box;
				background-size: contain;
				line-height: 50px;
				width: 40%;
				outline: none;
				border: 1px solid #299DFF;
				border-radius: 5px;
				margin: 50px 30% 10px;
				font-size: 20px;
				padding: 10px 0;
			}
			p{
				text-align: center;
				color:rgb(105,105,105);
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
        

		<h2>扫描桩上的二维码启动充电</h2>
        <div class="middle_image"></div>
		<button></button>
        <p class="middle_input">或<a style="color: blue; text-decoration: underline;" onclick="hrefBtn()">输入桩编号</a></p>
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

    <script type="text/javascript">
        
        //定义全局变量
      var urlM = "http://116.236.237.244:8080/SuperBackManage/";
    //    var urlM = "http://139.129.194.195:8080/SuperBackManage/";
       var openId = '<?php echo $openid;?>';
       var cpid;
       var deviceId = cpid;
       var chargeState = 0;
       var money = 0;
       var tradeNo = 0;
      
      //处理没有获取到openId的异常
        if(openId =="" || openId == null || openId == undefined){
        	location.href = "Home.php"; 
        } 
//监听扫码按钮
  /*
	1.先监控用户状态
	2.调用扫码接口获取编号
	3.获取编号请求桩的状态
  */
  		$("button").click(function(){
             //获取用户充电状态
             $("#mask").removeClass("hidden");
			  getUserState(openId); 
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
                    //抓取到返回的数据
                    if(data.returnCode==0){
                        //用户正在充电状态
                        if((data.chargeState == "1") || (data.chargeState == "2")){
							chargeState = data.chargeState;
                             tradeNo = data.tradeNo;
                             money = data.payMoney;
                            //根据openId获取充电单信息，进入充电界面 
                            getCpid(chargeState);                            
                        	$("#mask").addClass("hidden");
                        }else{
							chargeState = data.chargeState;
                            $("#mask").addClass("hidden");
                            //调取扫码接口
                            wxScanAPI();
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
                        if(JSON.stringify(detail) == "{}"){alert("没有获取到数据");}                        
                        var cp = detail.cp;
                        var obj = cp[0]; 
                        cpid = obj.cpid;
                        var state = 1;
                        Loggert("userState is busy and step to chargingState===openid==="+openId+'&chargeState='+e+'&payMode=4&money='+money+'&out_trade_no='+tradeNo);
                       //进入充电界面
						location.href='charge.php?cpid='+cpid+'&openid='+openId+'&chargeState='+e+'&payMode=4&money='+money+'&out_trade_no='+tradeNo;
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
 
        //调起微信扫码接口    
        function wxScanAPI(){
             wx.config({
                  	debug: false,
                  	appId: '<?php echo $signPackage["appId"];?>',
    			  	timestamp: '<?php echo $signPackage["timestamp"];?>',
    			  	nonceStr: '<?php echo $signPackage["nonceStr"];?>',
   			      	signature: '<?php echo $signPackage["signature"];?>',
                  	jsApiList: ["scanQRCode",]//// 所有要调用的 API 都要加到这个列表中     
                  });
              wx.ready(function () {
             	 wx.scanQRCode({   
                         needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                         scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                         success: function (res) { 
                             var result = res.resultStr;
                             //设备号添加两个0
                             deviceId = result;
                             //判断设备号长度是否符合
                             if(result.length >= 18){
                                   $("#mask").removeClass("hidden");
                                   //请求该桩的状态
                                   sendCpIdToSever(result); 
                              }else{
                                  alert("二维码错误");
                              }
                         }
                  });       
              });
            wx.error(function(res){
                // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
                alert("扫码错误"+JSON.stringify(res));       
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
				success: function(data) { //data就是返回的json数据                     
                    //alert(e +"请求桩的状态："+JSON.stringify(data));
                    //判断该桩处于空闲状态，可以被使用则进入支付界面
                    if(data.returnCode==0){
                    	$("#mask").addClass("hidden"); 
                        
                        var cpObj = data.detail;                       
location.href='pay.php?cpid='+e+'&openid='+openId+'&chargeState='+chargeState+'&payMode=4'+'&money=0'+'&cpObj='+escape(JSON.stringify(cpObj));
                    }else if(data.returnCode==4){ 
                    	$("#mask").addClass("hidden");      
                     	alert("没有插枪");
                    }else if(data.returnCode==5){
                        $("#mask").addClass("hidden");      
                     	alert("没有授权");
                    }else if(data.returnCode==2){
                        $("#mask").addClass("hidden");
                     	alert("其他错误");
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
        
        //输入设备号界面跳转
        function hrefBtn(){
        	 ajax = $.ajax({
				type:"GET", // 请求方式
				url:urlM+"wechatUserManager/getUserState", // 请求地址
				dataType:'json',
				data:{                    
                    openId:openId                    
				},
				success: function(data) { //data就是返回的json数据
                    //抓取到返回的数据
                    if(data.returnCode==0){
                        
                        //alert(data.chargeState);
                        
                        //用户正在充电状态
                        if((data.chargeState == "1") || (data.chargeState == "2")){
							chargeState = data.chargeState;
                            //根据openId获取充电单信息，进入充电界面 
                            getCpid(chargeState);                            
                        	$("#mask").addClass("hidden");
                        }else{
							chargeState = data.chargeState;
                            $("#mask").addClass("hidden");
                            //调取扫码接口
                            location.href = 'scan_input.html?openid='+openId;
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
        
//日志
        function Loggert(t){
         	var ajax = $.ajax({
                type:"GET",
            	url:urlM+"wechatUserManager/logger",
                dataType:"json",
                data:{
                  content:"returnWechatLogger"+openId+"===="+t
                },
                success:function(data){console.log("成功");},
                error: function(jqXHR) {console.log("失败");}
            });
        }
     </script>
</html>

	
