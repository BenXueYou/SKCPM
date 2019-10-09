// import Cookies from 'js-cookie'
import { Storage } from "@/utils/Storage";

const home = {
  state: {
    // localTag: Cookies.get('localTag') || 'Home',
    operatorArr: Storage.readSession("operatorArr") || [],
    chargeStationArr: Storage.readSession("chargeStationArr") || [],
    provinceArr: Storage.readSession("provinceArr") || [],
    chargeFactoryArr: Storage.readSession("chargeFactoryArr") || [],
    Authorization: Storage.readSession("Authorization") || "",
    OperatorId: Storage.readSession("OperatorId") || "",
    localTag: Storage.readSession("localTag") || "Home",
    localEnums: Storage.read("localEnums") || {},
    projectUuid: Storage.readSession("projectUuid") || "",
    account: Storage.read("account") || "",
    userUuid: Storage.read("userUuid") || "",
    projectList: Storage.read("projectList") || [],
    // username: localStorage.getItem("username") || ""
  },
  mutations: {
    SET_OPERATOR_ARR: (state, operatorArr) => {
      state.operatorArr = operatorArr;
      Storage.saveSession("operatorArr", operatorArr);
    },
    SET_CHARGE_STATION_ARR: (state, chargeStationArr) => {
      state.chargeStationArr = chargeStationArr;
      Storage.saveSession("chargeStationArr", chargeStationArr);
    },
    SET_PROVINCE_ARR: (state, provinceArr) => {
      state.provinceArr = provinceArr;
      Storage.saveSession("provinceArr", provinceArr);
    },
    SET_CHARGE_FACTORY_ARR: (state, chargeFactoryArr) => {
      state.chargeFactoryArr = chargeFactoryArr;
      Storage.saveSession("chargeFactoryArr", chargeFactoryArr);
    },
    SET_LOCAL_TAG: (state, localTag) => {
      state.localTag = localTag;
      Storage.saveSession("localTag", localTag);
    },
    SET_LOCAL_ENUMS: (state, localEnums) => {
      state.localEnums = localEnums;

      Storage.save("localEnums", localEnums);
    },
    SET_AUTHORIZATION: (state, Authorization) => {
      state.Authorization = Authorization;
      Storage.saveSession("Authorization", Authorization);
    },
    SET_OPERATOR_ID: (state, OperatorId) => {
      state.OperatorId = OperatorId;
      Storage.saveSession("OperatorId", OperatorId);
    },
    SET_PROJECT_LIST: (state, projectList) => {
      state.projectList = projectList;
      Storage.save("projectList", projectList);
    },
    SET_ACCOUNT: (state, account) => {
      state.account = account;
      Storage.save("account", account);
    },
    SET_USERUUID: (state, userUuid) => {
      state.userUuid = userUuid;
      Storage.save("userUuid", userUuid);
    }
  },
  actions: {
    setOperatorArr({ commit }, operatorArr) {
      commit("SET_OPERATOR_ARR", operatorArr);
    },
    setChargeStationArr({ commit }, OperatorArr) {
      commit("SET_CHARGE_STATION_ARR", OperatorArr);
    },
    setProvinceArr({ commit }, provinceArr) {
      commit("SET_PROVINCE_ARR", provinceArr);
    },
    setChargeFactoryArr({ commit }, chargeFactoryArr) {
      commit("SET_CHARGE_FACTORY_ARR", chargeFactoryArr);
    },
    setLocalTag({ commit }, localTag) {
      commit("SET_LOCAL_TAG", localTag);
    },
    setAuthorization({ commit }, Authorization) {
      commit("SET_AUTHORIZATION", Authorization);
    },
    setOperatorId({ commit }, OperatorId) {
      commit("SET_OPERATOR_ID", OperatorId);
    },
    setAccount({ commit }, account) {
      commit("SET_ACCOUNT", account);
    },
    SET_USERUUID({ commit }, userUuid) {
      commit("SET_USERUUID", userUuid);
    }
  }
};

export default home;
