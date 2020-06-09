<template>
	<el-row
		class="chargeAddress"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>设备管理／充电桩地址</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu flex-sbw">
				<div class="flex-sbw">
					<el-button v-if="$store.state.home.AuthorizationID" type="primary" @click="addBtnAct" style="margin:0 10px;">新增</el-button>
					<div class="flex-sbw-div">
						<span class="topTitleTxt">省：</span>
						<el-select
							class="left-space time-interal"
							v-model="province"
							clearable
							placeholder="请选择省"
							size="small"
							@change="provinceChangeAct"
						>
							<el-option
								v-for="item in provinceOptions"
								:key="item.provinceId"
								:label="item.province"
								:value="item.provinceId"
							></el-option>
						</el-select>
					</div>
					<div class="flex-sbw-div">
						<span class="topTitleTxt">市：</span>
						<el-select
							class="left-space time-interal"
							v-model="city"
							clearable
							placeholder="请选择市"
							size="small"
							@change="cityChangeAct"
						>
							<el-option
								v-for="item in cityOptions"
								:key="item.cityId"
								:label="item.cityName"
								:value="item.cityId"
							></el-option>
						</el-select>
					</div>
					<div class="flex-sbw-div">
						<span class="topTitleTxt">区：</span>
						<el-select
							class="left-space time-interal"
							v-model="area"
							clearable
							placeholder="请选择区"
							size="small"
							@change="areaChangeAct"
						>
							<el-option
								v-for="item in areaOptions"
								:key="item.areaId"
								:label="item.areaName"
								:value="item.areaId"
							></el-option>
						</el-select>
					</div>
					<div class="flex-sbw-div topTitleTxt">
						<span>地址：</span>
						<el-input style="width:auto" v-model="address" clearable></el-input>
					</div>
				</div>
				<el-button type="primary" @click="queryBtnAct" style="margin-bottom:10px;">查询</el-button>
			</div>
			<div class="tableBox">
			<el-table :data="tableData" stripe border  style="width: 100%">
				<!-- <el-table-column type="selection" width="55"></el-table-column> -->
				<el-table-column type="index" width="55" label="序号"></el-table-column>
				<el-table-column prop="province" label="省"></el-table-column>
				<el-table-column prop="cityName" label="市"></el-table-column>
				<el-table-column prop="areaName" label="区"></el-table-column>
				<el-table-column prop="addressName" label="地址" show-overflow-tooltip></el-table-column>
				<el-table-column prop="longitude" label="经度"></el-table-column>
				<el-table-column prop="latitude" label="纬度"></el-table-column>
				<el-table-column  v-if="$store.state.home.AuthorizationID" label="操作">
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
		<charge-address-edit
			:isShow="isShowEidtDialog"
			:rowData="rowData"
			@onCancel="close"
			ref="houseTable"
		/>
	</el-row>
</template>
<script>
import ChargeAddressEdit from "@/components/ChargeAddressEdit";
export default {
  components: {
    ChargeAddressEdit
  },
  mounted: function() {
    this.provinceOptions = this.$store.state.home.provinceArr;
    this.initData();
  },
  data: function() {
    return {
      isShowEidtDialog: false,
      pageSize: 10,
      pageSizeArr: window.config.pageSizeArr,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      provinceOptions: [],
      areaOptions: [],
      area: null,
      city: null,
      address: null,
      cityOptions: [],
      province: null,
      mainScreenLoading: false,
      tableData: window.config.tableData,
      rowData: null
    };
  },
  methods: {
    initData() {
      let data = {
        model: {
          addressName: this.address,
          areaId: this.area,
          cityId: this.city,
          provinceId: this.province
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      this.$deviceAjax
        .getChargeAddressList(data)
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
    provinceChangeAct() {
      if (!this.province) return;
      this.$deviceAjax
        .getCityByProvinceId({ provinceId: this.province })
        .then(res => {
          if (res.data.success) {
            this.cityOptions = res.data.model;
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    },
    cityChangeAct() {
      if (!this.city) return;
      this.$deviceAjax
        .getAreaListByCityId({ cityId: this.city })
        .then(res => {
          if (res.data.success) {
            this.areaOptions = res.data.model;
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    },
    areaChangeAct() {
      //   this.$deviceAjax
      //     .getAddressListByAreaId({ areaId: this.area })
      //     .then(res => {
      //       if (res.data.success) {
      //         this.address = res.data.model;
      //       } else {
      //         this.$message({ type: "warning", message: res.data.errMsg });
      //       }
      //     })
      //     .catch(() => {});
    },
    close(is) {
      this.isShowEidtDialog = !this.isShowEidtDialog;
      if (is) {
        this.initData();
      }
    },
    queryBtnAct() {
      this.initData();
    },
    addBtnAct() {
      this.rowData = {};
      this.isShowEidtDialog = !this.isShowEidtDialog;
    },
    deleteBtnAct() {},
    exportBtnAct() {},
    handleClick(row) {
      this.isShowEidtDialog = !this.isShowEidtDialog;
      console.log(row);
      this.$deviceAjax
        .editChargeAddress({ addressId: row.addressId })
        .then(res => {
          if (res.data.success) {
            this.rowData = res.data.model;
            Object.assign(this.rowData, row);
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
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
<style>
.chargeAddress .topMenu .el-input__inner {
	width: 120px;
	height: 32px;
}
</style>
<style lang='scss' scoped>
@import "@/style/variables.scss";
.chargeAddress {
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
			.flex-sbw-div {
				margin: 0 25px 0 15px;
				.el-input {
					.el-input__inner {
						width: 120px;
					}
				}
			}
			.el-button {
				color: #ffffff;
				background-color: #5b9cf8;
				border-color: #5b9cf8;
			}
		}
		.tableBox{
			min-height: calc(100% - 100px);
		}
		.footer {
			// margin-top: 30px;
			text-align: right;
		}
	}
}
</style>
