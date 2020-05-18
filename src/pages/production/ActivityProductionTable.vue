<template>
  <el-row class="ActivityProductionTable"
          v-loading="mainScreenLoading"
          element-loading-background="rgba(0, 0, 0, 0.8)">
    <div class="titleBox">
      位置：
      <span>微信商城／优惠活动信息</span>
    </div>
    <div v-if="!isShowAddDialog"
         class="bodyBox">
      <div class="topMenu flex-sbw"
           style="padding-bottom:5px">
        <div class="flex-sbw-div">
          <div class="flex-sbw">
            <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span>活动主题：</span>
              <el-input v-model="themeTitle"
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
          <el-table-column prop="title"
                           label="主题"></el-table-column>
          <el-table-column prop="zip"
                           label="有效日期">
            <template slot-scope="scope">
              {{scope.row.startTime}}—{{scope.row.endTime}}
            </template>
          </el-table-column>
          <el-table-column prop="gmtCreate"
                           label="发布日期"></el-table-column>
          <el-table-column label="操作">
            <template slot-scope="scope">
              <el-button @click="handleClick(scope.row)"
                         type="text"
                         size="small">编辑</el-button>
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
    <div v-if="isShowAddDialog"
         style="width:80%;height:80%;margin:30px auto">
      <el-form ref="form"
               :model="form"
               label-width="80px">
        <el-form-item label="活动名称">
          <el-input v-model="form.name"
                    clearable></el-input>
        </el-form-item>
        <el-form-item label="活动时间">
          <el-col :span="11">
            <el-date-picker style="width: 100%;"
                            v-model="form.beginTime"
                            type="datetime"
                            class="time-interal-date"
                            size="small"
                            placeholder="选择日期"
                            value-format="yyyy-MM-dd HH:mm:ss"></el-date-picker>
            <!-- <el-date-picker type="date" placeholder="选择日期" v-model="form.date1" style="width: 100%;"></el-date-picker> -->
          </el-col>
          <el-col class="line"
                  :span="2">————</el-col>
          <el-col :span="11">
            <el-date-picker style="width: 100%;"
                            v-model="form.endTime"
                            type="datetime"
                            class="time-interal-date"
                            size="small"
                            placeholder="选择日期"
                            value-format="yyyy-MM-dd HH:mm:ss"></el-date-picker>
          </el-col>
        </el-form-item>
        <el-form-item label="活动形式"
                      style="height:65vh;">
          <vue-ueditor-wrap style="height:80%;"
                            v-model="form.msg"
                            :config="myConfig"></vue-ueditor-wrap>
        </el-form-item>
        <el-form-item>
          <el-button type="primary"
                     @click="onSubmit">立即创建</el-button>
          <el-button @click="close">取消</el-button>
        </el-form-item>
      </el-form>
    </div>
  </el-row>
</template>
<script>
// import ActivityProductionTableAdd from "@/components/ActivityProductionTableAdd";
export default {
  components: {
    // ActivityProductionTableAdd
  },
  mounted: function() {
    this.beginTime = this.$common.getSpaceDate(-360) + " 00:00:00";
    this.endTime = this.$common.getCurrentTime();
    this.initData();
  },
  data: function() {
    return {
      msg: "",
      form: {
        name: "",
        beginTime: "",
        endTime: "",
        msg: ""
      },
      myConfig: window.config.vueUedutorWrap,
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
      themeTitle: null,
      tableData: window.config.tableData
    };
  },
  methods: {
    onSubmit() {
      console.log(this.form);
    },
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    initData() {
      let data = {
        model: {
          endTime: this.endTime,
          startTime: this.beginTime,
          title: this.themeTitle
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$ProductionAjax
        .getActivityList(data)
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
.ActivityProductionTable .edui-default .edui-editor-iframeholder {
  min-height: 50vh;
}
.ActivityProductionTable .flex-sbw-item {
  margin: 0 10px;
}
.ActivityProductionTable .dateBox {
  margin-left: 30px;
}
.ActivityProductionTable .flex-sbw-item .el-input,
.ActivityProductionTable .flex-sbw-item .el-input__inner {
  width: 150px;
  height: 32px;
}
.ActivityProductionTable .el-date-editor.el-input,
.ActivityProductionTable .el-date-editor.el-input__inner {
  width: 180px;
}
.ActivityProductionTable .el-input--suffix .el-input__inner {
  padding-right: 10px;
}

@media screen and (max-width: 1512px) {
  .ActivityProductionTable .flex-sbw-item {
    margin-right: 5px !important;
  }
  .ActivityProductionTable .flex-sbw-item .el-input,
  .ActivityProductionTable .flex-sbw-item .el-input__inner {
    width: 120px;
    height: 32px;
  }
  .ActivityProductionTable .el-input--suffix .el-input__inner {
    padding-right: 10px !important;
  }
  .ActivityProductionTable .dateBox {
    margin-left: 30px !important;
  }
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.ActivityProductionTable {
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
