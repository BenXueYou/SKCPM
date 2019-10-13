<?php
/*
 测试接口，测试添加车型
 * 
 * */
require_once "../con.php";
require_once '../logs/Loggle.php';
date_default_timezone_set("Asia/Shanghai");	

$sql="create table carlist(
carid         int(2) primary key,
cartype       varchar(20) not null,
carengytype   varchar(20),
carx         int(4),
cary         int(4),
carz         int(4),
cardrivetype  varchar(10),
wheelbase     int(4),
frontoverhang int(4),
rearoverhang  int(4),
trackfront    int(4),
rearfront     int(4),
minspace      int(4),
midspace      int(4),
ratednum      int(2),
ratedchair    int(2)
)";
$flag = QuerySql($sql);
$loggle = new Loggle();
$GLOBALS['loggle'] = $loggle;
if($flag){
	$data['returnCode'] = 0;
	$data['detail'] = array(
	"mes"=>"SUCCESS",
	"error"=>"SUCCESS",
	);
	$GLOBALS['loggle']->logs("车参数表格创建成功");
	echo json_encode($data);
	exit;
}else{
	$data['returnCode'] = 1;
	$data['detail'] = array(
		"mes"=>"FAIL",
		"error"=>"数据提交失败",
	);
	$GLOBALS['loggle']->logs("车参数表格创建失败");
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
		$msg="数据操作错误：".mysqli_error($con)."====$sql";
		$GLOBALS['loggle']->logs($msg);
	    die(json_encode($data));
		return false;
	}
}


?>