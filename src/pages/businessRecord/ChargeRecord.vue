<template>
	<el-row
		class="ChargeRecord"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>运营管理／充电记录</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:10px">
				<div class="flex-st">
					<div class="topTitleTxt flex-sbw-item">
						<span>用户ID：</span>
						<el-input v-model="userId" clearable></el-input>
					</div>
					<div class="topTitleTxt flex-sbw-item">
						<span>充电桩ID：</span>
						<el-input v-model="cpId" clearable></el-input>
					</div>
					<div class="topTitleTxt flex-sbw-item">
						<span>手机号：</span>
						<el-input v-model="phoneNumber" clearable></el-input>
					</div>
					<div class="topTitleTxt flex-sbw-item">
						<span>充电卡号：</span>
						<el-input v-model="cardNum" clearable></el-input>
					</div>
				</div>
			</div>
			<div class="topMenu flex-st" style="margin-bottom: 15px;">
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
					<span class="topTitleTxt">充电方式：</span>
					<el-select
						class="left-space time-interal"
						v-model="chargeMethodId"
						clearable
						placeholder="充电方式"
						size="small"
					>
						<el-option
							v-for="item in chargeMethodOptions"
							:key="item.typeStr"
							:label="item.typeName"
							:value="item.typeStr"
						></el-option>
					</el-select>
				</div>
				<div class="dateBox">
					<span class="topTitleTxt">充电时间：</span>
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
			<div class="topMenu flex-st" style="margin-bottom: 5px;">
				<el-button type="primary" @click="exportBtnAct" style="margin:-5px 10px 0">批量导出</el-button>
				<el-button type="primary" @click="queryBtnAct" style="margin:-5px 10px 0">查询</el-button>
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
					<el-table-column prop="transactionId" label="订单编号" width="300"></el-table-column>
					<el-table-column prop="cpId" label="充电桩序列号" width="180"></el-table-column>
					<el-table-column prop="userId" label="用户ID" width="160">
						<template slot-scope="scope">{{scope.row.chargeMethodId !==1?scope.row.userId:''}}</template>
					</el-table-column>
					<el-table-column prop="cardNum" label="卡号" width="160">
						<template slot-scope="scope">{{scope.row.chargeMethodId ===1?scope.row.cardNum:''}}</template>
					</el-table-column>
					<el-table-column prop="interfaceId" label="枪号" width="60"></el-table-column>
					<el-table-column prop="chargeModeId" label="充电模式" width="100">
						<template slot-scope="scope">{{transferChargeModelId(scope.row.chargeModeId)}}</template>
					</el-table-column>
					<el-table-column prop="chargeMethodId" label="充电类型" width="90">
						<template slot-scope="scope">{{scope.row.chargeMethodId ===1?'刷卡':'微信'}}</template>
					</el-table-column>
					<el-table-column prop="chargeStartTime" label="充电开始时间" width="180"></el-table-column>
					<el-table-column prop="chargeEndTime" label="充电结束时间" width="180"></el-table-column>
					<el-table-column prop="timeSpan" label="充电时长" width="180">
						<template slot-scope="scope">{{$common.formatSeconds(scope.row.timeSpan)}}</template>
					</el-table-column>
					<el-table-column prop="chargeQuantity" label="充电电量" width="120"></el-table-column>
					<el-table-column prop="chargeMoney" label="充电总金额" width="100"></el-table-column>
					<el-table-column prop="csName" label="充电站" width="150"></el-table-column>
					<el-table-column prop="operatorName" label="运营商" width="120"></el-table-column>
					<el-table-column prop="chargeFinishedFlag" label="交易状态" width="100">
						<template slot-scope="scope">{{scope.row.chargeFinishedFlag>0?"成功":'失败'}}</template>
					</el-table-column>
					<el-table-column label="操作" fixed="right" width="120">
						<template slot-scope="scope">
							<el-button @click="handleClick(scope.row)" type="text" size="small">详情</el-button>
							<el-button @click="handleEditClick(scope.row)" type="text" size="small">编辑</el-button>
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
		<charge-record-detail
			:visible.sync="isShowAddDialog"
			:rowData="rowData"
			@onCancel="close"
			ref="houseTable"
		/>
		<charge-record-edit
			:visible.sync="dialogRecordView"
			:rowData="rowData"
			@onCancel="closeRecordView"
			ref="houseTable"
		/>
	</el-row>
