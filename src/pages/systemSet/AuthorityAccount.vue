<template>
  <el-row
    class="AuthorityAccount"
    v-loading="mainScreenLoading"
    element-loading-background="rgba(0, 0, 0, 0.8)"
  >
    <div class="titleBox">
      位置：
      <span>账号管理</span>
    </div>
    <div class="bodyBox">
      <div class="topMenu flex-sbw" style="padding-bottom:5px">
        <div class="flex-sbw-div">
          <div class="flex-sbw">
            <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span>用户名：</span>
              <el-input v-model="userName"></el-input>
            </div>
            <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span>运营商：</span>
              <el-select
                class="left-space time-interal"
                v-model="operator"
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
            <div class="flex-sbw-div topTitleTxt flex-sbw-item">
              <span class="topTitleTxt">账户角色：</span>
              <el-select
                class="left-space time-interal"
                v-model="roleId"
                clearable
                placeholder="账户角色："
                size="small"
              >
                <el-option
                  v-for="item in accountRoleOptions"
                  :key="item.typeStr"
                  :label="item.typeName"
                  :value="item.typeStr"
                ></el-option>
              </el-select>
            </div>
            <!-- <div class="dateBox">
							<span class="topTitleTxt">时间：</span>
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
            </div>-->
          </div>
        </div>
      </div>
      <div class="topMenu" style="margin-bottom: 15px;">
        <el-button type="primary"  v-if="$store.state.home. AuthorizationID" @click="addBtnAct" style="margin:0 10px;">新增</el-button>
        <el-button type="primary" @click="queryBtnAct" style="margin:0 10px;">查询</el-button>
      </div>
      <div class="tableBox">
      <el-table :data="tableData" stripe border  style="width: 100%">
        <el-table-column type="selection" width="55"></el-table-column>
        <el-table-column type="index" width="55" label="序号"></el-table-column>
        <el-table-column prop="operatorName" label="运营商"></el-table-column>
        <el-table-column prop="userName" label="用户名"></el-table-column>
        <el-table-column prop="loginId" label="账号"></el-table-column>
        <el-table-column prop="password" label="密码"></el-table-column>
        <el-table-column prop="roleId" label="权限"></el-table-column>
        <el-table-column prop="roleDesc" label="权限描述">
          <template slot-scope="scope">{{transferRoleDesc(scope.row)}}</template>
        </el-table-column>
        <el-table-column prop="loginTime" label="最近登录时间"></el-table-column>
        <el-table-column  v-if="$store.state.home. AuthorizationID" prop="totalFee" label="操作">
          <template slot-scope="scope">
            <el-button @click="handleClick(scope.row)" type="text" size="small">编辑</el-button>
            <el-button @click="deleteBtnAct(scope.row)" type="text" size="small">删除</el-button>
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
    <authority-account-add :isShow="isShowAddDialog" :rowData="rowData" @onCancel="close" />
  </el-row>
</template>
<script>
import AuthorityAccountAdd from "@/components/AuthorityAccountAdd";
export default {
  components: {
    AuthorityAccountAdd
  },
  mounted: function() {
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.csOptions = this.$store.state.home.chargeStationArr;
    this.beginTime = this.$common.getSpaceDate(-30) + " 00:00:00";
    this.endTime = this.$common.getCurrentTime();
    this.operator = this.operatorOptions[0].operatorId;
    this.roleId = this.accountRoleOptions[0].typeStr;
    this.initData();
  },
  data: function() {
    return {
      rowData: {},
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      accountRoleOptions: [
        {
          typeStr: 0,
          typeName: "超级管理员",
          desc: "有且仅有一个，拥有一切权限"
        },
        {
          typeStr: 1,
          typeName: "系统操作员",
          desc: "浏览一切权限"
        },
        {
          typeStr: 2,
          typeName: "运营管理员",
          desc: "运营者一切权限"
        },
        {
          typeStr: 3,
          typeName: "普通操作员",
          desc: "浏览运营权限"
        }
      ],
      pageSize: 10,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      csName: null,
      userName: null,
      csOptions: [],
      operator: null,
      roleId: null,
      mainScreenLoading: false,
      tableData: window.config.tableData
    };
  },
  methods: {
    transferRoleDesc(rowData) {
      for (let i = 0; i < this.accountRoleOptions.length; i++) {
        let templateItem = this.accountRoleOptions[i];
        if (templateItem.typeStr === rowData.roleId) {
          return templateItem.desc;
        }
      }
      return "";
    },
    initData() {
      let data = {
        model: {
          roleId: this.roleId,
          userName: this.userName,
          //   endTime: this.endTime,
          operatorId: this.operator
          //   startTime: this.beginTime
        },
        pageIndex: 1,
        pageSize: 10,
        queryCount: true,
        start: 0
      };
      this.$userAjax
        .getAccountUserList(data)
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
      this.initData();
    },
    addBtnAct() {
      this.rowData = {};
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    deleteBtnAct(rowData) {
      this.$confirm("是否删除该条数据?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.deleteData(rowData);
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消删除"
          });
        });
    },
    deleteData(rowData) {
      this.$userAjax.deleteUserList({id: rowData.id}).then(res => {
        if (res.data.success) {
          this.$message({
            type: "success",
            message: "删除成功"
          });
          this.initData();
        }
      }).catch(() => {});
    },
    exportBtnAct() {},
    handleClick(row) {
      console.log(row);
      this.isShowAddDialog = !this.isShowAddDialog;
      this.rowData = row;
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
.AuthorityAccount .flex-sbw-item {
  margin: 0 35px 0 10px;
}
.AuthorityAccount .dateBox {
  margin-left: 30px;
}
.AuthorityAccount .flex-sbw-item .el-input,
.AuthorityAccount .flex-sbw-item .el-input__inner {
  width: 150px;
  height: 32px;
}
.AuthorityAccount .el-date-editor.el-input,
.AuthorityAccount .el-date-editor.el-input__inner {
  width: 180px;
}
.AuthorityAccount .el-input--suffix .el-input__inner {
  padding-right: 10px;
}

@media screen and (max-width: 1512px) {
  .AuthorityAccount .flex-sbw-item {
    margin-right: 25px !important;
  }
  .AuthorityAccount .flex-sbw-item .el-input,
  .AuthorityAccount .flex-sbw-item .el-input__inner {
    width: 120px;
    height: 32px;
  }
  .AuthorityAccount .el-input--suffix .el-input__inner {
    padding-right: 10px !important;
  }
  .AuthorityAccount .dateBox {
    margin-left: 30px !important;
  }
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.AuthorityAccount {
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
      margin-top: 30px;
      text-align: right;
    }
  }
}
</style>
