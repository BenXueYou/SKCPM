<template>
	<el-row
		class="chargeFactory"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>设备管理／充电桩厂商</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw">
				<div class="flex-sbw">
					<el-button
						type="primary"
						v-if="$store.state.home.AuthorizationID"
						@click="addBtnAct"
						style="margin:0 10px;"
					>新增</el-button>
					<!-- <el-button type="primary" @click="deleteBtnAct" style="margin:0 10px;">删除</el-button> -->
					<!-- <div class="flex-sbw-div topTitleTxt" style="margin:0 10px;">
						<span>运营商：</span>
						<el-input style="width:auto" v-model="operator" clearable></el-input>
					</div>-->
					<div class="flex-sbw-div topTitleTxt" style="margin:0 10px;">
						<span>桩厂商：</span>
						<el-input style="width:auto" v-model="mfrName" clearable></el-input>
					</div>
					<div class="flex-sbw-div topTitleTxt" style="margin:0 10px;">
						<span>桩型号：</span>
						<el-input style="width:auto" v-model="model" clearable></el-input>
					</div>
				</div>
				<el-button type="primary" @click="queryBtnAct" style="margin-bottom:10px;margin-right:5%">查询</el-button>
			</div>
			<div class="tableBox">
				<el-table
					:data="tableData"
					stripe
					border
					style="width: 100%"
					@selection-change="handleSelectionChange"
				>
					<!-- <el-table-column type="selection" width="55"></el-table-column> -->
					<el-table-column type="index" width="55" label="序号"></el-table-column>
					<el-table-column prop="mfrName" label="桩厂商"></el-table-column>
					<el-table-column prop="model" label="桩型号"></el-table-column>
					<el-table-column prop="cpType" label="桩类型"></el-table-column>
					<el-table-column prop="cpPhase" label="桩相数"></el-table-column>
					<el-table-column prop="interfaceCount" label="桩枪数"></el-table-column>
					<el-table-column v-if="$store.state.home.AuthorizationID" label="操作" width="100">
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
		<charge-factory-add
			:isShow="isShowEidtDialog"
			:rowData="rowData"
			@onCancel="close"
			ref="houseTable"
		/>
	</el-row>
</template>
<script>
import ChargeFactoryAdd from "@/components/ChargeFactoryAdd";
export default {
  components: {
    ChargeFactoryAdd
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
      station: null,
      stationOptions: [],
      operator: null,
      mainScreenLoading: false,
      tableData: window.config.tableData,
      mfrName: null,
      model: null,
      rowData: null
    };
  },
  methods: {
    initData() {
      let data = {
        model: {
          mfrName: this.mfrName,
          model: this.model
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$deviceAjax
        .getPileFactoryList(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
          } else {
          }
        })
        .catch(() => {});
    },
    deleteData(data) {
      this.$deviceAjax
        .deletePileFactory({ id: data.id })
        .then(res => {
          if (res.data.success) {
            this.$message({ type: "success", message: "删除成功" });
            this.initData();
            this.$bus.$emit("getPileFactoryList");
          } else {
            this.$message({ type: "error", message: res.data.errorMessage });
          }
        })
        .catch(() => {});
    },

    close(is) {
      this.isShowEidtDialog = !this.isShowEidtDialog;
      if (is) {
        this.currentPage = 1;
        this.initData();
        this.$bus.$emit("getPileFactoryList");
      }
    },
    queryBtnAct() {
      this.currentPage = 1;
      this.initData();
    },
    addBtnAct() {
      this.rowData = {};
      this.isShowEidtDialog = !this.isShowEidtDialog;
    },
    deleteBtnAct(data) {
      this.$confirm("是否删除该条数据?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.deleteData(data);
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消删除"
          });
        });
    },
    exportBtnAct() {},
    handleSelectionChange(arr) {
      console.log(arr);
    },
    handleClick(row) {
      this.$deviceAjax
        .editPileFactoryOptions({ id: row.id })
        .then(res => {
          if (res.data.success) {
            this.rowData = res.data.model;
            this.isShowEidtDialog = !this.isShowEidtDialog;
          } else {
            this.$message.warning(res.data.errMsg);
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
.chargeFactory {
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
			min-height: calc(100% - 100px);
		}
		.footer {
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
