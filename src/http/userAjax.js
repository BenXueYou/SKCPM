import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var userAjax = {
  deleteOperator(xhr) {
    let url = `${RestApi.api.UserAjax.deleteOperator}`;
    return axios({
      method: "post",
      headers: {
        'content-type': 'application/json'
      },
      url,
      params: { operatorIds: xhr.toString() }
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
  getAppUserList(xhr) {
    let url = `${RestApi.api.UserAjax.getAppUserList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getAccountUserList(xhr) {
    let url = `${RestApi.api.AuthorityAccount.getAccountUserList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addCompanyUser(xhr) {
    let url = `${RestApi.api.AuthorityAccount.addCompanyUser}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addAdminUser(xhr) {
    let url = `${RestApi.api.AuthorityAccount.addAdminUser}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  deleteUserList(xhr) {
    let url = `${RestApi.api.AuthorityAccount.deleteUserList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  updateUserList(xhr) {
    let url = `${RestApi.api.AuthorityAccount.updateUserList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getCardUserList(xhr) {
    let url = `${RestApi.api.UserAjax.getCardUserList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  saveCardUserDeposit(xhr) {
    let url = `${RestApi.api.UserAjax.saveCardUserDeposit}`;
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
