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
      //   if (returnData) {
      //   } else {
      //     callback(fasle);
      //   }
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
    var DataObj = {
      voltageA: 0,
      voltageB: 0,
      voltageC: 0,
      currentA: 0,
      currentB: 0,
      currentC: 0,
      chargeDuration: 0,
      quantity: 0,
      price: 0,
      fee: 0,
      dateTime: "----.--.-- --:--",
      deviceId: 0,
      gun: 0,
      cpType: 0
    };
    ajaxBase("GET", url, false, data, function (res) {
      if (res && res.success) {
        let dataInfo = res.model;
        // 未检测到离线
        if (dataInfo.serialNo) {
          // 检测到充电结束
          location.href = "finishCharge.php?serialNo=" + dataInfo.serialNo;
          callback();
        } else {
          DataObj.dateTime = getDateString() || 0;
          Object.assign(DataObj, dataInfo);
          callback(DataObj);
        }
      } else {
        const msg = '未检测到桩数据信号,强制退出则取消对本次充电的监控，重新扫码充电';
        mui.alert(msg);
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
  UploadUserMsg: function (url, user, callback) {
    // var mask = mui.createMask();
    url = url + "userManager/updateProfile";
    var data = {
      name: user.cpUserName,
      IdentificationCode: user.vin,
      sex: user.sex,
      codeMode: "Android",
      userId: user.cpUserId,
      plateNumber: user.platform
    };
    // 上传基本信息
    ajaxBase("POST", url, true, data, function (e) {
      var data = e;
      //			console.log("修改个人资料：" + user.cpUserId + "====" + JSON.stringify(e));
      if (data == null) {
        callback();
      }
      if (data.returnCode == 0) { // 修改成功
        var users = JSON.parse(localStorage.getItem('$users') || '[]');
        users.splice(0, users.length);
        users.push(user);
        localStorage.setItem('$users', JSON.stringify(users));
        callback();
      } else {
        callback();
      }
    });
    // 上传头像
    uploaderHeadImg(user.headImgurl, user.cpUserId);
  }

};
var files = [];
var index = 1;
var newUrlAfterCompress;
function uploaderHeadImg(fileSrc, userId) {
  console.log("图片路径=" + fileSrc);
  var dstname = "_downloads/" + getUid() + ".jpg"; // 设置压缩后图片的路径
  plus.zip.compressImage({
    src: fileSrc,
    dst: dstname,
    overwrite: true,
    quality: 20
  },
  function (event) {
    console.log("Compress success:" + event.target);
    appendFile(dstname); // 添加图片
    var urlStr = CONFIGS.LANCHUANG() + "userManager/uploadPortrait";
    var task = plus.uploader.createUpload(urlStr, {
      method: "POST"
    },
    function (t, status) { // 上传完成
      if (status == 200) {
        console.log(t.responseText);
        var result = JSON.parse(t.responseText);
        mui.toast(result.message);
      } else {
        console.log("上传失败：" + status);
      }
    }
    );

    for (var i = 0; i < files.length; i++) {
      var f = files[i];
      task.addFile(f.path, {
        key: f.name
      });
      console.log(JSON.stringify(files[i]));
    }
    task.addData('userId', "78503239");
    task.start();
  },
  function (error) {
    console.log(error);
    return src;
  });
}

// 向文件数组中添加图片
function appendFile(p) {
  files.push({
    path: p,
    name: "uploadkey_" + index
  });
  index++;
}
// 产生一个随机数
function getUid() {
  return Math.floor(Math.random() * 100000000 + 10000000).toString();
}
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
      console.log(url + ":", xhr);
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

function CurentTime() {
  var now = new Date();
  var year = now.getFullYear(); // 年
  var month = now.getMonth() + 1; // 月
  var day = now.getDate(); // 日
  var hh = now.getHours(); // 时
  var mm = now.getMinutes() - GetRandomNum(3.0, 1.0); // 分
  var clock = year + "-";
  if (month < 10) { clock += "0"; }
  clock += month + "-";
  if (day < 10) { clock += "0"; }
  clock += day + " ";
  if (hh < 10) { clock += "0"; }
  clock += hh + ":";
  if (mm < 10) clock += '0';
  clock += mm;
  return (clock);
}

// 随机数
function GetRandomNum(Min, Max) {
  var Range = Max - Min;
  var Rand = Math.random();
  return (Min + Math.round(Rand * Range));
}
