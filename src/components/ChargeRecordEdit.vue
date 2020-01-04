<template>
	<el-dialog
		:title="title"
		@close="close"
		:width="width"
		class="ChargeRecordEdit"
		:visible.sync="dialogVisible"
	>
		<div class="body">
			<div class="body_box" style="border-top:0px;">
				<el-row type="flex" justify="flex-start" :gutter="20">
					<el-col style="text-align:right;" :span="6">
						<p style="margin:7px 0">订单编号：</p>
					</el-col>
					<el-col style="text-align:right;" :span="18">
						<p style="text-align:left;margin:7px 0">{{formLabelAlign.transactionId}}</p>
					</el-col>
				</el-row>
				<el-row type="flex" justify="flex-start" :gutter="20">
					<el-col style="text-align:right;" :span="6">
						<p class="leftPClass">服务费：</p>
						<p class="leftPClass">基础电费：</p>
						<p class="leftPClass">充电电量：</p>
						<p class="leftPClass">充电时长：</p>
						<p class="leftPClass">充电前金额：</p>
						<p class="leftPClass">充电总金额：</p>
						<p class="leftPClass">充电后金额：</p>
					</el-col>
					<el-col :span="10" class="rightClass">
						<p>
							<el-input v-model="formLabelAlign.serviceTip" clearable></el-input>
						</p>
						<p>
							<el-input v-model="formLabelAlign.chargeMoney" clearable></el-input>
						</p>
						<p>
							<el-input v-model="formLabelAlign.chargeQuantity" clearable></el-input>
						</p>
						<p>
							<el-input v-model="formLabelAlign.timeSpan" clearable></el-input>
						</p>
						<p>
							<el-input v-model="formLabelAlign.beforeChargeBalance" clearable></el-input>
						</p>
						<!-- <p><el-input v-model="formLabelAlign.serviceTip" clearable></el-input></p> -->
						<p>{{Number(formLabelAlign.chargeMoney) + Number(formLabelAlign.serviceTip)}}</p>
						<p>{{Number(formLabelAlign.beforeChargeBalance) - Number(formLabelAlign.chargeMoney) - Number(formLabelAlign.serviceTip)}}</p>
						<!-- <p>{{$common.formatSeconds(formLabelAlign.timeSpan)}}</p> -->
					</el-col>
				</el-row>
			</div>
			<hr style="border-top:1px dashed rgba(25,25,25,0.1); height:0px;margin-right:26px" />
			<div class="body_box">
				<el-row type="flex" justify="flex-start" :gutter="20">
					<el-col style="text-align:right;" :span="6">
						<p>充电模式：</p>
						<p>交易状态：</p>
						<p>停机原因：</p>
						<p>充电类型：</p>
						<p>开始时间：</p>
						<p>结束时间：</p>
						<p>电表总度数：</p>
					</el-col>
					<el-col :span="12" style="text-align:left">
						<p>{{formLabelAlign.chargeModeId}}</p>
						<p>{{formLabelAlign.chargeFinishedFlag}}</p>
						<p>{{formLabelAlign.chargeEndCause || ''}}</p>
						<p>{{formLabelAlign.chargeMethodId || ''}}</p>
						<p>{{formLabelAlign.chargeStartTime || ''}}</p>
						<p>{{formLabelAlign.chargeEndTime || ''}}</p>
						<p>{{formLabelAlign.allQuantity || ''}}</p>
					</el-col>
				</el-row>
			</div>
		</div>
		<div slot="footer" class="dialogHeaderClass">
			<el-row type="flex" justify="space-between">
				<el-col style="text-align:left" :span="4"></el-col>
				<el-col class="header_right_box" :span="20">
					<!-- <el-button @click="confirm" type="primary">保存并新增</el-button>-->
					<el-button @click="confirm" type="primary">确认</el-button>
					<el-button @click="close" type="primary">关闭</el-button>
				</el-col>
			</el-row>
		</div>
	</el-dialog>
