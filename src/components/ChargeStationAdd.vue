<template>
	<el-dialog
		width="560px"
		:title="!rowData.csId?`新增充电站`:`修改充电站`"
		class="dialog-station-add"
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
						<el-form-item label="运营商：" prop="operatorId">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.operatorId"
								size="small"
								clearable
								placeholder="请选择"
							>
								<el-option
									v-for="item in operatorOptions"
									:key="item.operatorId"
									:label="item.operatorName"
									:value="item.operatorId"
								></el-option>
							</el-select>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="充电站：" prop="csName">
							<el-input class="time-interal" v-model="formLabelAlign.csName" size="small" clearable></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="省：" prop="provinceId">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.provinceId"
								size="small"
								clearable
								placeholder="请选择省"
								@change="provinceChangeAct"
							>
								<el-option
									v-for="item in provinceOptions"
									:key="item.provinceId"
									:label="item.province"
									:value="item.provinceId"
								></el-option>
							</el-select>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="市：" prop="cityId">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.cityId"
								size="small"
								clearable
								placeholder="请选择市"
								@change="cityChangeAct"
							>
								<el-option
									v-for="item in cityOptions"
									:key="item.cityId"
									:label="item.cityName"
									:value="item.cityId"
								></el-option>
							</el-select>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="区/县：" prop="areaId">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.areaId"
								size="small"
								clearable
								placeholder="请选择区/县"
								@change="areaChangeAct"
							>
								<el-option
									v-for="item in areaOptions"
									:key="item.areaId"
									:label="item.areaName"
									:value="item.areaId"
								></el-option>
							</el-select>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="地址：" prop="addressId">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.addressId"
								size="small"
								clearable
								placeholder="请选择地址"
							>
								<el-option
									v-for="item in addressOptions"
									:key="item.addressId"
									:label="item.addressName"
									:value="item.addressId"
								></el-option>
							</el-select>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-form-item style="margin-bottom:0px!important" label="开放时间:" required>
						<el-col :span="10">
							<el-form-item prop="startTime">
								<el-time-picker
									type="date"
									value-format="HH:mm"
									placeholder="选择开始时间"
									v-model="formLabelAlign.startTime"
									class="timePickerClass"
								></el-time-picker>
							</el-form-item>
						</el-col>
						<el-col class="line" :span="3" style="color:#dcdfe6;padding:0 8px;text-align:center">—</el-col>
						<el-col :span="10">
							<el-form-item prop="endTime">
								<el-time-picker
									placeholder="选择结束时间"
									value-format="HH:mm"
									v-model="formLabelAlign.endTime"
									class="timePickerClass"
								></el-time-picker>
							</el-form-item>
						</el-col>
					</el-form-item>
				</el-row>
				<el-row type="flex" justify="space-between">
					<el-col :span="12">
						<el-form-item label="停车收费:">
							<el-switch v-model="isParkFee"></el-switch>
						</el-form-item>
					</el-col>
					<el-col :span="12" v-if="isParkFee">
						<el-form-item label="停车费(元/时)：" prop="roomsType">
							<el-input class="time-interal" v-model="formLabelAlign.parkFee" size="small" clearable></el-input>
						</el-form-item>
					</el-col>
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
// import PopoverTreeForBottom from "@/pages/buildingsHouse/components/PopoverTreeForBottom";

