<template>
	<div class="login-div">
		<div class="login-head">
			<div style="width: 10%">
				<!-- <img src="@/assets/images/login/login_sk_logo.png" width="100%" /> -->
				<img src="@/assets/images/login/login_sk_logo.png" width="100%" />
			</div>
			<div class="logoTitle">充电桩管理云平台</div>
		</div>
		<div class="login-main">
			<div class="main-block">
				<div class="block-title">云平台登录</div>
				<el-form :rules="rules" ref="loginForm" :model="formLabelAlign" class="info-form">
					<el-form-item prop="username">
						<el-input
							placeholder="手机号/账号"
							v-model="formLabelAlign.username"
							@keyup.enter.native="login"
							style="width: 100%; margin-top: 34px;"
						>
							<!-- <img slot="prefix" src="@/assets/images/login/head.png" /> -->
							<i slot="prefix" class="el-icon-user-solid"></i>
						</el-input>
					</el-form-item>
					<el-form-item prop="password">
						<el-input
							placeholder="密码"
							type="password"
							v-model="formLabelAlign.password"
							@keyup.enter.native="login"
							style="width: 100%;"
						>
							<!-- <img slot="prefix" src="@/assets/images/login/pwd.png" /> -->
							<i slot="prefix" class="el-icon-lock"></i>
						</el-input>
					</el-form-item>
				</el-form>
				<div class="login-buttons">
					<el-checkbox v-model="isRembAccount">是否记住账号</el-checkbox>
					<div style="margin-right: 4px">
						<span class="button-text" style="cursor: pointer">忘记密码</span>
						<span class="button-text">|</span>
						<span class="button-text" style="cursor: pointer">注册</span>
					</div>
				</div>
				<el-button style="width: 100%; margin-top: 48px;" type="primary" @click="login" size="small">登录</el-button>
			</div>
		</div>
		<div class="login-foot">
			<div class="foot-item">
				<div class="item-text" v-for="(item,index) in alinkArr" :key="index">
					<a :href="item.strValue" target="_blank">{{item.strName}}</a>
				</div>
			</div>
			<div class="foot-text">Copyright © 2016 0901.com All Rights Reserved 版权所有</div>
		</div>
	</div>
</template>

<script>
export default {
  components: {},
  // inject: ['reload'],
  props: {},
  data() {
    let validateAccount = (rule, value, callback) => {
      /* eslint-disable */
			var eReg = /^[^\[\]\?\|\\\/\:\;\+\*\<\>]*$/;
			if (!eReg.test(value)) {
				callback(new Error("不能包含特殊字符 /[]:;丨+*?<>"));
			} else {
				callback();
			}
			/* eslint-enable */
    };
    let validatePwd = (rule, value, callback) => {
      /* eslint-disable */
			// var eReg = /^(?![^a-zA-Z]+$)(?!\D+$)/;
			// var eReg = true;
			// if (!eReg.test(value)) {
			// 	callback(new Error("至少包含数字，字母这两种（区分大小写）"));
			// } else {
			callback();
			// }
			/* eslint-enable */
    };
    let noSpace = (rule, value, callback) => {
      /* eslint-disable */
			var eReg = /^[^\s]*$/;
			if (!eReg.test(value)) {
				callback(new Error("字符中不能包含空格"));
			} else {
				callback();
			}
			/* eslint-enable */
    };
    return {
      alinkArr: window.config.alinkArr,
      formLabelAlign: {
        username: "",
        password: ""
      },
      isRembAccount: true,
      rules: {
        username: [
          { required: true, message: "手机号或账号不能为空", trigger: "blur" },
          {
            whitespace: true,
            type: "string",
            message: "不允许输入空格",
            trigger: "blur"
          },
          {
            min: 4,
            max: 16,
            message: "长度在 4 到 16 个字符",
            trigger: "blur"
          },
          { validator: validateAccount, trigger: "blur" },
          { validator: noSpace, trigger: "blur" }
        ],
        password: [
          { required: true, message: "密码不能为空", trigger: "blur" },
          { whitespace: true, message: "不允许输入空格", trigger: "blur" },
          {
            min: 4,
            max: 16,
            message: "长度在 6 到 16 个字符",
            trigger: "blur"
          },
          { validator: validatePwd, trigger: "blur" },
          { validator: noSpace, trigger: "blur" }
        ]
      }
    };
  },
  created() {},
  mounted() {
    this.formLabelAlign.username = this.$store.state.home.account;
    if (this.$store.state.home.Authorization) {
      let index = window.location.href.lastIndexOf("/");
      let suffix = window.location.href.substring(0, index + 1);
      window.location.href = suffix + "Main";
    }
  },
  methods: {
    login() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.$loginAjax
            .login({
              loginId: this.formLabelAlign.username,
              password: this.formLabelAlign.password
            })
            .then(res => {
              let body = res.data;
              this.loginSuccessResponse(body);
            });
        } else {
          this.$cToast.error("请正确填写内容");
        }
      });
    },
    loginSuccessResponse(body) {
      if (body) {
        if (this.isRembAccount) {
          this.$store.dispatch("setAccount", this.formLabelAlign.username);
          this.$store.dispatch("SET_USERUUID", this.formLabelAlign.password);
        } else {
          this.$store.dispatch("setAccount", "");
          this.$store.dispatch("SET_USERUUID", "");
        }
        let operatorId = body.model.operatorId;
        this.$store.dispatch("setOperatorId", operatorId);
        let Authorization = body.model.token;
        this.$store.dispatch("setAuthorization", Authorization);
        this.$store.dispatch("setAuthRoleId", body.model.roleId);
        // 角色ID 0 || 2 时 读写权限
        // 角色ID 1 || 3 时 读权限
        if (body.model.roleId % 2) {
          this.$store.dispatch("setAuthorizationID", false);
        } else {
          this.$store.dispatch("setAuthorizationID", true);
        }
        console.log(body.model);
        this.$store.dispatch("setLoginId", body.model.loginId);
        // 刷新页面以便于更新projectUuid
        this.$nextTick(() => {
          window.location.reload();
        });
      }
    }
  },
  watch: {},
  destroyed() {}
};
</script>

