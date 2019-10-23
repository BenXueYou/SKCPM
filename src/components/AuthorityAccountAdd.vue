<template>
	<el-dialog
		width="480px"
		:title="isAdd?`新增账号`:`修改账号`"
		class="dialog-account-edit"
		center
		:visible.sync="isCurrentShow"
		:before-close="onClickCancel"
		:close-on-click-modal="false"
	>
		<div class="dialog-content">
			<!--内容-->
			<el-form
				:rules="rules"
				ref="addHouseForm"
				:label-position="labelPosition"
				label-width="120px"
				:model="formLabelAlign"
				class="info-form"
			>
				<el-row type="flex" justify="space-between">
					<el-form-item label="运营商：" prop="operatorId">
						<el-select
							class="time-interal"
							v-model="formLabelAlign.operatorId"
							size="small"
							clearable
							placeholder="请选择运营商"
						>
							<el-option
								v-for="item in operatorOptions"
								:key="item.operatorId"
								:label="item.operatorName"
								:value="item.operatorId"
							></el-option>
						</el-select>
					</el-form-item>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-form-item label="用户名：" prop="userName">
						<el-input style="width:auto" v-model="formLabelAlign.userName"></el-input>
					</el-form-item>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-form-item label="密码：" prop="password">
						<el-input style="width:auto" v-model="formLabelAlign.password"></el-input>
					</el-form-item>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-form-item label="企业用户：">
						<el-radio-group v-model="radio">
							<el-radio :label="1">是</el-radio>
							<el-radio :label="0">否</el-radio>
						</el-radio-group>
					</el-form-item>
				</el-row>
				<el-row v-if="radio" type="flex" justify="space-between">
					<el-form-item label="企业名称：" prop="userName">
						<el-select
							class="time-interal"
							v-model="formLabelAlign.userId"
							size="small"
							clearable
							placeholder="请选择企业名称"
							@change="cityChangeAct"
						>
							<el-option
								v-for="item in cityOptions"
								:key="item.userId"
								:label="item.cityName"
								:value="item.userId"
							></el-option>
						</el-select>
					</el-form-item>
				</el-row>
				<el-row type="flex" v-if="!radio" justify="space-between">
					<el-form-item label="权限：" prop="roleId">
						<el-select
							class="time-interal"
							v-model="formLabelAlign.roleId"
							size="small"
							clearable
							placeholder="请选择权限"
						>
							<el-option
								v-for="item in accountRoleOptions"
								:key="item.typeStr"
								:label="item.typeName"
								:value="item.typeStr"
							></el-option>
						</el-select>
					</el-form-item>
				</el-row>
			</el-form>
		</div>
		<div slot="footer" class="dialog-footer">
			<el-button type="primary" @click="onClickConfirm" size="small">确定</el-button>
			<el-button type="primary" @click="onClickCancel" size="small">取消</el-button>
		</div>
	</el-dialog>
