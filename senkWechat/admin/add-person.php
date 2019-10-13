<?php
require_once "con.php";
require_once "model/person.php";
/*
 添加联系人的数据接口
 * 
 * 一下有三种添加方式的sql语句：
 * 第一种是：直接插入，不论数据库内有多少条重复数据
 * 第二种是：插入数据，若数据存在则过滤，否则直接插入
 * 第三种是：插入数据之前，检查记录是否存在，不存在则插入，存在则更新
 * 
 * */
date_default_timezone_set("Asia/Shanghai");	
	$person = $_POST["person"];
	if(!($person['name'] && $person['tel'])){
		$data['returnCode'] = 4;
		$data['detail'] = array(
			"mes"=>"FAIL",
			"error"=>"参数错误",
		);
       echo json_encode($data);
       exit;
	}
	
	$date_time = date("Y-m-d H:i:s");
//直接插入数据
$insert_sql = "insert into reservation_info (reser_name,reser_tel,reser_car,reser_num,reser_date,record_date) 
	values ("
	."'".$person['name']."'".","
	."'".$person['tel']."'".","
	."'".$person['carModel']."'".",".
	$person['manNum'].","."'"
	.$person['dateTime']."'".","
	."'".$date_time."'".")";
	
//插入数据，若数据存在则过滤，否则直接插入
$check_sql = "insert ignore into reservation_info (reser_name,reser_tel,reser_car,reser_num,reser_date,record_date) 
	values ("
	."'".$person['name']."'".","
	."'".$person['tel']."'".","
	."'".$person['carModel']."'".",".
	$person['manNum'].","."'"
	.$person['dateTime']."'".","
	."'".$date_time."'".")";
//将对象属性值转换为变量	
$name = $person['name'];
$carModel = $person['carModel'];
$manNum = $person['manNum'];
$tel = $person['tel'];
$dateTime = $person['dateTime'];
//检查记录是否存在，不存在则插入，存在则更新
$sql = "insert into reservation_info (reser_name,reser_tel,reser_car,reser_num,reser_date,record_date) 
values ('$name', '$tel', '$carModel', '$manNum', '$dateTime','$date_time') 
ON DUPLICATE KEY UPDATE 
reser_name='$name', reser_car = '$carModel', reser_num = '$manNum', reser_date = '$dateTime',record_date = '$date_time'";

//执行语句
	$flag = QuerySql($sql);
	if($flag){
		$data['returnCode'] = 0;
		$data['detail'] = array(
			"mes"=>"SUCCESS",
			"error"=>"SUCCESS",
		);
		echo json_encode($data);
		exit;
	}else{
		$data['returnCode'] = 1;
		$data['detail'] = array(
			"mes"=>"FAIL",
			"error"=>"数据提交失败",
		);
		echo json_encode($data);
		exit;
	}
function QuerySql($sql){
	$con = $GLOBALS['conn'];
	if(mysqli_query($con,$sql)){
		return true;
	}else{
		$data['returnCode'] = 2;
		$data['detail'] = array(
			"mes"=>"FAIL",
			"error"=>mysqli_error($con),
		);
//		die("数据操作错误：".mysqli_error($con)."====$sql");
		die(json_encode($data));
		return false;
	}
}


?>