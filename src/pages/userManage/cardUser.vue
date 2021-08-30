<template>
  <el-row class="CardUser"
          v-loading="mainScreenLoading"
          element-loading-background="rgba(0, 0, 0, 0.8)">
    <div v-if="!showCardChargRecord"
         class="titleBox">
      位置：
      <span>用户管理／充电卡管理</span>
    </div>
    <div v-if="!showCardChargRecord"
         class="bodyBox">
      <div class="topMenu"
           style="padding-bottom:10px">
        <div class="flex-st">
          <div class="flex-sbw-div topTitleTxt flex-sbw-item">
            <span>卡号：</span>
            <el-input v-model="cardNum"
                      clearable></el-input>
          </div>
          <div class="flex-sbw-div topTitleTxt flex-sbw-item">
            <span>用户名：</span>
            <el-input v-model="userName"
                      clearable></el-input>
          </div>
          <div class="flex-sbw-div topTitleTxt flex-sbw-item">
            <div class="dateBox">
              <span class="topTitleTxt">开卡时间：</span>
              <el-date-picker v-model="beginTime"
                              type="datetime"
                              class="time-interal-date"
                              size="small"
                              placeholder="选择日期"
                              value-format="yyyy-MM-dd HH:mm:ss"></el-date-picker>
              <span class="time-line">—</span>
              <el-date-picker v-model="endTime"
                              type="datetime"
                              class="time-interal-date"
                              placeholder="选择日期"
                              size="small"
                              value-format="yyyy-MM-dd HH:mm:ss"></el-date-picker>
            </div>
          </div>
        </div>
      </div>
      <div class="topMenu flex-st"
           style="margin-bottom: 5px;">
        <el-button type="primary"
                   v-if="$store.state.home.AuthorizationID"
                   @click="addBtnAct"
                   style="margin:-5px 10px 0">新增</el-button>
        <el-button type="primary"
                   @click="queryBtnAct"
                   style="margin:-5px 10px 0">查询</el-button>
      </div>
      <div class="tableBox">
        <el-table :data="tableData"
                  stripe
                  border
                  style="width: 100%">
          <el-table-column type="selection"
                           width="55"></el-table-column>
          <el-table-column type="index"
                           width="55"
                           label="序号"></el-table-column>
          <el-table-column prop="cardNum"
                           label="卡号"
                           width="180">
            <template slot-scope="scope">
              <el-button @click="JumpToAct(scope.row.cardNum,'cardNum')"
                         type="text">{{scope.row.cardNum}}</el-button>
            </template>
          </el-table-column>
          <el-table-column prop="userName"
                           label="用户名"
                           width="160">
            <template slot-scope="scope">
              <el-button @click="JumpToAct(scope.row.userName,'userName')"
                         type="text">{{scope.row.userName}}</el-button>
            </template>
          </el-table-column>
          <el-table-column prop="telephone"
                           label="联系电话"
                           width="160"></el-table-column>
          <el-table-column prop="plateNumbers"
                           label="车牌号"
                           width="160"></el-table-column>
          <el-table-column prop="balance"
                           label="余额"
                           width="100"></el-table-column>
          <!-- <el-table-column prop="openCardUser"
                           label="运营商"
                           width="120"></el-table-column> -->
          <el-table-column prop="openCardUser"
                           label="开卡人"
                           width="120"></el-table-column>
          <el-table-column prop="gmtCreate"
                           label="开卡时间"
                           width="180"></el-table-column>
          <el-table-column prop="gmtModify"
                           label="变更时间"
                           width="180"></el-table-column>
          <el-table-column label="操作">
            <template slot-scope="scope">
              <el-button @click="handleClick(scope.row)"
                         type="text"
                         size="small">编辑</el-button>
              <el-button style="color:#ff5f5f"
                         @click="forbidBtnAct(scope.row)"
                         type="text"
                         size="small">
                {{
								scope.row.isDeleted?'已禁用':'禁用'}}
              </el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <div class="footer">
        <el-pagination @size-change="handleSizeChange"
                       @current-change="handleCurrentChange"
                       :current-page="currentPage"
                       :page-sizes="pageSizeArr"
                       :page-size="pageSize"
                       layout="total, sizes, prev, pager, next, jumper"
                       :total="total"></el-pagination>
      </div>
    </div>
    <card-user-detail :visible.sync="isShowAddDialog"
                      :rowData="rowData"
                      @onCancel="close"
                      ref="houseTable" />

    <card-charge-record v-if="showCardChargRecord"
                        @back="cardUser={},showCardChargRecord=!showCardChargRecord"
                        :showCardChargRecord="showCardChargRecord"
                        :cardUser="cardUser"></card-charge-record>
  </el-row>