</template>
<script>
export default {
  components: {
    // AuthorityAccount,
  },
  props: {
    isAdd: {
      type: Boolean,
      default: true
    },
    isShow: {
      type: Boolean,
      default: false
    },
    rowData: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      radio: 0,
      accountRoleOptions: [
        {
          typeStr: 0,
          typeName: "超级管理员",
          desc: "有且仅有一个，拥有一切权限"
        },
        {
          typeStr: 1,
          typeName: "系统操作员",
          desc: "浏览一切权限"
        },
        {
          typeStr: 2,
          typeName: "运营管理员",
          desc: "运营者一切权限"
        },
        {
          typeStr: 3,
          typeName: "普通操作员",
          desc: "浏览运营权限"
        }
      ],
      operatorOptions: [],
      cityOptions: [],
      areaOptions: [],
      isCurrentShow: false,
      labelPosition: "right",
      formLabelAlign: {
        operatorId: null,
        userId: null,
        roleId: null,
        userName: null,
        password: null
      },
      rules: {
        operatorId: [
          { required: true, message: "运营商不能为空", trigger: "change" }
        ],
        password: [
          { required: true, message: "市不能为空", trigger: "change" }
        ],
        userName: [
          { required: true, message: "地址不能为空", trigger: "change" }
        ],
        roleId: [{ required: true, message: "区域不能为空", trigger: "change" }]
      }
    };
  },
  created() {},
  mounted() {
    this.operatorOptions = this.$store.state.home.operatorArr;
  },
  methods: {
    onClickCancel() {
      this.$emit("onCancel");
    },
    onClickConfirm() {
      console.log(this.formLabelAlign);
      let data = {
        loginId: this.$store.state.home.loginId,
        roleId: this.formLabelAlign.roleId,
        userId: this.formLabelAlign.userId,
        userName: this.formLabelAlign.userName,
        password: this.formLabelAlign.password,
        operatorId: this.formLabelAlign.operatorId
      };
      Object.assign(data, this.formLabelAlign);
      console.log(data);
      if (this.formLabelAlign.id) {
        this.updateAuthorityAccount(data);
      } else {
        this.addAuthorityAccount(data);
      }
    },
    updateAuthorityAccount(data) {
      this.$userAjax
        .updateUserList(data)
        .then(res => {
          if (res.data.success) {
            this.$emit("onCancel", true);
            this.$message.success("修改成功");
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
    addAuthorityAccount(data) {
      this.$userAjax
        .addAdminUser(data)
        .then(res => {
          if (res.data.success) {
            this.$emit("onCancel", true);
            this.$message.success("新增成功");
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
    operatorChangeAct() {
      this.$deviceAjax
        .getCityByoperatorId({ operatorId: this.formLabelAlign.operatorId })
        .then(res => {
          if (res.data.success) {
            this.cityOptions = res.data.model;
            this.formLabelAlign.password = this.cityOptions[0].password;
            this.formLabelAlign.areaId = null;
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    },
    cityChangeAct() {
      this.$deviceAjax
        .getAreaListBypassword({ password: this.formLabelAlign.password })
        .then(res => {
          if (res.data.success) {
            this.areaOptions = res.data.model;
            this.formLabelAlign.areaId = this.areaOptions[0].areaId;
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    }
  },
  watch: {
    isShow(val) {
      this.isCurrentShow = val;
    },
    rowData(val) {
      this.formLabelAlign = JSON.parse(JSON.stringify(val));
      Object.assign(this.formLabelAlign, this.formLabelAlign.address);
      console.log("formLabelAlign", this.formLabelAlign);
      this.cityOptions = val.cityList;
      this.areaOptions = val.areaList;
    }
  },
  destroyed() {}
};
</script>
<style>
.dialog-account-edit .el-dialog__header {
	border-bottom: 1px solid #eeeeee;
}
.dialog-account-edit .el-dialog--center .el-dialog__body {
	text-align: initial;
	padding: 25px 35px 5px 35px;
}
.dialog-account-edit .timePickerClass {
	width: 100%;
	height: 32px;
	line-height: 32px;
}
.dialog-account-edit .el-input .el-input__inner {
	width: 100%;
}
.dialog-account-edit .timePickerClass .el-input__icon,
.dialog-account-edit .timePickerClass .el-input__inner {
	height: 32px;
	line-height: 32px;
	width: 100%;
}
</style>
<style lang="scss" scoped>
.dialog-account-edit {
	.dialog-content {
		box-sizing: border-box;
	}
	.dialog-footer {
		padding: 0 0 4% 0;
		box-sizing: border-box;
	}
	.topTitleTxt {
		font-family: "PingFangSC-Regular";
		font-size: 14px;
		color: #cccccc;
	}
	.time-interal {
		width: 90%;
	}
	.info-form {
		// width: 85%;
		margin: 0 auto;
	}
	.el-form-item {
		margin-bottom: 15px;
	}
}
.el-dialog__header {
	background-color: red;
}
</style>
