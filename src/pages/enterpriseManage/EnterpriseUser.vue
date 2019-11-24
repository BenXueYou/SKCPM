<template>
	<el-row
		class="EnterpriseUser"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>企业用户／企业管理</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw">
				<div class="flex-sbw">
					<el-button type="primary"  v-if="$store.state.home. AuthorizationID" @click="addBtnAct" style="margin:0 10px;">新增</el-button>
					<el-button type="primary"  v-if="$store.state.home. AuthorizationID" @click="deleteBtnAct" style="margin:0 10px;">删除</el-button>
					<div class="flex-sbw-div topTitleTxt" style="margin:0 10px 0 30px;">
						<span>企业名称：</span>
						<el-input style="width:auto" v-model="operator"></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt" style="margin:0 10px;">
						<span>联系电话：</span>
						<el-input style="width:auto" v-model="telephone"></el-input>
					</div>
				</div>
				<el-button type="primary" @click="queryBtnAct" style="margin-bottom:10px;margin-right:5%">查询</el-button>
			</div>
      <div class="tableBox">
			<el-table
				:data="tableData"
				@selection-change="selectionChange"
stripe border
				style="width: 100%"
			>
				<el-table-column type="selection" width="55"></el-table-column>
				<el-table-column type="index" width="55" label="序号"></el-table-column>
				<el-table-column prop="companyName" label="企业名称" show-overflow-tooltip></el-table-column>
				<el-table-column prop="contactName" label="联系人" width="150"></el-table-column>
				<el-table-column prop="telephone" label="联系电话" show-overflow-tooltip></el-table-column>
				<el-table-column prop="account" label="账号" show-overflow-tooltip></el-table-column>
				<el-table-column prop="balance" show-overflow-tooltip label="余额"></el-table-column>
				<el-table-column prop="companyAddress" show-overflow-tooltip label="地址"></el-table-column>
				<el-table-column  v-if="$store.state.home. AuthorizationID" label="操作">
					<template slot-scope="scope">
						<el-button @click="handleClick(scope.row)" type="text" size="small">编辑</el-button>
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
		<enterprise-user-add
			:isShow="isShowEidtDialog"
			:rowData="rowData"
			@onCancel="close"
			ref="houseTable"
		/>
	</el-row>
</template>
<script>
import EnterpriseUserAdd from "@/components/EnterpriseUserAdd";
export default {
  components: {
    EnterpriseUserAdd
  },
  mounted: function() {
    this.initData();
  },
  data: function() {
    return {
      isShowEidtDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 10,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      telephone: null,
      stationOptions: [],
      operator: null,
      mainScreenLoading: false,
      tableData: window.config.tableData,
      rowData: {},
      enterpriseUserIds: []
    };
  },
  methods: {
    // checkBox多选
    selectionChange(selection) {
      console.log(selection);
      this.enterpriseUserIds = [];
      selection.forEach(item => {
        this.enterpriseUserIds.push(item.id);
      });
    },
    close(is) {
      this.isShowEidtDialog = !this.isShowEidtDialog;
      if (is) {
        // this.$bus.$emit("getOperatorList");
        this.initData();
      }
    },
    initData() {
      let data = {
        model: {
          companyName: this.operator,
          telephone: this.telephone
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$EnterpriseAjax
        .getEnterPriseUserApi(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.$store.dispatch('setEnterpriseUser', this.tableData);
            this.total = res.data.totalCount;
          } else {
            this.$message.wraning("请求失败");
          }
        })
        .catch(() => {});
    },
    queryBtnAct() {
      this.initData();
    },
    addBtnAct() {
      this.rowData = {};
      this.isShowEidtDialog = !this.isShowEidtDialog;
    },
    deleteBtnAct() {
      if (!this.enterpriseUserIds.length) {
        this.$message.warning("请选择要删除的企业名称");
        return;
      }
      this.$confirm("是否删除该条数据?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.deleteData();
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消删除"
          });
        });
    },
    deleteData() {
      this.$EnterpriseAjax
        .deleteEnterPriseUserApi(this.enterpriseUserIds)
        .then(res => {
          if (res.data.success) {
            this.initData();
            this.$message.success(res.data.errMsg);
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
    exportBtnAct() {},
    handleClick(row) {
      console.log(row);
      this.isShowEidtDialog = !this.isShowEidtDialog;
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
<style lang='scss' scoped>
@import "@/style/variables.scss";
.EnterpriseUser {
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
    .tableBox{
			height: calc(100% - 100px);
		}
		.footer {
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
