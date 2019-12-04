<?php
ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once "../lib/con.php";
// require_once 'log.php';

//初始化日志
// $logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
// $log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		//查询订单
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		// Log::DEBUG("query:" . json_encode($result));
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
		// Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		if (!array_key_exists("transaction_id", $data)) {
			$msg = "输入参数不正确";
			return false;
		}
		//收到微信支付成功的回调，给微信做出应答
		if (
			array_key_exists("return_code", $data)
			&& $data["return_code"] == "SUCCESS"
			&& array_key_exists("result_code", $data)
			&& $data["result_code"] == "SUCCESS"
		) {
			$openid = $data["openid"];
			$time_end = $data["time_end"];
			$total_fee = $data["total_fee"] / 100;
			$out_trade_no = $data["out_trade_no"];
			// $sqlStr = "update appuserrechargerecord set PayResultFlag = 0, FailDesp = '交易成功' where MerchantNum = '$out_trade_no'";
			// $flagres = $this->QuerySql($sqlStr);
			$params=array("depositMoney"=>$total_fee,"flag"=>"1","gmtCreate"=>$time_end,"openId"=>$openid,'orderId'=>$out_trade_no);
			$this->postNotifyToServer($params);
			return true;
		} else {
			return false;
		}
	}
	// 调用接口，通知服务做出支付记录
	public function postNotifyToServer($data)
	{
		$url = 'http://sksenk.cn/weChat/deposit/save';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_exec($ch);
		curl_close($ch);
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

// Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