<style lang="scss">
.login-div {
	.el-input__prefix {
		position: absolute;
		left: 18px;
		top: 6px;
	}
	.el-input--prefix .el-input__inner {
		padding-left: 38px;
	}
	.el-input__inner {
		background: rgba($color: #000000, $alpha: 0.05) !important;
		height: 46px;
		font-family: "PingFangSC-Regular";
		font-size: 14px;
		color: #575757;
		letter-spacing: 0;
	}
	.el-input__icon {
		line-height: 46px;
	}
	.el-checkbox__input.is-checked .el-checkbox__inner {
		background-color: #299dff;
	}
	.el-checkbox__input.is-checked .el-checkbox__inner:after {
		border-color: #ffffff !important;
	}
	.el-checkbox__label {
		font-family: "PingFangSC-Regular";
		font-size: 12px;
		color: #999999;
		letter-spacing: 0;
	}
	.el-button--primary {
		background-color: #299dff !important;
		height: 46px;
		font-family: "PingFangSC-Regular";
		font-size: 14px;
		color: #ffffff;
		letter-spacing: 0;
	}
}
</style>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.login-div {
	width: 100%;
	height: 100%;
	background: #222222;
	.login-head {
		height: 13%;
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: flex-start;
		padding: 2% 3%;
		box-sizing: border-box;
		.logoTitle {
			margin-left: 15px;
			margin-top: -10px;
			font: bold 36px/100% "微软雅黑", "Lucida Grande", "Lucida Sans", Helvetica,
				Arial, Sans;
			text-shadow: 1px 1px rgba(197, 223, 248, 0.8),
				2px 2px rgba(197, 223, 248, 0.8), 3px 3px rgba(197, 223, 248, 0.8),
				4px 4px rgba(197, 223, 248, 0.8), 5px 5px rgba(197, 223, 248, 0.8),
				6px 6px rgba(197, 223, 248, 0.8);
			color: #eeeeee;
			text-shadow: 5px 5px 0 #666, 7px 7px 0 #eee;
			text-shadow: 0 0 20px #363636;
		}
		.head-title {
			font-family: "PingFangSC-Regular";
			font-size: 16px;
			color: #dddddd;
			display: flex;
			align-items: center;
			&:hover {
				color: #26ca96;
			}
			.title {
				cursor: pointer;
			}
			.change-but {
				margin-left: 8px;
				cursor: pointer;
			}
		}
	}
	.login-main {
		height: 74%;
		width: 100%;
		// background: url("../../assets/login_bg.jpg") no-repeat;
		background: url("../../assets/webbg.jpg") no-repeat;
		background-size: 100% 100%;
		padding: 0 0 0 65%;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		.main-block {
			width: 75%;
			min-width: 300px;
			height: 400px;
			background: #ffffff;
			padding: 8%;
			box-sizing: border-box;
			.block-title {
				font-family: PingFangSC-Medium;
				font-size: 30px;
				color: #333333;
				text-align: center;
				width: 100%;
			}
			.login-buttons {
				display: flex;
				width: 94%;
				margin-top: 20px;
				margin-left: 10px;
				justify-content: space-between;
				.button-text {
					font-family: "PingFangSC-Regular";
					font-size: 12px;
					color: #999999;
					letter-spacing: 0;
				}
			}
		}
	}
	.login-foot {
		height: 13%;
		width: 100%;
		padding: 0 26%;
		box-sizing: border-box;
		display: flex;
		flex-direction: column;
		align-content: space-between;
		justify-content: center;
		.foot-item {
			display: flex;
			align-items: center;
			justify-content: space-between;
			.item-text {
				font-family: "PingFangSC-Regular";
				font-size: 16px;
				color: #999999;
				cursor: pointer;
				a {
					cursor: pointer;
					color: #999999;
					text-decoration: none;
				}
			}
		}
		.foot-text {
			margin-top: 14px;
			font-family: "PingFangSC-Regular";
			font-size: 14px;
			color: #555555;
			letter-spacing: 1.17px;
			text-align: center;
		}
	}
}
</style>
