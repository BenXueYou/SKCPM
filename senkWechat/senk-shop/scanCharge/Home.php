<?php

	$APPID='wx32a40fe9e54cc1c8';
    $REDIRECT_URI='http://www.senk.net.cn/senkWechat/scanCharge/scanCode.php';
    $scope='snsapi_base';
    //$scope='snsapi_userinfo';//需要授权
    $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
    header("Location:".$url);
		
?>