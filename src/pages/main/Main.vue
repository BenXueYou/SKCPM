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
						<transition :name="fade">
							<router-view class="Router"></router-view>
						</transition>
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
    return {
      fade: "slide-right" // 默认动态路由变化为slide-right
    };
  },
  created() {},
  mounted() {
    this.getOperatorList();
    this.getChargeStationList({
      model: {},
      pageIndex: 1,
      pageSize: 100000,
      queryCount: true,
      start: 0
    });
    this.getPileFactoryList({ pageIndex: 1, pageSize: 100000 });
    this.getProvinceList({ pageIndex: 1, pageSize: 100000 });
    console.log(this.$store.state.home);
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
            let arr = res.data.model || [];
            // arr.unshift({ operatorName: "全部", operatorId: null });
            this.$store.dispatch("setOperatorArr", arr);
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
  watch: {
    $route(to, from) {
      let isBack = this.$router.isBack; //  监听路由变化时的状态为前进还是后退
      if (isBack) {
        this.fade = "slide-right";
      } else {
        this.fade = "slide-left";
      }
      this.$router.isBack = false;
    }
  },
  destroyed() {
    this.unRegisterEventbus();
  }
};
</script>
<style>
.box .tableBox {
	overflow: auto !important;
	min-height: calc(100% - 150px);
	padding-bottom: 30px;
	box-sizing: border-box;
}
.box .tableBox .el-table {
	height: 100%;
}
/**渐进动画 */
/* .fade-enter-active,
.fade-leave-active {
	transition: opacity 0.5s;
}
.fade-enter,
.fade-leave {
	opacity: 0;
} */
/**移动移入动画 */
/* .slide-right-enter-active,
.slide-right-leave-active,
.slide-left-enter-active,
.slide-left-leave-active {
  will-change: transform;
  transition: all 1000ms;
  position: absolute;
}
.slide-right-enter {
  opacity: 0;
  transform: translate3d(-100%, 0, 0);
}
.slide-right-leave-active {
  opacity: 0;
  transform: translate3d(100%, 0, 0);
}
.slide-left-enter {
  opacity: 0;
  transform: translate3d(100%, 0, 0);
}
.slide-left-leave-active {
  opacity: 0;
  transform: translate3d(-100%, 0, 0);
} */

.slide-left-enter-active {
	transition: all 0.3s ease;
}
.slide-left-leave-active {
	transition: all 0.8s ease;
}
.slide-left-enter,
.slide-fade-leave-active {
	transform: translateX(100%);
	opacity: 0;
}
.slide-left-leave-to {
	transform: translateX(-100%);
	opacity: 0;
}

.slide-right-enter-active {
	transition: all 0.3s ease;
}
.slide-right-leave-active {
	transition: all 0.8s ease;
}
.slide-fade-leave-active,
.slide-right-enter {
	transform: translateX(-100%);
	opacity: 0;
}
.slide-right-leave-to {
	transform: translateX(100%);
	opacity: 0;
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
		height: 100%;
		overflow: auto;
		.el-header {
			padding: 0;
		}
		.left-menu {
			// width: 20%;
			max-width: 200px;
			background: $--color-left-menu;
			height: 100%;
		}
		.el-main {
			background-color: rgba(245, 245, 245, 0.8);
			padding: 10px 20px;
		}
	}
}
</style>
