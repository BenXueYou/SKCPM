<template>
  <el-row class="PileRealData"
          v-loading="mainScreenLoading"
          element-loading-background="rgba(0, 0, 0, 0.8)">
    <div class="titleBox">
      位置：
      <span>设备监控／充电监控</span>
    </div>
    <div class="bodyBox">
      <div class="topMenu flex-st"
           style="margin-bottom: 15px;">
        <div class="flex-sbw-div">
          <span class="topTitleTxt">充电桩：</span>
          <el-input v-model="cpId" />
        </div>
        <div class="flex-sbw-div">
          <span class="topTitleTxt">运营商：</span>
          <el-select class="left-space time-interal"
                     v-model="operatorId"
                     clearable
                     placeholder="运营商"
                     size="small"
                     @change="operatorIdChangeAct">
            <el-option v-for="item in operatorOptions"
                       :key="item.operatorId"
                       :label="item.operatorName"
                       :value="item.operatorId"></el-option>
          </el-select>
        </div>
        <div class="flex-sbw-div">
          <span class="topTitleTxt">充电站：</span>
          <el-select class="left-space time-interal"
                     v-model="csId"
                     clearable
                     placeholder="充电站"
                     size="small">
            <el-option v-for="item in stationOptions"
                       :key="item.csId"
                       :label="item.csName"
                       :value="item.csId"></el-option>
          </el-select>
        </div>
        <div class="flex-sbw-div">
          <span class="topTitleTxt">充电桩类型：</span>
          <el-select class="left-space time-interal"
                     v-model="cpType"
                     clearable
                     placeholder="充电桩类型"
                     size="small">
            <el-option v-for="item in cpTypeOptions"
                       :key="item.typeStr"
                       :label="item.typeName"
                       :value="item.typeStr"></el-option>
          </el-select>
        </div>
        <!-- <div class="flex-sbw-div">
					<span class="topTitleTxt">充电桩状态：</span>
					<el-select
						class="left-space time-interal"
						v-model="operator"
						clearable
						placeholder="充电桩状态"
						size="small"
					>
						<el-option
							v-for="item in operatorOptions"
							:key="item.typeStr"
							:label="item.typeName"
							:value="item.typeStr"
						></el-option>
					</el-select>
				</div>-->
        <el-button type="primary"
                   @click="queryBtnAct"
                   style="margin:-5px 10px 0">查询</el-button>
      </div>
      <div class="tableBox">
        <el-table :data="tableData"
                  stripe
                  border
                  style="width: 100%">
          <el-table-column type="index"
                           width="55"
                           label="序号"></el-table-column>
          <el-table-column prop="cpId"
                           label="桩序列号"
                           width="180"></el-table-column>
          <el-table-column prop="gun"
                           label="枪号"
                           width="60"></el-table-column>
          <el-table-column prop="eleType"
                           label="桩类型"
                           width="100"></el-table-column>
          <el-table-column prop="cpState"
                           label="设备状态"
                           width="100"></el-table-column>
          <el-table-column prop="gunState"
                           label="枪状态"
                           width="100">
            <template slot-scope="scope">
              <span v-if="scope.row.cpState==='在线'">{{scope.row.gunState==='3'?'充电中':'空闲'}}</span>
              <span v-else>{{scope.row.gunState}}</span>
            </template>
          </el-table-column>
          <el-table-column prop="userId"
                           label="用户ID"
                           width="160">
            <template slot-scope="scope">{{scope.row.gunState === '3'?scope.row.userId:''}}</template>
          </el-table-column>
          <el-table-column v-if="!cpType"
                           prop="soc"
                           label="SOC"
                           width="100"></el-table-column>
          <el-table-column prop="chargeAmount"
                           label="充电电量(kWh)"
                           width="100"></el-table-column>
          <el-table-column prop="chargeMoney"
                           label="充电金额(元)"
                           width="100"></el-table-column>
          <el-table-column prop="chargeTimeSpan"
                           label="已充时间(分)"
                           width="100">
            <template slot-scope="scope">{{$common.formatSeconds(scope.row.chargeTimeSpan)}}</template>

          </el-table-column>
          <el-table-column prop="chargePower"
                           label="功率(kw)">
          </el-table-column>
          <template v-if="cpType">
            <el-table-column prop="ua1"
                             label="A相电压(V)"></el-table-column>
            <el-table-column prop="ub1"
                             label="B相电压(V)"></el-table-column>
            <el-table-column prop="uc1"
                             label="C相电压(V)"></el-table-column>
            <el-table-column prop="ia1"
                             label="A相电流(A)"></el-table-column>
            <el-table-column prop="ib1"
                             label="B相电流(A)"></el-table-column>
            <el-table-column prop="ic1"
                             label="C相电流(A)"></el-table-column>
          </template>
          <template v-else>
            <el-table-column prop="ua1"
                             label="电压(V)"></el-table-column>
            <el-table-column prop="ia1"
                             label="电流(A)"></el-table-column>
          </template>
          <el-table-column prop="recordTime"
                           label="记录时间"
                           width="160"></el-table-column>
          <!-- <el-table-column prop="zip" label="电池组最高温度(°C)" width="120"></el-table-column>
					<el-table-column prop="zip" label="电池组最低温度" width="100"></el-table-column>
					<el-table-column prop="zip" label="单体电池最高温度(°C)" width="120"></el-table-column>
					<el-table-column prop="zip" label="单体组最低温度" width="100"></el-table-column>
					<el-table-column prop="zip" label="充电机温度(°C)" width="120"></el-table-column>
					<el-table-column prop="zip" label="充电导引电压(V)" width="100"></el-table-column>-->
          <!-- <el-table-column prop="operatorName" label="运营商" width="120"></el-table-column>
					<el-table-column prop="csName" label="充电站" width="150"></el-table-column>
					<el-table-column label="操作">
							<template slot-scope="scope">
							<el-button @click="handleClick(scope.row)" type="text" size="small">详情</el-button>
							</template>
					</el-table-column>-->
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
    <charge-record-detail :visible.sync="isShowAddDialog"
                          @onCancel="close()"
                          ref="houseTable" />
  </el-row>