</template>
<script>
export default {
  props: {
    width: {
      type: String,
      default() {
        return "600px";
      }
    },
    title: {
      type: String,
      default() {
        return "编辑记录";
      }
    },
    value: {
      type: String,
      default() {
        return "";
      }
    },
    visible: {
      type: Boolean,
      default() {
        return false;
      }
    },
    center: {
      type: Boolean,
      default() {
        return true;
      }
    },
    rowData: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  data() {
    return {
      dialogVisible: false,
      formLabelAlign: {}
    };
  },
  mounted() {
    this.dialogVisible = this.visible;
  },
  methods: {
    clearAction() {},
    transferCheckedNodes() {},
    handleClose(arr) {},
    httpRequest() {},
    close() {
      this.$emit("update:visible", false);
      this.$emit("close");
    },
    confirm() {
      this.$businessAjax
        .updateChargeRecord(this.formLabelAlign)
        .then(res => {
          if (res.data.success) {
            this.$message.success("修改成功");
            this.$emit("onCancel", true);
          } else {
            this.$message.warning("修改失败");
          }
        })
        .catch(() => {
          //   this.$message.error();
        });
    },
    nodeClick(data, node, nodeTree) {}
  },
  watch: {
    visible(val) {
      if (val) {
        this.name = this.value;
        this.formLabelAlign = JSON.parse(JSON.stringify(this.rowData));
      }
      this.dialogVisible = this.visible;
    },
    rowData: {
      handler(val, oldVal) {},
      deep: true,
      immediate: true
    }
  }
};
</script>
<style>
.ChargeRecordEdit .el-dialog {
	position: relative;
	top: 60px;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	transform: translate(-50%, 0%);
	margin: 0px !important;
	/* background: #212325; */
}
.ChargeRecordEdit .el-dialog__body {
	padding: 0px 0px 10px 20px;
	color: #606266;
	font-size: 14px;
	word-break: break-all;
}
.ChargeRecordEdit .el-input__icon {
	line-height: 30px;
	color: #26d39d;
}
.ChargeRecordEdit .el-dialog__headerbtn {
	top: 18px;
	display: none;
}
.ChargeRecordEdit .el-dialog__header {
	height: auto;
}
.dialogHeaderClass {
	width: 100%;
	padding: 5px 40px 14px;
	box-sizing: border-box;
}
.ChargeRecordEdit .dialogHeaderClass .header_left_txt {
	border-left: 2px solid #26d39d;
	font-family: "PingFangSC-Regular";
	font-size: 14px;
	color: #ffffff;
	padding-left: 10px;
}
.ChargeRecordEdit .pBox {
	display: flex;
	justify-content: flex-start;
	margin: 7px 0 8px;
}
.ChargeRecordEdit .pBox div {
	width: 50%;
	text-align: left;
}
.ChargeRecordEdit .header_right_box {
	text-align: right;
	margin-top: -10px;
}
.ChargeRecordEdit .header_right_box button {
	height: 32px;
	font-family: "PingFangSC-Regular";
	font-size: 13px;
	color: #ffffff;
	text-align: justify;
	padding: 7px 17px;
}

.ChargeRecordEdit .imgBox {
	display: inline-block;
	width: 100%;
	height: 100px;
	background: rgba(0, 0, 0, 0.1);
	border: 0 solid rgba(255, 255, 255, 0.1);
}
.ChargeRecordEdit .imgBox img {
	width: 100%;
	height: 100%;
}
.ChargeRecordEdit .left_tips_txt {
	font-family: "PingFangSC-Regular";
	font-size: 13px;
	color: #26d39d;
}
.ChargeRecordEdit .el-upload {
	display: inline-block;
	text-align: center;
	width: 100%;
	line-height: 130px;
	cursor: pointer;
	outline: none;
}
.ChargeRecordEdit .authBox {
	display: flex;
	justify-content: flex-start;
	flex-direction: row;
	flex-wrap: wrap;
}
.ChargeRecordEdit .el-select {
	display: inline-block;
	position: relative;
	width: 30%;
}

.ChargeRecordEdit .rightClass .el-input {
	width: 100%;
}
.ChargeRecordEdit .el-select .el-input {
	width: 100%;
}
.ChargeRecordEdit .el-select .el-select-dropdown__list {
	width: 100%;
}
.ChargeRecordEdit .el-input {
	display: inline-block;
	width: 30%;
	height: 30px;
}
.ChargeRecordEdit .el-input .el-input__inner {
	height: 30px;
	padding-right: 15px;
}
.ChargeRecordEdit .body_box {
	color: #bbbbbb;
}
.el-dialog__wrapper {
	overflow: auto;
}
.ChargeRecordEdit .time-line {
	display: inline-block;
	border-width: 1px 0px 0px 0px;
	width: 8px;
	border-color: #7a7b7c;
	border-style: solid;
	margin: 0px 3px;
}
.ChargeRecordEdit .img {
	vertical-align: baseline;
}
.ChargeRecordEdit .leftPClass {
	margin: 25px 0;
}
</style>

<style lang="scss" scoped>
@import "@/style/variables.scss";

@mixin padding {
	padding: 10px 6px 0px 26px;
	box-sizing: border-box;
}
.body {
	max-height: 600px;
	@include padding;
	.title {
		height: 40px;
		line-height: 30px;
		@include font-s;
	}
	.body_box {
		p {
			font-family: "PingFangSC-Regular";
			font-size: 12px;
			color: #606266;
			height: 16px;
		}
		.rightClass {
			text-align: left;
			p {
				margin: 25px 0;
			}
		}
	}
}
.footer {
	@include padding;
	overflow: hidden;
	button {
		height: 30px;
		padding: 7px 21px;
		background: rgba(40, 255, 187, 0.12);
		border: 1px solid rgba(40, 255, 187, 0.8);
		border-radius: 2px;
		border-radius: 2px;
		font-family: "PingFangSC-Regular";
		font-size: 12px;
		color: #ffffff;
		letter-spacing: 0;
	}
}
</style>
