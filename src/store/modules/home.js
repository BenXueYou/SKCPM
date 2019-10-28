// import Cookies from 'js-cookie'
import { Storage } from "@/utils/Storage";

const home = {
  state: {
    operatorArr: Storage.readSession("operatorArr") || [],
    chargeStationArr: Storage.readSession("chargeStationArr") || [],
    provinceArr: Storage.readSession("provinceArr") || [],
    chargeFactoryArr: Storage.readSession("chargeFactoryArr") || [],
    Authorization: Storage.readSession("Authorization") || "",
    OperatorId: Storage.readSession("OperatorId") || "",
    loginId: Storage.readSession("loginId") || "",
    account: Storage.read("account") || "",
    userUuid: Storage.read("userUuid") || "",
    roleId: Storage.read("roleId") || "",
    projectList: Storage.read("projectList") || [],
    enterpriseUser: localStorage.getItem("enterpriseUser") || ""
  },
  mutations: {
    SET_ENTERPRISE_USER: (state, enterpriseUser) => {
      state.enterpriseUser = enterpriseUser;
      Storage.saveSession("enterpriseUser", enterpriseUser);
    },
    SET_OPERATOR_ARR: (state, operatorArr) => {
      state.operatorArr = operatorArr;
      Storage.saveSession("operatorArr", operatorArr);
    },
    SET_ROLE_ID: (state, roleId) => {
      state.roleId = roleId;
      Storage.saveSession("roleId", roleId);
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
    SET_AUTHORIZATION: (state, Authorization) => {
      state.Authorization = Authorization;
      Storage.saveSession("Authorization", Authorization);
    },
    SET_OPERATOR_ID: (state, OperatorId) => {
      state.OperatorId = OperatorId;
      Storage.saveSession("OperatorId", OperatorId);
    },
    SET_LOGIN_ID: (state, loginId) => {
      state.loginId = loginId;
      Storage.saveSession("loginId", loginId);
    },
    SET_ACCOUNT: (state, account) => {
      state.account = account;
      Storage.saveSession("account", account);
    },
    SET_USERUUID: (state, userUuid) => {
      state.userUuid = userUuid;
      Storage.saveSession("userUuid", userUuid);
    }
  },
  actions: {
    setEnterpriseUser({ commit }, enterpriseUser) {
      commit("SET_ENTERPRISE_USER", enterpriseUser);
    },
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
    setLoginId({ commit }, loginId) {
      commit("SET_LOGIN_ID", loginId);
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
    },
    setRoleId({ commit }, roleId) {
      commit("SET_ROLE_ID", roleId);
    }
  }
};

export default home;
