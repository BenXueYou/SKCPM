var Pile = {
  // 获取所有充电站信息
  getCSList: function (url, data, callback) {
    mui.ajax(url, {
      data: data,
      type: "POST",
      timeout: 10000,
      headers: {'Content-Type': 'application/json'},
      crossDomain: true,
      success: function (data) {
        console.log(JSON.stringify(data));
        if (data.success) {
          var detail = data.model;
          callback(detail);
        } else {
          callback();
        }
      },
      error: function (jqxhr) {
        console.log("请求桩列表====" + jqxhr);
        callback();
      },
    });
  },
  // :根据扫码的设备号获取枪的状态
  pileState: function (url, cpid, callback) {
    var mask = mui.createMask();
    window.res = 0;
    mui.ajax(url, {
      data: {
        deviceId: cpid
      },
      type: "GET",
      crossDomain: true,
      timeout: 10000, // 超时时间：10秒
      beforeSend: function () {
        mask.show(); // 显示遮罩层
      },
      complete: function () {
        mask.close(); // 关闭遮罩层
      },
      success: function (data) {
        if (data.success) {
          callback(data.model);
        } else {
          callback();
        }
      },
      error: function (jqx, error, type) {
        alert("网络异常，请稍后再试");
        callback();
      }
    });
  },
  // 当桩正在被使用，则根据用户id，获取该正在充电的桩的信息(cpid)
  pileMsg: function (url, openid, callack) {
    mui.ajax(url, {
      data: {
        deviceId: openid,
        platform: 1
      },
      dataType: "JSON",
      type: "GET",
      crossDomain: true,
      timeout: 10000, // 超时时间：10秒
      success: function (data) {
        if (data.success) {
          callack(data.model);
        } else {
          alert(data.errorMessage);
          callack();
        }
      },
      error: function (xhr) {
        console.log(xhr);
        alert('请求错误');
        callack();
      }
    });
  },

  pileStart: function (url, data, callback) {
    var mask = mui.createMask();
    mui.ajax(url, {
      type: "POST",
      headers: {'Content-Type': 'application/json'},
      dataType: 'json',
      data: data,
      crossDomain: true,
      timeout: 35000,
      beforeSend: function () {
        mask.show(); // 显示遮罩层
      },
      complete: function () {
        mask.close(); // 关闭遮罩层
      },
      success: function (data) {
        if (data.success) {
          callback(data.success);
        } else {
          callback();
        }
      },
      error: function (xhr, type, error) {
        callback();
      }
    });
  },

  pileStop: function (url, openid, callback) {
    var mask = mui.createMask();
    url = url+"?userId="+openid;
    mui.ajax(url, {
      dataType: "json",
      headers: {'Content-Type': 'application/json'},
      type: "GET",
      crossDomain: true,
      timeout: 15000,
      beforeSend: function () {
        mask.show(); // 显示遮罩层
      },
      complete: function () {
        mask.close(); // 关闭遮罩层
      },
      success: function (data) {
        if (data.success) {
          callback(data.success);
        } else {
          callback();
        }
      },
      error: function (xhr, type, error) {
        callback();
        console.log(xhr)
        mask.close();
      }
    });
  },

  getSerialNo: function (url, openid, callback) {
    var mask = mui.createMask();
    var result = false;
    mui.ajax(url, {
      data: {
        userId: openid,
        platform: 1
      },
      dataType: "JSON",
      type: "GET",
      crossDomain: true,
      timeout: 15000,
      beforeSend: function () {
        mask.show(); // 显示遮罩层
      },
      complete: function () {
        mask.close(); // 关闭遮罩层
        callback(result);
      },
      success: function (data) {
        // data就是返回的json数据
        if (data.success) {
          result = data.model;
          callback(data.model);
        } else {
          mui.alert("网络延迟，账单请查看充电记录");
          callback();
        }
      },
      error: function (xhr, type, error) {
        callback();
      }
    });
  },
};
