<?php

 require_once "../../php/jssdk.php";
 $appid = "wx031732af628faee0";
 $secret =  "5e8ccf52a81d427752241374212af303";
 $jssdk = new JSSDK("wx031732af628faee0","5e8ccf52a81d427752241374212af303");
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
	<title>站点详情</title>
	<script type="text/javascript" src="../JS/jquery-3.0.0.min.js" ></script>
    <script type="text/javascript" src="../JS/touchslider.js" ></script>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <link rel="stylesheet" href="https://cache.amap.com/lbs/static/main1119.css"/>
    <link rel="stylesheet" href="../../CSS/slider_style.css"/>
    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=a668a7bf772ef0e195642264ba825493&plugin=AMap.Autocomplete,AMap.PlaceSearch"></script>
    <script type="text/javascript" src="https://cache.amap.com/lbs/static/addToolbar.js"></script>
	<style type="text/css">
		*{
			margin: 0px;
			padding: 0px;
		}
			
		body{
			background-color: lightgrey;
		}
		.top{
			overflow: hidden; 
			background-color: white; 
			width: 98%; 
			margin:1% 1% 0;
			padding: 5px 0;
		}
		.left{
            width: calc(98% - 100px);
			float: left;
			display: block;
			font-size: 16px;
			padding: 1px;
			margin-left: 10px;
			text-align: left;
			background-color: white;
		}
		.font-size{
			font-size: 12px;	
			background-color: white;	
		}
		#top_pileName{
			width: 98%;
				
		}
        .pileName{
                
            background-color: white;
			position: relative;
			width: 70%;
			margin: 2px 2px 2px 10px;
			line-height: 25px;
            
        }
            
		button{
			position: absolute;
			top: 0px;
			right: 10px;
			background-color: transparent;
			border: 0px;
			color: #299DFF;
            outline:none;
			text-decoration: none;
		}
		#dis{
				
			background-color: transparent;
			position: absolute;
			right: 10px;
			top: 10px;
			line-height: 18px;
			color: gray;
		}
		#address{
			margin: 3px 0 0px;
		}
		#validflag{
				
			border: 1px solid #299DFF; 
			width: 40px; 
			color: #299dff; 
			padding:1px 2px; 
			margin:1px 2px;
				
		}
		#validpay{
			border: 1px solid #04BE02; 
			width: 50px; 
			color: #04BE02; 
			padding:1px 2px; 
			margin:10px 2px;
		}	
	
	   .sel_btn{
			border-bottom: 1px solid #299DFF;
			color: #299DFF;
		}
		.menu{
			background-color: white; 
			margin: 0px 1%; 
			width: 98%;
				
		}
		.cell{
			line-height: 40px;
			border-bottom: 1px solid lightgray;
			padding-left: 10px;
			text-align: left;
			position: relative;
		}
		.font-size-cell{
				
			color: gray;
			font-size: 14px;
				 
		}
        .font-size-cell-img{
            	
            margin: 0px 0px 2px 15px;
            width: 50px;
            height: 50px;
            border-radius:25px ;
            float: left;
			display: block;
               
         }
            
		.cell_span{
			position: absolute;
			right: 10px;
			top: 0px;
		}
		.hidden{
			display: none;
		}
		.height{
			margin-top: 10px;
			height: 70px;
			border-bottom: 1px solid lightgrey;
		}
		ul li a{
			text-decoration: none;
		}
	</style>
