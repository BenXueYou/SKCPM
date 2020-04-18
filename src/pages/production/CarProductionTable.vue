<template>
  <el-row class="CarProductionTable"
          v-loading="mainScreenLoading"
          element-loading-background="rgba(0, 0, 0, 0.8)">
    <div class="titleBox">
      位置：
      <span>微信商城／车辆信息</span>
    </div>
    <div v-if="!isShowAddDialog"
         class="bodyBox">
      <div class="topMenu flex-sbw"
           style="padding-bottom:5px">
        <div class="flex-sbw-div">
          <div class="flex-sbw">
            <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span>车类型：</span>
              <el-input v-model="carType"
                        clearable></el-input>
            </div>
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
          <!-- <el-table-column type="selection"
                           width="55"></el-table-column> -->
          <el-table-column type="index"
                           width="55"
                           label="序号"></el-table-column>
          <el-table-column prop="carType"
                           label="车型"></el-table-column>
          <el-table-column prop="carEnergyType"
                           label="类型"></el-table-column>
          <el-table-column prop="ratedNum"
                           label="额定成员"></el-table-column>
          <el-table-column prop="ratedChair"
                           label="乘客座椅数"></el-table-column>
          <el-table-column prop="carVolume"
                           label="容积"></el-table-column>
          <el-table-column prop="gmtCreate"
                           label="发布日期"></el-table-column>
          <el-table-column v-if="$store.state.home.AuthorizationID"
                           label="操作">
            <template slot-scope="scope">
              <el-button v-if="$store.state.home.AuthorizationID"
                         @click="handleClick(scope.row)"
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
    <prodution-car-add v-if="isShowAddDialog"
                       @onCancel="close"
                       :rowData='rowData'
                       ref="ProdutionCarAdd" />
  </el-row>
</template>
<script>
import ProdutionCarAdd from "@/components/ProdutionCarAdd";
export default {
  components: {
    ProdutionCarAdd
  },
  mounted: function() {
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
      carType: null,
      mainScreenLoading: false,
      carModel: null,
      rowData: {},
      checkedIds: [],
      tableData: window.config.tableData
    };
  },
  methods: {
    close(is) {
      this.rowData = {};
      this.isShowAddDialog = !this.isShowAddDialog;
      if (is) {
        this.initData();
      }
    },
    initData() {
      let data = {
        model: {},
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.tableData = [];
      this.total = 0;
      this.$ProductionAjax
        .getCarList(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
          }
        })
        .catch(() => {});
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
      if (!data && this.checkedIds && !this.checkedIds.length) {
        this.$message.warning("请选择要删除的项");
        return;
      }
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
    },
    httpDeleteAct(data) {
      this.$ProductionAjax
        .deleteCar(data.id)
        .then(res => {
          if (res.data.success) {
            this.currentPage = 1;
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
    selectionChange(selection) {
      console.log(selection);
      this.checkedIds = [];
      selection.forEach(item => {
        this.checkedIds.push(item.id);
      });
    },
    handleCurrentChange(val) {
      console.log("页数发生变化：", val);
      this.currentPage = val;
      this.initData();
    },
    handleSizeChange(val) {
      console.log("每页条数发生变化：", val);
      this.pageSize = val;
    }
  },
  watch: {}
};
</script>
<style>
.CarProductionTable .flex-sbw-item {
  margin: 0 10px;
}
.CarProductionTable .dateBox {
  margin-left: 30px;
}
.CarProductionTable .flex-sbw-item .el-input,
.CarProductionTable .flex-sbw-item .el-input__inner {
  width: 150px;
  height: 32px;
}
.CarProductionTable .el-date-editor.el-input,
.CarProductionTable .el-date-editor.el-input__inner {
  width: 180px;
}
.CarProductionTable .el-input--suffix .el-input__inner {
  padding-right: 10px;
}

@media screen and (max-width: 1512px) {
  .CarProductionTable .flex-sbw-item {
    margin-right: 5px !important;
  }
  .CarProductionTable .flex-sbw-item .el-input,
  .CarProductionTable .flex-sbw-item .el-input__inner {
    width: 120px;
    height: 32px;
  }
  .CarProductionTable .el-input--suffix .el-input__inner {
    padding-right: 10px !important;
  }
  .CarProductionTable .dateBox {
    margin-left: 30px !important;
  }
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.CarProductionTable {
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
