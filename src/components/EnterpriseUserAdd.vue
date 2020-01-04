<template>
	<el-dialog
		width="580px"
		:title="!rowData.id?`新增企业用户`:`修改企业用户`"
		class="dialog-enterprise-add"
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
					<el-col :span="12">
						<el-form-item label="企业名称：" prop="companyName">
							<el-input class="time-interal" v-model="formLabelAlign.companyName" size="small" clearable></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="联系人：" prop="contactName">
							<el-input class="time-interal" v-model="formLabelAlign.contactName" size="small" clearable></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="电话：" prop="telephone">
							<el-input class="time-interal" v-model="formLabelAlign.telephone" size="small" clearable></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="余额：" prop="balance">
							<el-input
								style="width:96.5%"
								class="time-interal"
								v-model="formLabelAlign.balance"
								size="small"
								clearable
							></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="24">
						<el-form-item label="地址：" prop="companyAddress">
							<el-input
								style="width:96.5%"
								class="time-interal"
								v-model="formLabelAlign.companyAddress"
								size="small"
								clearable
							></el-input>
						</el-form-item>
					</el-col>
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
      chargePileFactoryOptions: [],
      chargePriceModelOptions: [],
      chargePileModelOptions: [],
      chargeStationModelOptions: [],
      businessOptions: [],
      isCurrentShow: false,
      labelPosition: "right",
      formLabelAlign: {
        account: "string",
        balance: 0,
        companyAddress: "string",
        companyId: "string",
        companyName: "string",
        contactName: "string",
        telephone: "string"
      },
      rules: {
        companyName: [
          { required: true, message: "企业用户名称不能为空", trigger: "blur" },
          { whitespace: true, message: "不允许输入空格", trigger: "blur" },
          { min: 1, max: 32, message: "长度在 1 到 32 个字符", trigger: "blur" }
        ],
        contactName: [
          { required: true, message: "联系人不能为空", trigger: "change" }
        ],
        telephone: [
          { required: true, message: "电话不能为空", trigger: "change" }
        ]
      }
    };
  },
  created() {},
  mounted() {
    this.initData();
  },
  methods: {
    initData() {},
    setUseData() {},
    onClickCancel() {
      this.$emit("onCancel");
    },
    onClickConfirm() {
      this.$refs.addHouseForm.validate(valid => {
        if (valid) {
          if (this.formLabelAlign.id) {
            this.updateOperator(this.formLabelAlign);
          } else {
            this.addOperator(this.formLabelAlign);
          }
        } else {
          this.$cToast.error("请正确填写内容");
        }
      });
    },
    addOperator(data) {
      this.$EnterpriseAjax
        .postEnterPriseUserApi(data)
        .then(res => {
          if (res.data.success) {
            this.$message.success("添加成功！");
            this.$emit("onCancel", true);
          }
        })
        .catch(() => {});
    },
    updateOperator(data) {
      this.$EnterpriseAjax
        .updateEnterPriseUserApi(data)
        .then(res => {
          if (res.data.success) {
            this.$message.success("修改成功");
            this.$emit("onCancel", true);
          }
        })
        .catch(() => {});
    }
  },
  watch: {
    isShow(val) {
      this.isCurrentShow = val;
      if (val && this.rowData.id) {
        this.formLabelAlign = JSON.parse(JSON.stringify(this.rowData));
      } else {
        this.formLabelAlign = {
          account: null,
          balance: 0,
          companyAddress: null,
          companyId: null,
          companyName: null,
          contactName: null,
          telephone: null
        };
      }
    }
  },
  destroyed() {}
};
</script>
<style>
.dialog-enterprise-add .el-dialog__header {
	border-bottom: 1px solid #eeeeee;
}
.dialog-enterprise-add .el-dialog--center .el-dialog__body {
	text-align: initial;
	padding: 25px 35px 20px 5px;
}
</style>
<style lang="scss" scoped>
.dialog-enterprise-add {
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
		margin-bottom: 12px;
	}
}
.el-dialog__header {
	background-color: red;
}
</style>
