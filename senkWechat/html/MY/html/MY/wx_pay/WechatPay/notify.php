<?php
ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
//require_once "../lib/con.php";
class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		//查询订单
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		if (
			array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS"
		) {
			return true;
		}
		return false;
	}

	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		if (!array_key_exists("transaction_id", $data)) {
			$msg = "输入参数不正确";
			return false;
		}
		error_log("wechat pay notify:=====".json_encode($data), 0);
		//收到微信支付成功的回调，给微信做出应答
		if (
			array_key_exists("return_code", $data)
			&& $data["return_code"] == "SUCCESS"
			&& array_key_exists("result_code", $data)
			&& $data["result_code"] == "SUCCESS"
		) {
			$openid = $data["openid"];
			$time_end = $data["time_end"];
			$time_end = date('Y-m-d H:i:s', strtotime($time_end));
			$total_fee = $data["total_fee"] / 100;
			$out_trade_no = $data["out_trade_no"];
			$params=array("depositMoney"=>$total_fee,"flag"=>1,"gmtCreate"=>$time_end,"openId"=>$openid,'orderId'=>$out_trade_no);
			$data_string = json_encode($params);			
			$result = $this->postNotifyToServer($data_string);
			if($result === 'true' || true){
    				return true;
			}else {
				return $this->postNotifyToServer($data_string);
			}
		} else {
			return false;
		}
	}
	// 调用接口，通知服务做出支付记录
	public function postNotifyToServer($data_string)
	{
		$url = 'http://47.104.204.250:8080/weChat/deposit/save';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
		//设置头信息
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
    			'Content-Type: application/json; charset=utf-8', 
    			'Content-Length: ' . strlen($data_string)
		));
		$res = curl_exec($ch);
		curl_close($ch);
		error_log("wechat pay notify:-------".$res, 0);
		$res = json_decode($res);
		error_log("wechat pay notify:-------".$res->success, 0);
		return $res->success;
	}
	// 直连数据库做出支付记录
	public function QuerySql($sql)
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
			//die("数据操作错误：".mysqli_error($con)."====$sql");
			die(json_encode($data));
			return false;
		}
	}
}

$notify = new PayNotifyCallBack();
$notify->Handle(false);
