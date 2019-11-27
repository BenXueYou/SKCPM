<template>
	<el-dialog
		:title="title"
		@close="close"
		:width="width"
		class="PileRealDataDetail"
		:visible.sync="dialogVisible"
	>
		<div class="body">
			<div class="body_box" style="border-top:0px;">
				<el-row type="flex" justify="flex-start" :gutter="20">
					<el-col style="text-align:right;" :span="5">
						<p>订单编号：</p>
					</el-col>
					<el-col style="text-align:right;" :span="17">
						<p style="text-align:left">{{rowData.transactionId}}</p>
					</el-col>
				</el-row>
				<el-row type="flex" justify="flex-start" :gutter="20">
					<el-col style="text-align:right;" :span="5">
						<p>服务费：</p>
						<p>基础电费：</p>
						<p>充电总金额：</p>
						<p>充电电量：</p>
						<p>充电前金额：</p>
						<p>充电后金额：</p>
						<p>充电时长：</p>
					</el-col>
					<el-col :span="6" style="text-align:left;">
						<p>{{rowData.serviceTip}}</p>
						<p>{{rowData.chargeMoney}}</p>
						<p>{{rowData.chargeMoney + rowData.serviceTip}}</p>
						<p>{{rowData.chargeQuantity}}</p>
						<p>{{rowData.beforeChargeBalance}}</p>
						<p>{{rowData.beforeChargeBalance - rowData.chargeMoney - rowData.serviceTip}}</p>
						<p>{{$common.formatSeconds(rowData.timeSpan)}}</p>
					</el-col>
					<el-col style="text-align:right;" :span="4">
						<p>充电模式：</p>
						<p>交易状态：</p>
						<p>停机原因：</p>
						<p>充电类型：</p>
						<p>开始时间：</p>
						<p>结束时间：</p>
						<p>电表总度数：</p>
					</el-col>
					<el-col :span="9" style="text-align:left;">
						<p>{{rowData.chargeModeId}}</p>
						<p>{{rowData.chargeFinishedFlag}}</p>
						<p>{{rowData.chargeEndCause || ''}}</p>
						<p>{{rowData.chargeMethodId || ''}}</p>
						<p>{{rowData.chargeStartTime || ''}}</p>
						<p>{{rowData.chargeEndTime || ''}}</p>
						<p>{{rowData.allQuantity || ''}}</p>
					</el-col>
				</el-row>
			</div>
			<hr style="border-top:1px dashed rgba(25,25,25,0.1); height:0px;margin-right:26px">
			<div class="body_box">
				<el-row type="flex" justify="flex-start" :gutter="20">
					<el-col style="text-align:right;" :span="5">
						<p>运营商：</p>
						<p>充电站：</p>
						<p>充电站编号：</p>
						<p>充电桩：</p>
						<p>充电桩编号：</p>
						<p>充电桩枪号：</p>
					</el-col>
					<el-col :span="6" style="text-align:left;">
						<p>{{rowData.operatorName}}</p>
						<p>{{rowData.csName}}</p>
						<p>{{rowData.csId}}</p>
						<p>{{rowData.cpId}}</p>
						<p>{{rowData.deviceId}}</p>
						<p>{{rowData.interfaceId}}</p>
					</el-col>
					<el-col style="text-align:right;" :span="4">
						<p>用户(卡)ID：</p>
						<p>手机号：</p>
						<p>证件号：</p>
						<p>车牌号：</p>
						<p>VIN号：</p>
						<p>大占比段：</p>
					</el-col>
					<el-col :span="9" style="text-align:left;">
						<p>{{rowData.userId}}</p>
						<p>{{rowData.cellphone || ''}}</p>
						<p>{{rowData.nativePlace || ''}}</p>
						<p>{{rowData.address || ''}}</p>
						<p>{{rowData.remarks || ''}}</p>
						<p>{{rowData.remarks || ''}}</p>
					</el-col>
				</el-row>
			</div>
		</div>
		<div slot="footer" class="dialogHeaderClass">
			<el-row type="flex" justify="space-between">
				<el-col style="text-align:left" :span="4"></el-col>
				<el-col class="header_right_box" :span="20">
					<!-- <el-button @click="confirm" type="primary">保存并新增</el-button>
					<el-button @click="confirm" type="primary">确认</el-button>-->
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
        return "720px";
      }
    },
    title: {
      type: String,
      default() {
        return "记录详情";
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
      countryOptions: window.config.options,
      countryOption: "",
      maritalOptions: window.config.options,
      maritalOption: "",
      nationOption: "",
      nationOptions: window.config.options,
      educationOptions: window.config.options,
      educationOption: "",
      checkedNodeName: "",
      inputWidth: "30%",
      visible_popver: false,
      checkeTreedNodes: [],
      dynamicTags: [],
      myHeaders: {},
      updateFileImage: "",
      dialogVisible: false,
      radioGender: "男",
      phoneNumber: "",
      name: "",
      radioDate: "",
      startTime: "",
      endTime: "",
      ResidentPopoverClass: "ResidentPopoverClass",
      treeData: window.config.treeData,
      defaultProps: {
        label: "label",
        children: "children"
      },
      filterText: "",
      certificateOptions: window.config.options,
      certificateOption: ""
    };
  },
  mounted() {
    this.dialogVisible = this.visible;
    this.name = this.value;
    this.checkeTreedNodes = this.dynamicTags;
  },
  methods: {
    filterNode(value, data) {
      if (!value) return true;
      return data.label.indexOf(value) !== -1;
    },
    clearAction() {},
    transferCheckedNodes() {},
    handleClose(arr) {
      this.dynamicTags = arr;
      this.checkeTreedNodes = this.dynamicTags;
    },
    httpRequest() {},
    close() {
      this.$emit("update:visible", false);
      this.$emit("close");
    },
    confirm() {},
    nodeClick(data, node, nodeTree) {
      var checkedKeys = this.$refs.roomTree.getCheckedKeys();
      if (checkedKeys.indexOf(data.id) !== -1) {
        checkedKeys.splice(checkedKeys.indexOf(data.id), 1);
      } else {
        checkedKeys.push(data.id);
      }
      this.$refs.roomTree.setCheckedKeys(checkedKeys);
    }
  },
  watch: {
    visible(val) {
      if (val) {
        this.name = this.value;
      }
      this.dialogVisible = this.visible;
      this.dynamicTags = [];
    },
    rowData: {
      handler(val, oldVal) {
        if (val.tagInofShows && val.tagInofShows.length) {
          val.tagInofShows.forEach(item => {
            item.id = item.tagUuid;
            item.label = item.tagName;
            this.dynamicTags.push(item);
          });
        }
      },
      deep: true,
      immediate: true
    }
  }
};
</script>
<style>
.PileRealDataDetail .el-dialog {
	position: relative;
	top: 60px;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	transform: translate(-50%, 0%);
	margin: 0px !important;
	/* background: #212325; */
}
.PileRealDataDetail .el-dialog__body {
	padding: 0px 0px 10px 20px;
	color: #606266;
	font-size: 14px;
	word-break: break-all;
}
.PileRealDataDetail .el-input__icon {
	line-height: 30px;
	color: #26d39d;
}
.PileRealDataDetail .el-dialog__headerbtn {
	top: 18px;
	display: none;
}
.PileRealDataDetail .el-dialog__header {
	height: auto;
}
.dialogHeaderClass {
	width: 100%;
	padding: 5px 40px 14px;
	box-sizing: border-box;
}
.PileRealDataDetail .dialogHeaderClass .header_left_txt {
	border-left: 2px solid #26d39d;
	font-family: 'PingFangSC-Regular';
	font-size: 14px;
	color: #ffffff;
	padding-left: 10px;
}
.PileRealDataDetail .pBox {
	display: flex;
	justify-content: flex-start;
	margin: 7px 0 8px;
}
.PileRealDataDetail .pBox div {
	width: 50%;
	text-align: left;
}
.PileRealDataDetail .header_right_box {
	text-align: right;
	margin-top: -10px;
}
.PileRealDataDetail .header_right_box button {
	height: 32px;
	font-family: 'PingFangSC-Regular';
	font-size: 13px;
	color: #ffffff;
	text-align: justify;
	padding: 7px 17px;
}

