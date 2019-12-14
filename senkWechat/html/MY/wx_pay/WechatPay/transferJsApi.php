# wechat 提现接口

<?php

        require_once "../lib/WxPay.Api.php";
        require_once "../lib/WxPay.Data.php";
        require_once "WxPay.JsApiPay.php";
        $openId = $_GET["openId"];
        $total_fee = $_GET["total_fee"];
        $partner_trade_no = $_GET["out_trade_no"];
        $total_fee = $total_fee * 100;
//参数；
        //②、统一下单
            $input = new WxPayTransferOrder();
            $input->SetDesc("山西尚宽电气集团有限公司-用户提现");
            $input->SetPartner_trade_no($partner_trade_no);
            $input->SetAmount($total_fee);
            $input->SetCheck_name("NO_CHECK");
            $input->SetOpenid($openId);
            //下单并获取返回的结果
            $order = WxPayApi::wx_transfer($input);
           
            //将数组打包成JSON格式
            $obj = json_encode($arr);
            echo $obj;
?>


