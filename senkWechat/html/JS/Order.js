var Order = {
  // 微信公众号支付下单
  getOrderToWechat: function (url, openid, out_trade_no, total_fee, callback) {
    url = "https://www.gxbie.com/LanChangWechat/html/MY/wx_pay/WechatPay/wxPayOrder.php";
    console.log("url======" + url + "==openid===" + openId);
    $.ajax({
      type: "GET",
      url: url,
      dataType: "json",
      timeout: 10000,
      data: {
        openId: openid,
        total_fee: total_fee,
        out_trade_no: out_trade_no,
      },
      success: function (data) {
        console.log(data); // 日志传输
        // outTradeNo = data[0];
        var order = data[1];

        // alert("---"+order);

        if (order == false || order == "false") {
          order = "100";
        }
        callback(order);
      },
      error: function (jqXHR) {
        alert("下单发生错误");
        // alert(jqXHR + "下单发生错误：" + JSON.stringify(jqXHR));
        console.log("get wechat pay order error!!!" + JSON.stringify(jqXHR));
        callback(false);
      }
    });
  },
  // 微信公众号提现
  /*
	*
	*
	*/
  getUserMoneyFromWechat: function (url, openId, partner_trade_no, amount, callback) {
    url = url + "../MY/wx_pay/WechatPay/transferJsApi.php";

    var mask = mui.createMask();
    var result = "0";
    var postData = {
      openId: userid,
      partner_trade_no: partner_trade_no,
      amount: amount
    };

    ajaxBase(url, false, postData, function (data) {
      if (data) {
        try {
          data = JSON.parse(data);
        } catch (data) {
          // TODO handle the exception
        }
        if (data["return_code"] == "SUCCESS" && data["result_code"]) {
          callback("提现成功");// 通知后台，余额为零
        } else {
          callback(data["return_msg"]);
        }
      } else {
        callback(false);
      }
    });
  },
  // 生成后台订单，并记录充电信息
  setMode: function (url, cpid, openid, money, payMode, out_trade_no, dcChargeMode, userAcccountSum, callback) {
    url = url + "scanCharge/setChargeMode";
    var setModeRes = 0;
    mui.ajax(url, {
      data: {
        deviceId: cpid,
        userId: openid,
        payMode: payMode,
        payValue: money,
        out_trade_no: out_trade_no,
        dcChargeMode: dcChargeMode,
        remainSum: userAcccountSum,
      },
      dataType: 'json',
      type: 'get',
      timeout: 20000,
      success: function (data) {
        console.log(JSON.stringify(data));
        if (data.returnCode == 0) {
          setModeRes = true;
          callback(setModeRes);
        } else if (data.returnCode == 1) {
          mui.alert("桩没有返回数据，操作超时,退出重新试试！！");
        } else if (data.returnCode == 2) {
          mui.alert("桩编号错误，退出重新试试");
        } else if (data.returnCode == 13) {
          mui.alert("充电桩通信故障，退出重新试试");
        } else {
          mui.alert("充电桩通信故障");
        }
      },
      error: function (xhr, type, error) {
        if (xhr.readyState == 0 || xhr.readyState == 1) {
          mui.alert("网络异常，请求未发送");
        } else if ((xhr.readyState == 2 || xhr.readyState == 3)) {
          mui.alert("请求已发送，等待服务器响应");
        } else {
          mui.alert("服务器响应异常");
          callback(false);
        }
      }
    });
  },

  // 获取所有订单

  getAllChargeOrder: function (url, userid, callback) {
    url = url + "userManager/chargeRecorderByUserId";
    var setModeRes = 0;
    mui.ajax(url, {
      data: {
        userId: userid
      },
      dataType: 'json',
      type: 'get',
      timeout: 20000,
      success: function (data) {
        console.log(JSON.stringify(data));

        if (data.returnCode == 0) {
          var detail = data.detail;
          var chargeRecorder = detail.chargeRecorder;
          callback(chargeRecorder);
        } else {
          mui.alert("没有充电记录");
          callback(false);
        }
      },
      error: function (xhr, type, error) {
        if (xhr.readyState == 0 || xhr.readyState == 1) {
          mui.alert("网络异常，请求未发送");
        } else if ((xhr.readyState == 2 || xhr.readyState == 3)) {
          mui.alert("请求已发送，等待服务器响应");
        } else {
          mui.alert("服务器响应异常");
        }
        callback(false);
      }
    });
  },

  // 获取设置的充电信息
  /*
	 * 根据用户ID，获取设置的充电信息
	 *
	 * */
  getMode: function (url, openid, callback) {
    var res = false;
    mui.ajax(url, {
      data: {
        userid: openid
      },
      dataType: "JSON",
      type: "GET",
      async: false,
      crossDomain: true,
      timeout: 10000,
      success: function (data) {

      },
      error: function (xhr, type, error) {

      }
    });

    res = {
      "cpid": "14010500000001700",
      "userstate": "0",
      "money": 10
    };

    callback(res);
  }
};

function ajaxBase(url, asyn, data, callback) {
  var mask = mui.createMask();
  mui.ajax(url, {
    data: data,
    type: 'POST',
    timeout: 10000,
    crossDomain: true,
    beforeSend: function () {
      //			plus.nativeUI.showWaiting("加载中...", {});
      mask.show(); // 显示遮罩层
    },
    complete: function () {
      //			plus.nativeUI.closeWaiting();
      mask.close(); // 关闭遮罩层
    },
    success: function (e) {
      callback(e);
    },
    error: function (xhr, type, error) {
      console.log(xhr + "---" + type + "---" + error);
      callback(false);
    }
  });
}
