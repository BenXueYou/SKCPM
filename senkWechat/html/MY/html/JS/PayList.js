(function ($, owner) {
  owner.getPayList = function (url, userid, callback) {
    callback = callback || $.noop;
    userid = userid || {};
    var res = "";
    url = url + "/userManager/loadAccountInfo";
    $.ajax(url, {
      data: {
        userId: userid
      },
      type: 'get',
      timeout: 10000,
      success: function (data) {
        console.log("获取充值记录" + data + "==" + JSON.stringify(data));
        if (data.returnCode == 0) {
          // 返回list
          res = data.detail.recorder;
        } else if (data.returnCode == 1) {
          // 没有数据
          res = 101;
        } else {
          // 账号有误
          res = 102;
        }
        callback(res);
      },
      error: function (xhr) {
        // AJAX出错
        res = 104;
        callback(res);
      }
    });
  };
}(mui, window.Pay = {}));
