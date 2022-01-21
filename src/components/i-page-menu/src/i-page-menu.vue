<!--
 * @Descripttion: 
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2021-09-09 17:24:44
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-09-09 17:24:44
-->
<template>

    <el-menu router :default-active="$route.path" @select="handleSelect" :collapse="isCollapse">
      <el-menu-item class="default-menu">
        <el-icon :size="20" @click="isCollapse = !isCollapse">
          <expand v-if="isCollapse" />
          <fold v-else />
        </el-icon>
      </el-menu-item>
      <template v-for="(item, index) in menu" :key="index">
        <el-sub-menu v-if="item.children" :index="String(index + 1)">
          <template #title>
            <i :class="item.icon"></i>
            <span>{{ item.label }}</span>
          </template>
          <el-menu-item-group>
            <el-menu-item
              v-for="(im, ix) in item.children"
              :key="ix"
              :index="im.path"
              >{{ im.label }}</el-menu-item
            >
          </el-menu-item-group>
        </el-sub-menu>
        <el-menu-item v-else :key="index" :index="item.path">
          <i :class="item.icon"></i>
          <span>{{ item.label }}</span>
        </el-menu-item>
      </template>

    </el-menu>
</template>

<script>
import { mapState } from "vuex";
export default {
  name: "IPageMenu",
  data() {
    return {    
      menuTitle: "1",
      subRoute: "",
      defaultActive: "",
      isCollapse: true,
      menu: [
        {
          id: "overview",
          label: "系统概览",
          icon: "el-icon-s-platform",
          path: "/Home",
        },
        {
          id: "monitor",
          label: "设备监控",
          icon: "el-icon-data-line",
          path: "2",
          children: [
            {
              id: "PileRealData",
              label: "充电监控",
              path: "/PileRealData",
            },
            {
              id: "SwitchData",
              label: "变位监控",
              path: "/SwitchData",
            },
            {
              id: "FaultAlarmData",
              label: "故障监控",
              path: "/FaultAlarmData",
            },
          ],
        },
        {
          id: "operation",
          label: "运营监控",
          icon: "el-icon-notebook-2",
          path: "4",
          children: [
            {
              id: "RechargeRecord",
              label: "充值记录",
              path: "/RechargeRecord",
            },
            {
              id: "RefrundRecord",
              label: "提现记录",
              path: "/RefrundRecord",
            },
            {
              id: "ChargeRecord",
              label: "充电记录",
              path: "/ChargeRecord",
            },
            {
              id: "ChargeReport",
              label: "充电报表",
              path: "/ChargeReport",
            },
            {
              id: "CardRechargeRecord",
              label: "卡充值记录",
              path: "/CardRechargeRecord",
            },
          ],
        },
        {
          id: "statics",
          label: "运营统计",
          icon: "el-icon-medal",
          path: "5",
          children: [
            {
              id: "AppUserStatics",
              label: "用户统计",
              path: "/AppUserStatics",
            },
            {
              id: "ChargePileStatics",
              label: "充电桩统计",
              path: "/ChargePileStatics",
            },
            {
              id: "ChargeStationStatics",
              label: "充电站统计",
              path: "/ChargeStationStatics",
            },
            {
              id: "OperatorStatics",
              label: "运营商统计",
              path: "/OperatorStatics",
            },
          ],
        },
        {
          id: "device",
          label: "设备管理",
          icon: "el-icon-price-tag",
          path: "6",
          children: [
            {
              id: "ChargePile",
              label: "充电桩",
              path: "/ChargePile",
            },
            {
              id: "ChargeStation",
              label: "充电站",
              path: "/ChargeStation",
            },
            {
              id: "ChargeAddress",
              label: "充电桩地址",
              path: "/ChargeAddress",
            },
            {
              id: "ChargeFactory",
              label: "充电桩厂商",
              path: "/ChargeFactory",
            },
          ],
        },
        {
          id: "user",
          label: "用户管理",
          icon: "el-icon-s-custom",
          path: "7",
          children: [
            {
              id: "AppUser",
              label: "用户管理",
              path: "/AppUser",
            },
            {
              id: "Operator",
              label: "运营商管理",
              path: "/Operator",
            },
            {
              id: "CardUser",
              label: "充电卡管理",
              path: "/CardUser",
            },
          ],
        },
        {
          id: "company",
          label: "企业用户",
          icon: "el-icon-s-home",
          path: "8",
          children: [
            {
              id: "EnterpriseUser",
              label: "企业用户",
              path: "/EnterpriseUser",
            },
            {
              id: "EnterpriseStaff",
              label: "企业员工",
              path: "/EnterpriseStaff",
            },
          ],
        },
        {
          id: "setting",
          label: "系统设置",
          icon: "el-icon-setting",
          path: "9",
          children: [
            {
              id: "AuthorityAccount",
              label: "账号管理",
              path: "/AuthorityAccount",
            },
            {
              id: "BillModel",
              label: "计费模型",
              path: "/BillModel",
            },
          ],
        },
        {
          id: "wxstore",
          label: "微信商城",
          icon: "el-icon-goods",
          path: "10",
          children: [
            {
              id: "ReservationTable",
              label: "预约信息",
              path: "/ReservationTable",
            },
            {
              id: "CarProductionTable",
              label: "车辆发布",
              path: "/CarProductionTable",
            },
            {
              id: "PileProductionTable",
              label: "充电桩发布",
              path: "/PileProductionTable",
            },
            {
              id: "RentProductionTable",
              label: "租赁方案",
              path: "/RentProductionTable",
            },
            {
              id: "ActivityProductionTable",
              label: "优惠活动",
              path: "/ActivityProductionTable",
            },
            {
              id: "CaseProductionTable",
              label: "优秀案例",
              path: "/CaseProductionTable",
            },
          ],
        },
      ],
    };
  },
  computed: {
    ...mapState({
      OperatorId: state => {
        return state.home.OperatorId;
      }
    })
  },
  watch: {
    $route() {
      this.defaultActive = this.$route.fullPath;
    }
  },
  created() {},
  methods: {
    handleSelect(index, indexpath) {
      this.menuTitle = indexpath[0];
      this.subRoute = index.split("/")[index.split("/").length - 1];
    }
  },
};
</script>
<style lang="scss">
.el-menu {
  height: 100%;
  text-align: left;
  background-color: #eef3f6;

  .el-menu-item.is-active {
      color: var(--el-color-primary);
      background-color: var(--el-menu-item-hover-fill);
  }
}
</style>