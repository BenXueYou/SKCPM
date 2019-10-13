<template>
	<el-row
		class="ChargeRecord"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>运营管理／充电记录</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:10px">
				<div class="flex-sbw">
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>用户名：</span>
						<el-input v-model="userName"></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>充电桩ID：</span>
						<el-input v-model="cpId"></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>手机号：</span>
						<el-input v-model="phoneNumber"></el-input>
					</div>
					<div class="dateBox">
						<span class="topTitleTxt">充电时间：</span>
						<el-date-picker
							v-model="beginTime"
							type="datetime"
							class="time-interal-date"
							size="small"
							placeholder="选择日期"
							value-format="yyyy-MM-dd HH:mm:ss"
						></el-date-picker>
						<span class="time-line">—</span>
						<el-date-picker
							v-model="endTime"
							type="datetime"
							class="time-interal-date"
							placeholder="选择日期"
							size="small"
							value-format="yyyy-MM-dd HH:mm:ss"
						></el-date-picker>
					</div>
				</div>
			</div>
			<div class="topMenu flex-st" style="margin-bottom: 15px;">
				<div class="flex-sbw-div">
					<span class="topTitleTxt">运营商：</span>
					<el-select
						class="left-space time-interal"
						v-model="operatorId"
						clearable
						placeholder="运营商"
						size="small"
					>
						<el-option
							v-for="item in operatorOptions"
							:key="item.operatorId"
							:label="item.operatorName"
							:value="item.operatorId"
						></el-option>
					</el-select>
				</div>
				<div class="flex-sbw-div">
					<span class="topTitleTxt">充电方式：</span>
					<el-select
						class="left-space time-interal"
						v-model="chargeMethodId"
						clearable
						placeholder="充电方式"
						size="small"
					>
						<el-option
							v-for="item in chargeMethodOptions"
							:key="item.typeStr"
							:label="item.typeName"
							:value="item.typeStr"
						></el-option>
					</el-select>
				</div>
			</div>
			<div class="topMenu flex-st" style="margin-bottom: 5px;">
				<el-button type="primary" @click="deleteBtnAct" style="margin:-5px 10px 0">批量导出</el-button>
				<el-button type="primary" @click="queryBtnAct" style="margin:-5px 10px 0">查询</el-button>
			</div>
			<el-table :data="tableData" stripe border style="width: 100%">
				<el-table-column type="selection" width="55"></el-table-column>
				<el-table-column type="index" width="55" label="序号"></el-table-column>
				<el-table-column prop="operatorName" label="运营商" width="120"></el-table-column>
				<el-table-column prop="csName" label="充电站" width="150"></el-table-column>
				<el-table-column prop="cpId" label="充电桩序列号" width="180"></el-table-column>
				<el-table-column prop="interfaceId" label="枪号" width="60"></el-table-column>
				<el-table-column prop="chargeMethodId" label="充电类型" width="100"></el-table-column>
				<el-table-column prop="chargeModeId" label="充电模式" width="100"></el-table-column>
				<el-table-column prop="chargeStartTime" label="充电开始时间" width="180"></el-table-column>
				<el-table-column prop="chargeEndTime" label="充电结束时间" width="180"></el-table-column>
				<el-table-column prop="chargeFinishedFlag" label="交易状态" width="100"></el-table-column>
				<el-table-column prop="transactionId" label="订单编号" width="300"></el-table-column>
				<el-table-column prop="userId" label="用户ID" width="160"></el-table-column>
				<el-table-column prop="timeSpan" label="充电时长" width="180">
					<template slot-scope="scope">
						{{$common.formatSeconds(scope.row.timeSpan)}}
					</template>
				</el-table-column>
				<el-table-column prop="chargeQuantity" label="充电电量" width="120"></el-table-column>
				<el-table-column prop="chargeMoney" label="充电总金额" width="100"></el-table-column>
				<el-table-column label="操作">
					<template slot-scope="scope">
						<el-button @click="handleClick(scope.row)" type="text" size="small">详情</el-button>
					</template>
				</el-table-column>
			</el-table>
			<div class="footer">
				<el-pagination
					@size-change="handleSizeChange"
					@current-change="handleCurrentChange"
					:current-page="currentPage"
					:page-sizes="pageSizeArr"
					:page-size="pageSize"
					layout="total, sizes, prev, pager, next, jumper"
					:total="total"
				></el-pagination>
			</div>
		</div>
		<charge-record-detail
			:visible.sync="isShowAddDialog"
			:rowData="rowData"
			@onCancel="close"
			ref="houseTable"
		/>
	</el-row>
