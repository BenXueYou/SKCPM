<template>
	<el-dialog
		width="780px"
		title="费率模板编辑"
		class="BillModelEdit"
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
				<el-row type="flex" justify="space-between" :gutter="30">
					<el-col :span="12">
						<el-form-item label="费率模板：" prop="rateId">
							<el-input v-model="formLabelAlign.rateId" placeholder="请输入内容" clearable></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="计费方案：" prop="billModelId">
							<el-input v-model="formLabelAlign.billModelId" placeholder="请输入内容" clearable></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between" :gutter="30">
					<el-col :span="12">
						<el-form-item label="生效时间：" prop="validTime">
							<el-input v-model="formLabelAlign.validTime" placeholder="请输入内容" clearable></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="失效时间：" prop="invalidTime">
							<el-input v-model="formLabelAlign.invalidTime" placeholder="请输入内容" clearable></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between" :gutter="30">
					<el-col :span="12">
						<el-form-item label="生效时段：" prop="timeIntervalCount">
							<el-select
								class="time-interal"
								v-model="formLabelAlign.timeIntervalCount"
								size="small"
								clearable
								placeholder="请选择"
							>
								<el-option v-for="item in 8" :key="item" :label="item" :value="item"></el-option>
							</el-select>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="服务费(元/度)：" prop="serviceTip">
							<el-input v-model="formLabelAlign.serviceTip" placeholder="请输入内容" clearable></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between" :gutter="30">
					<el-col :span="12">
						<el-form-item label="尖电价(元/度)：" prop="jprice">
							<el-input v-model="formLabelAlign.jprice" placeholder="请输入内容" clearable></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="峰电价(元/度)：" prop="fprice">
							<el-input v-model="formLabelAlign.fprice" placeholder="请输入内容" clearable></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row type="flex" justify="space-between" :gutter="30">
					<el-col :span="12">
						<el-form-item label="平电价(元/度)：" prop="pprice">
							<el-input v-model="formLabelAlign.pprice" placeholder="请输入内容" clearable></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item label="谷电价(元/度)：" prop="gprice">
							<el-input v-model="formLabelAlign.gprice" placeholder="请输入内容" clearable></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<template v-for="(item,index) in formLabelAlign.timeIntervalCount">
					<el-row :key="index" type="flex" justify="space-between" :gutter="30">
						<el-col :span="12">
							<el-form-item :label="`时段${item}类型：`" prop="id">
								<el-select
									class="time-interal"
									v-model="formLabelAlign['ti'+item+'Id']"
									size="small"
									clearable
									placeholder="请选择"
								>
									<el-option
										v-for="item in priceOptions"
										:key="item.id"
										:label="item.label"
										:value="item.id"
									></el-option>
								</el-select>
							</el-form-item>
						</el-col>
						<!-- :picker-options="{
										selectableRange: '00:00 - 23:59'
						}"-->
						<!-- :picker-options="{
										selectableRange: formLabelAlign['ti'+item+'Start'] +' - 23:59',
										format:'HH:mm'
						}"-->
						<!-- :picker-options="{
                    selectableRange: formLabelAlign['ti'+1+'Start'] +' - 23:59',
					format:'HH:mm'
						}"-->
						<el-col :span="12">
							<el-form-item :label="`时段${item}起始时刻：`" prop="csId">
								<el-time-picker
									v-model="formLabelAlign['ti'+item+'Start']"
									value-format="HH:mm"
									placeholder="任意时间点"
								></el-time-picker>——
								<el-time-picker
									v-if="item !== formLabelAlign.timeIntervalCount"
									v-model="formLabelAlign['ti'+(item+1)+'Start']"
									value-format="HH:mm"
									placeholder="任意时间点"
								></el-time-picker>
								<el-time-picker
									v-else
									v-model="formLabelAlign['ti'+1+'Start']"
									value-format="HH:mm"
									placeholder="任意时间点"
								></el-time-picker>
							</el-form-item>
						</el-col>
					</el-row>
				</template>
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
      priceOptions: [
        { id: 0, label: "尖电价" },
        { id: 1, label: "峰电价" },
        { id: 2, label: "平电价" },
        { id: 3, label: "谷电价" }
      ],
      cityOptions: [],
      areaOptions: [],
      isCurrentShow: false,
      labelPosition: "right",
      formLabelAlign: {
        billModelId: 0,
        timeIntervalCount: null,
        rateId: null,
        invalidTime: null,
        validTime: null,
        addressName: null,
        fprice: null,
        gprice: null,
        jprice: null,
        pprice: null,
        ti1Id: 0,
        ti1Start: null,
        ti2Id: 0,
        ti2Start: null,
        ti3Id: 0,
        ti3Start: null,
        ti4Id: 0,
        ti4Start: null,
        ti5Id: 0,
        ti5Start: null,
        ti6Id: 0,
        ti6Start: null,
        ti7Id: 0,
        ti7Start: null,
        ti8Id: 0,
        ti8Start: null
      },
      rules: {}
    };
  },
  created() {},
  mounted() {},
  methods: {
    onClickCancel() {
      this.$emit("onCancel");
    },
    onClickConfirm() {
      console.log(this.formLabelAlign);
      let data = {};
      Object.assign(data, this.formLabelAlign);
      data = this.$common.deleteEmptyString(data, true);
      if (this.formLabelAlign.id) {
        this.updateChargePrice(data);
      } else {
        this.addChargePrice(data);
      }
    },
    updateChargePrice(data) {
      this.$PriceAjax
        .putChargePrice(data)
        .then(res => {
          if (res.data.success) {
            this.$emit("onCancel", true);
            this.$message.success("修改成功");
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
    addChargePrice(data) {
      this.$deviceAjax
        .postChargePrice(data)
        .then(res => {
          if (res.data.success) {
            this.$emit("onCancel", true);
            this.$message.success("新增成功");
          } else {
            this.$message.warning(res.data.errMsg);
          }
        })
        .catch(() => {});
    },
    provinceChangeAct() {
      this.$deviceAjax
        .getCityByProvinceId({ provinceId: this.formLabelAlign.provinceId })
        .then(res => {
          if (res.data.success) {
            this.cityOptions = res.data.model;
            this.formLabelAlign.cityId = this.cityOptions[0].cityId;
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
    }
  },
  watch: {
    isShow(val) {
      this.isCurrentShow = val;
    },
    rowData(val) {
      this.formLabelAlign = JSON.parse(JSON.stringify(val));
      Object.assign(this.formLabelAlign, this.formLabelAlign.address);
      console.log(
        this.formLabelAlign["ti" + 1 + "Start"],
        "formLabelAlign",
        this.formLabelAlign
      );
    }
  },
  destroyed() {}
};
</script>
<style>
.BillModelEdit .el-dialog__header {
	border-bottom: 1px solid #eeeeee;
}
.BillModelEdit .el-dialog--center .el-dialog__body {
	text-align: initial;
	padding: 25px 35px 5px 35px;
}
.BillModelEdit .timePickerClass {
	width: 100%;
	height: 32px;
	line-height: 32px;
}
.BillModelEdit .el-input .el-input__inner {
	width: 100%;
}
.BillModelEdit .timePickerClass .el-input__icon,
.BillModelEdit .timePickerClass .el-input__inner {
	height: 32px;
	line-height: 32px;
	width: 100%;
}
.BillModelEdit .el-input--small .el-input__inner {
	height: 40px;
	line-height: 40px;
}
.BillModelEdit .el-date-editor.el-input,
.BillModelEdit .el-date-editor.el-input__inner {
	width: 40%;
}
</style>
<style lang="scss" scoped>
.BillModelEdit {
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
		width: 100%;
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
