import Vue from 'vue';
import Router from 'vue-router';
// import Home from '@/pages/home/Home';
const Login = () => import(/* webpackChunkName: "group-foo" */ '@/pages/login/Login');
const Main = () => import(/* webpackChunkName: "group-foo" */ '@/pages/main/Main');
const ChargePile = () => import(/* webpackChunkName: "group-foo" */ '@/pages/device/ChargePile');
const ChargeAddress = () => import(/* webpackChunkName: "group-foo" */ '@/pages/device/ChargeAddress');
const ChargeFactory = () => import(/* webpackChunkName: "group-foo" */ '@/pages/device/ChargeFactory');
const ChargeStation = () => import(/* webpackChunkName: "group-foo" */ '@/pages/device/ChargeStation');
const AppUser = () => import(/* webpackChunkName: "group-foo" */ '@/pages/userManage/appUser');
const Operator = () => import(/* webpackChunkName: "group-foo" */ '@/pages/userManage/operator');
const CardUser = () => import(/* webpackChunkName: "group-foo" */ '@/pages/userManage/cardUser');

const RechargeRecord = () => import(/* webpackChunkName: "group-foo" */ '@/pages/businessRecord/RechargeRecord');
const ChargeRecord = () => import(/* webpackChunkName: "group-foo" */ '@/pages/businessRecord/ChargeRecord');
const RefrundRecord = () => import(/* webpackChunkName: "group-foo" */ '@/pages/businessRecord/RefrundRecord');
const ChargingRecord = () => import(/* webpackChunkName: "group-foo" */ '@/pages/businessRecord/ChargingRecord');

const AppUserStatics = () => import(/* webpackChunkName: "group-foo" */ '@/pages/staticsData/AppUserStatics');
const ChargePileStatics = () => import(/* webpackChunkName: "group-foo" */ '@/pages/staticsData/ChargePileStatics');
const ChargeStationStatics = () => import(/* webpackChunkName: "group-foo" */ '@/pages/staticsData/ChargeStationStatics');
const OperatorStatics = () => import(/* webpackChunkName: "group-foo" */ '@/pages/staticsData/OperatorStatics');

const PileRealData = () => import(/* webpackChunkName: "group-foo" */ '@/pages/realData/PileRealData');
const FaultAlarmData = () => import(/* webpackChunkName: "group-foo" */ '@/pages/realData/FaultAlarmData');
const SwitchData = () => import(/* webpackChunkName: "group-foo" */ '@/pages/realData/SwitchData');

const BillModel = () => import(/* webpackChunkName: "group-foo" */ '@/pages/priceSet/BillModel');
const Home = () => import(/* webpackChunkName: "group-foo" */ '@/pages/home/Home');

const CaseProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/CaseProductionTable');
const ReservationTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/ReservationTable');
const RentProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/RentProductionTable');
const PileProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/PileProductionTable');
const AlignProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/AlignProductionTable');
const ActivityProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/ActivityProductionTable');
const CarProductionTable = () => import(/* webpackChunkName: "production" */ '@/pages/production/CarProductionTable');

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
          path: "ActivityProductionTable",
          name: "ActivityProductionTable",
          component: ActivityProductionTable,
          title: "优惠活动"
        },
        {
          path: "AlignProductionTable",
          name: "AlignProductionTable",
          component: AlignProductionTable,
          title: "加盟方案"
        },
        {
          path: "CarProductionTable",
          name: "CarProductionTable",
          component: CarProductionTable,
          title: "车辆发布"
        },
        {
          path: "PileProductionTable",
          name: "PileProductionTable",
          component: PileProductionTable,
          title: "充电桩发布"
        },
        {
          path: "RentProductionTable",
          name: "RentProductionTable",
          component: RentProductionTable,
          title: "租赁方案"
        },
        {
          path: "ReservationTable",
          name: "ReservationTable",
          component: ReservationTable,
          title: "预约信息"
        },
        {
          path: "CaseProductionTable",
          name: "CaseProductionTable",
          component: CaseProductionTable,
          title: "优秀案例"
        },
        {
          path: "ChargePile",
          name: "ChargePile",
          component: ChargePile,
          title: "充电桩管理"
        },
        {
          path: "ChargeAddress",
          name: "ChargeAddress",
          component: ChargeAddress,
          title: "充电桩地址"
        },
        {
          path: "ChargeFactory",
          name: "ChargeFactory",
          component: ChargeFactory,
          title: "充电桩厂商"
        },
        {
          path: "ChargeStation",
          name: "ChargeStation",
          component: ChargeStation,
          title: "充电站管理"
        },
        {
          path: "AppUser",
          name: "AppUser",
          component: AppUser,
          title: "微信/APP用户"
        },
        {
          path: "Operator",
          name: "Operator",
          component: Operator,
          title: "运营商管理"
        },
        {
          path: "CardUser",
          name: "CardUser",
          component: CardUser,
          title: "充电卡管理"
        },
        {
          path: "ChargeRecord",
          name: "ChargeRecord",
          component: ChargeRecord,
          title: "充电记录"
        },
        {
          path: "RechargeRecord",
          name: "RechargeRecord",
          component: RechargeRecord,
          title: "充值记录"
        },
        {
          path: "RefrundRecord",
          name: "RefrundRecord",
          component: RefrundRecord,
          title: "退款记录"
        },
        {
          path: "ChargingRecord",
          name: "ChargingRecord",
          component: ChargingRecord,
          title: "扣费记录"
        },
        {
          path: "AppUserStatics",
          name: "AppUserStatics",
          component: AppUserStatics,
          title: "app用户统计"
        },
        {
          path: "ChargePileStatics",
          name: "ChargePileStatics",
          component: ChargePileStatics,
          title: "充电桩统计"
        },
        {
          path: "ChargeStationStatics",
          name: "ChargeStationStatics",
          component: ChargeStationStatics,
          title: "充电站统计"
        },
        {
          path: "OperatorStatics",
          name: "OperatorStatics",
          component: OperatorStatics,
          title: "运营商统计"
        },
        {
          path: "Home",
          name: "Home",
          component: Home,
          title: "概览"
        },
        {
          path: "SwitchData",
          name: "SwitchData",
          component: SwitchData,
          title: "变位数据"
        },
        {
          path: "PileRealData",
          name: "PileRealData",
          component: PileRealData,
          title: "充电监控"
        },
        {
          path: "FaultAlarmData",
          name: "FaultAlarmData",
          component: FaultAlarmData,
          title: "故障报警"
        },
        {
          path: "BillModel",
          name: "BillModel",
          component: BillModel,
          title: "计费模型"
        },
      ]
    }
  ]
});
