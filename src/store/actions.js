/*
 * @Descripttion: 
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2021-09-02 14:34:22
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-09-02 15:24:59
 */
export default {
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
  }
}