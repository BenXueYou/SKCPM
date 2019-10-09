<template>
	<el-row
		class="OperatorStatics"
		v-loading="mainScreenLoading"
		element-loading-background="rgba(0, 0, 0, 0.8)"
	>
		<div class="titleBox">
			位置：
			<span>首页／概览</span>
		</div>
		<div class="bodyBox">
			<div class="topMenu" style="padding-bottom:5px">
				<el-table :data="[tableData[0]]" stripe border style="width: 100%">
					<el-table-column prop="chargeStationCount" label="充电站总数"></el-table-column>
					<el-table-column prop="chargePileCount" label="充电桩总数"></el-table-column>
					<el-table-column prop="chargePileDcCount" label="直流桩总数"></el-table-column>
					<el-table-column prop="chargePileAcCount" label="交流桩总数"></el-table-column>
					<el-table-column prop="weChatUserCount" label="注册用户数"></el-table-column>
					<el-table-column prop="cardCount" label="卡用户数"></el-table-column>
				</el-table>
			</div>
			<div class="topMenu flex-spa" style="margin: 15px 0;">
				<div class="flex-sbw">
					<div class="flex-sbw-div topTitleTxt flex-sbw-item">
						<span>运营商：</span>
						<el-select
							class="left-space time-interal"
							v-model="operatorId"
							clearable
							placeholder="处理状态"
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
						<span>统计类型：</span>
						<el-select
							class="left-space time-interal"
							v-model="type"
							clearable
							placeholder="统计类型"
							size="small"
						>
							<el-option
								v-for="item in staticTypeOptions"
								:key="item.typeStr"
								:label="item.typeName"
								:value="item.typeStr"
							></el-option>
						</el-select>
					</div>
					<div class="dateBox" style="text-align:right">
						<span class="topTitleTxt">查询时间：</span>
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
				<el-button type="primary" @click="queryBtnAct" style="margin:5px 12px;">查询</el-button>
			</div>
			<el-container>
				<el-main>
					<div class="echartsBox">
						<el-row
							v-loading="fullscreenLoading"
							element-loading-background="rgba(0, 0, 0, 0.8)"
							ref="canvsWidth"
							id="canvasBox"
						></el-row>
					</div>
				</el-main>
				<el-aside width="200px">
					<el-table :data="[tableData[1]]" stripe border style="width: 100%">
						<el-table-column prop="province" label="充电总电量(kWh)"></el-table-column>
					</el-table>
					<el-table :data="[tableData[1]]" stripe border style="width: 100%">
						<el-table-column prop="province" label="服务费(元)"></el-table-column>
					</el-table>
					<el-table :data="[tableData[1]]" stripe border style="width: 100%">
						<el-table-column prop="province" label="基础电费(元)"></el-table-column>
					</el-table>
					<el-table :data="[tableData[1]]" stripe border style="width: 100%">
						<el-table-column prop="city" label="充电总费用(元)"></el-table-column>
					</el-table>
					<el-table :data="[tableData[1]]" stripe border style="width: 100%">
						<el-table-column prop="city" label="充电总费用(元)"></el-table-column>
					</el-table>
				</el-aside>
			</el-container>
		</div>
	</el-row>
