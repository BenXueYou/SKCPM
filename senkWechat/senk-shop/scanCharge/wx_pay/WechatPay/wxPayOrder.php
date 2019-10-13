<?php
        require_once "../lib/WxPay.Api.php";
        require_once "WxPay.JsApiPay.php";
		$openId = $_GET["openId"];
		$out_trade_no = $_GET["total_fee"];
		$total_fee = $_GET["total_fee"];
	    $total_fee = $total_fee * 100;
//调试信息
//$openId = "oR9d21lZxSloF2iQtPHjdRAdy-2o";
//$total_fee = 1;
        //②、统一下单
			$tools = new JsApiPay();
            $input = new WxPayUnifiedOrder();
            $input->SetBody("山西尚宽电气集团有限公司");
            $input->SetAttach("test");
//          $Out_trade_no = "sk".rand(1000,9999).date("YmdHis").rand(10000,99999);
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($total_fee);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 36000));
            $input->SetGoods_tag("test");
            $input->SetNotify_url("http://www.senk.net.cn/senkWechat/scanCharge/wx_pay/WechatPay/notify.php");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            //下单并获取返回的结果
            $order = WxPayApi::unifiedOrder($input);
            //获取并解析返回的参数
           $jsApiParameters = $tools->GetJsApiParameters($order);
            //解析并得到商户号
		//	$Out_trade_no = $input->GetOut_trade_no();
            //组装成数组
//			$arr = array();
//			array_push($arr, $Out_trade_no);
//			array_push($arr, json_decode($jsApiParameters));
            //将数组打包成JSON格式
			$obj = json_encode($jsApiParameters);
			echo $obj;

?>
