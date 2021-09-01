/*
 * @Descripttion:
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2020-12-18 09:54:54
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-09-01 16:12:26
 */
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
  transferApi (data) {
    let url = `${RestApi.api.StaticsAjax.transferApi}`;
    return axios({
      method: "post",
      url,
      params: data
    });
  }
};

function install(Vue) {
  Vue.prototype.$staticsAjax = staticsAjax;
}

export default install;
