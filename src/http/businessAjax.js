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
  appLogin(xhr) {
    let url = `${RestApi.api.appLogin}`;
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
