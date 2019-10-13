<?php
require_once "../con.php";
require_once '../logs/Loggle.php';
/*
 获取汽车列表的数据，以租赁方案id为连接字段
 * 
 * */
$sql = "select * from carlist,rent_scheme where carlist.rentid=rent_scheme.rentid";
$flags = QuerySql($sql);
if($flags){
	$data['returnCode'] = 0;
	$detail = array();
	while($row = mysqli_fetch_array($flags,MYSQLI_ASSOC)){
		array_push($detail,$row);
	}
	$data['detail'] = $detail;
	echo json_encode($data);
}else{
	$data['returnCode'] = 1;
	$data['detail'] = array(
		"mes"=>"FAIL",
		"error"=>"no message",
	);
	echo json_encode($data);
}
function QuerySql($sql){
	$con = $GLOBALS['conn'];
	if(mysqli_query($con,$sql)){
		return mysqli_query($con,$sql);
	}else{
		$data['returnCode'] = 2;
		$data['detail'] = array(
			"mes"=>"FAIL",
			"error"=>mysqli_error($con),
		);
		$msg="数据操作错误：".mysqli_error($con)."====$sql";
		$GLOBALS['loggle']->logs($msg);
	    die(json_encode($data));
		return json_encode($data);
	}
} 
?>