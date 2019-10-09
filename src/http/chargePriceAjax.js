import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var staticsAjax = {
  getChargePrice(xhr) {
    let url = `${RestApi.api.RealAjax.getChargePrice}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  realAlarmData(xhr) {
    let url = `${RestApi.api.RealAjax.realAlarmData}`;
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
