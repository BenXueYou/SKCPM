<template>
	<div class="ProPileAdd">
		<el-header>发布充电桩</el-header>
		<el-form ref="form" :model="form" label-width="120px">
			<el-form-item label="添加图片：" style="text-align:left;">
				<el-upload
					action="https://jsonplaceholder.typicode.com/posts/"
					list-type="picture-card"
					:on-preview="handlePictureCardPreview"
					:on-remove="handleRemove"
				>
					<i class="el-icon-plus"></i>
				</el-upload>
			</el-form-item>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="产品名称：" prop="pileName">
						<el-input class="time-interal" v-model="form.pileName" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="产品型号：" prop="pileType">
						<el-input class="time-interal" v-model="form.pileType" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="输出电压：" prop="outVoltage">
						<el-input class="time-interal" v-model="form.outVoltage" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="轮廓尺寸：" prop="size">
						<el-input class="time-interal" v-model="form.size" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-form-item label="输入电压：">
				<el-input v-model="form.inVoltage"></el-input>
			</el-form-item>
			<el-form-item label="输出电流：">
				<el-input v-model="form.outCurrent"></el-input>
			</el-form-item>
			<el-form-item label="最大输出电流：">
				<el-input v-model="form.maxOutCurrent"></el-input>
			</el-form-item>
			<el-form-item label="输出功率：">
				<el-input v-model="form.outPower"></el-input>
			</el-form-item>

			<el-form-item label="产品说明：">
				<el-input type="textarea" v-model="form.description"></el-input>
			</el-form-item>
			<el-form-item label="产品优势：">
				<el-input type="textarea" v-model="form.advantage"></el-input>
			</el-form-item>
		</el-form>
		<el-footer>
			<el-button type="primary" @click="onSubmit">保存</el-button>
			<el-button @click="onClose">取消</el-button>
		</el-footer>
	</div>
</template>
<script>
export default {
  data() {
    return {
      dialogImageUrl: "",
      dialogVisible: false,
      form: {
        advantage: "",
        description: "",
        inVoltage: "",
        maxOutCurrent: "",
        outCurrent: "",
        outPower: "",
        outVoltage: "",
        picUrl: "",
        pileName: "",
        pileType: "",
        size: ""
      }
    };
  },
  methods: {
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    onSubmit() {
      console.log("submit!");
    },
    onClose() {
      this.$emit("onCancel");
    }
  }
};
</script>
<style lang="scss" scoped>
.ProPileAdd {
	width: 60%;
	margin: 10px auto;
	min-height: calc(100% - 60px);
	-webkit-box-shadow: 0 2px 30px 0 rgba(0, 0, 0, 0.2);
	box-shadow: 0 2px 30px 0 rgba(0, 0, 0, 0.2);
	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		from(#f1f5f8),
		color-stop(#efefef),
		to(#ffffff)
	);
	background-image: linear-gradient(180deg, #f1f5f8, #efefef, #ffffff);
	background-color: #ffffff;
	padding: 25px 10%;
	border-radius: 5px;
	box-sizing: border-box;
	.el-header {
		font-size: 24px;
		color: #363636;
	}
}
</style>
