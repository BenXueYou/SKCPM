<template>
	<el-row
		class="ChargeStationStatics"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>运营统计／充电站统计</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw" style="padding-bottom:5px">
				<div class="flex-sbw-div">
					<div class="flex-sbw">
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>充电站：</span>
							<el-select
								class="left-space time-interal"
								v-model="csId"
								clearable
								placeholder="充电站"
								size="small"
							>
								<el-option
									v-for="item in csOptions"
									:key="item.csId"
									:label="item.csName"
									:value="item.csId"
								></el-option>
							</el-select>
						</div>
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>运营商：</span>
							<!-- <el-input v-model="station" clearable></el-input> -->
							<el-select
								class="left-space time-interal"
								v-model="operator"
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
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
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
						<div class="dateBox">
							<span class="topTitleTxt">时间：</span>
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
			</div>
			<div class="topMenu" style="margin-bottom: 15px;">
				<!-- <el-button
					v-if="$store.state.home.AuthorizationID"
					type="primary"
					@click="exportBtnAct"
					style="margin:0 10px;"
				>批量导出</el-button> -->
				<el-button type="primary" @click="queryBtnAct" style="margin:0 10px;">查询</el-button>
			</div>
			<div class="tableBox">
				<el-table :data="tableData" stripe border style="width: 100%">
					<el-table-column type="selection" width="55"></el-table-column>
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="csName" label="充电站"></el-table-column>
					<el-table-column prop="operatorName" label="运营商"></el-table-column>
					<el-table-column prop="chargeCount" label="充电次数"></el-table-column>
					<el-table-column prop="chargeTimeSpan" label="充电时长"></el-table-column>
					<el-table-column prop="chargeQuantity" label="充电电量(kWh)"></el-table-column>
					<el-table-column prop="serviceTip" label="服务费(元)"></el-table-column>
					<el-table-column prop="chargeMoney" label="基础电费(元)"></el-table-column>
					<el-table-column prop="totalFee" label="总费(元)"></el-table-column>
					<el-table-column prop="jquantity" label="波时段充电电量(kWh)"></el-table-column>
					<el-table-column prop="jfee" label="波时段充电金额(元)"></el-table-column>
					<el-table-column prop="fquantity" label="峰时段充电电量(kWh)"></el-table-column>
					<el-table-column prop="ffee" label="峰时段充电金额(元)"></el-table-column>
					<el-table-column prop="pquantity" label="平时段充电电量(kWh)"></el-table-column>
					<el-table-column prop="pfee" label="平时段充电金额(元)"></el-table-column>
					<el-table-column prop="gquantity" label="谷时段充电电量(kWh)"></el-table-column>
					<el-table-column prop="gfee" label="谷时段充电金额(元)"></el-table-column>
				</el-table>
			</div>
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
		<!-- <app-user-add :isShow="isShowAddDialog" @onCancel="close()" ref="houseTable" /> -->
	</el-row>
</template>
<script>
// import appUserAdd from "@/components/appUserAdd";
export default {
  components: {
    // appUserAdd
  },
  mounted: function() {
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.csOptions = this.$store.state.home.chargeStationArr;
    this.beginTime = this.$common.getSpaceDate(-30) + " 00:00:00";
    this.endTime = this.$common.getCurrentTime();
    this.operator = this.operatorOptions[0].operatorId;
    this.chargeMethodId = this.chargeMethodOptions[0].typeStr;
    this.initData();
  },
  data: function() {
    return {
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      chargeMethodOptions: [
        // { typeStr: 0, typeName: "APP充电" },
        { typeStr: 1, typeName: "刷卡充电" },
        { typeStr: 0, typeName: "微信充电" }
        // { typeStr: 4, typeName: "全部充电" }
      ],
      pageSize: 10,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      csName: null,
      csId: null,
      csOptions: [],
      operator: null,
      chargeMethodId: null,
      mainScreenLoading: false,
      tableData: window.config.tableData
    };
  },
  methods: {
    initData() {
      let data = {
        model: {
          chargeMethodId: this.chargeMethodId,
          csId: this.csId,
          endTime: this.endTime,
          operatorId: this.operator,
          startTime: this.beginTime
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$staticsAjax
        .getChargeStation(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
          }
        })
        .catch(() => {});
    },
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    queryBtnAct() {
      this.initData();
    },
    addBtnAct() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    deleteBtnAct() {},
    exportBtnAct() {},
    handleClick(row) {
      console.log(row);
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
.ChargeStationStatics .flex-sbw-item {
	margin: 0 10px;
}
.ChargeStationStatics .dateBox {
	margin-left: 30px;
}
.ChargeStationStatics .flex-sbw-item .el-input,
.ChargeStationStatics .flex-sbw-item .el-input__inner {
	width: 150px;
	height: 32px;
}
.ChargeStationStatics .el-date-editor.el-input,
.ChargeStationStatics .el-date-editor.el-input__inner {
	width: 180px;
}
.ChargeStationStatics .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1512px) {
	.ChargeStationStatics .flex-sbw-item {
		margin-right: 5px !important;
	}
	.ChargeStationStatics .flex-sbw-item .el-input,
	.ChargeStationStatics .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.ChargeStationStatics .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
	.ChargeStationStatics .dateBox {
		margin-left: 30px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.ChargeStationStatics {
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
		.footer {
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
