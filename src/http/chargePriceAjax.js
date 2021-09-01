/*
 * @Descripttion:
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2020-12-18 09:54:54
 * @LastEditors:
 * @LastEditTime: 2021-09-01 15:48:21
 */
import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export const priceAjax = {
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
