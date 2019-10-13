<template>
	<el-row
		class="ChargeRecord"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>设备监控／开关监控</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:10px">
				<div class="flex-sbw">
					<div class="flex-sbw-div">
						<span class="topTitleTxt">数据状态：</span>
						<el-select
							class="left-space time-interal"
							v-model="type"
							clearable
							placeholder="请选择确认状态"
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

					<div class="flex-sbw-div">
						<span class="topTitleTxt">桩类型：</span>
						<el-select
							class="left-space time-interal"
							v-model="cpTypeOptions"
							clearable
							placeholder="桩类型"
							size="small"
						>
							<el-option
								v-for="item in cpTypeOptions"
								:key="item.typeStr"
								:label="item.typeName"
								:value="item.typeStr"
							></el-option>
						</el-select>
					</div>
					<div class="dateBox">
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
			<div class="topMenu flex-st" style="margin-bottom: 15px;"></div>
			<div class="topMenu flex-st" style="margin-bottom: 5px;"></div>
			<el-table :data="tableData" stripe border style="width: 100%">
				<el-table-column type="selection" width="55"></el-table-column>
				<el-table-column type="index" width="55" label="序号"></el-table-column>
				<el-table-column prop="date" label="充电桩" width="120"></el-table-column>
				<el-table-column prop="name" label=" 新值" width="100"></el-table-column>
				<el-table-column prop="zip" label="新值含义"></el-table-column>
				<el-table-column prop="id" label="新值记录时间" width="180"></el-table-column>
				<el-table-column prop="index" label="旧值" width="100"></el-table-column>
				<el-table-column prop="index" label="旧值含义"></el-table-column>
				<el-table-column prop="zip" label="旧值记录时间" width="180"></el-table-column>
				<el-table-column prop="zip" label="确认状态" width="100"></el-table-column>
				<el-table-column prop="zip" label="确认模式" width="100"></el-table-column>
				<el-table-column label="操作">
					<template slot-scope="scope">
						<el-button @click="handleClick(scope.row)" type="text" size="small">确认</el-button>
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
      typeOptions: [
        {
          typeStr: 1,
          typeName: "确认"
        },
        {
          typeStr: 0,
          typeName: "未确认"
        }
      ],
      cpTypeOptions: [
        {
          typeStr: 0,
          typeName: "直流"
        },
        {
          typeStr: 1,
          typeName: "交流"
        }
      ],
      cpType: 0,
      station: null,
      stationOptions: [],
      type: null,
      mainScreenLoading: false,
      tableData: window.config.tableData
    };
  },
  methods: {
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    queryBtnAct() {
      this.initData();
    },
    initData() {
      let data = {
        model: {
          checkState: 0,
          endTime: this.endTime,
          startTime: this.beginTime,
          cpType: this.cpType,
          type: this.type
        },
        pageIndex: 1,
        pageSize: 10,
        queryCount: true,
        start: 0
      };
      this.$realAjax
        .realSwitchData(data)
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
