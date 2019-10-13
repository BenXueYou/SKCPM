<?php
        
        require_once "../lib/WxPay.Api.php";
        require_once "../lib/con.php";
        require_once "WxPay.JsApiPay.php";
        $openId = $_GET["openId"];
        $total_fee = $_GET["total_fee"];
        $Out_trade_no = $_GET["out_trade_no"];
        $total_fee = $total_fee * 100;
        date_default_timezone_set('Asia/Shanghai');//设置时区

        //②、统一下单
            $tools = new JsApiPay();
            $input = new WxPayUnifiedOrder();
            $input->SetBody("广西蓝创新能源汽车设备有限公司");
            $input->SetAttach("test");
            $input->SetOut_trade_no($Out_trade_no);
            $input->SetTotal_fee($total_fee);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 36000));
            $input->SetGoods_tag("test");
            $input->SetNotify_url("https://www.gxbie.com/LanChangWechat/html/MY/wx_pay/WechatPay/notify.php");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            //下单并获取返回的结果
            $order = WxPayApi::unifiedOrder($input);
            //获取并解析返回的参数
            $jsApiParameters = $tools->GetJsApiParameters($order);

            //echo $jsApiParameters->paySign;
            // "获取cpuserid与账户余额"
            $sql1 = "SELECT CPUSERID , ACCOUNTSUM FROM CPUSERINFO WHERE OPENID = '$openId'";
            $sql1Res = QuerySql($sql1);
            if($sql1Res){
                $detail = array();
                while($row = mysqli_fetch_array($sql1Res,MYSQLI_ASSOC)){
                    array_push($detail,$row);
                }
                $result = $detail[0];
                $cpuserid = $result["CPUSERID"];
                $PreAccountSum = $result["ACCOUNTSUM"];
                $money = $total_fee/100;
                
                $showtime=date("Y-m-d H:i:s");

               if($cpuserid == null || $cpuserid == ""){
                 
                   $arr = array();
                    array_push($arr, $Out_trade_no);
                    array_push($arr, "false");
                    //将数组打包成JSON格式
                    $obj = json_encode($arr);

                    echo $obj;
                 	return;
               }
               
                $sql2 = "INSERT INTO appuserrechargerecord (cpuserid,rechargetime,rechargemoney,PaymentModeId,TransactionNum,MerchantNum,PayResultFlag,FailDesp,Signature,PreAccountSum) VALUES ($cpuserid,'$showtime',$money,'3','$Out_trade_no','$Out_trade_no','1','未支付','',$PreAccountSum)";
                $flagRes = QuerySql($sql2);

                 //组装成数组
                $arr = array();
                array_push($arr, $Out_trade_no);
                array_push($arr, json_decode($jsApiParameters));
                //将数组打包成JSON格式
                $obj = json_encode($arr);

                echo $obj;


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
                $res = mysqli_query($con,$sql);
                if($res){
                    return $res; 
                }else{
                    $data['returnCode'] = 2;
                    $data['detail'] = array(
                        "mes"=>"FAIL",
                        "error"=>mysqli_error($con),
                    );
                    die("数据操作错误：".mysqli_error($con)."====$sql");
                    die(json_encode($data));
                    return false;
                }
            }

?>
