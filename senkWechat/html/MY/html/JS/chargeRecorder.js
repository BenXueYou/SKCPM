var ChargeRecord = {
  getChargeRecord: function (url, data, callback) {
    console.log(data);
    mui.ajax(url, {
      type: "POST",
      dataType: 'json',
      headers: {'Content-Type': 'application/json'},
      data: data,
      success: function (data) {
        console.log("充电记录=" + data);
        if (data.success) {
          callback(data);
        } else {
          mui.alert("没有抓到数据");
          callback();
        }
      },
      error: function (jqXHR) {
        mui.alert("服务器通信异常");
        callback();
        console.log(JSON.stringify(jqXHR));
      }
    });
  },
  getPayRecord: function (urlM, data, callback) {
    $.ajax({
      type: "POST",
      url: urlM,
      dataType: 'json',
      data: data,
      success: function (data) {
        console.log("支付记录=" + JSON.stringify(data));
        if (data.success) {
          var payRecorder = data.model;
          callback(payRecorder);
        } else {
          alert("没有抓到数据");
          callback();
        }
      },
      error: function (jqXHR) {
        mui.alert("服务器通信异常");
        callback();
        console.log(JSON.stringify(jqXHR));
      }
    });
  }
};