.PileRealDataDetail .imgBox {
	display: inline-block;
	width: 100%;
	height: 100px;
	background: rgba(0, 0, 0, 0.1);
	border: 0 solid rgba(255, 255, 255, 0.1);
}
.PileRealDataDetail .imgBox img {
	width: 100%;
	height: 100%;
}
.PileRealDataDetail .left_tips_txt {
	font-family: 'PingFangSC-Regular';
	font-size: 13px;
	color: #26d39d;
}
.PileRealDataDetail .el-upload {
	display: inline-block;
	text-align: center;
	width: 100%;
	line-height: 130px;
	cursor: pointer;
	outline: none;
}
.PileRealDataDetail .authBox {
	display: flex;
	justify-content: flex-start;
	flex-direction: row;
	flex-wrap: wrap;
}
.PileRealDataDetail .el-select {
	display: inline-block;
	position: relative;
	width: 30%;
}
.PileRealDataDetail .el-select .el-input {
	width: 100%;
}
.PileRealDataDetail .el-select .el-select-dropdown__list {
	width: 100%;
}
.PileRealDataDetail .el-input {
	display: inline-block;
	width: 30%;
	height: 30px;
}
.PileRealDataDetail .el-input .el-input__inner {
	height: 30px;
	padding-right: 15px;
}
.PileRealDataDetail .body_box {
	padding: 15px 0px 20px;
	color: #bbbbbb;
}
.el-dialog__wrapper {
	overflow: auto;
}
.PileRealDataDetail .time-line {
	display: inline-block;
	border-width: 1px 0px 0px 0px;
	width: 8px;
	border-color: #7a7b7c;
	border-style: solid;
	margin: 0px 3px;
}
.PileRealDataDetail .img {
	vertical-align: baseline;
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
			margin: 7px 0 8px;
			height: 16px;
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
