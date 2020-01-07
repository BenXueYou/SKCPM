import store from '@/store/store.js';

let httpUrlHeader = window.config.httpUrlHeader;
// http://139.129.194.195:8080
export default {
  api: {
    /**
     * 图片下载地址
     */
    imageUrl: `${httpUrlHeader}/fileforward-server-v1/project/${store.state.home.projectUuid}/fileforward/fileByUrl?fileUrl=`,
    /**
     * 全部翻译获取接口
     */
    queryBaseTypeByGroup: process.env.LOCAL_ENUMS,
    /**
     * 登录模块
     */
    login: {
      login: `${httpUrlHeader}/login/login`,
      logout: `${httpUrlHeader}/login/logout`,
      modifyPassword: `${httpUrlHeader}/login/modify/password`,
    },

    /**
     * 1、首页
     */
    HomeAjax: {
      trend: `${httpUrlHeader}/index/statistical/trend`,
      summary: `${httpUrlHeader}/index/statistical/summary`,
    },
    /**
     * 1、监控
     */
    RealAjax: {
      realPileData: `${httpUrlHeader}/chargePile/real/time/data`,
      realAlarmData: `${httpUrlHeader}/webAlarm/list-by-page`,
      // 告警记录
      getAlarmRecord: `${httpUrlHeader}/webAlarm/list-by-page`,
      switchDataRecord: `${httpUrlHeader}/displacement/list-by-page`
    },

    /**
     * 设备管理
     */
    DeviceAjax: {
      getAddOptions: `${httpUrlHeader}/chargePile/before/add`,
      deletePile: `${httpUrlHeader}/chargePile/delete`,
      addPile: `${httpUrlHeader}/chargePile/save`,
      getPileList: `${httpUrlHeader}/chargePile/list-by-page`,
      getEditOptions: `${httpUrlHeader}/chargePile/toEdit`,
      updatePile: `${httpUrlHeader}/chargePile/update`,
      getPileOptions: `${httpUrlHeader}/chargePile/list`,

      deleteChargeStation: `${httpUrlHeader}/charge/station/delete`,
      getChargeStationList: `${httpUrlHeader}/charge/station/list-by-page`,
      addChargeStation: `${httpUrlHeader}/charge/station/save`,
      editChargeStationOptions: `${httpUrlHeader}/charge/station/toEdit`,
      updateChargeStation: `${httpUrlHeader}/charge/station/update`,
      getChargeStationListByOperatorId: `${httpUrlHeader}/charge/station/query-list-by-operatorId`,

      deletePileFactory: `${httpUrlHeader}/manufacturer/delete`,
      getPileFactoryList: `${httpUrlHeader}/manufacturer/list-by-page`,
      addPileFactory: `${httpUrlHeader}/manufacturer/save`,
      editPileFactoryOptions: `${httpUrlHeader}/manufacturer/toEdit`,
      updatePileFactory: `${httpUrlHeader}/manufacturer/update`,
      getPileModelListById: `${httpUrlHeader}/manufacturer/query-model-by-mfrid`,

      // 省市区地址管理接口
      getProvince: `${httpUrlHeader}/address/province/list`,
      getCityByProvinceId: `${httpUrlHeader}/address/queryCityListByProvinceId`,
      getAreaListByCityId: `${httpUrlHeader}/address/queryAreaListByCityId`,
      getAddressListByAreaId: `${httpUrlHeader}/address/queryAddressByAreaId`,

      // 充电桩地址管理
      getChargeAddressList: `${httpUrlHeader}/address/list-by-page`,
      deleteChargeAddress: `${httpUrlHeader}/address/delete`,
      postChargeAddress: `${httpUrlHeader}/address/save`,
      editChargeAddress: `${httpUrlHeader}/address/toEdit`,
      updateChargeAddress: `${httpUrlHeader}/address/update`,
    },

    /**
     * 运营管理
     */
    BusinessAjax: {
      getChargeRecordTotal: `${httpUrlHeader}/charge/record/count`,
      exportChargeRecord: `${httpUrlHeader}/charge/record/export`,
      updateChargeRecord: `${httpUrlHeader}/charge/record/update`,
      getChargeRecordList: `${httpUrlHeader}/charge/record/list-by-page`,
      deductRecordList: `${httpUrlHeader}/deduct/record/list`,

      getRechargeRecord: `${httpUrlHeader}/weChat/deposit/record`,
      exportRechargeRecord: `${httpUrlHeader}/weChat/export/deposit-record`,

      getRefrundRecord: `${httpUrlHeader}/weChat/withdraw-list-by-page`,

      // 充电报表
      getChargeReport: `${httpUrlHeader}/charge/record/charge/reports`

    },

    /**
     * 用户管理
     */
    UserAjax: {
      deleteOperator: `${httpUrlHeader}/operator/delete`,
      getOperatorList: `${httpUrlHeader}/operator/list-by-page`,
      addOperator: `${httpUrlHeader}/operator/save`,
      editOperatorOptions: `${httpUrlHeader}/operator/toEdit`,
      updateOperator: `${httpUrlHeader}/operator/update`,
      getOperatorOptions: `${httpUrlHeader}/operator/list`,

      getAppUserList: `${httpUrlHeader}/weChat/list-by-page`,

      getCardUserList: `${httpUrlHeader}/card/deposit/list-by-page`,
      saveCardUserDeposit: `${httpUrlHeader}/card/deposit/save`,
    },
    /**
       * 运营统计
       */
    StaticsAjax: {
      getAppUser: `${httpUrlHeader}/statistics/user`,
      getOperator: `${httpUrlHeader}/statistics/operator`,
      getChargeStation: `${httpUrlHeader}/statistics/chargeStation`,
      getChargePile: `${httpUrlHeader}/statistics/chargePile`,
    },

    /**
     * 微信商城
     */
    ProductionAjax: {

      getCarList: `${httpUrlHeader}/weChat/mall/car-list`,
      addCar: `${httpUrlHeader}/weChat/mall/save-Car`,
      deleteCar: `${httpUrlHeader}/weChat/mall/delete-Car`,
      updateCar: `${httpUrlHeader}/weChat/mall/update-Car`,
      detailCar: `${httpUrlHeader}/weChat/mall/queryCarById`,

      getPileList: `${httpUrlHeader}/weChat/mall/pile-list`,
      addPile: `${httpUrlHeader}/weChat/mall/pile-add`,
      deletePile: `${httpUrlHeader}/weChat/mall/pile-delete`,
      updatePile: `${httpUrlHeader}/weChat/mall/pile-update`,
      detailPile: `${httpUrlHeader}/weChat/mall/pile-detail`,

      getReservationList: `${httpUrlHeader}/weChat/mall/reservation-list`,
      exportReservation: `${httpUrlHeader}/weChat/mall/reservation-export`,

      getActivityList: `${httpUrlHeader}/weChat/mall/discount-list`,
      addActivity: `${httpUrlHeader}/weChat/mall/discount-add`,
      deleteActivity: `${httpUrlHeader}/weChat/mall/discount-delete`,
      updateActivity: `${httpUrlHeader}/weChat/mall/discount-update`,
      detailActivity: `${httpUrlHeader}/weChat/mall/discount-detail`,

      getCaseList: `${httpUrlHeader}/weChat/mall/excellent-list`,
      addCase: `${httpUrlHeader}/weChat/mall/excellent-add`,
      deleteCase: `${httpUrlHeader}/weChat/mall/excellent-delete`,
      updateCase: `${httpUrlHeader}/weChat/mall/excellent-update`,
      detailCase: `${httpUrlHeader}/weChat/mall/excellent-detail`,

      saveAlign: `${httpUrlHeader}/weChat/mall/league-update`,
      detailAlign: `${httpUrlHeader}/weChat/mall/league-detail`,

      getRentList: `${httpUrlHeader}/weChat/mall/rentScheme-list`,
      addRent: `${httpUrlHeader}/weChat/mall/rentScheme-add`,
      deleteRent: `${httpUrlHeader}/weChat/mall/rentScheme-delete`,
      updateRent: `${httpUrlHeader}/weChat/mall/rentScheme-update`,
      detailRent: `${httpUrlHeader}/weChat/mall/rentScheme-detail`,

      updateImage: `${httpUrlHeader}/weChat/mall/upload`

    },
    /**
     * 充电价格
     */
    ChargePriceAjax: {
      getChargePrice: `${httpUrlHeader}/bill/model/list-by-page`,
      putChargePrice: `${httpUrlHeader}/bill/model/update`,
      getChargePriceDetail: `${httpUrlHeader}/bill/model/detail`,
    },

    AuthorityAccount: {
      getAuthorityAccount: `${httpUrlHeader}/user/list-by-page`,
      getAccountUserList: `${httpUrlHeader}/user/list-by-page`,
      addCompanyUser: `${httpUrlHeader}/user/companyUser-add`,
      addAdminUser: `${httpUrlHeader}/user/save-manage`,
      deleteUserList: `${httpUrlHeader}/user/delete`,
      updateUserList: `${httpUrlHeader}/user/update`,
    },

    /**
     * 企业用户
     */
    EnterpriseManageApi: {
      // 企业用户
      getEnterPriseUserApi: `${httpUrlHeader}/company/user/list-by-page`,
      postEnterPriseUserApi: `${httpUrlHeader}/company/user/save`,
      updateEnterPriseUserApi: `${httpUrlHeader}/company/user/update`,
      deleteEnterPriseUserApi: `${httpUrlHeader}/company/user/delete`,
      // 企业员工
      getEnterPriseStaffApi: `${httpUrlHeader}/employee/list-by-page`,
      deleteEnterPriseStaffApi: `${httpUrlHeader}/employee/delete`,
      checkEnterPriseStaffApi: `${httpUrlHeader}/employee/check`,

    },
    // 测试APP登陆接口
    appLogin: `http://139.129.194.195:8080/SuperBackManage/userManager/loginUser`
  }
};
