<template>
	<el-row
		class="ChargeReport"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>运营管理／充电报表</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:10px;">
				<div class="flex-sbw" style="margin-bottom:15px;">
					<div class="flex-sbw-div">
						<span class="topTitleTxt">统计报表类型：</span>
						<el-select
							class="left-space time-interal"
							v-model="type"
							clearable
							placeholder="请选择报表类型"
							@change="initData"
							size="small"
						>
							<el-option
								v-for="item in typeOptions"
								:key="item.typeStr"
								:label="item.typeName"
								:value="item.typeStr"
							></el-option>
						</el-select>
					</div>

					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>运营商：</span>
						<el-select
							class="left-space time-interal"
							v-model="operatorId"
							clearable
							placeholder="请选择运营商"
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
						<span class="topTitleTxt">充电站：</span>
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
						<span>充电方式：</span>
						<el-select
							class="left-space time-interal"
							v-model="chargeWay"
							clearable
							placeholder="充电方式 "
							size="small"
						>
							<el-option
								v-for="item in chargeWayOptions"
								:key="item.typeStr"
								:label="item.typeName"
								:value="item.typeStr"
							></el-option>
						</el-select>
					</div>
				</div>
				<div class="topMenu flex-st">
					<div style="margin-right: 50px;" class="flex-sbw-div">
            <span class="topTitleTxt">记录类型：</span>
            <el-select
              class="left-space time-interal"
              v-model="recordType"
              placeholder="记录类型"
              size="small"
            >
              <el-option
                v-for="item in recordTypeOptions"
                :key="item.typeStr"
                :label="item.typeName"
                :value="item.typeStr"
              ></el-option>
            </el-select>
          </div>
					<div class="dateBox">
						<span class="topTitleTxt">查询时间：</span>
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
					<el-button type="primary" @click="queryBtnAct" style="margin:-5px 30px 0">查询</el-button>
				</div>
			</div>
			<div class="tableBox">
				<el-table
					:data="tableData"
					show-summary
					:summary-method="summaryMethod"
					stripe
					border
					style="width: 100%"
				>
					<el-table-column type="selection" width="55"></el-table-column>
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="recordType" label="记录类型" width="100">
						<template slot-scope="scope">{{scope.row.recordType ===1?'快电':'尚宽'}}</template>
					</el-table-column>
					<el-table-column v-if="type === 4" prop="data" label="用户ID/卡号" width="150"></el-table-column>
					<el-table-column v-if="type !== 4" prop="data" width="150" label="时间"></el-table-column>
					<el-table-column prop="count" label="充电次数" width="100"></el-table-column>
					<el-table-column prop="chargeQuantity" label="充电电量(度)" width="120"></el-table-column>
					<!-- <el-table-column prop="index" label="充电金额（元）"></el-table-column> -->
					<el-table-column prop="chargeMoney" label="基础电费(元)" width="120"></el-table-column>
					<el-table-column prop="serviceTip" label="服务费(元)" width="120"></el-table-column>
					<el-table-column prop="totalFee" label="总电费(元)" width="120"></el-table-column>
					<el-table-column prop="jquantity" label="尖充电电量(度)" width="120"></el-table-column>
					<el-table-column prop="jfee" label="尖充电金额(元)" width="120"></el-table-column>
					<el-table-column prop="fquantity" label="波充电电量(度)" width="120"></el-table-column>
					<el-table-column prop="ffee" label="波充电金额(元)" width="120"></el-table-column>
					<el-table-column prop="pquantity" label="平充电电量(度)" width="120"></el-table-column>
					<el-table-column prop="pfee" label="平充电金额(元)" width="120"></el-table-column>
					<el-table-column prop="gquantity" label="谷充电电量(度)" width="120"></el-table-column>
					<el-table-column prop="gfee" label="谷充电金额(元)" width="120"></el-table-column>
					<!-- <el-table-column label="操作">
						<template slot-scope="scope">
							<el-button @click="handleClick(scope.row)" type="text" size="small">确认</el-button>
						</template>
					</el-table-column>-->
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
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.csOptions = this.$store.state.home.chargeStationArr;
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
      chargeWay: 0,
      chargeWayOptions: [
        // { typeStr: 0, typeName: "APP充电" },
        { typeStr: 1, typeName: "刷卡充电" },
        { typeStr: 0, typeName: "微信充电" }
      ],
      typeOptions: [
        {
          typeStr: 1,
          typeName: "按日统计"
        },
        {
          typeStr: 2,
          typeName: "按月统计"
        },
        {
          typeStr: 3,
          typeName: "按年统计"
        },
        {
          typeStr: 4,
          typeName: "按用户统计"
        }
      ],
      csId: null,
      csOptions: [],
      operatorOptions: [],
      operatorId: null,
      type: 1,
      mainScreenLoading: false,
      tableData: [],
      recordTypeOptions: [
        { typeStr: 0, typeName: "尚宽" },
        { typeStr: 1, typeName: "快电" }
      ],
      recordType: 0,
    };
  },
  methods: {
    summaryMethod(param) {
      // param 是固定的对象，里面包含 columns与 data参数的对象 {columns: Array[4], data: Array[5]},包含了表格的所有的列与数据信息
      const { columns, data } = param;
      console.log(param);
      const sums = [];
      columns.forEach((column, index) => {
        if (index === 0) {
          sums[index] = "合计";
          return;
        }
        if (index > 2) {
          const values = data.map(item => Number(item[column.property]));
          // 验证每个value值是否是数字，如果是执行if
          if (!values.every(value => isNaN(value))) {
            sums[index] = values.reduce((prev, curr) => {
              return prev + curr;
            }, 0);
            switch (index) {
              case 3:
                sums[index] += "次";
                break;
              case 4:
              case 8:
              case 10:
              case 12:
              case 14:
                sums[index] = sums[index].toFixed(2);
                sums[index] += "度";
                break;
              default:
                sums[index] = sums[index].toFixed(2);
                sums[index] += "元";
                break;
            }
          } else {
            sums[index] = "";
          }
        } else {
          return "";
        }
      });

      return sums;
    },
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    queryBtnAct() {
      this.currentPage = 1;
      this.initData();
    },
    initData() {
      let data = {
        model: {
          chargeMethodId: this.chargeWay,
          csId: this.csId,
          dimension: this.type,
          endTime: this.endTime,
          operatorId: this.operatorId,
          startTime: this.beginTime,
          recordType: this.recordType
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$businessAjax
        .getChargeReport(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
          } else {
          }
        })
        .catch(() => {});
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
  watch: {
    tableData: {
      handler() {},
      deep: true,
      immediate: true
    }
  }
};
</script>
<style>
.ChargeReport .flex-sbw-item .el-input,
.ChargeReport .flex-sbw-item .el-input__inner {
	width: 160px;
	height: 32px;
}
.ChargeReport .el-date-editor.el-input,
.ChargeReport .el-date-editor.el-input__inner {
	width: 190px;
}
.ChargeReport .el-input--suffix .el-input__inner {
	padding-right: 10px;
}
.ChargeReport .el-table__body-wrapper {
	max-height: calc(100% - 100px);
	overflow: auto;
	border: 0px solid #c0c4cc;
}
@media screen and (max-width: 1540px) {
	.ChargeReport .flex-sbw-item {
		margin-right: 5px !important;
	}
	.ChargeReport .flex-sbw-item .el-input,
	.ChargeReport .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.ChargeReport .el-date-editor.el-input,
	.ChargeReport .el-date-editor.el-input__inner {
		width: 180px;
	}
	.ChargeReport .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.ChargeReport {
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
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