</template>
<script>
import ChargeRecordDetail from "@/components/ChargeRecordDetail";
export default {
  components: {
    ChargeRecordDetail
  },
  mounted: function() {
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.stationOptions = this.$store.state.home.chargeStationArr;
    this.initData();
    this.setInt = setInterval(() => {
      this.initData();
    }, 10000);
  },
  destroyed: function() {
    clearInterval(this.setInt);
    console.log("------destroyed--------");
  },
  data: function() {
    return {
      cpId: null,
      isShowAddDialog: false,
      pageSizeArr: window.config.pageSizeArr,
      pageSize: 10,
      currentPage: 1,
      total: 10,
      beginTime: null,
      endTime: null,
      operatorOptions: [],
      csId: null,
      stationOptions: [],
      operatorId: null,
      mainScreenLoading: false,
      tableData: [],
      cpType: 0,
      cpTypeOptions: [
        {
          typeStr: 0,
          typeName: "直流"
        },
        {
          typeStr: 1,
          typeName: "交流"
        }
      ]
    };
  },
  methods: {
    operatorIdChangeAct(val) {
      console.log(val);
    },
    close() {
      this.isShowAddDialog = !this.isShowAddDialog;
    },
    initData() {
      let data = {
        model: {
          cpType: this.cpType,
          csId: this.csId,
          operatorId: this.operatorId,
          cpId: this.cpId
        },
        pageIndex: this.currentPage,
        pageSize: this.pageSize,
        queryCount: true,
        start: 0
      };
      data = this.$common.deleteEmptyString(data, true);
      this.$realAjax
        .realPileData(data)
        .then(res => {
          this.tableData = [];
          if (res.data.success && res.data.model) {
            let num = [];
            res.data.model.forEach(element => {
              element.chargePower = element.chargePower / 1000.00;
              num.push(element);
            });
            this.tableData = num;
            this.total = res.data.totalCount;
          } else {
            this.$message.warning("没有找到相关数据");
          }
        })
        .catch(() => {});
    },
    queryBtnAct() {
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
  watch: {
    tableData: {
      handler() {},
      deep: true,
      immediate: true
    }
  }
};
</script>
<style>
.PileRealData .flex-sbw-item .el-input,
.PileRealData .flex-sbw-div .el-input,
.PileRealData .flex-sbw-div .el-input__inner,
.PileRealData .flex-sbw-item .el-input__inner {
  width: 160px;
  height: 32px;
}
.PileRealData .el-date-editor.el-input,
.PileRealData .el-date-editor.el-input__inner {
  width: 190px;
}
.PileRealData .el-input--suffix .el-input__inner {
  padding-right: 10px;
}

@media screen and (max-width: 1540px) {
  .PileRealData .flex-sbw-item {
    margin-right: 5px !important;
  }
  .PileRealData .flex-sbw-item .el-input,
  .PileRealData .flex-sbw-item .el-input__inner {
    width: 120px;
    height: 32px;
  }
  .PileRealData .el-date-editor.el-input,
  .PileRealData .el-date-editor.el-input__inner {
    width: 180px;
  }
  .PileRealData .el-input--suffix .el-input__inner {
    padding-right: 10px !important;
  }
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.PileRealData {
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
    .flex-st {
      display: flex;
      justify-content: flex-start;
      padding-bottom: 15px;
      .flex-sbw-div {
        margin: 0 10px;
      }
      .el-button {
        color: #ffffff;
        background-color: #5b9cf8;
        border-color: #5b9cf8;
        // height: 32px;
        // line-height: 32px;
      }
    }
    .footer {
      // margin-top: 30px;
      text-align: right;
    }
  }
}
</style>
