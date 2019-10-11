# wechat 提现接口

<?php

        require_once "../lib/WxPay.Api.php";
        require_once "../lib/WxPay.Data.php";
        require_once "WxPay.JsApiPay.php";
        $enc_bank_no = $_GET["enc_bank_no"];
        $total_fee = $_GET["total_fee"];
        $enc_true_name = $_GET['enc_true_name'];
        $bank_code = $_GET["bank_code"];
        $partner_trade_no = $_GET["partner_trade_no"];
        $total_fee = $total_fee * 100;
//参数；
        //②、统一下单
            $tools = new JsApiPay();
            $input = new WxpayBankOrder();
            $input->SetDesc("山西尚宽电气集团有限公司-企业转账");
            $input->SetPartner_trade_no($partner_trade_no);
            $input->SetAmount($total_fee);
            $input->SetEnc_bank_no($enc_bank_no);
            $input->SetEnc_true_name($enc_true_name);
            $input->SetBank_code($bank_code);
            //下单并获取返回的结果
            $order = WxPayApi::mmpaysptrans_pay_bank($input);
            //将数组打包成JSON格式
            $obj = json_encode($arr);
            echo $obj;
?>


