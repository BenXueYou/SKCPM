<template>
	<el-row
		class="charegePile"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>设备管理／充电桩</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw">
				<div class="flex-sbw-div">
					<span class="topTitleTxt">运营商：</span>
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
				<div class="flex-sbw-div">
					<span class="topTitleTxt">充电站：</span>
					<el-select
						class="left-space time-interal"
						v-model="station"
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
						v-model="beginTime"
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
				<el-button type="primary" @click="addBtnAct" style="margin-bottom:10px;">新增</el-button>
				<el-button type="primary" @click="deleteBtnAct">删除</el-button>
				<el-button type="primary" @click="exportBtnAct">导出</el-button>
			</div>
			<el-table
				:data="tableData"
				@selection-change="selectionChange"
				stripe
				border
				style="width: 100%"
			>
				<el-table-column type="selection" width="55"></el-table-column>
				<el-table-column type="index" width="55" label="序号"></el-table-column>
				<el-table-column prop="cpName" label="桩名"></el-table-column>
				<el-table-column prop="cpId" label="桩ID"></el-table-column>
				<el-table-column prop="operatorName" label="运营商"></el-table-column>
				<el-table-column prop="csName" label="充电站"></el-table-column>
				<el-table-column prop="rateId" width="85" label="费率模板"></el-table-column>
				<el-table-column prop="mfrName" label="桩厂商"></el-table-column>
				<el-table-column prop="model" label="桩型号"></el-table-column>
				<el-table-column prop="gmtCreate" label="建桩日期"></el-table-column>
				<el-table-column prop="location" label="详细地址" show-overflow-tooltip></el-table-column>
				<el-table-column label="操作" width="100">
					<template slot-scope="scope">
						<el-button @click="handleClick(scope.row)" type="text" size="small">查看</el-button>
						<el-button type="text" size="small">编辑</el-button>
					</template>
				</el-table-column>
			</el-table>
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
		<charge-pile-add :isShow="isShowAddDialog" :rowData="rowData" @onCancel="close" ref="houseTable" />
	</el-row>
</template>
<script>
import ChargePileAdd from "@/components/ChargePileAdd";
export default {
  components: {
    ChargePileAdd
  },
  mounted: function() {
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.stationOptions = this.$store.state.home.chargeStationArr;
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
      station: null,
      stationOptions: [],
      operator: null,
      mainScreenLoading: false,
      rowData: null,
      tableData: window.config.tableData,
      checkedCpids: []
    };
  },
  methods: {
    // checkBox多选
    selectionChange(selection) {
      console.log(selection);
      this.checkedCpids = [];
      selection.forEach(item => {
        this.checkedCpids.push(item.cpId);
      });
    },
    initData() {
      var data = {
        model: {
          csId: this.station,
          endTime: this.endTime,
          operatorId: this.operator,
          operatorLoginId: this.$store.state.home.operatorId,
          startTime: this.beginTime
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$deviceAjax
        .getPileList(data)
        .then(res => {
          if (res.data.success) {
            this.tableData = res.data.model;
            this.total = res.data.totalCount;
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    },
    close(is) {
      this.isShowAddDialog = false;
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
    deleteBtnAct() {
      if (!this.checkedCpids) {
        this.$message.warning('请选择要删除的桩');
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
        .deletePile(this.checkedCpids)
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
      this.$deviceAjax
        .getEditOptions({ cpId: row.cpId })
        .then(res => {
          if (res.data.success) {
            this.rowData = res.data.model;
            Object.assign(this.rowData, row);
            this.isShowAddDialog = !this.isShowAddDialog;
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
.charegePile {
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
