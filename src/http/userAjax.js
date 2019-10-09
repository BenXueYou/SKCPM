import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var userAjax = {
  deleteOperator(xhr) {
    let url = `${RestApi.api.UserAjax.deleteOperator}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getOperatorListByPage(xhr) {
    let url = `${RestApi.api.UserAjax.getOperatorList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addOperator(xhr) {
    let url = `${RestApi.api.UserAjax.addOperator}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  editOperatorOptions(xhr) {
    let url = `${RestApi.api.UserAjax.editOperatorOptions}`;
    return axios({
      method: "post",
      url,
      params: xhr
    });
  },
  updateOperator(xhr) {
    let url = `${RestApi.api.UserAjax.updateOperator}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getOperatorList(xhr) {
    let url = `${RestApi.api.UserAjax.getOperatorOptions}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
};

function install(Vue) {
  Vue.prototype.$userAjax = userAjax;
}

export default install;