</head>
<body>
		<div class="top" style="">
			<img class="left" style="margin: 10px 0px 2px 10px; width: 80px; height: 80px; border-radius:40px ;" src="../../img/13.jpg"/>
			<div class="left">
				<div id="top_pileName" class="pileName" style="font-size:16px ; ">
					<span id="name">充电站名</span>
                    <span class="rig_top">
						<button><img src="../../img/navicon.png"/>导航</button>
						<!--<span id="dis" class="font-size" style="">--km</span>-->
					</span>         
				</div>
				<div id="address" class="font-size" style="text-wrap:normal;">
					-------
				</div>
				<span id="dc" class="font-size" style="">
					直流桩：<span id="dcisnum">0</span>/<span id="dcnum">0</span>&nbsp;&nbsp;
				</span>
				<span id="ac" class="font-size" style="padding: 2px 0px 5px;">
					交流桩：<span id="acisnum">0</span>/<span id="acnum">0</span>
				</span>
				<div id="" style="margin:0;">
				<span id="validflag" class="font-size" style="">
					公共桩
				</span>
				<span id="validpay" class="font-size" style="">
					微信支付
				</span>
				</div>
			</div>
		</div>

		
		<div id="pagenavi" class="menu" style="background-color:white;">
			<a href="#" style='outline: none;background-color: white;width: 49%;display: inline-block;text-align: center;line-height:40px;text-decoration:none;' class="btn active">详情</a>
			<a href="#" style='outline: none;background-color: white;width: 49%;display: inline-block;text-align: center;line-height:40px;text-decoration:none;' class="btn ">充电站</a>
		</div>
		
<div class='swipe '>
  <ul id='slider4'>
    <li class="lf_btn_cell menu"><a href="#"><div class="cell font-size-cell">充电费（根据波峰平谷价格而定）<span class="cell_span"><span id="chargefee">0</span>元/度</span>
			</div>
			<div class="cell font-size-cell">停车费（根据现场实际情况而定）<span class="cell_span" ><span id="parkfee">0</span>元/小时</span>
			</div>
			<div class="cell font-size-cell">服务费<span class="cell_span" ><span id = "servicefee">0</span>元/度</span>
			</div>
			<div class="cell font-size-cell">开放时间<span class="cell_span" id = "opentime">00:00——23:59</span>
			</div>
			<div class="cell font-size-cell">直流桩<span class="cell_span">共<span id = "dcnum1">0</span>个, 空闲<span id = "dcisnum1">0</span>个</span>
			</div>
			<div class="cell font-size-cell">交流桩<span class="cell_span">共<span  id = "acnum1">0</span>个 ,空闲<span id = "acisnum1">0</span>个</span>
			</div>
		</a></li>
    <li id = 'con' class="rg_btn_cell menu top">
			
		</li>
    
  </ul>
