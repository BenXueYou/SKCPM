<template>
	<div class="box">
		<el-container>
			<el-header>
				<sk-header></sk-header>
			</el-header>
			<el-container class="container">
				<left-menu class="left-menu"></left-menu>
				<el-main>
					<keep-alive>
						<router-view></router-view>
					</keep-alive>
				</el-main>
			</el-container>
		</el-container>
	</div>
</template>

<script>
import leftMenu from "@/components/leftMenu.vue";
import skHeader from "@/components/header.vue";
export default {
  components: { leftMenu, skHeader },
  props: {},
  data() {
    return {};
  },
  created() {},
  mounted() {
    this.getOperatorList();
    this.getChargeStationList({ pageIndex: 1, pageSize: 100000 });
    this.getPileFactoryList({ pageIndex: 1, pageSize: 100000 });
    this.getProvinceList({pageIndex: 1, pageSize: 100000});
  },
  methods: {
    registerEventbus() {
      this.$bus.$on("getOperatorList", () => {
        this.getOperatorList();
      });
      this.$bus.$on("getChargeStationList", () => {
        this.getChargeStationList({ pageIndex: 1, pageSize: 100000 });
      });
      this.$bus.$on("getPileFactoryList", () => {
        this.getPileFactoryList({ pageIndex: 1, pageSize: 100000 });
      });
    },
    unRegisterEventbus() {
      this.$bus.$off("getOperatorList");
      this.$bus.$off("getChargeStationList");
      this.$bus.$off("getPileFactoryList");
    },
    // 获取当前账号下的运营商
    getOperatorList() {
      this.$userAjax
        .getOperatorList()
        .then(res => {
          if (res.data.success) {
            console.log(res.data);
            this.$store.dispatch("setOperatorArr", res.data.model);
          } else {
            this.$message({ type: "warning", message: "获取运营商数据失败" });
          }
        })
        .catch(() => {});
    },
    // 获取当前账号下的充电站
    getChargeStationList(data) {
      this.$deviceAjax
        .getChargeStationList(data)
        .then(res => {
          if (res.data.success) {
            this.$store.dispatch("setChargeStationArr", res.data.model);
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    },
    // 获取省市区地址
    getProvinceList() {
      this.$deviceAjax
        .getProvinceList()
        .then(res => {
          if (res.data.success) {
            this.$store.dispatch("setProvinceArr", res.data.model);
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    },
    // 获取厂商
    getPileFactoryList(data) {
      this.$deviceAjax
        .getPileFactoryList(data)
        .then(res => {
          if (res.data.success) {
            this.$store.dispatch("setChargeFactoryArr", res.data.model);
          }
        })
        .catch(() => {});
    }
  },
  watch: {},
  destroyed() {
    this.unRegisterEventbus();
  }
};
</script>
<style>
.box .el-table {
	overflow: auto !important;
}
</style>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
@import "@/style/variables.scss";
.box {
	display: flex;
	justify-content: space-between;
	height: 100%;
	color: #cccccc;
	.editFontClass {
		font-family: "PingFangSC-Regular";
		font-size: 13px;
		color: #26d39d;
		margin: 0 10px;
	}
	.deleteBtnClass {
		font-family: "PingFangSC-Regular";
		font-size: 13px;
		color: #ff5f5f;
	}
	.el-container,
	.container {
		width: 100%;
		.el-header {
			padding: 0;
		}
		.left-menu {
			// width: 20%;
			max-width: 200px;
			background: $--color-left-menu;
		}
		.el-main {
			background-color: rgba(245, 245, 245, 0.8);
			padding: 10px 20px;
		}
	}
}
</style>
