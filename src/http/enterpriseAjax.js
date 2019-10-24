import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var EnterpriseAjax = {
  deleteEnterPriseUserApi(xhr) {
    let url = `${RestApi.api.EnterpriseManageApi.deleteEnterPriseUserApi}`;
    return axios({
      method: "post",
      headers: {
        'content-type': 'application/json'
      },
      url,
      params: { operatorIds: xhr.toString() }
    });
  },
  getEnterPriseUserApi(xhr) {
    let url = `${RestApi.api.EnterpriseManageApi.getEnterPriseUserApi}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  postEnterPriseUserApi(xhr) {
    let url = `${RestApi.api.EnterpriseManageApi.postEnterPriseUserApi}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  updateEnterPriseUserApi(xhr) {
    let url = `${RestApi.api.EnterpriseManageApi.updateEnterPriseUserApi}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },

  getEnterPriseStaffApi(xhr) {
    let url = `${RestApi.api.EnterpriseManageApi.getEnterPriseStaffApi}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  deleteEnterPriseStaffApi(xhr) {
    let url = `${RestApi.api.AuthorityAccount.deleteEnterPriseStaffApi}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  checkEnterPriseStaffApi(xhr) {
    let url = `${RestApi.api.AuthorityAccount.checkEnterPriseStaffApi}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
};

function install(Vue) {
  Vue.prototype.$EnterpriseAjax = EnterpriseAjax;
}

export default install;
