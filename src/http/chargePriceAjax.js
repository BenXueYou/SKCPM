import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var priceAjax = {
  getChargePrice(xhr) {
    let url = `${RestApi.api.ChargePriceAjax.getChargePrice}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  putChargePrice(xhr) {
    let url = `${RestApi.api.ChargePriceAjax.putChargePrice}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  realAlarmData(xhr) {
    let url = `${RestApi.api.ChargePriceAjax.realAlarmData}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
};

function install(Vue) {
  Vue.prototype.$PriceAjax = priceAjax;
}

export default install;
