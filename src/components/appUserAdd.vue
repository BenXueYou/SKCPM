<template>
	<el-dialog
		width="520px"
		:title="isAdd?`修改用户信息`:`修改用户信息`"
		class="dialog-user-edit"
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
						<el-form-item label="用户名：" prop="chargePriceModel">
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
						<el-form-item label="电话：" prop="chargePriceModel">
							<el-input
								class="time-interal"
								style="width:96%;box-sizing: border-box;"
								v-model="formLabelAlign.phoneNumber"
								size="small"
								clearable
							></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="地址：" prop="chargePriceModel">
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
						<el-form-item label="邮箱：" prop="chargePriceModel">
							<el-input
								class="time-interal"
								style="width:96%;box-sizing: border-box;"
								v-model="formLabelAlign.email"
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
    isShow: {
      type: Boolean,
      default: false
    },
    initTreeRootData: {
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
        phoneNumber: null,
        address: null,
        email: null
      },
      rules: {
        userName: [
          { required: true, message: "用户名不能为空", trigger: "change" }
        ],
        phoneNumber: [
          { required: true, message: "电话不能为空", trigger: "change" }
        ]
      }
    };
  },
  created() {},
  mounted() {},
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
    }
  },
  watch: {
    isShow(val) {
      this.isCurrentShow = val;
    }
  },
  destroyed() {}
};
</script>
<style>
.dialog-user-edit .el-dialog__header {
	border-bottom: 1px solid #eeeeee;
}
.dialog-user-edit .el-dialog--center .el-dialog__body {
	text-align: initial;
	padding: 25px 35px 5px 5px;
}
.dialog-user-edit .timePickerClass {
	width: 100%;
	height: 32px;
	line-height: 32px;
}
.dialog-user-edit .el-input .el-input__inner {
	width: 100%;
}
.dialog-user-edit .timePickerClass .el-input__icon,
.dialog-user-edit .timePickerClass .el-input__inner {
	height: 32px;
	line-height: 32px;
	width: 100%;
}
</style>
<style lang="scss" scoped>
.dialog-user-edit {
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
