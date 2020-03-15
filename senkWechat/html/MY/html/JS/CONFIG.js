const CONFIGS = {
  WXPAYSERVER: function () {
    return "http://gxbie.com/LanChuang/wechatPay/unifiedOrder?payid=";
  },
  ALIPAYSERVER: function () {
    return "https://gxbie.com/LanChuang/wechatPay/alipayUnifiedOrder?payid=";
  },
  /* Server */
  LANCHUANG: function () {
    return "http://sksenk.cn/"; // 天翼云平台
  },
  URLManage: function () {
    const URLHeader = "http://47.104.204.250:8080";
    const URLObj = {
      registerWechatApi: `${URLHeader}/weChat/register`,
      getUserInfoApi: `${URLHeader}/weChat/query/detail`,
      postUserInfoApi: `${URLHeader}/weChat/update`,
      changeUserStateApi:`${URLHeader}/weChat/update-user-status`,
      getCpileBaseInfoApi: `${URLHeader}/scan/charge/get-pile-baseInfo`,
      getCpileStateoApi: `${URLHeader}/scan/charge/check-pile`,

      getMsgCodeApi: `${URLHeader}/weChat/verificationCode`,
      postWithDrawApi: `${URLHeader}/weChat/withdraw`,

      getRealTimeData: `${URLHeader}/scan/charge/get-real-time-data`,
      getSerialNoApi: `${URLHeader}/scan/charge/getSerialNo`,
      getOrderBySerialNoApi: `${URLHeader}/scan/charge/query-order-detail-by-serialNo`,
      startChargeApi: `${URLHeader}/scan/charge/startCharge`,
      stopChargeApi: `${URLHeader}/scan/charge/stopCharge`,

      postPayOrderApi: `${URLHeader}/weChat/deposit/save`,
      getPayOrderAPi: `${URLHeader}/weChat/deposit/record`,
      getChargeRecordApi: `${URLHeader}/weChat/charge/record-by-openId`,
      getRefrundOrderAPi: `${URLHeader}/weChat/withdraw-list-by-page`,

      getCSList: `${URLHeader}/map/query/near/list`,
      getCSDetail: `${URLHeader}/map/query/station/detail`,
      getPileList: `${URLHeader}/map/query/station/list`,

    };
    return URLObj;
  },
  TURLManage: function () {
    const URLHeader = "http://129.28.156.99:8080";
    const URLObj = {
      registerWechatApi: `${URLHeader}/weChat/register`,
      getUserInfoApi: `${URLHeader}/weChat/query/detail`,
      postUserInfoApi: `${URLHeader}/weChat/update`,
      changeUserStateApi:`${URLHeader}/weChat/update-user-status`,
      getCpileBaseInfoApi: `${URLHeader}/scan/charge/get-pile-baseInfo`,
      getCpileStateoApi: `${URLHeader}/scan/charge/check-pile`,

      getMsgCodeApi: `${URLHeader}/weChat/verificationCode`,
      postWithDrawApi: `${URLHeader}/weChat/withdraw`,

      getRealTimeData: `${URLHeader}/scan/charge/get-real-time-data`,
      getSerialNoApi: `${URLHeader}/scan/charge/getSerialNo`,
      getOrderBySerialNoApi: `${URLHeader}/scan/charge/query-order-detail-by-serialNo`,
      startChargeApi: `${URLHeader}/scan/charge/startCharge`,
      stopChargeApi: `${URLHeader}/scan/charge/stopCharge`,

      postPayOrderApi: `${URLHeader}/weChat/deposit/save`,
      getPayOrderAPi: `${URLHeader}/weChat/deposit/record`,
      getChargeRecordApi: `${URLHeader}/weChat/charge/record-by-openId`,
      getRefrundOrderAPi: `${URLHeader}/weChat/withdraw-list-by-page`,

      getCSList: `${URLHeader}/map/query/near/list`,
      getCSDetail: `${URLHeader}/map/query/station/detail`,
      getPileList: `${URLHeader}/map/query/station/list`,

    };
    return URLObj;
  },
  GETOUTTRADENO: function (cpid) {
    var indexNo = cpid.substr(0, 6) + cpid.substr(-6, 6);
    var ts = new Date();
    var td = ts.getDate(); // day
    td = td < 10 ? "0" + td : td;
    var ty = ts.getFullYear();//
    var tm = ts.getMonth() + 1;
    tm = tm < 10 ? "0" + tm : tm;
    var th = ts.getHours();
    th = th < 10 ? "0" + th : th;
    var tmin = ts.getMinutes();
    tmin = tmin < 10 ? "0" + tmin : tmin;
    var tsd = ts.getSeconds();
    tsd = tsd < 10 ? "0" + tsd : tsd;
    return ("sk" + indexNo + ty + tm + td + th + tmin + tsd);  }
};
