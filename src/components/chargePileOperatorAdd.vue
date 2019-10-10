<template>
	<el-dialog
		width="580px"
		:title="isAdd?`新增运营商`:`修改运营商`"
		class="dialog-factory-add"
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
						<el-form-item label="运营商：" prop="operatorName">
							<el-input class="time-interal" v-model="formLabelAlign.operatorName" size="small"></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="联系人：" prop="contactName">
							<el-input class="time-interal" v-model="formLabelAlign.contactName" size="small"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="电话：" prop="telephone">
							<el-input class="time-interal" v-model="formLabelAlign.telephone" size="small"></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="邮箱：" prop="email">
							<el-input class="time-interal" v-model="formLabelAlign.email" size="small"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="24">
						<el-form-item label="地址：" prop="address">
							<el-input
								style="width:96.5%"
								class="time-interal"
								v-model="formLabelAlign.address"
								size="small"
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
        address: "",
        bankCard: "",
        bankCode: "",
        bossId: 0,
        cardUser: "",
        contactName: "",
        email: "",
        operatorId: 0,
        operatorLoginId: 0,
        operatorName: "",
        telephone: "",
        validFlag: 0,
        bulk: false
      },
      rules: {
        operatorName: [
          { required: true, message: "运营商名称不能为空", trigger: "blur" },
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
    initData() {
      /**
       *     "id": 2,
    "operatorId": 34,
    "operatorName": "尙宽",
    "bossId": 0,
    "telephone": "15251877737",
    "email": "",
    "address": "山西省太原市小店区尚宽电气集团",
    "validFlag": 1,
    "contactName": "tes",
    "bankCard": "6222621020010875574",
    "bankCode": "1020",
    "cardUser": "赵文昌",
    "gmtCreate": "2019-07-31 21:22:54",
    "gmtModify": "2019-07-31 21:23:58",
    "isDeleted": 0
       */
      this.$userAjax
        .getOperatorList()
        .then(res => {})
        .catch(() => {});
    },
    setUseData() {},
    onClickCancel() {
      this.$emit("onCancel");
    },
    onClickConfirm() {
      this.$refs.addHouseForm.validate(valid => {
        if (valid) {
          if (this.formLabelAlign.operatorId) {
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
      this.$userAjax
        .addOperator(data)
        .then(res => {
          if (res.data.success) {
            this.$message.success("添加成功！");
            this.$emit("onCancel", true);
          }
        })
        .catch(() => {});
    },
    updateOperator(data) {
      this.$userAjax
        .updateOperator(data)
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
      if (val) {
        this.formLabelAlign = JSON.parse(JSON.stringify(this.rowData));
      } else {
        this.formLabelAlign = {
          address: "",
          bankCard: "",
          bankCode: "",
          bossId: 0,
          cardUser: "",
          contactName: "",
          email: "",
          operatorId: this.$store.state.home.OperatorId,
          operatorLoginId: this.$store.state.home.OperatorId,
          operatorName: "",
          telephone: "",
          validFlag: 0,
          bulk: false
        };
      }
    }
  },
  destroyed() {}
};
</script>
<style>
.dialog-factory-add .el-dialog__header {
	border-bottom: 1px solid #eeeeee;
}
.dialog-factory-add .el-dialog--center .el-dialog__body {
	text-align: initial;
	padding: 25px 35px 20px 5px;
}
</style>
<style lang="scss" scoped>
.dialog-factory-add {
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