</template>
<script>
import CardUserDetail from "@/components/CardUserEdit";
import CardChargeRecord from "@/pages/businessRecord/CardChargeRecord";
export default {
  components: {
    CardUserDetail,
    CardChargeRecord
  },
  mounted: function() {
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.stationOptions = this.$store.state.home.chargeStationArr;
    // this.beginTime = this.$common.getSpaceDate(-30) + " 00:00:00";
    this.endTime = this.$common.getCurrentTime();
    this.initData();
  },
  data: function() {
    return {
      showCardChargRecord: false,
      cardUser: {},
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
      tableData: [],
      cardNum: null,
      userName: null,
      phoneNumber: null,
      chargeMethodId: null,
      rowData: {}
    };
  },
  methods: {
    JumpToAct(val, key) {
      this.cardUser[key] = val;
      this.showCardChargRecord = true;
    },
    forbidBtnAct(rowData) {
      if (rowData.isDeleted) {
        this.$message({ type: "warning", message: "已经禁用" });
        return;
      }
      this.$userAjax
        .deleteCardUser({ id: rowData.id })
        .then(res => {
          if (res.data.success) {
            this.$message({ type: "success", message: "禁用成功" });
            this.endTime = this.$common.getCurrentTime();
            this.initData();
          }
        })
        .catch(() => {});
    },
    close(is) {
      this.isShowAddDialog = !this.isShowAddDialog;
      if (is) {
        this.endTime = this.$common.getCurrentTime();
        this.initData();
      }
    },
    queryBtnAct() {
      this.currentPage = 1;
      this.initData();
    },
    addBtnAct() {
      this.rowData = {};
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    initData() {
      var data = {
        model: {
          cardNum: this.cardNum,
          endTime: this.endTime,
          startTime: this.beginTime,
          operatorId: this.operatorId,
          telephone: this.phoneNumber,
          userName: this.userName
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$userAjax
        .getCardUserList(data)
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
    getTotal(data) {
      this.$businessAjax
        .getCardUserTotal(data)
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
    exportBtnAct() {},
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
.CardUser .flex-sbw-item .el-input,
.CardUser .flex-sbw-item .el-input__inner {
  width: 160px;
  height: 32px;
}
.CardUser .flex-sbw-item .el-date-editor.el-input,
.CardUser .flex-sbw-item .el-date-editor .el-input__inner {
  width: 190px;
}
.CardUser .el-input--suffix .el-input__inner {
  padding-right: 10px;
}

@media screen and (max-width: 1540px) {
  .CardUser .flex-sbw-item {
    margin-right: 25px !important;
  }
  .CardUser .flex-sbw-item .el-input,
  .CardUser .flex-sbw-item .el-input__inner {
    width: 120px;
    height: 32px;
  }
  .CardUser .flex-sbw-item .el-date-editor.el-input,
  .CardUser .flex-sbw-item .el-date-editor .el-input__inner {
    width: 180px;
  }
  .CardUser .el-input--suffix .el-input__inner {
    padding-right: 10px !important;
  }
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.CardUser {
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
        margin-right: 45px;
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
      min-height: calc(100% - 150px);
    }
    .footer {
      // padding-top: 30px;
      text-align: right;
    }
  }
}
</style>
