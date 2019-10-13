import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var businessAjax = {
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
  deductRecordList(xhr) {
    let url = `${RestApi.api.BusinessAjax.deductRecordList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
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
      method: "post",
      url,
      data: xhr
    });
  },
  getRefrundRecord(xhr) {
    let url = `${RestApi.api.BusinessAjax.getRefrundRecord}`;
    return axios({
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
