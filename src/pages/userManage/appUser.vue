<template>
	<el-row
		class="appUser"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>用户管理／微信APP用户</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw" style="padding-bottom:5px">
				<div class="flex-sbw-div">
					<div class="flex-sbw">
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>用户ID：</span>
							<el-input v-model="userId" clearable></el-input>
						</div>
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>电话：</span>
							<el-input v-model="phoneNumber" clearable></el-input>
						</div>
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>车牌号：</span>
							<el-input v-model="plateNumber" clearable></el-input>
						</div>
						<div class="dateBox">
							<span class="topTitleTxt">注册时间：</span>
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
			<div class="tableBox">
				<el-table :data="tableData" stripe border style="width: 100%">
					<el-table-column type="selection" width="55"></el-table-column>
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="userId" label="用户ID" show-overflow-tooltip></el-table-column>
					<el-table-column prop="userName" label="用户名" show-overflow-tooltip></el-table-column>
					<el-table-column prop="telephone" label="电话" show-overflow-tooltip></el-table-column>
					<el-table-column prop="openId" label="用户openID" show-overflow-tooltip></el-table-column>
					<el-table-column prop="userType" label="用户类型">
						<template slot-scope="scope">{{scope.row.userType?'APP用户':'微信用户'}}</template>
					</el-table-column>
					<el-table-column prop="balance" show-overflow-tooltip label="余额"></el-table-column>
					<el-table-column prop="chargeState" show-overflow-tooltip label="状态"></el-table-column>
					<el-table-column prop="gmtCreate" show-overflow-tooltip label="注册时间"></el-table-column>
					<el-table-column prop="gmtModify" show-overflow-tooltip label="更新时间"></el-table-column>
					<!-- <el-table-column label="操作">
					<template slot-scope="scope">
						<el-button @click="handleClick(scope.row)" type="text" size="small">编辑</el-button>
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
		<app-user-add :isShow="isShowAddDialog" @onCancel="close()" ref="houseTable" />
	</el-row>
</template>
<script>
import appUserAdd from "@/components/appUserAdd";
export default {
  components: {
    appUserAdd
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
      operatorOptions: [],
      userName: null,
      stationOptions: [],
      phoneNumber: null,
      mainScreenLoading: false,
      plateNumber: null,
      tableData: [],
      userId: null
    };
  },
  methods: {
    initData() {
      let data = {
        model: {
          endTime: this.endTime,
          startTime: this.beginTime,
          userId: this.userId,
          telephone: this.phoneNumber
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$userAjax
        .getAppUserList(data)
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
      this.currentPage = 1;
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
.appUser .flex-sbw-item {
	margin: 0 10px;
}
.appUser .dateBox {
	margin-left: 30px;
}
.appUser .flex-sbw-item .el-input,
.appUser .flex-sbw-item .el-input__inner {
	width: 150px;
	height: 32px;
}
.appUser .el-date-editor.el-input,
.appUser .el-date-editor.el-input__inner {
	width: 180px;
}
.appUser .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1512px) {
	.appUser .flex-sbw-item {
		margin-right: 5px !important;
	}
	.appUser .flex-sbw-item .el-input,
	.appUser .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.appUser .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
	.appUser .dateBox {
		margin-left: 30px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.appUser {
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
