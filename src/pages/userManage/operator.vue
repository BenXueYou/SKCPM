<template>
	<el-row
		class="chargePileOperator"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>用户管理／运营商</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw">
				<div class="flex-sbw">
					<el-button type="primary" @click="addBtnAct" style="margin:0 10px;">新增</el-button>
					<el-button type="primary" @click="deleteBtnAct" style="margin:0 10px;">删除</el-button>
					<div class="flex-sbw-div topTitleTxt" style="margin:0 10px 0 30px;">
						<span>运营商：</span>
						<el-input style="width:auto" v-model="operator"></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt" style="margin:0 10px;">
						<span>联系电话：</span>
						<el-input style="width:auto" v-model="phoneNumber"></el-input>
					</div>
				</div>
				<el-button type="primary" @click="queryBtnAct" style="margin-bottom:10px;margin-right:5%">查询</el-button>
			</div>
			<div class="tableBox">
				<el-table
					:data="tableData"
					@selection-change="selectionChange"
					stripe
					border
					style="width: 100%"
				>
					<el-table-column type="selection" width="55"></el-table-column>
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="operatorName" label="运营商" width="150"></el-table-column>
					<el-table-column prop="contactName" label="联系人" width="150"></el-table-column>
					<el-table-column prop="telephone" label="联系电话" width="180"></el-table-column>
					<el-table-column prop="email" label="邮箱" width="180"></el-table-column>
					<el-table-column prop="address" show-overflow-tooltip label="地址"></el-table-column>
					<el-table-column label="操作">
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
		<charge-pile-operator-add
			:isShow="isShowEidtDialog"
			:rowData="rowData"
			@onCancel="close"
			ref="houseTable"
		/>
	</el-row>
</template>
<script>
import chargePileOperatorAdd from "@/components/chargePileOperatorAdd";
export default {
  components: {
    chargePileOperatorAdd
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
      phoneNumber: null,
      stationOptions: [],
      operator: null,
      mainScreenLoading: false,
      tableData: window.config.tableData,
      rowData: {},
      operatorIds: []
    };
  },
  methods: {
    // checkBox多选
    selectionChange(selection) {
      console.log(selection);
      this.operatorIds = [];
      selection.forEach(item => {
        this.operatorIds.push(item.operatorId);
      });
    },
    close(is) {
      this.isShowEidtDialog = !this.isShowEidtDialog;
      if (is) {
        this.$bus.$emit("getOperatorList");
        this.initData();
      }
    },
    initData() {
      let data = {
        model: {
          operatorName: this.operator,
          telephone: this.phoneNumber
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$userAjax
        .getOperatorListByPage(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
            this.$bus.$emit("getOperatorList");
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
      if (!this.operatorIds.length) {
        this.$message.warning("请选择要删除的运营商");
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
      this.$userAjax
        .deleteOperator(this.operatorIds)
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
      this.$userAjax
        .editOperatorOptions({ operatorId: row.operatorId })
        .then(res => {
          if (res.data.success) {
            this.isShowEidtDialog = !this.isShowEidtDialog;
            this.rowData = res.data.model;
          } else {
            this.$message.wraning("请求数据失败");
          }
        })
        .catch(() => {});
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
.chargePileOperator {
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
		.tableBox {
			height: calc(100% - 100px);
		}
		.footer {
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
