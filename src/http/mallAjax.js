import axios from "@/utils/Request";
import RestApi from "@/utils/RestApi";
export var ProductionAjax = {
  getCarList(xhr) {
    let url = `${RestApi.api.ProductionAjax.getCarList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addCar(xhr) {
    let url = `${RestApi.api.ProductionAjax.addCar}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  deleteCar(xhr) {
    let url = `${RestApi.api.ProductionAjax.deleteCar}`;
    let param = new URLSearchParams();
    param.append("id", xhr);
    return axios({
      method: "post",
      headers: {
        'Content-Type': 'application/json'
      },
      url,
      data: xhr
    });
  },
  updateCar(xhr) {
    let url = `${RestApi.api.ProductionAjax.updateCar}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  detailCar(xhr) {
    let url = `${RestApi.api.ProductionAjax.detailCar}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getPileList(xhr) {
    let url = `${RestApi.api.ProductionAjax.getPileList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addPile(xhr) {
    let url = `${RestApi.api.ProductionAjax.addPile}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  deletePile(xhr) {
    let url = `${RestApi.api.ProductionAjax.deletePile}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  updatePile(xhr) {
    let url = `${RestApi.api.ProductionAjax.updatePile}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  detailPile(xhr) {
    let url = `${RestApi.api.ProductionAjax.detailPile}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getReservationList(xhr) {
    let url = `${RestApi.api.ProductionAjax.getReservationList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  exportReservation(xhr) {
    let url = `${RestApi.api.ProductionAjax.exportReservation}`;
    return axios({
      responseType: 'arraybuffer', // 二进制流
      method: "post",
      url,
      data: xhr
    });
  },
  getActivityList(xhr) {
    let url = `${RestApi.api.ProductionAjax.getActivityList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addActivity(xhr) {
    let url = `${RestApi.api.ProductionAjax.addActivity}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  deleteActivity(xhr) {
    let url = `${RestApi.api.ProductionAjax.deleteActivity}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  updateActivity(xhr) {
    let url = `${RestApi.api.ProductionAjax.updateActivity}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  detailActivity(xhr) {
    let url = `${RestApi.api.ProductionAjax.detailActivity}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getCaseList(xhr) {
    let url = `${RestApi.api.ProductionAjax.getCaseList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addCase(xhr) {
    let url = `${RestApi.api.ProductionAjax.addCase}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  deleteCase(xhr) {
    let url = `${RestApi.api.ProductionAjax.deleteCase}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  updateCase(xhr) {
    let url = `${RestApi.api.ProductionAjax.updateCase}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  detailCase(xhr) {
    let url = `${RestApi.api.ProductionAjax.detailCase}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  saveAlign(xhr) {
    let url = `${RestApi.api.ProductionAjax.saveAlign}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  detailAlign(xhr) {
    let url = `${RestApi.api.ProductionAjax.detailAlign}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  getRentList(xhr) {
    let url = `${RestApi.api.ProductionAjax.getRentList}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  addRent(xhr) {
    let url = `${RestApi.api.ProductionAjax.addRent}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  deleteRent(xhr) {
    let url = `${RestApi.api.ProductionAjax.deleteRent}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  updateRent(xhr) {
    let url = `${RestApi.api.ProductionAjax.updateRent}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
  detailRent(xhr) {
    let url = `${RestApi.api.ProductionAjax.detailRent}`;
    return axios({
      method: "post",
      url,
      params: xhr
    });
  },
  updateImage(xhr) {
    let url = `${RestApi.api.ProductionAjax.updateImage}`;
    return axios({
      method: "post",
      url,
      data: xhr
    });
  },
};

function install(Vue) {
  Vue.prototype.$ProductionAjax = ProductionAjax;
}

export default install;
