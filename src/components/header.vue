<template>
	<el-row class="header" type="flex" justify="space-between">
		<el-col :span="8" class="headLeft logo">
			<img src="@/assets/left_headr_sk_logo.png" alt srcset />
		</el-col>
		<el-col :span="16" class="headTop">
			<el-dropdown trigger="click" @command="handleCommand" class="quit-btn">
				<span class="el-dropdown-link myAccountHeader">
					<img src="@/assets/images/header.png" alt />
					<span class="userName">{{username}}</span>
					<i class="el-icon-caret-bottom el-icon--right"></i>
				</span>
				<el-dropdown-menu slot="dropdown">
					<el-dropdown-item class="dropdown-li" disabled command="xiugai">
						<span class="myAccountItem">
							<img src="@/assets/images/mima.png" class="normal" width="14px" height="14px" />
							<!-- <img src="@/assets/images/mima_l.png" class="active" width="14px" height="14px" /> -->
							<span>修改密码</span>
						</span>
					</el-dropdown-item>
					<el-dropdown-item class="dropdown-li" command="tuichu">
						<span class="myAccountItem">
							<img src="@/assets/images/tuichu.png" class="normal" width="14px" height="14px" />
							<!-- <img src="@/assets/images/tuichu_l.png" class="active" width="14px" height="14px" /> -->
							<span>退出</span>
						</span>
					</el-dropdown-item>
				</el-dropdown-menu>
			</el-dropdown>
		</el-col>
	</el-row>
</template>
<script>
export default {
  data() {
    return {
      username: "用户名"
    };
  },
  methods: {
    handleCommand(command) {
      this.onClickQuit();
    },
    onClickQuit() {
      this.$store.dispatch("setAccount", "");
      this.$store.dispatch("setAuthorization", "");
      this.$store.dispatch("setOperatorId", []);
      this.$store.dispatch("SET_USERUUID", "");
      this.$router.push({
        name: "Login"
      });
    }
  }
};
</script>
<style scoped lang='scss'>
@import "@/style/variables.scss";
// .dropdown-li {
// 	text-align: left;
// 	.myAccountItem {
// 		span {
// 			padding-left: 4px;
// 		}
// 		img {
// 			width: 11px;
// 			height: 11px;
// 		}
// 		.active {
// 			display: none;
// 		}

// 		vertical-align: top;
// 	}
// 	&:hover {
// 		color: #299dff;
// 		.normal {
// 			display: none !important;
// 		}
// 		.active {
// 			display: inline-block;
// 		}
// 	}
// }
.header {
	height: 100%;
	padding: 0;
	display: flex;
	-ms-flex-flow: row nowrap;
	flex-flow: row nowrap;
	-ms-flex-align: center;
	align-items: center;
	.headLeft {
		width: 20%;
		height: 100%;
		max-width: 200px;
		background: $--color-left-menu;
		text-align: left;
		img {
			width: 100%;
			height: 100%;
		}
	}
	.headTop {
		text-align: right;
		.myAccountHeader {
			cursor: pointer;
			line-height: 30px;
			font-family: "PingFangSC-Light";
			font-size: 12px;
			color: #363636;
			letter-spacing: 0;
			text-align: left;
			span {
				padding-left: 15px;
			}
			img {
				vertical-align: top;
			}
		}
		.quit-btn {
			margin-left: auto;
			margin-right: 1%;
			.quit-btn-icon {
				display: flex;
				flex-direction: row;
				align-items: center;
				justify-content: center;
				.quit-btn-text {
					font-family: "PingFangSC-Regular";
					font-size: 12px;
					color: #dddddd;
					letter-spacing: 0;
					text-align: right;
					margin-left: 6px;
				}
			}
		}
	}
}
</style>
