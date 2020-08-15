import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var DeviceAjax = {
  operatorPiles(xhr) {
    let url = `${RestApi.api.DeviceAjax.operatorPiles}`;
    return axios({
      method: 'post',
      url,
      data: xhr,
    });
  },
  getAddOptions(xhr) {
    let url = `${RestApi.api.DeviceAjax.getAddOptions}`;
    return axios({
      method: "get",
      url,
      params: xhr
    });
  },
  deletePile(xhr) {
    let url = `${RestApi.api.DeviceAjax.deletePile}`;
    return axios({
      method: "post",
      url,
      params: {cpIdList: xhr.toString()}
    });
  },
  addPile(xhr) {
    let url = `${RestApi.api.DeviceAjax.addPile}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getPileList(xhr) {
    let url = `${RestApi.api.DeviceAjax.getPileList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getEditOptions(xhr) {
    let url = `${RestApi.api.DeviceAjax.getEditOptions}`;
    return axios({
      headers: {
        'content-type': 'application/json'
      },
      method: "post",
      url,
      params: xhr
    });
  },
  updatePile(xhr) {
    let url = `${RestApi.api.DeviceAjax.updatePile}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  deleteChargeStation(xhr) {
    let url = `${RestApi.api.DeviceAjax.deleteChargeStation}`;
    return axios({
      method: "post",
      headers: {
        'content-type': 'application/json'
      },
      url,
      params: {csId: xhr.toString()}
    });
  },
  getChargeStationListByOperatorId(xhr) {
    let url = `${RestApi.api.DeviceAjax.getChargeStationListByOperatorId}`;
    return axios({
      method: "post",
      headers: {
        'content-type': 'application/json'
      },
      url,
      params: {operatorId: xhr}
    });
  },
  getChargeStationList(xhr) {
    let url = `${RestApi.api.DeviceAjax.getChargeStationList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addChargeStation(xhr) {
    let url = `${RestApi.api.DeviceAjax.addChargeStation}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  editChargeStationOptions(xhr) {
    let url = `${RestApi.api.DeviceAjax.editChargeStationOptions}`;
    return axios({
      headers: {
        'content-type': 'application/json'
      },
      method: "post",
      url,
      data: xhr
    });
  },
  updateChargeStation(xhr) {
    let url = `${RestApi.api.DeviceAjax.updateChargeStation}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getPileModelListById(xhr) {
    let url = `${RestApi.api.DeviceAjax.getPileModelListById}`;
    return axios({
      method: "post",
      url,
      params: {mfrId: xhr}
    });
  },
  deletePileFactory(xhr) {
    let url = `${RestApi.api.DeviceAjax.deletePileFactory}`;
    return axios({
      headers: {
        'content-type': 'application/json'
      },
      method: "post",
      url,
      data: xhr.id
    });
  },
  getPileFactoryList(xhr) {
    let url = `${RestApi.api.DeviceAjax.getPileFactoryList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addPileFactory(xhr) {
    let url = `${RestApi.api.DeviceAjax.addPileFactory}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  editPileFactoryOptions(xhr) {
    let url = `${RestApi.api.DeviceAjax.editPileFactoryOptions}`;
    let id = xhr.id;
    return axios({
      headers: {
        'content-type': 'application/json'
      },
      method: "post",
      url,
      data: id
    });
  },
  updatePileFactory(xhr) {
    let url = `${RestApi.api.DeviceAjax.updatePileFactory}`;
    return axios({
      headers: {
        'content-type': 'application/json'
      },
      method: "post",
      url,
      data: xhr
    });
  },
  getProvinceList(xhr) {
    let url = `${RestApi.api.DeviceAjax.getProvince}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getCityByProvinceId(xhr) {
    let url = `${RestApi.api.DeviceAjax.getCityByProvinceId}`;
    return axios({
      method: "post",
      url,
      params: xhr
    });
  },
  getAreaListByCityId(xhr) {
    let url = `${RestApi.api.DeviceAjax.getAreaListByCityId}`;
    return axios({
      method: "post",
      url,
      params: xhr
    });
  },
  getAddressListByAreaId(xhr) {
    let url = `${RestApi.api.DeviceAjax.getAddressListByAreaId}`;
    return axios({
      method: "post",
      url,
      params: xhr
    });
  },
  getChargeAddressList(xhr) {
    let url = `${RestApi.api.DeviceAjax.getChargeAddressList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  deleteChargeAddress(xhr) {
    let url = `${RestApi.api.DeviceAjax.deleteChargeAddress}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  postChargeAddress(xhr) {
    let url = `${RestApi.api.DeviceAjax.postChargeAddress}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  editChargeAddress(xhr) {
    let url = `${RestApi.api.DeviceAjax.editChargeAddress}`;
    return axios({
      method: "post",
      url,
      params: xhr
    });
  },
  updateChargeAddress(xhr) {
    let url = `${RestApi.api.DeviceAjax.updateChargeAddress}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },

};

function install(Vue) {
  Vue.prototype.$deviceAjax = DeviceAjax;
}

export default install;
