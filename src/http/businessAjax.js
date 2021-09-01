import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export const businessAjax = {
  // 充电记录
  getChargeRecordTotal(xhr) {
    let url = `${RestApi.api.BusinessAjax.getChargeRecordTotal}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  exportChargeRecord(xhr) {
    let url = `${RestApi.api.BusinessAjax.exportChargeRecord}`;
    return axios({
      responseType: 'arraybuffer', // 二进制流
      method: "post",
      url,
      data: xhr
    });
  },
  getChargeRecordList(xhr) {
    let url = `${RestApi.api.BusinessAjax.getChargeRecordList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  updateChargeRecord(xhr) {
    let url = `${RestApi.api.BusinessAjax.updateChargeRecord}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  // 扣款记录
  deductRecordList(xhr) {
    let url = `${RestApi.api.BusinessAjax.deductRecordList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  // 充值记录
  getRechargeRecord(xhr) {
    let url = `${RestApi.api.BusinessAjax.getRechargeRecord}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  exportRechargeRecord(xhr) {
    let url = `${RestApi.api.BusinessAjax.exportRechargeRecord}`;
    return axios({
      responseType: 'arraybuffer', // 二进制流
      method: "post",
      url,
      data: xhr
    });
  },
  // 退款记录
  getRefrundRecord(xhr) {
    let url = `${RestApi.api.BusinessAjax.getRefrundRecord}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },

  // 充电报表
  getChargeReport(xhr) {
    let url = `${RestApi.api.BusinessAjax.getChargeReport}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  // 获取卡充值记录
  getCardDepositList(xhr) {
    let url = `${RestApi.api.BusinessAjax.getCardDepositList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  // 获取新增卡充值记录
  saveCardUserDeposit(xhr) {
    let url = `${RestApi.api.BusinessAjax.saveCardUserDeposit}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  // 根据卡号查询卡充电记录
  getCardChargeRecordByCardNum(xhr) {
    let url = `${RestApi.api.BusinessAjax.getCardChargeRecordByCardNum}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  // 根据用户名查询卡充电记录
  getCardChargeRecordByUserName(xhr) {
    let url = `${RestApi.api.BusinessAjax.getCardChargeRecordByUserName}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  // 导出卡充电记录
  exportCardChargeRecordExcel(xhr) {
    let url = `${RestApi.api.BusinessAjax.exportCardChargeRecordExcel}`;
    return axios({
      responseType: 'arraybuffer', // 二进制流
      method: "post",
      url,
      data: xhr
    });
  },
};

function install(Vue) {
  Vue.prototype.$businessAjax = businessAjax;
}

export default install;