</template>
<script>
// import appUserAdd from "@/components/appUserAdd";
export default {
  components: {
    // appUserAdd
  },
  mounted: function() {
    console.log(this.$common.getStartTime());
    this.operatorOptions = this.$store.state.home.operatorArr;
    this.initData();
    this.initLineData();
    let day = new Date();
    day.setDate(1);
    let firstdate = this.$common.timestampToFormatter(day, "yyyy-mm-dd");
    let enddate = this.$common.timestampToFormatter(
      new Date().getTime(),
      "yyyy-mm-dd"
    );
    this.beginTime = firstdate + " " + "00:00:00";
    this.endTime = enddate + " " + "23:59:59";
  },
  data: function() {
    return {
      fullscreenLoading: false,
      total: 10,
      beginTime: this.$common.getStartTime(),
      endTime: this.$common.getCurrentTime(),
      operatorOptions: [],
      operatorId: 34,
      stationOptions: [],
      type: 3,
      dayArr: [],
      operator: null,
      mainScreenLoading: false,
      tableData: window.config.tableData,
      trendLineDataList: [],
      staticTypeOptions: [
        {
          typeStr: 1,
          typeName: "按电量统计"
        },
        {
          typeStr: 2,
          typeName: "按次数统计"
        },
        {
          typeStr: 3,
          typeName: "按收入统计"
        }
      ]
    };
  },
  methods: {
    initLineData() {
      this.$homeAjax
        .trend({
          endTime: this.endTime,
          operatorId: this.operatorId,
          startTime: this.beginTime,
          type: this.type
        })
        .then(res => {
          console.log(res.data);
          if (res.data.success) {
            let arr = res.data.model;
            this.dayArr = [];
            this.trendLineDataList = [];
            if (!arr.length) {
              this.$message({type: 'warning', message: '查询结果为空'});
              return;
            }
            for (let i = 0; i < arr.length; i++) {
              this.dayArr.push(arr[i].day);
              this.trendLineDataList.push(arr[i].data);
            }
            this.drawLine();
          } else {
          }
        })
        .catch(() => {});
    },
    initData() {
      this.$homeAjax
        .summary()
        .then(res => {
          console.log(res.data);
          if (res.data.success) {
            this.tableData = [res.data.model];
          }
        })
        .catch(() => {});
    },
    queryBtnAct() {
      this.initLineData();
    },
    handleSizeChange(val) {
      console.log("每页条数发生变化：", val);
      this.pageSize = val;
    },
    drawLine() {
      let dom = document.getElementById("canvasBox");
      let w =
				window.innerWidth ||
				document.documentElement.clientWidth ||
				document.body.clientWidth;
      let h =
				window.innerHeight ||
				document.documentElement.clientHeight ||
				document.body.clientHeight;
      this.$refs.canvsWidth.$el.style.width = (w * 2) / 3 - 120 + "px";
      this.$refs.canvsWidth.$el.style.height = (3 * h) / 10 - 80 + "px";
      console.log(this.$refs.canvsWidth.$el.style.width);
      if (!dom) {
        return;
      }
      dom.style.width = this.$refs.canvsWidth.$el.style.width;
      dom.style.height = this.$refs.canvsWidth.$el.style.height;

      let myChart = this.$echarts.init(dom);
      window.addEventListener("resize", function() {
        myChart.resize();
      });
      let app = {};
      let option = null;
      app.title = "坐标轴刻度与标签对齐";
      option = {
        tooltip: {
          trigger: "axis",
          show: true,
          axisPointer: {
            type: "none"
          }
        },
        textStyle: {
          color: "#666666"
        },
        grid: {
          left: "4%",
          right: "3%",
          top: "10",
          bottom: "20"
        },
        xAxis: {
          type: "category",
          // interval: 10,
          boundaryGap: false,
          splitLine: {
            show: false,
            lineStyle: {
              color: ["#666666"],
              opacity: 0.6
            }
          },
          data: this.dayArr
        },
        yAxis: {
          // name: '车流量统计结果(日)',
          type: "value",
          boundaryGap: true,
          axisLabel: {
            formatter: "{value}"
          },
          splitLine: {
            show: true,
            lineStyle: {
              color: ["#666666"],
              opacity: 0.6
            }
          }
        },
        series: [
          {
            type: "line",
            color: ["#28FFBB"],
            smooth: false,
            itemStyle: {
              normal: {
                color: {
                  type: "linear",
                  x: 0,
                  y: 0,
                  x2: 0,
                  y2: 1,
                  colorStops: [
                    {
                      offset: 0,
                      color: "#28FFBB" // 0% 处的颜色
                    },
                    {
                      offset: 1,
                      color: "rgba(40,253,186,0.00)" // 100% 处的颜色
                    }
                  ],
                  globalCoord: false // 缺省为 false
                }
              }
            },
            areaStyle: {
              normal: {
                color: {
                  type: "linear",
                  x: 0,
                  y: 0,
                  x2: 0,
                  y2: 1,
                  colorStops: [
                    {
                      offset: 0,
                      color: "#28FFBB" // 0% 处的颜色
                    },
                    {
                      offset: 1,
                      color: "rgba(40,253,186,0.00)" // 100% 处的颜色
                    }
                  ],
                  globalCoord: false // 缺省为 false
                }
              }
            },
            data: this.trendLineDataList
          }
        ]
      };

      if (option && typeof option === "object") {
        myChart.setOption(option, true);
        // myChart.resize();
      }
    }
  },
  watch: {}
};
</script>
<style>
.OperatorStatics .flex-sbw-item {
	margin: 0 10px;
}
.OperatorStatics .dateBox {
	margin-left: 30px;
}
.OperatorStatics .flex-sbw-item .el-input,
.OperatorStatics .flex-sbw-item .el-input__inner {
	width: 150px;
	height: 32px;
}
.OperatorStatics .el-date-editor.el-input,
.OperatorStatics .el-date-editor.el-input__inner {
	width: 180px;
}
.OperatorStatics .el-input--suffix .el-input__inner {
	padding-right: 10px;
}

@media screen and (max-width: 1512px) {
	.OperatorStatics .flex-sbw-item {
		margin-right: 5px !important;
	}
	.OperatorStatics .flex-sbw-item .el-input,
	.OperatorStatics .flex-sbw-item .el-input__inner {
		width: 120px;
		height: 32px;
	}
	.OperatorStatics .el-input--suffix .el-input__inner {
		padding-right: 10px !important;
	}
	.OperatorStatics .dateBox {
		margin-left: 30px !important;
	}
}
</style>

<style lang='scss' scoped>
@import "@/style/variables.scss";
.OperatorStatics {
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
		height: calc(100% - 100px);
		.topMenu {
			text-align: left;
			.topTitleTxt {
				color: #999999;
			}
		}
		.flex-sbw {
			display: flex;
			justify-content: space-between;
			padding-top: 15px;
			.el-button {
				color: #ffffff;
				background-color: #5b9cf8;
				border-color: #5b9cf8;
			}
		}
		.flex-spa {
			display: flex;
			justify-content: space-around;
			padding-bottom: 5px;
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