</div>
<br/>
		
	</body>
	<script type="text/javascript" src="../JS/CONFIG.js"></script>
	<script type="text/javascript">
        
        var marker;
        var csid;
        var name;
        var arr;
   	    
        var urlM = CONFIGS.LANCHUANG();//请求主路径
        
        function getQueryString(name) { 
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
            var r = window.location.search.substr(1).match(reg); 
            if (r != null) return unescape(r[2]); return null; 
        } 
        
        csid = getQueryString("csid");
        lng = getQueryString("lng");
        lat = getQueryString("lat");
 		//alert(lng+"="+lat+"="+csid);
        
        map = new AMap.Map('container', {
       		 resizeEnable: true,
    	});
       marker = new AMap.Marker({
            position:[lng,lat]
        });
        
        console=window.console || {dir:new Function(),log:new Function()};
        var active=0,
            as=document.getElementById('pagenavi').getElementsByTagName('a');
        for(var i=0;i<as.length;i++){
            (function(){
                var j=i;
                as[i].onclick=function(){
                    t4.slide(j);
                    return false;
                }
            })();
        }

        var t4=new TouchSlider('slider4',{speed:1000, direction:0, interval:6000, fullsize:true});
        t4.on('before',function(m,n){
            as[m].className='font-size-cell';
            as[n].className='active';
        })
	
        getfindSMPDetailById();
        
       function getfindSMPDetailById(){
        var ajax = $.ajax({
        	type:"GET",
            url:urlM +"mapSearchPile/findSMPDetailById",
            dataType:"json",
            async: false,// 使用同步操作
            timeout:20, //超时时间：50秒
        	data:{
                type:'cs',
            	longitude:lng,
                latitude:lat,
                id:csid
            },
        	success: function(data) {
            console.log(data+"=======："+JSON.stringify(data));
            if(data.returnCode == 0){
            	var detail = data.detail;
            	var csList = detail.smDto;
            	console.log("长度："+csList.length);
           		for(var h=0;h<csList.length;h++){
             		document.getElementById('name').innerHTML = csList[h]['name'];
                    name = csList[h]['name'];
                    document.getElementById('address').innerHTML = csList[h]['location'];
                   // document.getElementById('dis').innerHTML = csList[h]['distance'] / 10.0+"km";
            	    document.getElementById('chargefee').innerHTML = csList[h]['chargefee'] == ""?0:csList[h]['chargefee'];
                    document.getElementById('servicefee').innerHTML = csList[h]['servicetip'] == null||""?0:csList[h]['servicetip'];
                    document.getElementById('dcnum1').innerHTML = document.getElementById('dcnum').innerHTML = csList[h]['dcnum'];
                    document.getElementById('acnum1').innerHTML = document.getElementById('acnum').innerHTML = csList[h]['acnum'];
                    document.getElementById('parkfee').innerHTML = csList[h]['parkingfee']==null?0:csList[h]['parkingfee'];
                    document.getElementById('dcisnum1').innerHTML = document.getElementById('dcisnum').innerHTML = csList[h]['dcisnum'];
                    document.getElementById('acisnum1').innerHTML = document.getElementById('acisnum').innerHTML = csList[h]['acisnum'];
                    document.getElementById('opentime').innerHTML = csList[h]['opentime'];
                 }
                
                getPileCsDetail(detail.cpList);
        	   }
        	},
        	error: function(jqXHR) {
            	alert("网络请求发生错误");
        	},

        });

    };
	
	
		function getPileCsDetail(pileArr){
            
			for(var i = 0;i < pileArr.length;i++){
               	var con = document.getElementById("con");  
                var div = document.createElement('div');
                div.setAttribute('class', 'font-size-cell height');
                con.appendChild(div); 
                    var img = document.createElement('img');
                    img.setAttribute('class','font-size-cell-img');
                	if(pileArr[i].cptype == "交流"){
                    	img.setAttribute('src','../../img/rgslowicon.png');
                    }else{
                        img.setAttribute('src','../../img/rgfasticon.png');
                    }
                    
                    div.appendChild(img);
                    
                    var div_div = document.createElement('div');
                    div_div.setAttribute('class','pileName left');
                    div_div.innerHTML = pileArr[i].cpname;
                    div.appendChild(div_div);
                    
                    var div_div_div = document.createElement('div');
                    div_div_div.setAttribute('class','left');
                    div.appendChild(div_div_div);
                    
                    var div_3_spanr = document.createElement('span');
                    div_div_div.appendChild(div_3_spanr);
                    
                    var span_power = document.createElement('span');
                    span_power.innerHTML = '功率';
                    div_3_spanr.appendChild(span_power);
                    
                    var div_3_span2 = document.createElement('span');
                    div_3_span2.innerHTML = pileArr[i].ratedpower;
                    div_3_spanr.appendChild(div_3_span2);
                    
                    var span_KW = document.createElement('span');
                    span_KW.innerHTML = 'kw';
                    div_3_spanr.appendChild(span_KW);
                  
                    var nbsp = document.createElement('span');
                    nbsp.innerHTML += '&nbsp&nbsp&nbsp';
                    div_div_div.appendChild(nbsp);
                                      
                    var div_3_spanl = document.createElement('span');
                    div_div_div.appendChild(div_3_spanl);
                    
                    var span_qt = document.createElement('span');
                    span_qt.innerHTML = '枪头：';
                    div_3_spanl.appendChild(span_qt);
                    
                    var div_3_spantype = document.createElement('span');
                	div_3_spantype.innerHTML = pileArr[i].interfacecount;
                    div_3_spanl.appendChild(div_3_spantype);

                   
                    
                   div.appendChild(document.createElement("br"));

                }
		}	        
		$('.rig_top').on('click',function(){
           
                   marker.markOnAMAP({
                        position: marker.getPosition(),
                        name:name//name属性在移动端有效
                    })
        });	
        
         wx.config({

                  debug: false,
                  appId: '<?php echo $signPackage["appId"];?>',
    			  timestamp: '<?php echo $signPackage["timestamp"];?>',
    			  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
   			      signature: '<?php echo $signPackage["signature"];?>',
                  jsApiList: [// 所有要调用的 API 都要加到这个列表中     
                           "scanQRCode",
                      		"onMenuShareTimeline",
                      		"onMenuShareAppMessage",
                      		"onMenuShareQQ",
                      		"onMenuShareWeibo",
                      		"onMenuShareQZone"
                       ]
                  });
        
        
         wx.ready(function () {
                  
                     wx.onMenuShareTimeline({
                        title: '充电邀请', // 分享标题
                        link: 'http://pxywechat.applinzi.com/html/csDetail.html?csid='+csid+'&lng='+lng+'&lat='+lat, // 分享链接
                        imgUrl: 'http://pxywechat.applinzi.com/img/logo.png', // 分享图标
                        success: function () { 
                            
                            alert("分享成功")
                            // 用户确认分享后执行的回调函数
                        },
                        cancel: function () { 
                            // 用户取消分享后执行的回调函数
                            alert("取消成功")
                        }
                    });
                    
                  
                  
                  wx.onMenuShareAppMessage({
                        title: '充电邀请', // 分享标题
                        desc: '充电邀请,James,来充电吧，come on!', // 分享描述
                        link: 'http://pxywechat.applinzi.com/html/csDetail.html?csid='+csid+'&lng='+lng+'&lat='+lat, // 分享链接
                        imgUrl: 'http://pxywechat.applinzi.com/img/logo.png', // 分享图标
                        type: 'link', // 分享类型,music、video或link，不填默认为link
                        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                        success: function () {
                             alert("分享成功")
                            // 用户确认分享后执行的回调函数
                        },
                        cancel: function () { 
                            // 用户取消分享后执行的回调函数
                             alert("取消成功")
                        }
                    });
                  
                  
                  wx.onMenuShareQQ({
                    title: '充电邀请', // 分享标题
                    desc: '充电邀请', // 分享描述
                    link: 'http://pxywechat.applinzi.com/html/csDetail.html?csid='+csid+'&lng='+lng+'&lat='+lat, // 分享链接
                    imgUrl: 'http://pxywechat.applinzi.com/img/logo.png', // 分享图标
                    success: function () { 
                       // 用户确认分享后执行的回调函数
                    },
                    cancel: function () { 
                       // 用户取消分享后执行的回调函数
                    }
                });
                  
                wx.onMenuShareQZone({
                    title: '充电邀请', // 分享标题
                    desc: '充电邀请', // 分享描述
                    link: 'http://pxywechat.applinzi.com/html/csDetail.html?csid='+csid+'&lng='+lng+'&lat='+lat, // 分享链接
                    imgUrl: 'http://pxywechat.applinzi.com/img/logo.png', // 分享图标
                    success: function () { 
                       // 用户确认分享后执行的回调函数
                    },
                    cancel: function () { 
                        // 用户取消分享后执行的回调函数
                    }
                });  

                 wx.onMenuShareWeibo({
                    title: '充电邀请', // 分享标题
                    desc: '充电邀请', // 分享描述
                    link: 'http://pxywechat.applinzi.com/html/csDetail.html?csid='+csid+'&lng='+lng+'&lat='+lat, // 分享链接
                    imgUrl: 'http://pxywechat.applinzi.com/img/logo.png', // 分享图标
                    success: function () { 
                       // 用户确认分享后执行的回调函数
                    },
                    cancel: function () { 
                        // 用户取消分享后执行的回调函数
                    }
                }); 
                  
              });
         

	</script>
</html>
