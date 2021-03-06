import Vue from 'vue';
import Router from 'vue-router';

const Login = () => import(/* webpackChunkName: "login" */ '@/pages/login/Login');
const Main = () => import(/* webpackChunkName: "main" */ '@/pages/main/Main');
// 概览
const Home = () => import(/* webpackChunkName: "home" */ '@/pages/home/Home');
// 设备管理
const ChargePile = () => import(/* webpackChunkName: "gdevice" */ '@/pages/device/ChargePile');
const ChargeAddress = () => import(/* webpackChunkName: "device" */ '@/pages/device/ChargeAddress');
const ChargeFactory = () => import(/* webpackChunkName: "device" */ '@/pages/device/ChargeFactory');
const ChargeStation = () => import(/* webpackChunkName: "device" */ '@/pages/device/ChargeStation');
// 用户管理
const AppUser = () => import(/* webpackChunkName: "userManage" */ '@/pages/userManage/appUser');
const Operator = () => import(/* webpackChunkName: "userManage" */ '@/pages/userManage/operator');
const CardUser = () => import(/* webpackChunkName: "userManage" */ '@/pages/userManage/cardUser');
// 运营管理
const RechargeRecord = () => import(/* webpackChunkName: "businessRecord" */ '@/pages/businessRecord/RechargeRecord');
const ChargeRecord = () => import(/* webpackChunkName: "businessRecord" */ '@/pages/businessRecord/ChargeRecord');
const CardChargeRecord = () => import(/* webpackChunkName: "businessRecord" */ '@/pages/businessRecord/CardChargeRecord');
const RefrundRecord = () => import(/* webpackChunkName: "businessRecord" */ '@/pages/businessRecord/RefrundRecord');
const ChargingRecord = () => import(/* webpackChunkName: "businessRecord" */ '@/pages/businessRecord/ChargingRecord');
const ChargeReport = () => import(/* webpackChunkName: "businessRecord" */ '@/pages/businessRecord/ChargeReport');
const CardRechargeRecord = () => import(/* webpackChunkName: "businessRecord" */ '@/pages/businessRecord/CardRechargeRecord');
// 运营统计
const AppUserStatics = () => import(/* webpackChunkName: "staticsData" */ '@/pages/staticsData/AppUserStatics');
const ChargePileStatics = () => import(/* webpackChunkName: "staticsData" */ '@/pages/staticsData/ChargePileStatics');
const ChargeStationStatics = () => import(/* webpackChunkName: "staticsData" */ '@/pages/staticsData/ChargeStationStatics');
const OperatorStatics = () => import(/* webpackChunkName: "staticsData" */ '@/pages/staticsData/OperatorStatics');

// 实时监控
const PileRealData = () => import(/* webpackChunkName: "realData" */ '@/pages/realData/PileRealData');
const FaultAlarmData = () => import(/* webpackChunkName: "realData" */ '@/pages/realData/FaultAlarmData');
const SwitchData = () => import(/* webpackChunkName: "realData" */ '@/pages/realData/SwitchData');

// 费率模板
const BillModel = () => import(/* webpackChunkName: "priceSet" */ '@/pages/priceSet/BillModel');

