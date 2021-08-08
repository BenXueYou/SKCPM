 <?php
    require_once "../lib/WxPay.Api.php";
    
        $out_trade_no = $_GET["out_trade_no"];
        $input = new WxPayOrderQuery();
	    $input->SetOut_trade_no($out_trade_no);
	    $result = WxPayApi::orderQuery($input);
	  if(array_key_exists("return_code", $result)
		 && array_key_exists("result_code", $result)
		 && array_key_exists("trade_state", $result)
		 && $result["return_code"] == "SUCCESS"
		 && $result["return_code"] == "SUCCESS"
		 && $result["trade_state"] == "SUCCESS")
	 {
		 $res=1;
	 }else{
            $res=0;
	 }
        echo $res;
?>
