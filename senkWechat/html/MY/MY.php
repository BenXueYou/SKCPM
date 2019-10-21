<?php
$APPID = 'wx031732af628faee0';
$REDIRECT_URI = 'https://www.gxbie.com/LanChangWechat/html/MY/My_record.php';
$scope = 'snsapi_base';
//$scope='snsapi_userinfo';//需要授权
$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $APPID . '&redirect_uri=' . urlencode($REDIRECT_URI) . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect';
//header("Location:".$url);
header("Location:" . $url);
