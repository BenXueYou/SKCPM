<template>
	<el-row
		class="AppUserStatics"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>运营统计／APP用户统计</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:5px">
				<div class="flex-sbw">
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>用户名：</span>
						<el-input v-model="userName" clearable></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>用户(卡)ID号：</span>
						<el-input v-model="userId" clearable></el-input>
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
				<!-- <el-button
					type="primary"
					v-if="$store.state.home.AuthorizationID"
					@click="deleteBtnAct"
					style="margin:0 10px;"
				>批量导出</el-button> -->
				<el-button type="primary" @click="queryBtnAct" style="margin:0 10px;">查询</el-button>
			</div>
			<div class="tableBox">
				<el-table :v-loading="mainScreenLoading" :data="tableData" stripe border style="width: 100%">
					<el-table-column type="selection" width="55"></el-table-column>
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="userId" label="用户(卡)ID号"></el-table-column>
					<el-table-column prop="userName" label="用户名"></el-table-column>
					<el-table-column prop="telephone" label="电话"></el-table-column>
					<!-- <el-table-column prop="date" label="车牌号"></el-table-column> -->
					<el-table-column prop="chargeCount" label="充电次数"></el-table-column>
					<el-table-column prop="chargeTimeSpan" label="充电时长"></el-table-column>
					<el-table-column prop="chargeQuantity" label="充电电量(kWh)"></el-table-column>
					<el-table-column prop="serviceTip" label="服务费(元)"></el-table-column>
					<el-table-column prop="chargeMoney" label="基础电费(元)"></el-table-column>
					<el-table-column prop="totalFee" label="充电总费用(元)"></el-table-column>
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
    this.chargeWay = this.chargeWayOptions[0].typeStr;
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
      chargeWay: null,
      chargeWayOptions: [
        // { typeStr: 0, typeName: "APP充电" },
        { typeStr: 1, typeName: "刷卡充电" },
        { typeStr: 0, typeName: "微信充电" }
        // { typeStr: 4, typeName: "全部充电" }
      ],
      userName: null,
      userId: null,
      mainScreenLoading: false,
      tableData: window.config.tableData
    };
  },
  methods: {
    initData() {
      let data = {
        model: {
          chargeMethodId: this.chargeWay,
          endTime: this.endTime,
          startTime: this.beginTime,
          userId: null,
          userName: this.userName
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$staticsAjax
        .getAppUser(data)
        .then(res => {
          console.log(res.data);
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
/* .AppUserStatics .flex-sbw-item {
	margin: 0 10px;
} */
.AppUserStatics .flex-sbw-item .el-input,
.AppUserStatics .flex-sbw-item .el-input__inner {
	width: 150px;
	height: 32px;
}
.AppUserStatics .el-date-editor.el-input,
.AppUserStatics .el-date-editor.el-input__inner {
	width: 180px;
}
.AppUserStatics .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1512px) {
	.AppUserStatics .flex-sbw-item {
		margin-right: 5px !important;
	}
	.AppUserStatics .flex-sbw-item .el-input,
	.AppUserStatics .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.AppUserStatics .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.AppUserStatics {
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
