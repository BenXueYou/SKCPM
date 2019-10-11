
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>微信支付退款</title>
</head>
<?php
ini_set('date.timezone','Asia/Shanghai');
require_once "wx_pay/lib/WxPay.Api.php";
function printf_info($data)
{
	if(isset($data['err_code_des']) || isset($data['result_code'])){
		// $GLOBALS['err_code_des'] = "SUCCESS";
	   if(isset($data['err_code_des']) && $data['err_code_des'] !== ""){
		  $GLOBALS['err_code_des'] = $data['err_code_des'];
        }else{
           $GLOBALS['err_code_des']="成功";
		}
		$GLOBALS['result_code'] = $data['result_code'];
	}else{
		$GLOBALS['err_code_des'] = $data['return_msg'];
		$GLOBALS['result_code'] = $data['return_code'];
	}
	if($data["result_code"] == "SUCCESS" && $data["return_code"] == "SUCCESS"){
        // echo "<font color='#f00;'>退款结果</font> :". $data["result_code"];
	}else{
		// foreach($data as $key=>$value)
		// {
			// echo "<font color='#f00;'>$key</font> : $value <br/>";
		// }
		//  echo "<font color='#f00;'>退款结果</font> :". $data["result_code"]."<br/>";
		//  echo "<font color='#f00;'>退款通知</font> :". $data["err_code_des"];
	}
}

if(isset($_REQUEST["transaction_id"]) && $_REQUEST["transaction_id"] != ""){
	$transaction_id = $_REQUEST["transaction_id"];
	$total_fee = $_REQUEST["total_fee"];
	$refund_fee = $_REQUEST["refund_fee"];
	$input = new WxPayRefund();
	$input->SetTransaction_id($transaction_id);
	$input->SetTotal_fee($total_fee);
	$input->SetRefund_fee($refund_fee);
    $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis").rand(1000,9999));
    $input->SetOp_user_id(WxPayConfig::MCHID);
	printf_info(WxPayApi::refund($input));
	// exit();
}

//$_REQUEST["out_trade_no"]= "122531270220150304194108";
///$_REQUEST["total_fee"]= "1";
//$_REQUEST["refund_fee"] = "1";
if(isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != ""){
	$out_trade_no = $_REQUEST["out_trade_no"];
	$total_fee = $_REQUEST["total_fee"];
	$refund_fee = $_REQUEST["refund_fee"];
	$input = new WxPayRefund();
	$input->SetOut_trade_no($out_trade_no);
	$input->SetTotal_fee($total_fee);
	$input->SetRefund_fee($refund_fee);
    $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis").rand(1000,9999));
    $input->SetOp_user_id(WxPayConfig::MCHID);
	printf_info(WxPayApi::refund($input));
}
?>
<body>  
	<form action="#" method="post">
        <div style="margin-left:2%;color:#f00">微信订单号和商户订单号选少填一个，微信订单号优先：</div><br/>
        <div style="margin-left:2%;">微信订单号：</div><br/>
        <input type="text" style="width:96%;height:35px;margin-left:2%;" name="transaction_id" /><br /><br />
        <div style="margin-left:2%;">商户订单号：</div><br/>
        <input type="text" style="width:96%;height:35px;margin-left:2%;" name="out_trade_no" /><br /><br />
        <div style="margin-left:2%;">订单总金额(分)：
		 <div style="margin-left:2%;color:#f00;font-size:12px;margin:0;padding:0;">所有金额以分为单位，1元=100分</div>
		</div>
		<br/>
        <input type="text" style="width:96%;height:35px;margin-left:2%;" name="total_fee" /><br /><br />
        <div style="margin-left:2%;">退款金额(分)：</div><br/>
        <input type="text" style="width:96%;height:35px;margin-left:2%;" name="refund_fee" /><br /><br />
		<div align="center">
			<input type="submit" value="提交退款" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button"/>
		</div>
	</form>
</body>
<script type="text/javascript" src="http://www.senk.net.cn/senkWechat/JS/jquery-3.0.0.min.js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	//var urlM = "http://116.236.237.244:8080/SuperBackManage/";
     var urlM = "http://139.129.194.195:8080/SuperBackManage/";

var status = "<?php echo $GLOBALS['result_code'];?>";
status = status=="FAIL"?0:1;//转成数字
var des = "<?php echo $GLOBALS['err_code_des'];?>";
var money = "<?php echo $_REQUEST['total_fee']?>";
var now=new Date();
var timeStamp=now.getFullYear()+"-"+(now.getMonth()+1)+"-"+now.getDate()+" "+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
// console.log("===="+"<?php echo $_REQUEST["out_trade_no"]?>"+"====="+timeStamp+"====="+"<?php echo $_REQUEST['total_fee']?>"+"====="+status+"========"+des);
sendRefundRes();
function sendRefundRes(){
    	var Ajax = $.ajax({
        		type:"GET",
				url: urlM + "scanCharge/updateRefund",
				dataType:'json',
				async : false,
				contentType:"application/x-www-form-urlencoded; charset=UTF-8",
				data:{
                    tradeNo:"<?php echo $_REQUEST["out_trade_no"]?>",
					refundTime:timeStamp,
					money:money/100,
					status:status,
					desp:des
				},
				success: function(data) {
					alert(data.message+"====退款结果:"+"<?php echo $GLOBALS['result_code'];?>"+"====描述:"+des);
                    console.log(JSON.stringify(data));
				},
				error: function(jqXHR) {
                    alert("服务器通信异常");
        		},
        });
    }

</script>
</html>