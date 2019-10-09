<template>
	<el-row
		class="ChargePileStatics"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>运营统计／充电桩统计</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw" style="padding-bottom:5px">
				<div class="flex-sbw-div">
					<div class="flex-sbw">
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>桩ID：</span>
							<el-input v-model="cpId"></el-input>
						</div>
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>充电站：</span>
							<!-- <el-input v-model="station"></el-input> -->
							<el-select
								class="left-space time-interal"
								v-model="csId"
								clearable
								placeholder="充电站"
								size="small"
							>
								<el-option
									v-for="item in csOptions"
									:key="item.typeStr"
									:label="item.typeName"
									:value="item.typeStr"
								></el-option>
							</el-select>
						</div>
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>运营商：</span>
							<!-- <el-input v-model="station"></el-input> -->
							<el-select
								class="left-space time-interal"
								v-model="operator"
								clearable
								placeholder="处理状态"
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
					</div>
				</div>
			</div>
			<div class="topMenu" style="margin-bottom: 15px;">
				<el-button type="primary" @click="deleteBtnAct" style="margin:0 10px;">批量删除</el-button>
				<el-button type="primary" @click="queryBtnAct" style="margin:0 10px;">查询</el-button>
			</div>
			<el-table :data="tableData" stripe border style="width: 100%">
				<el-table-column type="selection" width="55"></el-table-column>
				<el-table-column type="index" width="55" label="序号"></el-table-column>
				<el-table-column prop="date" label="充电桩ID"></el-table-column>
				<el-table-column prop="date" label="桩名"></el-table-column>
				<el-table-column prop="date" label="运营商"></el-table-column>
				<el-table-column prop="name" label="充电站"></el-table-column>
				<el-table-column prop="province" label="充电次数"></el-table-column>
				<el-table-column prop="province" label="充电时长"></el-table-column>
				<el-table-column prop="province" label="充电电量(kWh)"></el-table-column>
				<el-table-column prop="city" label="服务费(元)"></el-table-column>
				<el-table-column prop="city" label="基础电费(元)"></el-table-column>
				<el-table-column prop="city" label="充电总费用(元)"></el-table-column>
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
		<!-- <app-user-add :isShow="isShowAddDialog" @onCancel="close()" ref="houseTable" /> -->
	</el-row>
</template>
<script>
// import appUserAdd from "@/components/appUserAdd";
export default {
  components: {
    // appUserAdd
  },
  mounted: function() {},
  data: function() {
    return {
      cpId: null,
      csId: null,
      csOptions: [],
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 15,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      operator: null,
      mainScreenLoading: false,
      tableData: window.config.tableData
    };
  },
  methods: {
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    queryBtnAct() {},
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
    },
    handleSizeChange(val) {
      console.log("每页条数发生变化：", val);
      this.pageSize = val;
    }
  },
  watch: {}
};
</script>
<style>
.ChargePileStatics .flex-sbw-item {
	margin: 0 10px;
}
.ChargePileStatics .dateBox {
	margin-left: 30px;
}
.ChargePileStatics .flex-sbw-item .el-input,
.ChargePileStatics .flex-sbw-item .el-input__inner {
	width: 150px;
	height: 32px;
}
.ChargePileStatics .el-date-editor.el-input,
.ChargePileStatics .el-date-editor.el-input__inner {
	width: 180px;
}
.ChargePileStatics .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1512px) {
	.ChargePileStatics .flex-sbw-item {
		margin-right: 5px !important;
	}
	.ChargePileStatics .flex-sbw-item .el-input,
	.ChargePileStatics .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.ChargePileStatics .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
	.ChargePileStatics .dateBox {
		margin-left: 30px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.ChargePileStatics {
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
			margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
