<template>
	<el-row ref="headerH" class="header left_menu_box">
		<el-row class="el-row">
			<el-col :span="24">
				<el-menu
					:default-active="defaultActive"
					class="el-menu-vertical"
					@open="handleOpen"
					@close="handleClose"
					@select="handleSelect"
					background-color="#354054"
					text-color="#DDDDDD"
					:router="true"
					active-text-color="#ff5f5f"
				>
					<el-menu-item index="/main/Home" style="padding-left:20px;background-color:rgb(53,64,84)">
						<i class="el-icon-s-platform"></i>
						系统概览
					</el-menu-item>
					<el-submenu index="2" :class="menuTitle === '2'? 'submenuActiveClass' : ''">
						<template slot="title">
							<i class="el-icon-data-line"></i>
							<span>设备监控</span>
							<img
								v-show="menuTitle === '2'"
								class="left_menu_box_right_icon"
								src="@/assets/images/select-down.png"
							/>
							<img
								v-show="menuTitle !== '2'"
								class="left_menu_box_right_icon"
								src="@/assets/images/leftMenu/left_menu_down_icon.png"
								alt
							/>
						</template>
						<el-menu-item index="/Main/PileRealData">充电监控</el-menu-item>
						<el-menu-item index="/Main/SwitchData">变位监控</el-menu-item>
						<el-menu-item index="/Main/FaultAlarmData">故障监控</el-menu-item>
					</el-submenu>
					<el-submenu index="5" :class="menuTitle === '5'? 'submenuActiveClass' : ''">
						<template slot="title">
							<i class="el-icon-notebook-2"></i>
							<span slot="title">运营管理</span>
							<img
								v-show="menuTitle === '5'"
								class="left_menu_box_right_icon"
								src="@/assets/images/select-down.png"
							/>
							<img
								v-show="menuTitle !== '5'"
								class="left_menu_box_right_icon"
								src="@/assets/images/leftMenu/left_menu_down_icon.png"
								alt
							/>
						</template>
						<el-menu-item index="/Main/RechargeRecord">充值记录</el-menu-item>
						<el-menu-item index="/Main/RefrundRecord">提现记录</el-menu-item>
						<el-menu-item index="/Main/ChargeRecord">充电记录</el-menu-item>
						<!-- <el-menu-item index="/Main/ChargingRecord">扣费记录</el-menu-item> -->
					</el-submenu>
					<el-submenu index="6" :class="menuTitle === '6'? 'submenuActiveClass' : ''">
						<template slot="title">
							<i class="el-icon-medal"></i>
							<span slot="title">运营统计</span>
							<img
								v-show="menuTitle === '6'"
								class="left_menu_box_right_icon"
								src="@/assets/images/select-down.png"
							/>
							<img
								v-show="menuTitle !== '6'"
								class="left_menu_box_right_icon"
								src="@/assets/images/leftMenu/left_menu_down_icon.png"
								alt
							/>
						</template>
						<el-menu-item index="/Main/AppUserStatics">用户统计</el-menu-item>
						<el-menu-item index="/Main/ChargePileStatics">充电桩统计</el-menu-item>
						<el-menu-item index="/Main/ChargeStationStatics">充电站统计</el-menu-item>
						<el-menu-item index="/Main/OperatorStatics">运营商统计</el-menu-item>
					</el-submenu>

					<el-submenu index="3" :class="menuTitle === '3'? 'submenuActiveClass' : ''">
						<template slot="title">
							<i class="el-icon-price-tag"></i>
							<span>设备管理</span>
							<img
								v-show="menuTitle === '3'"
								class="left_menu_box_right_icon"
								src="@/assets/images/select-down.png"
							/>
							<img
								v-show="menuTitle !== '3'"
								class="left_menu_box_right_icon"
								src="@/assets/images/leftMenu/left_menu_down_icon.png"
								alt
							/>
						</template>
						<el-menu-item index="/Main/ChargePile">充电桩</el-menu-item>
						<el-menu-item index="/Main/ChargeStation">充电站</el-menu-item>
						<el-menu-item index="/Main/ChargeAddress">充电桩地址</el-menu-item>
						<el-menu-item index="/Main/ChargeFactory">充电桩厂商</el-menu-item>
					</el-submenu>
					<el-submenu index="4" :class="menuTitle === '4'? 'submenuActiveClass' : ''">
						<template slot="title">
							<!-- <img class="access_autn_select" src="@/assets/images/leftMenu/access_authority.png" alt /> -->
							<i class="el-icon-s-custom"></i>
							<span slot="title">用户管理</span>
							<img
								v-show="menuTitle === '4'"
								class="left_menu_box_right_icon"
								src="@/assets/images/select-down.png"
							/>
							<img
								v-show="menuTitle !== '4'"
								class="left_menu_box_right_icon"
								src="@/assets/images/leftMenu/left_menu_down_icon.png"
								alt
							/>
						</template>
						<el-menu-item index="/Main/AppUser">用户管理</el-menu-item>
						<el-menu-item index="/Main/Operator">运营商管理</el-menu-item>
						<!-- <el-menu-item index="/Main/CardUser">充电卡管理</el-menu-item> -->
					</el-submenu>

					<el-menu-item index="/main/BillModel" style="padding-left:20px;background-color:rgb(53,64,84)">
						<i class="el-icon-money"></i>
						计费模型
					</el-menu-item>
					<el-submenu index="7" :class="menuTitle === '7'? 'submenuActiveClass' : ''">
						<template slot="title">
							<i class="el-icon-menu"></i>
							<span slot="title">微信商城</span>
							<img
								v-show="menuTitle === '6'"
								class="left_menu_box_right_icon"
								src="@/assets/images/select-down.png"
							/>
							<img
								v-show="menuTitle !== '6'"
								class="left_menu_box_right_icon"
								src="@/assets/images/leftMenu/left_menu_down_icon.png"
								alt
							/>
						</template>
						<el-menu-item index="/Main/ReservationTable">预约信息</el-menu-item>
						<el-menu-item index="/Main/CarProductionTable">车辆发布</el-menu-item>
						<el-menu-item index="/Main/PileProductionTable">充电桩发布</el-menu-item>
						<el-menu-item index="/Main/RentProductionTable">租赁方案</el-menu-item>
						<el-menu-item index="/Main/ActivityProductionTable">优惠活动</el-menu-item>
						<el-menu-item index="/Main/CaseProductionTable">优秀案例</el-menu-item>
						<el-menu-item index="/Main/AlignProductionTable">加盟方案</el-menu-item>
					</el-submenu>
				</el-menu>
			</el-col>
		</el-row>
	</el-row>
