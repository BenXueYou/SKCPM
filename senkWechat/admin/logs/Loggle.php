<?php
class Loggle{
	
     static public function logs($msg){
     	 $filePath = dirname(__FILE__);
	     date_default_timezone_set("Asia/Shanghai");
	     $startDate = Date("Y-m-d H:i:s:u"); 
     	 file_put_contents(dirname(__FILE__)."/logs.log", '【'.$startDate.'】'.$msg."\n",FILE_APPEND);
     }
     
     static public function flogs($msg){
     	define('_ROOT', str_replace("\\", '/', dirname(__FILE__)));
     	$myfile = fopen(_ROOT."/newfile.log","r") or die("Unable to open file!");
//   	$myfile = fopen("","w") or die("Unable to open file!");
		fwrite($myfile, $msg."\n");
		fclose($myfile);
     }
}
?>