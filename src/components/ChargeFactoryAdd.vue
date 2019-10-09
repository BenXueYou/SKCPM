<template>
	<el-dialog
		width="580px"
		:title="isAdd?`新增充电桩厂商`:`修改充电桩厂商`"
		class="dialog-factory-add"
		center
		:visible.sync="isCurrentShow"
		:before-close="onClickCancel"
		:close-on-click-modal="false"
	>
		<div class="dialog-content">
			<!--内容-->
			<el-form
				:rules="rules"
				ref="addHouseForm"
				:label-position="labelPosition"
				label-width="120px"
				:model="formLabelAlign"
				class="info-form"
			>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="桩厂商：" prop="mfrName">
							<el-input class="time-interal" v-model="formLabelAlign.mfrName" size="small"></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="桩厂商代号：" prop="mfrAbbr">
							<el-input class="time-interal" v-model="formLabelAlign.mfrAbbr" size="small"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="桩型号：" prop="model">
							<el-input class="time-interal" v-model="formLabelAlign.model" size="small"></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="桩功率(kW)：" prop="ratedPower">
							<el-input class="time-interal" v-model="formLabelAlign.ratedPower" size="small"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-form-item label="桩参数：" prop="chargeStationModel">
						<el-col :span="8">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.cpType"
								size="small"
								clearable
								placeholder="请选择桩类型"
							>
								<el-option
									v-for="item in cpTypeOptions"
									:key="item.typeStr"
									:label="item.typeName"
									:value="item.typeStr"
								></el-option>
							</el-select>
						</el-col>
						<el-col :span="8">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.cpPhase"
								size="small"
								clearable
								placeholder="请选择桩相数"
							>
								<el-option
									v-for="item in cpPhaseOptions"
									:key="item.typeStr"
									:label="item.typeName"
									:value="item.typeStr"
								></el-option>
							</el-select>
						</el-col>
						<el-col :span="8">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.interfaceCount"
								size="small"
								clearable
								placeholder="请选择桩枪数"
							>
								<el-option
									v-for="item in interfaceCountOptions"
									:key="item.typeStr"
									:label="item.typeName"
									:value="item.typeStr"
								></el-option>
							</el-select>
						</el-col>
					</el-form-item>
				</el-row>
			</el-form>
		</div>
		<div slot="footer" class="dialog-footer">
			<el-button type="primary" @click="onClickConfirm" size="small">确定</el-button>
			<el-button type="primary" @click="onClickCancel" size="small">取消</el-button>
		</div>
	</el-dialog>
</template>

<script>
export default {
  props: {
    isAdd: {
      type: Boolean,
      default: true
    },
    isShow: {
      type: Boolean,
      default: false
    },
    rowData: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      cpTypeOptions: [
        {
          typeStr: 0,
          typeName: "直流"
        },
        {
          typeStr: 1,
          typeName: "交流"
        }
      ],
      cpPhaseOptions: [
        {
          typeStr: 1,
          typeName: "三相"
        },
        {
          typeStr: 0,
          typeName: "单相"
        }
      ],
      interfaceCountOptions: [
        {
          typeStr: 0,
          typeName: "单枪"
        },
        {
          typeStr: 1,
          typeName: "双枪"
        }
      ],
      isCurrentShow: false,
      labelPosition: "right",
      formLabelAlign: {
        mfrName: null,
        mfrAbbr: null,
        model: null,
        ratedPower: null,
        cpType: null,
        cpPhase: null,
        interfaceCount: null
      },
      rules: {
        mfrName: [
          { required: true, message: "名称不能为空", trigger: "change" }
        ],
        mfrAbbr: [
          { required: true, message: "桩厂商代号不能为空", trigger: "change" }
        ],
        model: [
          { required: true, message: "桩型号不能为空", trigger: "change" }
        ],
        ratedPower: [
          { required: true, message: "充电桩功率不能为空", trigger: "change" }
        ]
      }
    };
  },
  created() {},
  mounted() {
    this.initData();
  },
  methods: {
    initData() {
      this.houseTypeOptions = [];
      this.houseUseOptions = [];
    },
    setUseData() {},
    onClickCancel() {
      this.$emit("onCancel");
    },
    onClickConfirm() {
      let data = {
        cpPhase: 0,
        cpType: 0,
        interfaceCount: 0,
        mfrAbbr: "string",
        mfrId: 0,
        mfrName: "string",
        model: "string",
        ratedPower: 0
      };
      Object.assign(data, this.formLabelAlign);
      if (this.formLabelAlign.id) {
        this.updateHttpFactory(data);
      } else {
        this.addHttpFactory(data);
      }
    },
    addHttpFactory() {
      this.$deviceAjax
        .addPileFactory(this.formLabelAlign)
        .then(res => {
          console.log(res.data);
          if (res.data.success) {
            this.$message.success("新增成功");
            this.$emit("onCancel", true);
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
    updateHttpFactory() {
      this.$deviceAjax
        .updatePileFactory(this.formLabelAlign)
        .then(res => {
          if (res.data.success) {
            this.$message.success("修改成功");
            this.$emit("onCancel", true);
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
    addHouse() {},
    addHouseSuccessResponse(body) {}
  },
  watch: {
    isShow(val) {
      this.isCurrentShow = val;
      if (val && this.rowData.id) {
        this.formLabelAlign = JSON.parse(JSON.stringify(this.rowData));
        this.formLabelAlign.cpType = Number(this.formLabelAlign.cpType);
        this.formLabelAlign.cpPhase = Number(this.formLabelAlign.cpPhase);
        this.formLabelAlign.interfaceCount = Number(
          this.formLabelAlign.interfaceCount
        );
        console.log(this.formLabelAlign);
      } else {
        this.formLabelAlign = {};
      }
    }
  },
  destroyed() {}
};
</script>
<style>
.dialog-factory-add .el-dialog__header {
	border-bottom: 1px solid #eeeeee;
}
.dialog-factory-add .el-dialog--center .el-dialog__body {
	text-align: initial;
	padding: 25px 35px 20px 5px;
}
</style>
<style lang="scss" scoped>
.dialog-factory-add {
	.dialog-content {
		box-sizing: border-box;
	}
	.dialog-footer {
		padding: 0 0 4% 0;
		box-sizing: border-box;
	}
	.topTitleTxt {
		font-family: "PingFangSC-Regular";
		font-size: 14px;
		color: #cccccc;
	}
	.time-interal {
		width: 90%;
	}
	.info-form {
		// width: 85%;
		margin: 0 auto;
	}
	.el-form-item {
		margin-bottom: 12px;
	}
}
.el-dialog__header {
	background-color: red;
}
</style>