</template>
<script>
import ChargeRecordDetail from "@/components/ChargeRecordDetail";
export default {
  components: {
    ChargeRecordDetail
  },
  mounted: function() {
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.stationOptions = this.$store.state.home.chargeStationArr;
    this.beginTime = this.$common.getStartTime();
    this.endTime = this.$common.getCurrentTime();
    this.initData();
  },
  data: function() {
    return {
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 10,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      chargeMethodOptions: [
        // { typeStr: 0, typeName: "APP充电" },
        { typeStr: 1, typeName: "刷卡充电" },
        { typeStr: 3, typeName: "微信充电" },
        // { typeStr: 4, typeName: "全部充电" }
      ],
      station: null,
      stationOptions: [],
      operatorId: null,
      mainScreenLoading: false,
      tableData: window.config.tableData,
      cpId: null,
      userName: null,
      phoneNumber: null,
      chargeMethodId: null,
      rowData: {}
    };
  },
  methods: {
    /**
	   *   {
      "cellStyleMap": {},
      "cpId": "1401070000000045",
      "deviceId": "1401070000000045",
      "interfaceId": 2,
      "transactionId": "14010700000000451915252115240000",
      "cardNum": "0000000000000000",
      "userId": "8881556682148237",
      "chargeQuantity": 38.84,
      "csName": "",
      "csId": 0,
      "operatorId": 34,
      "operatorName": "",
      "beforeChargeBalance": 50,
      "chargeMoney": 34.1792,
      "serviceTip": 0,
      "chargeStartTime": "2019-06-25 21:15:24",
      "chargeEndTime": "2019-06-25 22:22:17",
      "chargeFinishedFlag": 2,
      "chargeEndCause": "充满",
      "billModelId": 206,
      "jTime": 0,
      "fTime": 4012,
      "pTime": 0,
      "gTime": 0,
      "jQuantity": 0,
      "fQuantity": 38.84,
      "pQuantity": 0,
      "gQuantity": 0,
      "jFee": 0,
      "fFee": 34.1792,
      "pFee": 0,
      "gFee": 0,
      "chargeMethodId": 3,
      "chargeModeId": 4,
      "chargePara": 0,
      "allQuantity": 61473.6,
      "gmtCreate": "2019-07-05 23:10:02",
      "gmtModify": "2019-08-22 20:40:26",
      "isDeleted": 0,
      "jtime": 0,
      "ftime": 4012,
      "ptime": 0,
      "gtime": 0,
      "jquantity": 0,
      "fquantity": 38.84,
      "pquantity": 0,
      "gquantity": 0,
      "jfee": 0,
      "ffee": 34.1792,
      "pfee": 0,
      "gfee": 0
    }
	   */
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    queryBtnAct() {
      this.initData();
    },
    addBtnAct() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    initData() {
      var data = {
        model: {
          chargeEndTime: this.endTime,
          chargeMethodId: null,
          chargeStartTime: this.beginTime,
          deviceId: this.cpId,
          operatorId: this.operatorId,
          telephone: this.phoneNumber,
          userName: this.userName
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true
      };
      this.getTotal(data);
      this.$businessAjax
        .getChargeRecordList(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
          } else {
            this.$message.warning(res.data.errorMessage);
          }
        })
        .catch(() => {});
    },
    getTotal(data) {
      this.$businessAjax
        .getChargeRecordTotal(data)
        .then(res => {
          if (res.data.success) {
            this.total = res.data.model;
          } else {
            this.$message.warning(res.data.errorMessage);
          }
        })
        .catch(() => {});
    },
    deleteBtnAct() {},
    exportBtnAct() {},
    handleClick(row) {
      console.log(row);
      this.rowData = row;
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    handleCurrentChange(val) {
      console.log("页数发生变化：", val);
      this.currentPage = val;
      this.initData();
    },
    handleSizeChange(val) {
      console.log("每页条数发生变化：", val);
      this.pageSize = val;
      this.initData();
    }
  },
  watch: {}
};
</script>
<style>
.ChargeRecord .flex-sbw-item .el-input,
.ChargeRecord .flex-sbw-item .el-input__inner {
	width: 160px;
	height: 32px;
}
.ChargeRecord .el-date-editor.el-input,
.ChargeRecord .el-date-editor.el-input__inner {
	width: 190px;
}
.ChargeRecord .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1540px) {
	.ChargeRecord .flex-sbw-item {
		margin-right: 5px !important;
	}
	.ChargeRecord .flex-sbw-item .el-input,
	.ChargeRecord .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.ChargeRecord .el-date-editor.el-input,
	.ChargeRecord .el-date-editor.el-input__inner {
		width: 180px;
	}
	.ChargeRecord .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.ChargeRecord {
	text-align: center;
	height: 100%;
	.titleBox {
		text-align: left;
		color: $--color-title-txt;
		padding: 3px 15px 13px;
	}
	.bodyBox {
		background-color: #ffffff;
		padding: 25px 32px;
		border-radius: 5px;
		.topMenu {
			text-align: left;
			.topTitleTxt {
				color: #999999;
			}
		}
		.flex-sbw {
			display: flex;
			justify-content: space-between;
			padding-bottom: 15px;
			.el-button {
				color: #ffffff;
				background-color: #5b9cf8;
				border-color: #5b9cf8;
			}
		}
		.flex-st {
			display: flex;
			justify-content: flex-start;
			padding-bottom: 15px;
			.flex-sbw-div {
				margin: 0 10px;
			}
			.el-button {
				color: #ffffff;
				background-color: #5b9cf8;
				border-color: #5b9cf8;
				// height: 32px;
				// line-height: 32px;
			}
		}
		.footer {
			margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
