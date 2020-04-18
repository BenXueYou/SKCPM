<template>
  <el-row class="PileProductionTable"
          v-loading="mainScreenLoading"
          element-loading-background="rgba(0, 0, 0, 0.8)">
    <div class="titleBox">
      位置：
      <span>微信商城／充电桩信息</span>
    </div>
    <div v-if="!isShowAddDialog"
         class="bodyBox">
      <div class="topMenu flex-sbw"
           style="padding-bottom:5px">
        <div class="flex-sbw-div">
          <div class="flex-sbw">

            <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span>产品名称：</span>
              <el-input v-model="productionName"
                        clearable></el-input>
            </div>
            <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span>产品型号：</span>
              <el-input v-model="productionType"
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
        <el-button type="primary"
                   v-if="$store.state.home.AuthorizationID"
                   @click="deleteBtnAct"
                   style="margin:0 10px;">批量删除</el-button>
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
          <el-table-column prop="pileName"
                           label="产品名称"></el-table-column>
          <el-table-column prop="pileType"
                           label="产品型号"></el-table-column>
          <el-table-column prop="size"
                           label="轮廓尺寸"></el-table-column>
          <el-table-column prop="maxOutCurrent"
                           label="最大输出电流"></el-table-column>
          <el-table-column prop="outPower"
                           label="输出功率"></el-table-column>
          <el-table-column prop="gmtCreate"
                           label="发布时间"></el-table-column>
          <el-table-column v-if="$store.state.home.AuthorizationID"
                           label="操作">
            <template slot-scope="scope">
              <el-button @click="handleClick(scope.row)"
                         type="text"
                         size="small">编辑</el-button>
              <el-button @click="deleteBtnAct(scope.row)"
                         type="text"
                         size="small">删除</el-button>
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
    <pile-production-add v-if="isShowAddDialog"
                         @onCancel="close"
                         :rowData='rowData'
                         ref="PileProductionAdd" />
  </el-row>
</template>
<script>
import PileProductionAdd from "@/components/PileProductionAdd";
export default {
  components: {
    PileProductionAdd
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
      checkedIds: [],
      productionName: null,
      mainScreenLoading: false,
      productionType: null,
      rowData: {},
      tableData: window.config.tableData
    };
  },
  methods: {
    initData() {
      let data = {
        model: {
          endTime: this.endTime,
          pileName: this.productionName,
          pileType: this.productionType,
          startTime: this.beginTime
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.tableData = [];
      this.total = 0;
      this.$ProductionAjax
        .getPileList(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
          }
        })
        .catch(() => {});
    },
    close(is) {
      this.isShowAddDialog = !this.isShowAddDialog;
      if (is) {
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
    // checkBox多选
    selectionChange(selection) {
      console.log(selection);
      this.checkedIds = [];
      selection.forEach(item => {
        this.checkedIds.push(item.cpId);
      });
    },
    deleteBtnAct(val) {
      if (!val && this.checkedIds && !this.checkedIds.length) {
        this.$message.warning("请选择要删除的项");
        return;
      }
      this.$confirm("是否删除该条数据?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.httpDeleteAct(val);
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消删除"
          });
        });
    },
    httpDeleteAct(data) {
      this.$ProductionAjax
        .deletePile(data.id)
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
.PileProductionTable .flex-sbw-item {
  margin: 0 10px;
}
.PileProductionTable .dateBox {
  margin-left: 30px;
}
.PileProductionTable .flex-sbw-item .el-input,
.PileProductionTable .flex-sbw-item .el-input__inner {
  width: 150px;
  height: 32px;
}
.PileProductionTable .el-date-editor.el-input,
.PileProductionTable .el-date-editor.el-input__inner {
  width: 180px;
}
.PileProductionTable .el-input--suffix .el-input__inner {
  padding-right: 10px;
}

@media screen and (max-width: 1512px) {
  .PileProductionTable .flex-sbw-item {
    margin-right: 5px !important;
  }
  .PileProductionTable .flex-sbw-item .el-input,
  .PileProductionTable .flex-sbw-item .el-input__inner {
    width: 120px;
    height: 32px;
  }
  .PileProductionTable .el-input--suffix .el-input__inner {
    padding-right: 10px !important;
  }
  .PileProductionTable .dateBox {
    margin-left: 30px !important;
  }
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.PileProductionTable {
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
