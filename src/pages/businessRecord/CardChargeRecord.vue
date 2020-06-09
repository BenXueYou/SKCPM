<template>
  <el-row
    class="CardChargeRecord"
    v-loading="mainScreenLoading"
    element-loading-background="rgba(0, 0, 0, 0.8)"
  >
    <div class="titleBox">
      位置：
      <span>用户管理／卡用户管理／卡充电记录</span>
    </div>
    <div class="bodyBox">
      <div class="topMenu" style="padding-bottom:10px">
        <div class="flex-st">
          <div class="topTitleTxt flex-sbw-item">
            <span>用户名：</span>
            <el-input v-model="userName" clearable></el-input>
          </div>
          <div class="topTitleTxt flex-sbw-item">
            <span>充电卡号：</span>
            <el-input v-model="cardNum" clearable></el-input>
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
      </div>
      <div class="topMenu flex-st" style="margin-bottom: 5px;">
        <el-button type="primary" @click="exportBtnAct" style="margin:-5px 10px 0">批量导出</el-button>
        <el-button type="primary" @click="queryBtnAct" style="margin:-5px 10px 0">查询</el-button>
        <el-button
          type="primary"
          class="el-icon-back"
          @click="backBtnAct"
          style="margin:-5px 10px 0"
        >返回</el-button>
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
          <!-- <el-table-column prop="chargeModeId" label="充电模式" width="100">
						<template slot-scope="scope">{{transferChargeModelId(scope.row.chargeModeId)}}</template>
					</el-table-column>
					<el-table-column prop="chargeMethodId" label="充电类型" width="90">
						<template slot-scope="scope">{{scope.row.chargeMethodId ===1?'刷卡':'微信'}}</template>
          </el-table-column>-->
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
  props: {
    cardUser: {
      type: Object,
      default: () => {
        return {};
      }
    },
    showCardChargRecord: {
      type: Boolean,
      default: false
    }
  },
  components: {
    ChargeRecordDetail,
    ChargeRecordEdit
  },
  watch: {
    showCardChargRecord(val) {},
    cardUser: {
      handler(newVal, oldVal) {
        console.log(newVal);
        if (newVal.cardNum) {
          this.cardNum = newVal.cardNum;
          this.userName = "";
        } else {
          this.cardNum = "";
          this.userName = newVal.userName;
        }
        this.currentPage = 1;
        this.beginTime = this.$common.getSpaceDate(-30) + " 00:00:00";
        this.endTime = this.$common.getCurrentTime();
        this.initData();
      },
      deep: true,
      immediate: true
    }
  },
  mounted: function() {
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.stationOptions = this.$store.state.home.chargeStationArr;
    this.cardNum = this.cardUser.cardNum;
    this.userName = this.cardUser.userName;
    this.currentPage = 1;
    this.beginTime = this.$common.getSpaceDate(-30) + " 00:00:00";
    this.endTime = this.$common.getCurrentTime();
    // this.initData();
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
      operatorId: null,
      mainScreenLoading: false,
      tableData: window.config.tableData,
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
    backBtnAct() {
      this.$emit("back", false);
    },
    summaryMethod(param) {
      // param 是固定的对象，里面包含 columns与 data参数的对象 {columns: Array[4], data: Array[5]},包含了表格的所有的列与数据信息
      const { columns, data } = param;
      const sums = [];
      columns.forEach((column, index) => {
        if (index === 0) {
          sums[index] = "合计";
          return;
        }
        if (index > 8 && index < 13) {
          console.log(index);
          const values = data.map(item => Number(item[column.property]));
          // 验证每个value值是否是数字，如果是执行if
          if (!values.every(value => isNaN(value))) {
            sums[index] = values.reduce((prev, curr) => {
              return prev + curr;
            }, 0);

            switch (index) {
              case 9:
                sums[index] = this.$common.formatSeconds(sums[index]);
                break;
              case 10:
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
    initData() {
      var data = {
        model: {
          endTime: this.endTime,
          startTime: this.beginTime,
          cardNum: this.cardNum,
          userName: this.userName
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true
      };
      data.model = this.$common.deleteEmptyString(data.model);
      if (data.model.userName) {
        this.getCardChargeRecordByUserName(data);
      } else {
        this.httpQueryCardChargeRecordByCardNum(data);
      }
      // this.getTotal(data);
    },
    httpQueryCardChargeRecordByCardNum(data) {
      this.$businessAjax
        .getCardChargeRecordByCardNum(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
          } else {
            this.$message.warning(res.data.errorMessage);
          }
        })
        .catch(() => {});
    },
    getCardChargeRecordByUserName(data) {
      this.$businessAjax
        .getCardChargeRecordByUserName(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
          } else {
            this.$message.warning(res.data.errorMessage);
          }
        })
        .catch(() => {});
    },
    getTotal() {
      var data = {
        model: {
          endTime: this.endTime,
          beginTime: this.beginTime,
          cardNum: this.cardNum,
          userName: this.userName
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true
      };
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
    exportBtnAct() {
      var data = {
        model: {
          cardNum: null,
          endTime: this.endTime,
          startTime: this.beginTime,
          userName: this.userName
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true
      };
      // 过滤空字符串
      data.model = this.$common.deleteEmptyString(data.model);
      this.$businessAjax
        .exportCardChargeRecordExcel(data)
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
  }
};
</script>
<style>
.CardChargeRecord .el-table__fixed,
.CardChargeRecord .el-table__fixed-right {
  box-shadow: 0 0 0px rgba(0, 0, 0, 0.12);
}
.CardChargeRecord .flex-sbw-item .el-input,
.CardChargeRecord .flex-sbw-item .el-input__inner {
  width: 160px;
  height: 32px;
}
.CardChargeRecord .el-date-editor.el-input,
.CardChargeRecord .el-date-editor.el-input__inner {
  width: 190px;
}
.CardChargeRecord .el-input--suffix .el-input__inner {
  padding-right: 10px;
}
.CardChargeRecord .flex-sbw-item {
  margin-right: 5%;
}
.CardChargeRecord .el-table__body-wrapper {
  max-height: calc(100% - 100px);
  overflow: auto;
  border: 0px solid #c0c4cc;
}
.CardChargeRecord .el-table__footer-wrapper .el-table--border th,
.CardChargeRecord.el-table__footer-wrapper .el-table--border td {
  border-right: 0px solid #dcdfe6;
}
@media screen and (max-width: 1540px) {
  .CardChargeRecord .flex-sbw-item {
    margin-right: 5px !important;
  }
  .CardChargeRecord .flex-sbw-item .el-input,
  .CardChargeRecord .flex-sbw-item .el-input__inner {
    width: 120px;
    height: 32px;
  }
  .CardChargeRecord .el-date-editor.el-input,
  .CardChargeRecord .el-date-editor.el-input__inner {
    width: 180px;
  }
  .CardChargeRecord .el-input--suffix .el-input__inner {
    padding-right: 10px !important;
  }
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.CardChargeRecord {
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
      min-height: calc(100% - 200px);
    }
    .footer {
      // padding-top: 30px;
      text-align: right;
    }
  }
}
</style>