export default {
  components: {
    // PopoverTreeForBottom,
  },
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
      endTimeOptions: [],
      provinceOptions: [],
      addressOptions: [],
      areaOptions: [],
      cityOptions: [],
      operatorOptions: [],
      isCurrentShow: false,
      labelPosition: "right",
      isParkFee: false,
      formLabelAlign: {
        openTime: "00:00-23:59",
        startTime: "00:00",
        addressName: null,
        endTime: "23:59",
        csName: null,
        operatorId: null,
        parkFee: null,
        addressId: null,
        provinceId: 0,
        cityId: 0,
        areaId: 0
      },
      rules: {
        addressName: [
          { required: true, message: "地址不能为空", trigger: "blur" },
          { whitespace: true, message: "不允许输入空格", trigger: "blur" },
          { min: 1, max: 32, message: "长度在 1 到 64 个字符", trigger: "blur" }
        ],
        startTime: [
          { required: true, message: "开放开始时间不能为空", trigger: "change" }
        ],
        endTime: [
          { required: true, message: "结束时间不能为空", trigger: "change" }
        ],
        csName: [
          { required: true, message: "充电站名称不能为空", trigger: "change" }
        ],
        operatorId: [
          { required: true, message: "运营商不能为空", trigger: "change" }
        ],
        provinceId: [
          { required: true, message: "请选择省", trigger: "change" }
        ],
        cityId: [{ required: true, message: "请选择市", trigger: "change" }],
        areaId: [{ required: true, message: "请选择区/县", trigger: "change" }],
        addressId: [
          { required: true, message: "地址不能为空", trigger: "change" }
        ]
      }
    };
  },
  created() {},
  mounted() {
    this.provinceOptions = this.$store.state.home.provinceArr;
    this.operatorOptions = this.$store.state.home.operatorArr;
  },
  methods: {
    httpRequest() {
      let data = {
        areaId: 0,
        cityId: 0,
        csName: "string",
        endTime: "string",
        addressName: "string",
        operatorId: 0,
        parkFee: 0,
        provinceId: 0,
        startTime: "string",
        validFlag: 0
      };
      this.formLabelAlign.openTime = [
        this.formLabelAlign.startTime,
        this.formLabelAlign.endTime
      ].join("-");
      Object.assign(data, this.formLabelAlign);
      if (this.formLabelAlign.id) {
        this.updateChargeStation(data);
      } else {
        this.addChargeStation(data);
      }
    },
    onClickCancel() {
      this.$emit("onCancel");
    },
    updateChargeStation(data) {
      this.$deviceAjax
        .updateChargeStation(data)
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
    addChargeStation(data) {
      this.$deviceAjax
        .addChargeStation(data)
        .then(res => {
          if (res.data.success) {
            this.$message.success("添加成功");
            this.$emit("onCancel", true);
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
    onClickConfirm() {
      this.$refs.addHouseForm.validate(valid => {
        if (valid) {
          this.httpRequest();
        } else {
          this.$cToast.error("请正确填写内容");
        }
      });
    },
    provinceChangeAct() {
      this.$deviceAjax
        .getCityByProvinceId({ provinceId: this.formLabelAlign.provinceId })
        .then(res => {
          if (res.data.success) {
            this.cityOptions = res.data.model;
            this.formLabelAlign.cityId = this.cityOptions[0].cityId;
            this.cityChangeAct();
            this.formLabelAlign.areaId = null;
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    },
    cityChangeAct() {
      this.$deviceAjax
        .getAreaListByCityId({ cityId: this.formLabelAlign.cityId })
        .then(res => {
          if (res.data.success) {
            this.areaOptions = res.data.model;
            this.formLabelAlign.areaId = this.areaOptions[0].areaId;
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    },
    areaChangeAct() {
      this.$deviceAjax
        .getAddressListByAreaId({ areaId: this.formLabelAlign.areaId })
        .then(res => {
          if (res.data.success) {
            this.addressOptions = res.data.model;
          } else {
            this.$message({ type: "warning", message: res.data.errMsg });
          }
        })
        .catch(() => {});
    }
  },
  watch: {
    isShow(val) {
      this.isCurrentShow = val;
      if (val && this.rowData.csId) {
        this.formLabelAlign = JSON.parse(JSON.stringify(this.rowData));
        console.log(this.formLabelAlign);
        this.formLabelAlign.endTime = this.formLabelAlign.openTime.split(
          "-"
        )[1];
        this.formLabelAlign.startTime = this.formLabelAlign.openTime.split(
          "-"
        )[0];
        this.provinceChangeAct(this.formLabelAlign.provinceId);
        this.cityChangeAct(this.formLabelAlign.cityId);
        this.areaChangeAct(this.formLabelAlign.areaId);
      } else {
        this.formLabelAlign = {
          openTime: null,
          startTime: null,
          addressName: null,
          endTime: null,
          csName: null,
          operatorId: null,
          parkFee: 0,
          addressId: null,
          provinceId: 0,
          cityId: 0,
          areaId: 0
        };
      }
    }
  },
  destroyed() {}
};
</script>
<style>
.dialog-station-add .el-dialog__header {
	border-bottom: 1px solid #eeeeee;
}
.dialog-station-add .el-dialog--center .el-dialog__body {
	text-align: initial;
	padding: 25px 35px 5px 5px;
}
.dialog-station-add .timePickerClass {
	width: 100% !important;
	height: 32px;
	line-height: 32px;
}
.dialog-station-add .timePickerClass .el-input__icon,
.dialog-station-add .timePickerClass .el-input__inner {
	height: 32px;
	line-height: 32px;
}
</style>
<style lang="scss" scoped>
.dialog-station-add {
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
		margin-bottom: 15px;
	}
}
.el-dialog__header {
	background-color: red;
}
</style>
