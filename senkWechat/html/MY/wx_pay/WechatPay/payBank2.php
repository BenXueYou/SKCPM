# wechat 转账接口
/*
* @Descripttion:
* @version:
* @Author: congsir
* @Date: 2021-08-08 12:33:31
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-08-09 16:15:40
*/

<?php
require_once "../lib2/WxPay.Api.php";
require_once "../lib2/WxPay.Data.php";
require_once "WxPay.JsApiPay2.php";
$bank_no = $_GET["enc_bank_no"];
$total_fee = $_GET["total_fee"];
$true_name = $_GET['enc_true_name'];
$enc_bank_code = $_GET["bank_code"];
$partner_trade_no = $_GET["partner_trade_no"];
$total_fee = $total_fee * 100;
//参数；
function getPubKey()
{
	$pub_key_file = './pub_key.pem';
	if (!is_file($pub_key_file)) {
		$tools = new JsApiPay();
		$pub_key_ret = $tools->getPublicKey();
		$pu_key = $pub_key_ret['pub_key'];
		//保存成PEM文件
		file_put_contents("./pub_key.pem", $pu_key);
		return $pu_key;
	} else {
		return file_get_contents($pub_key_file);
	}
}

function openSslPubKey($dec_str)
{
	$cmd = "openssl rsa -RSAPublicKey_in -in pub_key.pem -out public_pkcs8.pem";
	shell_exec($cmd);
	$pubkey = openssl_pkey_get_public(file_get_contents('./public_pkcs8.pem'));
	$encrypt_data = '';
	$encrypted = '';
	$r = openssl_public_encrypt($dec_str, $encrypt_data, $pubkey, OPENSSL_PKCS1_OAEP_PADDING);
	if ($r) { //加密成功，返回base64编码的字符串
		return base64_encode($encrypted . $encrypt_data);
	} else {
		return false;
	}
}

// 调用接口，通知服务做出支付记录
function postNotifyToServer($data_string)
{
	$url = 'http://47.104.204.250:8080/weChat/deposit/save';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	//设置头信息
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json; charset=utf-8',
		'Content-Length: ' . strlen($data_string)
	));
	$res = curl_exec($ch);
	curl_close($ch);
	error_log("wechat pay notify:-------" . $res, 0);
	$res = json_decode($res);
	error_log("wechat pay notify:-------" . $res->success, 0);
	return $res->success;
}
//②、获取公钥
getPubKey();
$enc_true_name = openSslPubKey($true_name);
$enc_bank_no = openSslPubKey($bank_no);
// 下单发请求    
$input = new WxpayBankOrder();
$input->SetDesc("山西尚宽电气集团有限公司-企业转账");
$input->SetPartner_trade_no($partner_trade_no);
$input->SetAmount($total_fee);
$input->SetEnc_bank_no($enc_bank_no);
$input->SetEnc_true_name($enc_true_name);
$input->SetBank_code($enc_bank_code);
//下单并获取返回的结果
$order = WxPayApi::mmpaysptrans_pay_bank($input);
//将数组打包成JSON格式
$obj = json_encode($arr);
echo $obj;
?>