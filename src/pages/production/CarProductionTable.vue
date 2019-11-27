<template>
	<el-row
		class="CarProductionTable"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>微信商城／车辆信息</span>
		</div>
		<div  v-if="!isShowAddDialog" class="bodyBox">
			<div class="topMenu flex-sbw" style="padding-bottom:5px">
				<div class="flex-sbw-div">
					<div class="flex-sbw">
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>车类型：</span>
							<el-input v-model="carType"></el-input>
						</div>
						<div class="flex-sbw-div topTitleTxt flex-sbw-item">
							<span>车型号：</span>
							<el-input v-model="carModel"></el-input>
						</div>
						<div class="dateBox">
							<span class="topTitleTxt">发布时间：</span>
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
						</div>
					</div>
				</div>
			</div>
			<div class="topMenu" style="margin-bottom: 15px;">
				<el-button type="primary"  v-if="$store.state.home. AuthorizationID" @click="addBtnAct" style="margin:0 10px;">新增</el-button>
				<el-button type="primary"  v-if="$store.state.home. AuthorizationID" @click="deleteBtnAct" style="margin:0 10px;">批量删除</el-button>
				<el-button type="primary" @click="queryBtnAct" style="margin:0 10px;">查询</el-button>
			</div>
			<div class="tableBox">
			<el-table :data="tableData" stripe border  style="width: 100%">
				<el-table-column type="selection" width="55"></el-table-column>
				<el-table-column type="index" width="55" label="序号"></el-table-column>
				<el-table-column prop="date" label="车型"></el-table-column>
				<el-table-column prop="name" label="类型"></el-table-column>
				<el-table-column prop="province" label="额定成员"></el-table-column>
				<el-table-column prop="city" label="乘客座椅数"></el-table-column>
				<el-table-column prop="city" label="容积"></el-table-column>
				<el-table-column prop="zip" label="发布日期"></el-table-column>
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
		<prodution-car-add v-if="isShowAddDialog" @onCancel="close" ref="ProdutionCarAdd" />
	</el-row>
</template>
<script>
import ProdutionCarAdd from "@/components/ProdutionCarAdd";
export default {
  components: {
    ProdutionCarAdd
  },
  mounted: function() {},
  data: function() {
    return {
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 15,
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
      tableData: window.config.tableData
    };
  },
  methods: {
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    queryBtnAct() {},
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