// 商城
const CaseProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/CaseProductionTable');
const ReservationTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/ReservationTable');
const RentProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/RentProductionTable');
const PileProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/PileProductionTable');
const AlignProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/AlignProductionTable');
const ActivityProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/ActivityProductionTable');
const CarProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/CarProductionTable');
// 账号管理
const AuthorityAccount = () => import(/* webpackChunkName: "systemSet" */ '@/pages/systemSet/AuthorityAccount');
const EnterpriseUser = () => import(/* webpackChunkName: "enterpriseManage" */ '@/pages/enterpriseManage/EnterpriseUser');
const EnterpriseStaff = () => import(/* webpackChunkName: "enterpriseManage" */ '@/pages/enterpriseManage/EnterpriseStaff');
const EnterpriseChargeRecord = () => import(/* webpackChunkName: "enterpriseManage" */ '@/pages/enterpriseManage/EnterpriseChargeRecord');
const EnterpriseReportData = () => import(/* webpackChunkName: "enterpriseManage" */ '@/pages/enterpriseManage/EnterpriseReportData');

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      redirect: "Login",
    },
    {
      path: '/Login',
      name: 'Login',
      component: Login
    },
    {
      path: '/Main',
      name: 'Main',
      component: Main,
      children: [
        {
          path: "/ActivityProductionTable",
          name: "ActivityProductionTable",
          component: ActivityProductionTable,
          title: "优惠活动"
        },
        {
          path: "/AlignProductionTable",
          name: "AlignProductionTable",
          component: AlignProductionTable,
          title: "加盟方案"
        },
        {
          path: "/CarProductionTable",
          name: "CarProductionTable",
          component: CarProductionTable,
          title: "车辆发布"
        },
        {
          path: "/PileProductionTable",
          name: "PileProductionTable",
          component: PileProductionTable,
          title: "充电桩发布"
        },
        {
          path: "/RentProductionTable",
          name: "RentProductionTable",
          component: RentProductionTable,
          title: "租赁方案"
        },
        {
          path: "/ReservationTable",
          name: "ReservationTable",
          component: ReservationTable,
          title: "预约信息"
        },
        {
          path: "/CaseProductionTable",
          name: "CaseProductionTable",
          component: CaseProductionTable,
          title: "优秀案例"
        },
        {
          path: "/ChargePile",
          name: "ChargePile",
          component: ChargePile,
          title: "充电桩管理"
        },
        {
          path: "/ChargeAddress",
          name: "ChargeAddress",
          component: ChargeAddress,
          title: "充电桩地址"
        },
        {
          path: "/ChargeFactory",
          name: "ChargeFactory",
          component: ChargeFactory,
          title: "充电桩厂商"
        },
        {
          path: "/ChargeStation",
          name: "ChargeStation",
          component: ChargeStation,
          title: "充电站管理"
        },
        {
          path: "/AppUser",
          name: "AppUser",
          component: AppUser,
          title: "微信/APP用户"
        },
        {
          path: "/Operator",
          name: "Operator",
          component: Operator,
          title: "运营商管理"
        },
        {
          path: "/CardUser",
          name: "CardUser",
          component: CardUser,
          title: "充电卡管理"
        },
        {
          path: "/ChargeRecord",
          name: "ChargeRecord",
          component: ChargeRecord,
          title: "充电记录"
        },
        {
          path: "/RechargeRecord",
          name: "RechargeRecord",
          component: RechargeRecord,
          title: "充值记录"
        },
        {
          path: "/RefrundRecord",
          name: "RefrundRecord",
          component: RefrundRecord,
          title: "退款记录"
        },
        {
          path: "/ChargingRecord",
          name: "ChargingRecord",
          component: ChargingRecord,
          title: "扣费记录"
        },
        {
          path: "/AppUserStatics",
          name: "AppUserStatics",
          component: AppUserStatics,
          title: "app用户统计"
        },
        {
          path: "/ChargePileStatics",
          name: "ChargePileStatics",
          component: ChargePileStatics,
          title: "充电桩统计"
        },
        {
          path: "/ChargeStationStatics",
          name: "ChargeStationStatics",
          component: ChargeStationStatics,
          title: "充电站统计"
        },
        {
          path: "/OperatorStatics",
          name: "OperatorStatics",
          component: OperatorStatics,
          title: "运营商统计"
        },
        {
          path: "/Home",
          name: "Home",
          component: Home,
          title: "概览"
        },
        {
          path: "/SwitchData",
          name: "SwitchData",
          component: SwitchData,
          title: "变位数据"
        },
        {
          path: "/PileRealData",
          name: "PileRealData",
          component: PileRealData,
          title: "充电监控"
        },
        {
          path: "/FaultAlarmData",
          name: "FaultAlarmData",
          component: FaultAlarmData,
          title: "故障报警"
        },
        {
          path: "/BillModel",
          name: "BillModel",
          component: BillModel,
          title: "计费模型"
        },
        {
          path: "/AuthorityAccount",
          name: "AuthorityAccount",
          component: AuthorityAccount,
          title: "账号管理"
        },
        {
          path: "/EnterpriseUser",
          name: "EnterpriseUser",
          component: EnterpriseUser,
          title: "企业用户"
        },
        {
          path: "/EnterpriseStaff",
          name: "EnterpriseStaff",
          component: EnterpriseStaff,
          title: "企业员工"
        },
        {
          path: "/EnterpriseChargeRecord",
          name: "EnterpriseChargeRecord",
          component: EnterpriseChargeRecord,
          title: "充电记录"
        },
        {
          path: "/EnterpriseReportData",
          name: "EnterpriseReportData",
          component: EnterpriseReportData,
          title: "充电报表"
        },
        {
          path: "/ChargeReport",
          name: "ChargeReport",
          component: ChargeReport,
          title: "充电报表"
        },
        {
          path: "/CardRechargeRecord",
          name: "CardRechargeRecord",
          component: CardRechargeRecord,
          title: "卡充值记录"
        },
        {
          path: "/CardChargeRecord",
          name: "CardChargeRecord",
          component: CardChargeRecord,
          title: "卡充电记录"
        }
      ]
    }
  ]
});
