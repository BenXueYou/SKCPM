<template>
	<el-row
		class="RechargeRecord"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>运营管理／充值记录</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:5px">
				<div class="flex-sbw">
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>用户名：</span>
						<el-input v-model="userName" clearable></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>手机号：</span>
						<el-input v-model="telephone" clearable></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>订单流水号：</span>
						<el-input v-model="transationNum" clearable></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>支付金额：</span>
						<el-input v-model="money" clearable></el-input>
						<!-- <el-select
							class="left-space time-interal"
							v-model="payStatus"
							clearable
							placeholder="支付状态"
							size="small"
						>
							<el-option
								v-for="item in payStatusOptions"
								:key="item.typeStr"
								:label="item.typeName"
								:value="item.typeStr"
							></el-option>
						</el-select>-->
					</div>
					<div class="dateBox">
						<span class="topTitleTxt">支付时间：</span>
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
			<div class="topMenu" style="margin-bottom: 15px;">
				<el-button type="primary" @click="deleteBtnAct" style="margin:0 10px;">批量删除</el-button>
				<el-button type="primary" @click="queryBtnAct" style="margin:0 10px;">查询</el-button>
			</div>
			<div class="tableBox">
				<el-table :data="tableData" stripe border style="width: 100%">
					<el-table-column type="selection" width="55"></el-table-column>
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="orderId" width="240" label="订单号"></el-table-column>
					<el-table-column prop="userId"  width="160" label="用户ID"></el-table-column>
					<!-- <el-table-column prop="userName" label="用户名"></el-table-column> -->
					<el-table-column prop="telephone"  min-width="120" label="电话"></el-table-column>
					<el-table-column prop="depositMoney" min-width="80" label="充值金额"></el-table-column>
					<el-table-column prop="beforeDepositMoney" min-width="100" label="充值前金额"></el-table-column>
					<el-table-column prop="balance" min-width="100" label="充值后金额"></el-table-column>
					<el-table-column prop="gmtCreate" label="支付时间" width="160"></el-table-column>
					<el-table-column prop="gmtModify" label="更新时间" width="160"></el-table-column>
					<el-table-column prop="flag" label="交易状态">
						<template slot-scope="scope">{{scope.row.flag?'成功':'失败'}}</template>
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
    this.beginTime = this.$common.getSpaceDate(-30) + " 00:00:00";
    this.endTime = this.$common.getCurrentTime();
    this.initData();
  },
  data: function() {
    return {
      isShowAddDialog: false,
      transationNum: null,
      userName: null,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 10,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      money: null,
      operator: null,
      mainScreenLoading: false,
      payStatus: null,
      payStatusOptions: [],
      tableData: [],
      telephone: null
    };
  },
  methods: {
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
    initData() {
      let data = {
        model: {
          balance: 0,
          depositEndTime: this.endTime,
          depositMoney: this.money,
          depositStartTime: this.beginTime,
          gmtCreate: null,
          gmtModify: null,
          id: 0,
          isDeleted: 0,
          openId: null,
          telephone: this.telephone,
          userId: null,
          userName: this.userName
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$businessAjax
        .getRechargeRecord(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
          }
        })
        .catch(() => {});
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
.RechargeRecord .flex-sbw-item .el-input,
.RechargeRecord .flex-sbw-item .el-input__inner {
	width: 150px;
	height: 32px;
}
.RechargeRecord .el-date-editor.el-input,
.RechargeRecord .el-date-editor.el-input__inner {
	width: 180px;
}
.RechargeRecord .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1512px) {
	.RechargeRecord .flex-sbw-item {
		margin-right: 5px !important;
	}
	.RechargeRecord .flex-sbw-item .el-input,
	.RechargeRecord .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.RechargeRecord .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.RechargeRecord {
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