</template>
<script>
import ChargeRecordDetail from "@/components/ChargeRecordDetail";
import ChargeRecordEdit from "@/components/ChargeRecordEdit";
export default {
  components: {
    ChargeRecordDetail,
    ChargeRecordEdit
  },
  mounted: function() {
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.stationOptions = this.$store.state.home.chargeStationArr;
    this.beginTime = this.$common.getSpaceDate(-30) + " 00:00:00";
    this.endTime = this.$common.getCurrentTime();
    this.initData();
  },
  data: function() {
    return {
      dialogRecordView: false,
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 10,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      chargeMethodOptions: [
        // { typeStr: 0, typeName: "APP充电" },
        { typeStr: 1, typeName: "刷卡充电" },
        { typeStr: 0, typeName: "微信充电" }
        // { typeStr: 4, typeName: "全部充电" }
      ],
      station: null,
      stationOptions: [],
      operatorId: null,
      mainScreenLoading: false,
      tableData: window.config.tableData,
      cpId: null,
      userName: null,
      userId: null,
      phoneNumber: null,
      chargeMethodId: null,
      rowData: {},
      cardNum: null,
      chargeModelOptions: {
        0: "自动充满",
        1: "电量",
        2: "时间",
        3: "金额",
        4: "刷卡"
      }
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
        if (index > 10 && index < 14) {
          const values = data.map(item => Number(item[column.property]));
          // 验证每个value值是否是数字，如果是执行if
          if (!values.every(value => isNaN(value))) {
            sums[index] = values.reduce((prev, curr) => {
              return prev + curr;
            }, 0);
            switch (index) {
              case 11:
                sums[index] = this.$common.formatSeconds(sums[index]);
                break;
              case 12:
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
    transferChargeModelId(chargeModelId) {
      return this.chargeModelOptions[chargeModelId];
    },
    // 关闭编辑弹窗
    closeRecordView(is) {
      this.dialogRecordView = !this.dialogRecordView;
      if (is) {
        this.initData();
        this.endTime = this.$common.getCurrentTime();
      }
    },
    // 编辑
    handleEditClick(rowData) {
      this.dialogRecordView = !this.dialogRecordView;
      this.rowData = rowData;
    },
    /**
	   *   {
      "cellStyleMap": {},
      "cpId": "1401070000000045",
      "deviceId": "1401070000000045",
      "interfaceId": 2,
      "transactionId": "14010700000000451915252115240000",
      "cardNum": "0000000000000000",
      "userId": "8881556682148237",
      "chargeQuantity": 38.84,
      "csName": "",
      "csId": 0,
      "operatorId": 34,
      "operatorName": "",
      "beforeChargeBalance": 50,
      "chargeMoney": 34.1792,
      "serviceTip": 0,
      "chargeStartTime": "2019-06-25 21:15:24",
      "chargeEndTime": "2019-06-25 22:22:17",
      "chargeFinishedFlag": 2,
      "chargeEndCause": "充满",
      "billModelId": 206,
      "jTime": 0,
      "fTime": 4012,
      "pTime": 0,
      "gTime": 0,
      "jQuantity": 0,
      "fQuantity": 38.84,
      "pQuantity": 0,
      "gQuantity": 0,
      "jFee": 0,
      "fFee": 34.1792,
      "pFee": 0,
      "gFee": 0,
      "chargeMethodId": 3,
      "chargeModeId": 4,
      "chargePara": 0,
      "allQuantity": 61473.6,
      "gmtCreate": "2019-07-05 23:10:02",
      "gmtModify": "2019-08-22 20:40:26",
      "isDeleted": 0,
      "jtime": 0,
      "ftime": 4012,
      "ptime": 0,
      "gtime": 0,
      "jquantity": 0,
      "fquantity": 38.84,
      "pquantity": 0,
      "gquantity": 0,
      "jfee": 0,
      "ffee": 34.1792,
      "pfee": 0,
      "gfee": 0
    }
	   */
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    queryBtnAct() {
      this.initData();
    },
    addBtnAct() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    initData() {
      var data = {
        model: {
          chargeEndTime: this.endTime,
          chargeMethodId: this.chargeMethodId,
          chargeStartTime: this.beginTime,
          deviceId: this.cpId,
          operatorId: this.operatorId,
          telephone: this.phoneNumber,
          cardNum: this.cardNum,
          userId: this.userId
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true
      };
      data.model = this.$common.deleteEmptyString(data.model);
      this.getTotal(data);
      this.$businessAjax
        .getChargeRecordList(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
          } else {
            this.$message.warning(res.data.errorMessage);
          }
        })
        .catch(() => {});
    },
    getTotal(data) {
      this.$businessAjax
        .getChargeRecordTotal(data)
        .then(res => {
          if (res.data.success) {
            this.total = res.data.model;
          } else {
            this.$message.warning(res.data.errorMessage);
          }
        })
        .catch(() => {});
    },
    deleteBtnAct() {},
    exportBtnAct() {
      var data = {
        model: {
          cardNum: null,
          operatorLoginId: this.$store.state.home.OperatorId,
          //   roleId: this.$store.state.home.AuthRoleId,
          userId: null,
          chargeEndTime: this.endTime,
          chargeMethodId: this.chargeMethodId,
          chargeStartTime: this.beginTime,
          deviceId: this.cpId,
          operatorId: this.operatorId,
          telephone: this.phoneNumber,
          userName: this.userName
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true
      };
      // 过滤空字符串
      data.model = this.$common.deleteEmptyString(data.model);
      this.$businessAjax
        .exportChargeRecord(data)
        .then(res => {
          if (res.data) {
            const content = res.data;
            const blob = new Blob([content]);
            const fileName = new Date().getTime() + ".xlsx";
            if ("download" in document.createElement("a")) {
              // 非IE下载
              const elink = document.createElement("a");
              elink.download = fileName;
              elink.style.display = "none";
              elink.href = URL.createObjectURL(blob);
              document.body.appendChild(elink);
              elink.click();
              URL.revokeObjectURL(elink.href); // 释放URL 对象
              document.body.removeChild(elink);
            }
          }
        })
        .catch(() => {});
    },
    handleClick(row) {
      console.log(row);
      this.rowData = row;
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
.ChargeRecord .el-table__fixed,
.ChargeRecord .el-table__fixed-right {
	box-shadow: 0 0 0px rgba(0, 0, 0, 0.12);
}
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
.ChargeRecord .flex-sbw-item {
	margin-right: 5%;
}
.ChargeRecord .el-table__body-wrapper {
	max-height: calc(100% - 100px);
	overflow: auto;
	border: 0px solid #c0c4cc;
}
.ChargeRecord .el-table__footer-wrapper .el-table--border th,
.ChargeRecord.el-table__footer-wrapper .el-table--border td {
	border-right: 0px solid #dcdfe6;
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
				margin-right: 3%;
			}
			.el-button {
				color: #ffffff;
				background-color: #5b9cf8;
				border-color: #5b9cf8;
				// height: 32px;
				// line-height: 32px;
			}
		}
		.tableBox {
			height: calc(100% - 200px);
		}
		.footer {
			// padding-top: 30px;
			text-align: right;
		}
	}
}
</style>
