<template>
	<el-row
		class="chargeStation"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>设备管理／充电站</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw">
				<div class="flex-sbw-div">
					<span class="topTitleTxt">运营商：</span>
					<el-select
						class="left-space time-interal"
						v-model="queryModel.operatorId"
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
				<div class="flex-sbw-div">
					<span class="topTitleTxt">充电站：</span>
					<el-select
						class="left-space time-interal"
						v-model="queryModel.csId"
						clearable
						placeholder="充电站"
						size="small"
					>
						<el-option
							v-for="item in stationOptions"
							:key="item.csId"
							:label="item.csName"
							:value="item.csId"
						></el-option>
					</el-select>
				</div>
				<div class="flex-sbw-div">
					<span class="topTitleTxt">时间：</span>
					<el-date-picker
						v-model="startTime"
						type="datetime"
						class="time-interal-date"
						size="small"
						placeholder="选择日期"
						value-format="yyyy-MM-dd HH:mm:ss"
					></el-date-picker>
					<span class="time-line"></span>
					<el-date-picker
						v-model="endTime"
						type="datetime"
						class="time-interal-date"
						placeholder="选择日期"
						size="small"
						value-format="yyyy-MM-dd HH:mm:ss"
					></el-date-picker>
				</div>
				<el-button type="mini" @click="queryBtnAct">查询</el-button>
			</div>
			<div class="topMenu">
				<el-button
					type="primary"
					v-if="$store.state.home.AuthorizationID"
					@click="addBtnAct"
					style="margin-bottom:10px;"
				>新增</el-button>
				<el-button type="primary" v-if="$store.state.home.AuthorizationID" @click="deleteBtnAct">删除</el-button>
				<el-button type="primary" v-if="$store.state.home.AuthorizationID" @click="exportBtnAct">导出</el-button>
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
					<el-table-column prop="csName" label="充电站"></el-table-column>
					<el-table-column prop="operatorName" width="180" label="运营商"></el-table-column>
					<el-table-column prop="openTime" width="120" label="开放时间"></el-table-column>
					<el-table-column prop="location" show-overflow-tooltip label="地址"></el-table-column>
					<el-table-column prop="gmtCreate" label="建站日期"></el-table-column>
					<el-table-column label="操作">
						<template slot-scope="scope">
							<!-- <el-button @click="handleClick(scope.row)" type="text" size="small">查看</el-button> -->
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
		<charge-station-add
			:isShow="isShowAddDialog"
			:rowData="rowData"
			@onCancel="close"
			ref="houseTable"
		/>
	</el-row>
</template>
<script>
import ChargeStationAdd from "@/components/ChargeStationAdd";
export default {
  components: {
    ChargeStationAdd
  },
  mounted: function() {
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.stationOptions = this.$store.state.home.chargeStationArr;
    this.initData();
  },
  data: function() {
    return {
      queryModel: {
        addressId: null,
        area: null,
        areaId: null,
        city: null,
        cityId: null,
        csId: null,
        csName: null,
        endTime: null,
        location: null,
        openTime: null,
        operatorId: null,
        parkFee: null,
        property: null,
        province: null,
        provinceId: null,
        startTime: null,
        validFlag: null
      },
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 10,
      currentPage: 1,
      total: 10,
      startTime: null,
      endTime: null,
      operatorOptions: [],
      station: null,
      stationOptions: [],
      operator: null,
      mainScreenLoading: false,
      tableData: window.config.tableData,
      rowData: {},
      checkedCSids: []
    };
  },
  methods: {
    close(is) {
      this.isShowAddDialog = !this.isShowAddDialog;
      if (is) {
        this.$bus.$emit("getChargeStationList");
        this.initData();
      }
    },
    queryBtnAct() {
      this.currentPage = 1;
      this.initData();
    },
    addBtnAct() {
      this.isShowAddDialog = !this.isShowAddDialog;
      this.rowData = {};
    },
    initData() {
      this.queryModel.startTime = this.startTime;
      this.queryModel.endTime = this.endTime;
      var data = {
        model: this.queryModel,
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$deviceAjax
        .getChargeStationList(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
            this.$bus.$emit("getChargeStationList");
          }
        })
        .catch(() => {});
    },
    deleteBtnAct() {
      if (!this.checkedCSids.length) {
        this.$message.warning("请选择充电站");
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
      this.$deviceAjax
        .deleteChargeStation(this.checkedCSids)
        .then(res => {
          if (res.data && res.data.succcess) {
            this.$message({ type: "success", message: "删除成功！" });
            this.initData();
          } else {
            this.$message({ type: "error", message: "删除失败" });
          }
        })
        .catch(() => {});
    },
    exportBtnAct() {},
    handleClick(row) {
      console.log(row);
      this.$deviceAjax
        .editChargeStationOptions(row.csId)
        .then(res => {
          if (res.data.success) {
            this.rowData = res.data.model;
            this.isShowAddDialog = !this.isShowAddDialog;
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
    // checkBox多选
    selectionChange(selection) {
      console.log(selection);
      this.checkedCSids = [];
      selection.forEach(item => {
        this.checkedCSids.push(item.csId);
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
      this.initData();
    }
  },
  watch: {}
};
</script>
<style lang='scss' scoped>
@import "@/style/variables.scss";
.chargeStation {
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
		// .tableBox {
		// 	height: calc(100% - 100px);
		// }
		.footer {
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
