<template>
  <el-row class="RentProductionTable"
          v-loading="mainScreenLoading"
          element-loading-background="rgba(0, 0, 0, 0.8)">
    <div class="titleBox">
      位置：
      <span>微信商城／租赁方案</span>
    </div>
    <div v-if="!isShowAddDialog"
         class="bodyBox">
      <div class="topMenu flex-sbw"
           style="padding-bottom:5px">
        <div class="flex-sbw-div">
          <div class="flex-sbw">
            <!-- <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span>租赁人：</span>
              <el-input v-model="userName"
                        clearable></el-input>
            </div>
            <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span>电话号码：</span>
              <el-input v-model="phoneNumber"
                        clearable></el-input>
            </div> -->
            <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span>车型号：</span>
              <el-input v-model="carModel"
                        clearable></el-input>
            </div>
            <div class="dateBox">
              <span class="topTitleTxt">发布时间：</span>
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
      <div class="topMenu"
           style="margin-bottom: 15px;">
        <el-button type="primary"
                   v-if="$store.state.home.AuthorizationID"
                   @click="addBtnAct"
                   style="margin:0 10px;">新增</el-button>
        <!-- <el-button type="primary"
                   v-if="$store.state.home.AuthorizationID"
                   @click="deleteBtnAct"
                   style="margin:0 10px;">批量删除</el-button> -->
        <el-button type="primary"
                   @click="queryBtnAct"
                   style="margin:0 10px;">查询</el-button>
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
          <el-table-column prop="carType"
                           label="车型"></el-table-column>
          <el-table-column prop="carPrice"
                           label="售价（万元）"></el-table-column>
          <el-table-column prop="gmtCreate"
                           label="发布时间"></el-table-column>
          <el-table-column v-if="$store.state.home.AuthorizationID"
                           label="操作">
            <template slot-scope="scope">
              <el-button @click="handleClick(scope.row)"
                         type="text"
                         size="small">编辑</el-button>
              <el-button type="text"
                         v-if="$store.state.home.AuthorizationID"
                         @click="deleteBtnAct(scope.row)"
                         style="margin:0 10px;">删除</el-button>
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
    <rent-add v-else
              :rowData='rowData'
              @onCancel="close()"
              ref="houseTable" />
  </el-row>
</template>
<script>
import RentAdd from "@/components/RentAdd";
export default {
  components: {
    RentAdd
  },
  mounted: function() {
    this.beginTime = this.$common.getSpaceDate(-360) + " 00:00:00";
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
      carModel: null,
      rowData: {},
      tableData: window.config.tableData
    };
  },
  methods: {
    initData() {
      let data = {
        model: {
          carType: this.carModel,
          endTime: this.endTime,
          startTime: this.startTime
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.total = 0;
      this.tableData = [];
      this.$ProductionAjax
        .getRentList(data)
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
      this.rowData = {};
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    deleteBtnAct(data) {
      if (data) {
        this.$confirm("是否删除该条数据?", "提示", {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning"
        })
          .then(() => {
            this.httpDeleteAct(data);
          })
          .catch(() => {
            this.$message({
              type: "info",
              message: "已取消删除"
            });
          });
      }
    },
    httpDeleteAct(data) {
      this.$ProductionAjax
        .deleteRent(data)
        .then(res => {
          if (res.data.success) {
            this.$message({ type: "success", messge: "删除成功" });
            this.initData();
          }
        })
        .catch(() => {});
    },
    exportBtnAct() {},
    handleClick(row) {
      console.log(row);
      this.rowData = row;
      this.$ProductionAjax
        .detailRent({ id: row.id })
        .then(res => {
          if (res.data.success) {
            this.rowData = res.data.model;
          }
        })
        .catch(() => {});
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
.RentProductionTable .flex-sbw-item {
  margin: 0 10px;
}
.RentProductionTable .dateBox {
  margin-left: 30px;
}
.RentProductionTable .flex-sbw-item .el-input,
.RentProductionTable .flex-sbw-item .el-input__inner {
  width: 150px;
  height: 32px;
}
.RentProductionTable .el-date-editor.el-input,
.RentProductionTable .el-date-editor.el-input__inner {
  width: 180px;
}
.RentProductionTable .el-input--suffix .el-input__inner {
  padding-right: 10px;
}

@media screen and (max-width: 1512px) {
  .RentProductionTable .flex-sbw-item {
    margin-right: 5px !important;
  }
  .RentProductionTable .flex-sbw-item .el-input,
  .RentProductionTable .flex-sbw-item .el-input__inner {
    width: 120px;
    height: 32px;
  }
  .RentProductionTable .el-input--suffix .el-input__inner {
    padding-right: 10px !important;
  }
  .RentProductionTable .dateBox {
    margin-left: 30px !important;
  }
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.RentProductionTable {
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
