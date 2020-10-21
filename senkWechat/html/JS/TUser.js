var User = {
  // 企业用户注册
  CmpEmpRegist: function (url, cmpId, openId, phone, name, phoneCode, psw, signId) {
    // var mask = mui.createMask();
    url = url + "";
    var postData = {
      COMPANYID: cmpId,
      openId: openId,
      phone: phone,
      name: name,
      phoneCode: phoneCode,
      psw: psw,
      signId: ""
    };
    ajaxBase("POST", url, false, postData, function (returnData) {
    });
  },
  // 获取用户当前状态
  getUserState: function (url, userid, callback) {
    var postData = {
      openId: userid,
    };
    ajaxBase("GET", url, false, postData, function (data) {
      if (data && data.model) {
        var user = data.model;
        localStorage.setItem('$users', JSON.stringify(user));
        callback(user);
      } else {
        callback();
      }
    });
  },
  // 改变用户状态，取消用户标记
  UserChange: function (url, userid, callback) {
    var postData = {
      userId: userid,
    };
    // url = url + '?userId=' + userid;
    ajaxBase('POST', url, false, postData, function (data) {
      if (data && data.success) {
        callback(data.success);
      } else {
        callback();
      }
    });
  },

  getPileChargeData: function (url, userid, callback) {
    window.chargeData = false;
    var data = {
      userId: userid
    };
    var DataObj = {};
    ajaxBase("GET", url, false, data, function (res) {
      if (res && res.success) {
        let dataInfo = res.model;
        // 未检测到离线
        if (dataInfo.serialNo) {
          // 检测到充电结束
          location.href = "TfinishCharge.php?serialNo=" + dataInfo.serialNo;
          callback();
        } else {
          DataObj.dateTime = getDateString() || 0;
          Object.assign(DataObj, dataInfo);
          callback(DataObj);
        }
      } else {
        callback();
      }
    });
  },

  userIsLogin: function () {
    var userInfo = {
      "balance": 0,
      "chargeState": 0,
      "companyCode": "string",
      "gmtCreate": "2019-10-14T03:39:19.525Z",
      "gmtModify": "2019-10-14T03:39:19.525Z",
      "id": 0,
      "imgUrl": "string",
      "isDeleted": "2019-10-14T03:39:19.525Z",
      "nickName": "string",
      "openId": "string",
      "telephone": "string",
      "userId": "string",
      "userName": "string",
      "userType": 0
    };
    localStorage.setItem('$user', userInfo);
    var user = localStorage.getItem('$users') || "{}";
    if (user) {
      return JSON.parse(user);
    } else {
      return {};
    }
  },
  // 获取用户本次充电账单结算信息
  getUserChargeData: function (url, userid, serialNo, callback) {
    var postData = {
      userid: userid,
      serialNo: serialNo
    };
    const method = "GET";
    var dataInfo = {};
    ajaxBase(method, url, false, postData, function (data) {
      if (data.success) {
        var dto = data.model;
        dataInfo.chargeStartTime = dto.chargeStartTime;
        dataInfo.chargeTimeSpan = dto.timeSpan;
        dataInfo.chargeQuantity = dto.chargeQuantity;
        dataInfo.chargeMoney = dto.chargeMoney;
        dataInfo.transationId = dto.transactionId;
        dataInfo.totalfee = dto.chargeMoney + dto.serviceTip;
        dataInfo.serviceTip = dto.serviceTip;
        let chargeTimeSpan = dataInfo.chargeTimeSpan;
        if (chargeTimeSpan > 60) {
          var min = chargeTimeSpan / 60;
          var h = 0;
          if (min > 60) {
            min = min % 60;
            h = min / 60;
            h = h.toFixed(0);
          }
          // var s = chargeTimeSpan % 60;
          let ts = min + h * 60;
          let t = ts.toFixed(0);
          dataInfo.chargeTimeSpan = t;
        } else {
          let t = chargeTimeSpan / 60;
          t = t.toFixed(0);
          dataInfo.chargeTimeSpan = t;
        }
        callback(dataInfo);
      } else if (data.returnCode == 1) {
        alert("充电桩超时，订单将会以充电记录的形式出现");
        callback();
      } else {
        callback();
      }
    });
  },
};
function ajaxBase(method, url, asyn, data, callback) {
  var mask = mui.createMask();
  mui.ajax(url, {
    data: data,
    type: method,
    timeout: 10000,
    crossDomain: true,
    beforeSend: function () {
      mask.show(); // 显示遮罩层
    },
    complete: function () {
      mask.close(); // 关闭遮罩层
    },
    success: function (e) {
      if (e.success) {
        callback(e);
      } else {
        mui.alert(e.errorMessage);
        callback();
      }
    },
    error: function (xhr) {
      callback();
    }
  });
}

function getDateString() {
  var ts = new Date();
  var td = ts.getDate(); // day
  var ty = ts.getFullYear(); //
  var tm = ts.getMonth() + 1;
  var th = ts.getHours();
  var tmin = ts.getMinutes();
  var tsd = ts.getSeconds();
  var dtime = ty + "-" + (tm < 10 ? "0" + tm : tm) + "-" + (td < 10 ? "0" + td : td) + "&nbsp" + (th < 10 ? "0" + th : th) + ":" + (tmin < 10 ? "0" + tmin : tmin) + ":" + (tsd < 10 ? "0" + tsd : tsd);
  return dtime;
}
