<template>
	<el-row
		class="EnterpriseStaff"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>企业用户／员工管理</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw" style="padding-bottom:5px">
				<div class="flex-sbw-div">
					<div class="flex-sbw">
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>用户姓名：</span>
							<el-input v-model="userName" clearable></el-input>
						</div>
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>企业名称：</span>
							<!-- <el-input v-model="station" clearable></el-input> -->
							<el-select
								class="left-space time-interal"
								v-model="companyId"
								clearable
								placeholder="请选择企业名称"
								size="small"
							>
								<el-option
									v-for="item in companyOptions"
									:key="item.companyId"
									:label="item.companyName"
									:value="item.companyId"
								></el-option>
							</el-select>
						</div>
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>当前状态：</span>
							<el-select
								class="left-space time-interal"
								v-model="status"
								clearable
								placeholder="充电方式 "
								size="small"
							>
								<el-option
									v-for="item in statusOptions"
									:key="item.typeStr"
									:label="item.typeName"
									:value="item.typeStr"
								></el-option>
							</el-select>
						</div>
						<!-- <div class="dateBox">
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
						</div>-->
					</div>
				</div>
			</div>
			<div class="topMenu" style="margin-bottom: 15px;">
				<div class="dateBox" style="display:inline-block">
					<span class="topTitleTxt">申请时间：</span>
					<el-date-picker
						v-model="applyBeginTime"
						type="datetime"
						class="time-interal-date"
						size="small"
						placeholder="选择日期"
						value-format="yyyy-MM-dd HH:mm:ss"
					></el-date-picker>
					<span class="time-line">—</span>
					<el-date-picker
						v-model="applyEndTime"
						type="datetime"
						class="time-interal-date"
						placeholder="选择日期"
						size="small"
						value-format="yyyy-MM-dd HH:mm:ss"
					></el-date-picker>
				</div>
				<div class="dateBox" style="display:inline-block">
					<span class="topTitleTxt">确认时间：</span>
					<el-date-picker
						v-model="affirmBeginTime"
						type="datetime"
						class="time-interal-date"
						size="small"
						placeholder="选择日期"
						value-format="yyyy-MM-dd HH:mm:ss"
					></el-date-picker>
					<span class="time-line">—</span>
					<el-date-picker
						v-model="affirmEndTime"
						type="datetime"
						class="time-interal-date"
						placeholder="选择日期"
						size="small"
						value-format="yyyy-MM-dd HH:mm:ss"
					></el-date-picker>
				</div>
			</div>
			<div class="topMenu" style="margin-bottom: 15px;">
				<el-button type="primary" @click="resoveBtnAct" style="margin:0 0 0 10px;">通过</el-button>
				<el-button type="primary" @click="refuseBtnAct" style="margin:0 2px;">拒绝</el-button>
				<el-button type="primary" @click="deleteBtnAct" style="margin:0;">删除</el-button>
				<el-button type="primary" @click="queryBtnAct" style="margin:0 2px;">查询</el-button>
				<el-button type="primary" @click="exportBtnAct" style="margin:0 10px 0 0;">导出</el-button>
			</div>
			<div class="tableBox">
				<el-table
					:data="tableData"
					@selection-change="selectionChange"
					stripe
					border
					style="width: 100%"
				>
					<el-table-column type="selection" width="55"></el-table-column>
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="employeeName" label="用户姓名"></el-table-column>
					<el-table-column prop="telephone" label="联系电话"></el-table-column>
					<el-table-column prop="companyName" label="企业名称"></el-table-column>
					<el-table-column prop="plateNum" label="车牌号"></el-table-column>
					<el-table-column prop="applyDate" show-overflow-tooltip label="申请时间"></el-table-column>
					<el-table-column prop="affirmDate" show-overflow-tooltip label="确认时间"></el-table-column>
					<el-table-column prop="status" label="状态">
						<template slot-scope="scope">{{scope.row.status?"通过":"不通过"}}</template>
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
    this.companyOptions = this.$store.state.home.enterpriseUser;
    this.companyOptions.unshift({
      companyId: null,
      companyName: "全部"
    });
    this.beginTime = this.$common.getSpaceDate(-30) + " 00:00:00";
    this.endTime = this.$common.getCurrentTime();
    this.operator = this.companyOptions[0].operatorId;
    this.status = this.statusOptions[0].typeStr;
    this.initData();
  },
  data: function() {
    return {
      userName: null,
      csOptions: [],
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 10,
      currentPage: 1,
      total: 10,
      affirmBeginTime: null,
      affirmEndTime: null,
      applyEndTime: null,
      applyBeginTime: null,
      companyOptions: [],
      companyId: null,
      mainScreenLoading: false,
      tableData: [],
      status: null,
      checkedStaffUuids: [],
      statusOptions: [
        { typeStr: null, typeName: "全部" },
        { typeStr: 1, typeName: "通过" },
        { typeStr: 0, typeName: "拒绝" }
      ]
    };
  },
  methods: {
    initData() {
      let data = {
        model: {
          affirmEndTime: this.affirmEndTime,
          affirmStartTime: this.affirmBeginTime,
          applyEndTime: this.applyEndTime,
          applyStartTime: this.applyBeginTime,
          employeeName: this.userName,
          status: this.status
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$EnterpriseAjax
        .getEnterPriseStaffApi(data)
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
    selectionChange(selection) {
      console.log(selection);
      this.checkedStaffUuids = [];
      selection.forEach(item => {
        this.checkedStaffUuids.push(item.employeeId);
      });
    },
    deleteBtnAct() {
      this.$confirm("是否删除该条数据?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.deleteData();
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消删除"
          });
        });
    },
    // 通过审核
    resoveBtnAct() {
      if (this.checkedStaffUuids) {
        this.checkStaffAuthority(1);
      } else {
        this.$message.warning("请选择要审核的员工");
      }
    },
    // 拒绝审核
    refuseBtnAct() {
      if (this.checkedStaffUuids) {
        this.checkStaffAuthority(0);
      } else {
        this.$message.warning("请选择要审核的员工");
      }
    },
    // 审核员工
    checkStaffAuthority(status) {
      let data = {
        affirmDate: this.$common.getCurrentTime(),
        employeeId: this.checkedStaffUuids,
        status: status
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$EnterpriseAjax
        .checkEnterPriseStaffApi(data)
        .then(res => {
          if (res.data.success) {
            this.$message.success("操作成功");
            this.initData();
          }
        })
        .catch(() => {});
    },
    deleteData() {
      this.$deviceAjax
        .deletePile({ employeeId: this.checkedStaffUuids })
        .then(res => {
          if (res.data.success) {
            this.initData();
            this.$message.success(res.data.errMsg);
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
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
.EnterpriseStaff .flex-sbw-item {
	margin: 0 50px 0 10px;
}
.EnterpriseStaff .dateBox {
	margin-left: 10px;
}
.EnterpriseStaff .flex-sbw-item .el-input,
.EnterpriseStaff .flex-sbw-item .el-input__inner {
	width: 150px;
	height: 32px;
}
.EnterpriseStaff .el-date-editor.el-input,
.EnterpriseStaff .el-date-editor.el-input__inner {
	width: 180px;
}
.EnterpriseStaff .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1512px) {
	.EnterpriseStaff .flex-sbw-item {
		margin-right: 25px !important;
	}
	.EnterpriseStaff .flex-sbw-item .el-input,
	.EnterpriseStaff .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.EnterpriseStaff .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
	.EnterpriseStaff .dateBox {
		margin-left: 10px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.EnterpriseStaff {
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
		.tableBox {
			min-height: calc(100% - 200px);
		}
		.footer {
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
