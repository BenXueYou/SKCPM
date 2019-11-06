<template>
	<el-row
		class="ChargeRecord"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>计费模型</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:10px">
				<div class="flex-sbw">
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
						<span class="topTitleTxt">费率模板：</span>
						<el-select class="time-interal" v-model="rateId" size="small" clearable placeholder="请选择">
							<el-option v-for="item in chargePriceModelOptions" :key="item" :label="item" :value="item"></el-option>
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
					<el-button type="primary" @click="queryBtnAct" style="margin:-5px 10px 0">查询</el-button>
				</div>
			</div>
			<div class="tableBox">
			<el-table :data="tableData" stripe border  style="width: 100%">
				<el-table-column type="selection" width="55"></el-table-column>
				<el-table-column type="index" width="55" label="序号"></el-table-column>
				<el-table-column prop="validTime" label="生效时间" width="180"></el-table-column>
				<el-table-column prop="invalidTime" label="失效时间" width="180"></el-table-column>
				<el-table-column prop="timeIntervalCount" label="有效时段" width="120"></el-table-column>
				<el-table-column prop="serviceTip" label=" 服务费" width="100"></el-table-column>
				<el-table-column prop="jprice" label="尖电价"></el-table-column>
				<el-table-column prop="fprice" label="峰电价" width="100"></el-table-column>
				<el-table-column prop="pprice" label="平电价"></el-table-column>
				<el-table-column prop="gprice" label="谷电价" width="100"></el-table-column>
				<el-table-column prop="ti1Start" label="时段1起始时刻" width="120"></el-table-column>
				<el-table-column prop="ti1Id" label="时段1类型" width="120"></el-table-column>
				<el-table-column prop="ti2Start" label="时段2起始时刻" width="120"></el-table-column>
				<el-table-column prop="ti2Id" label="时段2类型" width="120"></el-table-column>
				<el-table-column prop="ti3Start" label="时段3起始时刻" width="120"></el-table-column>
				<el-table-column prop="ti3Id" label="时段3类型" width="120"></el-table-column>
				<el-table-column prop="ti4Start" label="时段4起始时刻" width="120"></el-table-column>
				<el-table-column prop="ti4Id" label="时段4类型" width="120"></el-table-column>
				<el-table-column prop="ti5Start" label="时段5起始时刻" width="120"></el-table-column>
				<el-table-column prop="ti5Id" label="时段5类型" width="120"></el-table-column>
				<el-table-column prop="ti6Start" label="时段6起始时刻" width="120"></el-table-column>
				<el-table-column prop="ti6Id" label="时段6类型" width="120"></el-table-column>
				<el-table-column prop="ti7Start" label="时段7起始时刻" width="120"></el-table-column>
				<el-table-column prop="ti7Id" label="时段7类型" width="120"></el-table-column>
				<el-table-column prop="ti8Start" label="时段8起始时刻" width="120"></el-table-column>
				<el-table-column prop="ti8Id" label="时段8类型" width="120"></el-table-column>
				<!-- <el-table-column prop="zip" label="确认模式" width="120"></el-table-column> -->
				<el-table-column label="操作">
					<template slot-scope="scope">
						<el-button @click="handleClick(scope.row)" type="text" size="small">编辑</el-button>
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
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.operatorId = this.operatorOptions[0].operatorId;
    this.getAddOptions();
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
      rateId: null,
      chargePriceModelOptions: [],
      operatorId: null,
      mainScreenLoading: false,
      tableData: window.config.tableData
    };
  },
  methods: {
    // 新增充电桩的时候Options
    getAddOptions() {
      this.$deviceAjax
        .getAddOptions({ operatorLoginId: this.$store.state.home.OperatorId })
        .then(res => {
          console.log(res.data);
          if (res.data.success) {
            this.chargePriceModelOptions = res.data.model.rateList;
            this.rateId = this.chargePriceModelOptions[0];
          } else {
          }
        })
        .catch(() => {});
    },
    initData() {
      let data = {
        model: {
          operatorId: this.operatorId,
          rateId: this.rateId
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$PriceAjax
        .getChargePrice(data)
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
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
