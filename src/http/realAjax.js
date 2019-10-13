import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var realAjax = {
  realPileData(xhr) {
    let url = `${RestApi.api.RealAjax.realPileData}`;
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
  realSwitchData(xhr) {
    let url = `${RestApi.api.RealAjax.switchDataRecord}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
};

function install(Vue) {
  Vue.prototype.$realAjax = realAjax;
}
export default install;
