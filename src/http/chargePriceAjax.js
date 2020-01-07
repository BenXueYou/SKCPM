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
  getChargePriceDetail(xhr) {
    let url = `${RestApi.api.ChargePriceAjax.getChargePriceDetail}`;
    return axios({
      method: "get",
      url,
      params: xhr
    });
  },
};

function install(Vue) {
  Vue.prototype.$PriceAjax = priceAjax;
}

export default install;
