<?php

require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
$openId = $_GET["openId"];
$total_fee = $_GET["total_fee"];
$out_trade_no = $_GET["out_trade_no"];
$total_fee = $total_fee * 100;
// 设置时区
date_default_timezone_set('Asia/Shanghai');
// 统一下单
$tools = new JsApiPay();
$input = new WxPayUnifiedOrder();
$input->SetBody("山西尚宽电气集团有限公司");
$input->SetAttach("test");
$input->SetOut_trade_no($out_trade_no);
$input->SetTotal_fee($total_fee);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 36000));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://sksenk.cn/senkWechat/html/MY/wx_pay/WechatPay/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
//下单并获取返回的结果
$order = WxPayApi::unifiedOrder($input);
//获取并解析返回的参数
$jsApiParameters = $tools->GetJsApiParameters($order);
//组装成数组
$arr = array();
array_push($arr, $out_trade_no);
array_push($arr, json_decode($jsApiParameters));
//将数组打包成JSON格式
$obj = json_encode($arr);
echo $obj;

function QuerySql($sql)
{
    $con = $GLOBALS['conn'];
    $res = mysqli_query($con, $sql);
    if ($res) {
        return $res;
    } else {
        $data['returnCode'] = 2;
        $data['detail'] = array(
            "mes" => "FAIL",
            "error" => mysqli_error($con),
        );
        die("数据操作错误：" . mysqli_error($con) . "====$sql");
        die(json_encode($data));
        return false;
    }
}
function linkMysqlAccount($total_fee, $out_trade_no, $openId)
{
    // "获取cpuserid与账户余额"
    $sql1 = "SELECT user_id , balance FROM t_sk_wechat_info WHERE open_id = '$openId'";
    $sql1Res = QuerySql($sql1);
    if ($sql1Res) {
        $detail = array();
        while ($row = mysqli_fetch_array($sql1Res, MYSQLI_ASSOC)) {
            array_push($detail, $row);
        }
        $result = $detail[0];
        $cpuserid = $result["user_id"];
        $PreAccountSum = $result["balance"];
        $money = $total_fee / 100;
        $showtime = date("Y-m-d H:i:s");
        if ($cpuserid == null || $cpuserid == "") {
            $arr = array();
            array_push($arr, $out_trade_no);
            array_push($arr, "false");
            //将数组打包成JSON格式
            $obj = json_encode($arr);
            echo $obj;
            return;
        }
        $sql2 = "INSERT INTO t_sk_withdraw_record (cpuserid,gmt_create,withdraw_money,order_id,flag,beforebalance) VALUES ($cpuserid,'$showtime',$money,$out_trade_no','1','',$PreAccountSum)";
        $flagRes = QuerySql($sql2);
    } else {
        $data['returnCode'] = 1;
        $data['detail'] = array(
            "mes" => "FAIL",
            "error" => "no message",
        );
        echo json_encode($data);
    }
}
