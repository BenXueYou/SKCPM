<template>
	<el-row
		class="FaultAlarmRecord"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>设备监控／告警记录</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:10px">
				<div class="flex-st">
					<div class="flex-sbw-div">
						<span class="topTitleTxt">确认状态：</span>
						<el-select
							class="left-space time-interal"
							v-model="operator"
							clearable
							placeholder="确认状态"
							size="small"
						>
							<el-option
								v-for="item in checkedOptions"
								:key="item.typeStr"
								:label="item.typeName"
								:value="item.typeStr"
							></el-option>
						</el-select>
					</div>
					<div class="flex-sbw-div dateBox">
						<span class="topTitleTxt">起始时间：</span>
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
					<el-button type="primary" @click="queryBtnAct" style="margin:-5px 10px 0">查询</el-button>
				</div>
			</div>
			<div class="tableBox">
				<el-table :data="tableData" stripe border  style="width: 100%">
					<el-table-column type="selection" width="55"></el-table-column>
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="cpId" label="充电桩" width="180"></el-table-column>
					<el-table-column prop="gun" label="枪号" width="60"></el-table-column>
					<el-table-column prop="cardNum" label="APP/卡号" width="180"></el-table-column>
					<el-table-column prop="gmtModify" label="记录时间" width="180"></el-table-column>
					<el-table-column prop="chargeType" label="充电方式" width="100"></el-table-column>
					<el-table-column prop="alarmType" label="告警描述" width="300"></el-table-column>
					<el-table-column prop="checkState" label="确认状态" width="120">
						<template slot-scope="scope">{{scope.row.checkState===0?'未确认':'已确认'}}</template>
					</el-table-column>
					<el-table-column prop="checkMode" label="确认模式" width="180">
						<template slot-scope="scope">{{scope.row.checkMode===0?'自动':'手动'}}</template>
					</el-table-column>
					<el-table-column label="操作">
						<template slot-scope="scope">
							<el-button
								v-if="!scope.row.checkState"
								@click="handleClick(scope.row)"
								type="text"
								size="small"
							>确认</el-button>
							<el-button v-else type="text" size="small">已确认</el-button>
						</template>
					</el-table-column>
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
		<charge-record-detail :visible.sync="isShowAddDialog" @onCancel="close()" ref="houseTable" />
	</el-row>
</template>
<script>
import ChargeRecordDetail from "@/components/ChargeRecordDetail";
export default {
  components: {
    ChargeRecordDetail
  },
  mounted: function() {
    this.beginTime = this.$common.getSpaceDate(-30) + " 00:00:00";
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
      checkedOptions: [
        { typeStr: 0, typeName: "未确认" },
        { typeStr: 1, typeName: "已确认" },
        { typeStr: null, typeName: "全部" }
      ],
      station: null,
      stationOptions: [],
      operator: null,
      mainScreenLoading: false,
      tableData: window.config.tableData
    };
  },
  methods: {
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    initData() {
      var data = {
        model: {
          endTime: this.endTime,
          startTime: this.beginTime
        },
        pageIndex: this.pageSize,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$realAjax
        .realAlarmData(data)
        .then(res => {
          if (res.data.success) {
            console.log(res.data.model);
            this.tableData = res.data.model;
          }
        })
        .catch(() => {});
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
.FaultAlarmRecord .flex-sbw-item .el-input,
.FaultAlarmRecord .flex-sbw-item .el-input__inner {
	width: 160px;
	height: 32px;
}
.FaultAlarmRecord .el-date-editor.el-input,
.FaultAlarmRecord .el-date-editor.el-input__inner {
	width: 190px;
}
.FaultAlarmRecord .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1540px) {
	.FaultAlarmRecord .flex-sbw-item {
		margin-right: 5px !important;
	}
	.FaultAlarmRecord .flex-sbw-item .el-input,
	.FaultAlarmRecord .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.FaultAlarmRecord .el-date-editor.el-input,
	.FaultAlarmRecord .el-date-editor.el-input__inner {
		width: 180px;
	}
	.FaultAlarmRecord .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.FaultAlarmRecord {
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
				margin: 0 5% 0 10px;
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
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
