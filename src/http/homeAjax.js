import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var homeAjax = {
  trend(data) {
    let url = `${RestApi.api.HomeAjax.trend}`;
    return axios({
      method: "post",
      url,
      data
    });
  },
  summary(xhr) {
    let url = `${RestApi.api.HomeAjax.summary}`;
    return axios({
      method: "post",
      url,
      params: xhr
    });
  },
};

function install(Vue) {
  Vue.prototype.$homeAjax = homeAjax;
}

export default install;
