<?php
//     $conn=mysqli_connect("rm-m5e787i1v45kyah4to.mysql.rds.aliyuncs.com","root_sxsk","Sxsk1219") or die("数据库服务器连接错误".mysqli_connect_error($conn));
//     mysqli_select_db($conn,"cpm") or die("数据库访问错误".mysqli_connect_error($conn));
 	error_reporting(0);  
       mysqli_query($conn,"set character set utf8");
       mysqli_query($conn,"set names utf8");
       $HOST = "rm-m5e787i1v45kyah4to.mysql.rds.aliyuncs.com";
//     $HOST = "192.168.8.212:3306/?useSSL=false";
       $USERNAME = "root_sxsk";
//     $USERNAME = "admin";
       $PASSWORD = "Sxsk1219";
//     $PASSWORD = "123456";
       $DATABASE = "cpm";
//     $DATABASE = "shangkuan";
//     $conn=mysqli_connect($HOST,$USERNAME,$PASSWORD) or die("数据库服务器连接错误".mysqli_connect_error($conn));
//	mysqli_select_db($conn,$DATABASE) or die("数据库访问错误".mysqli_connect_error($conn));
      
       require_once 'logs/Loggle.php';
       $loggle = new Loggle();

       
       if(!mysqli_connect($HOST,$USERNAME,$PASSWORD)){
       	$loggle->logs("数据库服务器连接错误".mysqli_connect_error($conn));
       }else{
              $conn=mysqli_connect($HOST,$USERNAME,$PASSWORD);
       }
       if(!mysqli_select_db($conn,$DATABASE)){
       	$loggle->logs("数据库访问错误".mysqli_connect_error($conn));
       }else{
       	mysqli_select_db($conn,$DATABASE);
       }

      
                
?>