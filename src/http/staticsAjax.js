import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var staticsAjax = {
  getAppUser(xhr) {
    let url = `${RestApi.api.StaticsAjax.getAppUser}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getOperator(xhr) {
    let url = `${RestApi.api.StaticsAjax.getOperator}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getChargeStation(xhr) {
    let url = `${RestApi.api.StaticsAjax.getChargeStation}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getChargePile(xhr) {
    let url = `${RestApi.api.StaticsAjax.getChargePile}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
};

function install(Vue) {
  Vue.prototype.$staticsAjax = staticsAjax;
}

export default install;
