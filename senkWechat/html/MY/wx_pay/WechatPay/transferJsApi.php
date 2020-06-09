# wechat 提现接口

<?php
require_once "../lib/WxPay.Api.php";
require_once "../lib/WxPay.Data.php";
require_once "WxPay.JsApiPay.php";
$openId = $_GET["openId"];
$total_fee = $_GET["total_fee"];
$partner_trade_no = $_GET["out_trade_no"];
$user_id = $_GET["user_id"];
$total_fee = $total_fee * 100;
//参数；
//②、统一下单
$tools = new JsApiPay();
$input = new WxPayTransferOrder();
$input->SetDesc("山西尚宽电气集团有限公司-用户提现");
$input->SetPartner_trade_no($partner_trade_no);
$input->SetAmount($total_fee);
$input->SetCheck_name("NO_CHECK");
$input->SetOpenid($openId);
//下单并获取返回的结果
$order = WxPayApi::wx_transfer($input);
//获取并解析返回的参数
// $jsApiParameters = $tools->GetJsApiParameters($order);
// //将数组打包成JSON格式
// $obj = json_encode($arr);
// $data = json_encode($arr);
// if (
//         array_key_exists("return_code", $data)
//         && $data["return_code"] == "SUCCESS"
//         && array_key_exists("result_code", $data)
//         && $data["result_code"] == "SUCCESS"
// ) {
//         $openid = $data["openid"];
//         $time_end = $data["time_end"];
//         $time_end = date('Y-m-d H:i:s', strtotime($time_end));
//         $total_fee = $data["total_fee"] / 100;
//         $out_trade_no = $data["out_trade_no"];
//         $params = array("userId" => $user_id, "withdrawMoney" => $total_fee, "flag" => 1, "gmtCreate" => $time_end, "openId" => $openid, 'orderId' => $out_trade_no);
//         $data_string = json_encode($params);
//         $this->postNotifyToServer($data_string);
//         return true;
// } else {
//         return false;
// }
// echo $obj;




// 调用接口，通知服务做出支付记录
function postNotifyToServer($data_string)
{
        $url = 'http://sksenk.cn/weChat/withdraw';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        //设置头信息
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($data_string)
        ));
        $res = curl_exec($ch);
        curl_close($ch);
}
?>