</template>
<script>
export default {
  mounted: function() {
    console.log(this.$route);
    // this.$router.push("AccessCaseConfig");
    // this.$router.push("{ name: this.$route.name }");
    this.defaultActive = this.$route.fullPath;
    console.log(this.defaultActive);
  },
  data: function() {
    return {
      menuTitle: "1",
      subRoute: "VistorRecord",
      defaultActive: ""
    };
  },
  watch: {
    $route(to, from) {
      this.defaultActive = this.$route.fullPath;
    }
  },
  methods: {
    handleOpen(key, keyPath) {
      this.menuTitle = key;
    },
    handleClose(key, keyPath) {
      this.menuTitle = key;
    },
    handleSelect(index, indexpath) {
      // console.log(index, indexpath);
      this.menuTitle = indexpath[0];
      this.subRoute = index.split("/")[index.split("/").length - 1];
    }
  }
};
</script>
<style>
.left_menu_box .el-icon-arrow-down:before {
	content: "";
}
</style>
<style lang="scss" scoped>
@import "@/style/variables.scss";
.left_menu_box .left_menu_box_right_icon {
	width: 9.2px;
	height: 6px;
	position: absolute;
	top: 24px;
	right: 18px;
}
.left_menu_box .el-submenu .el-menu-item {
	padding-left: 55px !important;
	font-family: "PingFangSC-Regular";
	font-size: 13px !important;
	color: #dddddd;
	text-align: justify;
	background-color: rgba(27, 27, 27, 0.6) !important;
	height: 45px;
}
.left_menu_box .access_autn_select {
	margin-right: 10px;
	width: 15px;
	height: 15px;
}
.el-submenu__title {
	position: relative;
	font-family: "PingFangSC-Regular";
	font-size: 14px !important;
	border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
	box-shadow: 8px 0 18px 0 rgba(0, 0, 0, 0.1);
}
.el-menu-item.isActive {
	border-left: 2px solid #26d39d !important;
}
.left_menu_box .el-menu-item.is-active {
	color: rgb(220, 221, 222) !important;
	background-color: $--color-primary !important;
}
.left_menu_box .submenuActiveClass .el-submenu__title {
	background-color: $--color-left-submenu !important;
}
.el-menu--collapse {
	width: 100%;
}
.el-menu--vertical {
	background: rgba(39, 42, 45, 0.9);
	width: 140px;
}
.el-menu--vertical .el-menu {
	background: rgba(39, 42, 45, 0.9);
	border: none;
	min-width: 138px;
}
.header {
	width: 100%;
	height: 100%;
	background: rgba(35, 38, 41, 0.8);
	box-sizing: border-box;
	position: relative;
}
.left_menu_box {
	overflow-y: auto;
	overflow-x: hidden;
	text-align: left;
}
.el-menu {
	background: rgba(39, 42, 45, 0.9);
	border: none;
}
.menuItemBoxClass .el-submenu {
	height: 50px;
	line-height: 49px;
}
.el-menu--horizontal {
	border: none;
}
.el-menu--horizontal .el-menu-item {
	transition: all 0.6s ease-in-out;
}
.el-menu--horizontal .el-submenu:hover,
.el-menu--horizontal .el-menu-item:hover {
	transition: all 0.6s ease-in-out;
}
.el-menu--horizontal > .el-menu-item .is-active {
	background-color: rgb(35, 57, 54);
}
.el-submenu__title:hover,
.el-menu-item:hover,
.el-menu-item:focus {
	background-color: $--color-primary;
	color: #72757f;
}
li {
	padding: 0;
}

a:-webkit-any-link {
	color: -webkit-link;
	text-decoration: none;
	cursor: auto;
}
.left_menu_box .el-icon-arrow-down:before {
	content: "";
	background-image: url("../assets/images/leftMenu/down_btn.png");
}
</style>
