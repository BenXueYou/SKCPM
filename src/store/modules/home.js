// import Cookies from 'js-cookie'
import { Storage } from "@/utils/Storage";

const home = {
  state: {
    operatorArr: Storage.readSession("operatorArr") || [],
    chargeStationArr: Storage.readSession("chargeStationArr") || [],
    provinceArr: Storage.readSession("provinceArr") || [],
    chargeFactoryArr: Storage.readSession("chargeFactoryArr") || [],
    Authorization: Storage.readSession("Authorization") || "",
    AuthorizationID: Storage.readSession("AuthorizationID") || "",
    AuthRoleId: Storage.readSession("AuthRoleId") || "",
    OperatorId: Storage.readSession("OperatorId") || "",
    loginId: Storage.readSession("loginId") || "",
    account: Storage.read("account") || "",
    userUuid: Storage.read("userUuid") || "",
    enterpriseUser: localStorage.getItem("enterpriseUser") || []
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
    SET_AUTHORIZATIONID: (state, AuthorizationID) => {
      state.AuthorizationID = AuthorizationID;
      Storage.saveSession("AuthorizationID", AuthorizationID);
    },
    SET_AUTHROLE_ID: (state, AuthRoleId) => {
      state.AuthRoleId = AuthRoleId;
      Storage.saveSession("AuthRoleId", AuthRoleId);
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
    setAuthorizationID({ commit }, AuthorizationID) {
      commit("SET_AUTHORIZATIONID", AuthorizationID);
    },
    setAuthRoleId({ commit }, AuthRoleId) {
      commit("SET_AUTHROLE_ID", AuthRoleId);
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
  }
};

export default home;
