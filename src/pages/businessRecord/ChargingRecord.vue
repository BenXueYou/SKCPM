<template>
	<el-row
		class="ChargeRecord"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>运营管理／扣费记录</span>
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
							:key="item.typeStr"
							:label="item.typeName"
							:value="item.typeStr"
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
				<el-table-column prop="transactionId" label="订单编号" width="300"></el-table-column>
				<el-table-column prop="cpId" label="充电桩序列号" width="180"></el-table-column>
				<el-table-column prop="interfaceId" label="枪号" width="60"></el-table-column>
				<el-table-column prop="csName" label="充电站" width="150"></el-table-column>
				<el-table-column prop="operatorName" label="运营商" width="120"></el-table-column>
				<el-table-column prop="chargeMethodId" label="充电类型" width="100"></el-table-column>
				<el-table-column prop="chargeModeId" label="充电模式" width="100"></el-table-column>
				<el-table-column prop="chargeStartTime" label="充电开始时间" width="180"></el-table-column>
				<el-table-column prop="chargeEndTime" label="充电结束时间" width="180"></el-table-column>
				<el-table-column prop="chargeFinishedFlag" label="交易状态" width="100"></el-table-column>
				<el-table-column prop="userId" label="用户ID" width="160"></el-table-column>
				<el-table-column prop="timeSpan" label="充电时长" width="180">
					<template slot-scope="scope">{{$common.formatSeconds(scope.row.timeSpan)}}</template>
				</el-table-column>
				<el-table-column prop="chargeQuantity" label="充电电量" width="120"></el-table-column>
				<el-table-column prop="chargeMoney" label="应扣金额" width="100"></el-table-column>
				<el-table-column prop="beforeChargeBalance" label="充电前金额" width="100"></el-table-column>
				<el-table-column prop="zip" label="充电后金额" width="100">
					<template
						slot-scope="scope"
					>{{scope.row.beforeChargeBalance - scope.row.chargeMoney - scope.row.serviceTip}}</template>
				</el-table-column>
				<el-table-column prop="chargeMoney" label="实扣金额" width="100"></el-table-column>
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
    this.beginTime = this.$common.getStartTime();
    this.endTime = this.$common.getCurrentTime();
    this.initData();
  },
  data: function() {
    return {
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 15,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      userName: null,
      cpId: null,
      phoneNumber: null,
      chargeWayOptions: [],
      mainScreenLoading: false,
      tableData: window.config.tableData,
      operatorId: null,
      chargeWay: null,
      rowData: null,
      chargeMethodOptions: [
        { typeStr: 0, typeName: "APP充电" },
        { typeStr: 2, typeName: "刷卡充电" },
        { typeStr: 3, typeName: "微信充电" },
        { typeStr: 4, typeName: "全部充电" }
      ],
      chargeMethodId: null
    };
  },
  methods: {
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
          chargeStartTime: this.beginTime,
          chargeMothodId: this.chargeWay,
          chargeEndTime: this.endTime,
          deviceId: this.cpId,
          operatorId: this.operatorId,
          telephone: this.phoneNumber,
          userName: this.userName
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$businessAjax
        .deductRecordList(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
          } else {
            this.$message.warning("数据查询失败");
          }
        })
        .catch(err => {
          console.log(err);
        });
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
