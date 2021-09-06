/*
 * @Descripttion: 
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2021-09-02 14:34:05
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-09-02 15:24:12
 */
export default {
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
}