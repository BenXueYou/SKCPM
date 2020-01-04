<template>
	<el-dialog
		width="580px"
		:title="!rowData.cardNum?`新增卡用户信息`:`修改卡用户信息`"
		class="card-user-edit"
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
						<el-form-item label="卡号：" prop="chargePriceModel">
							<el-input
								class="time-interal"
								style="width:96%;box-sizing: border-box;"
								v-model="formLabelAlign.address"
								size="small"
								clearable
							></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="运营商：" prop="operatorId">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.operatorId"
								size="small"
								clearable
								placeholder="请选择"
							>
								<el-option
									v-for="item in businessOptions"
									:key="item.operatorId"
									:label="item.operatorName"
									:value="item.operatorId"
								></el-option>
							</el-select>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="用户名：" prop="userName">
							<el-input
								class="time-interal"
								style="width:96%;box-sizing: border-box;"
								v-model="formLabelAlign.userName"
								size="small"
								clearable
							></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="电话：" prop="telephone">
							<el-input
								class="time-interal"
								style="width:96%;box-sizing: border-box;"
								v-model="formLabelAlign.telephone"
								size="small"
								clearable
							></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="修改后余额：" prop="telephone">
							<el-input
								class="time-interal"
								style="width:96%;box-sizing: border-box;"
								v-model="formLabelAlign.deforeDepositMoney"
								size="small"
								clearable
							></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="修改前余额：" prop="depositMoney">
							<el-input
								class="time-interal"
								style="width:96%;box-sizing: border-box;"
								v-model="formLabelAlign.depositMoney"
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
// import PopoverTreeForBottom from "@/pages/buildingsHouse/components/PopoverTreeForBottom";

export default {
  components: {
    // PopoverTreeForBottom,
  },
  props: {
    isAdd: {
      type: Boolean,
      default: true
    },
    visible: {
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
      isCurrentShow: false,
      labelPosition: "right",
      formLabelAlign: {
        userName: null,
        cardNum: null,
        telephone: null,
        operatorId: null,
        depositMoney: null,
        beforeDepositMoney: null
      },
      businessOptions: [],
      rules: {
        userName: [
          { required: true, message: "用户名不能为空", trigger: "change" }
        ],
        cardNum: [
          { required: true, message: "卡号不能为空", trigger: "change" }
        ],
        depositMoney: [
          { required: true, message: "余额不能为空", trigger: "change" }
        ],
        phoneNumber: [
          { required: true, message: "电话不能为空", trigger: "change" }
        ]
      }
    };
  },
  created() {},
  mounted() {
    this.businessOptions = this.$store.state.home.operatorArr;
  },
  methods: {
    onClickCancel() {
      this.$emit("onCancel");
    },
    onClickConfirm() {
      this.$refs.addHouseForm.validate(valid => {
        if (valid) {
        } else {
          this.$cToast.error("请正确填写内容");
        }
      });
    },
    saveCardUser() {
      this.$userAjax
        .saveCardUserDeposit(this.formLabelAlign)
        .then(res => {
          if (res.data.success) {
            this.$message.success("编辑成功！");
            this.$emit("onCancel", true);
          } else {
          }
        })
        .catch(() => {});
    }
  },
  watch: {
    visible(val) {
      this.isCurrentShow = val;
      if (val && this.rowData.cardNum) {
        Object.assign(this.formLabelAlign, this.rowData);
      } else {
        this.formLabelAlign = {
          userName: null,
          cardNum: null,
          telephone: null,
          operatorId: null,
          depositMoney: null,
          beforeDepositMoney: null
        };
      }
      //   this.formLabelAlign.operatorLoginId = this.$store.state.home.OperatorId;
    }
  },
  destroyed() {}
};
</script>
<style>
.card-user-edit .el-dialog__header {
	border-bottom: 1px solid #eeeeee;
}
.card-user-edit .el-dialog--center .el-dialog__body {
	text-align: initial;
	padding: 25px 35px 5px 5px;
}
.card-user-edit .timePickerClass {
	width: 100%;
	height: 32px;
	line-height: 32px;
}
.card-user-edit .el-input .el-input__inner {
	width: 100%;
}
.card-user-edit .timePickerClass .el-input__icon,
.card-user-edit .timePickerClass .el-input__inner {
	height: 32px;
	line-height: 32px;
	width: 100%;
}
</style>
<style lang="scss" scoped>
.card-user-edit {
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
