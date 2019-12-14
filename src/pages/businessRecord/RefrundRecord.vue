<template>
	<el-row
		class="RefrundRecord"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>运营管理／退款记录</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:5px">
				<div class="flex-sbw">
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>用户ID：</span>
						<el-input v-model="userId"></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>订单流水号：</span>
						<el-input v-model="transationNum"></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>提现金额：</span>
						<el-input v-model="Money"></el-input>
						<!-- <el-select
							class="left-space time-interal"
							v-model="refundStatus"
							clearable
							placeholder="处理状态"
							size="small"
						>
							<el-option
								v-for="item in refundStatusOptions"
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
				<el-button type="primary" @click="deleteBtnAct" style="margin:0 10px;">批量导出</el-button>
				<el-button type="primary" @click="queryBtnAct" style="margin:0 10px;">查询</el-button>
			</div>
			<div class="tableBox">
				<el-table :data="tableData" stripe border  style="width: 100%">
					<el-table-column type="selection" width="55"></el-table-column>
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="orderId" label="订单号"></el-table-column>
					<el-table-column prop="userId" label="用户ID"></el-table-column>
					<!-- <el-table-column prop="date" label="用户名"></el-table-column> -->
					<!-- <el-table-column prop="name" label="电话"></el-table-column> -->
					<el-table-column prop="withdrawMoney" label="退款金额"></el-table-column>
					<el-table-column prop="beforeBalance" label="退款前金额"></el-table-column>
					<el-table-column prop="balance" label="退款后金额"></el-table-column>
					<el-table-column prop="gmtCreate" label="退款时间"></el-table-column>
					<el-table-column prop="gmtModify" label="更新时间"></el-table-column>
					<el-table-column prop="flag" label="退款状态"></el-table-column>
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
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 10,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      Money: null,
      stationOptions: [],
      operator: null,
      mainScreenLoading: false,
      userId: null,
      transationNum: null,
      refundStatus: null,
      refundStatusOptions: [],
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
          endTime: this.endTime,
          openId: this.userId,
          startTime: this.beginTime
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$businessAjax
        .getRefrundRecord(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
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
  watch: {}
};
</script>
<style>
.RefrundRecord .flex-sbw-item .el-input,
.RefrundRecord .flex-sbw-item .el-input__inner {
	width: 150px;
	height: 32px;
}
.RefrundRecord .el-date-editor.el-input,
.RefrundRecord .el-date-editor.el-input__inner {
	width: 180px;
}
.RefrundRecord .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1512px) {
	.RefrundRecord .flex-sbw-item {
		margin-right: 5px !important;
	}
	.RefrundRecord .flex-sbw-item .el-input,
	.RefrundRecord .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.RefrundRecord .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.RefrundRecord {
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
