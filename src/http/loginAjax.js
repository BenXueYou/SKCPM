import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var loginAjax = {
  login(data) {
    let url = RestApi.api.login.login;
    return axios({
      method: 'POST',
      url,
      data
    });
  },
  logout(data) {
    let url = `${RestApi.api.login.logout}`;
    return axios({
      method: "post",
      url,
      data
    });
  },
  modifyPassword(data) {
    let url = `${RestApi.api.login.modifyPassword}`;
    return axios({
      method: "post",
      url,
      data
    });
  },
};

function install(Vue) {
  Vue.prototype.$loginAjax = loginAjax;
}

export default install;
