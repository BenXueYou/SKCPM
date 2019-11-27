<template>
	<div class="ProCarAdd">
		<el-header>发布车辆</el-header>
		<el-form ref="form" :model="form" label-width="240px">
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
					<el-form-item label="车型：" prop="carType">
						<el-input class="time-interal" v-model="form.carType" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="型式：" prop="carEnergyType">
						<el-input class="time-interal" v-model="form.carEnergyType" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="长（mm）：" prop="carLength">
						<el-input class="time-interal" v-model="form.carLength" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="宽（mm）：" prop="carWidth">
						<el-input class="time-interal" v-model="form.carWidth" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="高（mm）：" prop="carHigh">
						<el-input class="time-interal" v-model="form.carHigh" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="驱动形式：" prop="carDriverType">
						<el-input class="time-interal" v-model="form.carDriverType" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="轴距（mm）：" prop="wheelBase">
						<el-input class="time-interal" v-model="form.outVoltage" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="前悬（mm）：" prop="frontOverhang">
						<el-input class="time-interal" v-model="form.size" size="frontOverhang"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="后悬（mm）：" prop="rearOverhang">
						<el-input class="time-interal" v-model="form.rearOverhang" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="轮距（前轮 mm ）：" prop="trackFront">
						<el-input class="time-interal" v-model="form.trackFront" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="轮距（后轮 mm）：" prop="rearFront">
						<el-input class="time-interal" v-model="form.rearFront" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="最小离地间距（mm）：" prop="minSpace">
						<el-input class="time-interal" v-model="form.minSpace" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="乘客门一级踏步离地高（mm）：" prop="midSpace">
						<el-input class="time-interal" v-model="form.midSpace" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="额定成员（人）：" prop="ratedNum">
						<el-input class="time-interal" v-model="form.ratedNum" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="乘客座椅数（座）：" prop="ratedChair">
						<el-input class="time-interal" v-model="form.ratedChair" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="车辆容积(m³)：" prop="carVolume">
						<el-input class="time-interal" v-model="form.carVolume" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="电池容量（KWh）：" prop="batteryCapacity">
						<el-input class="time-interal" v-model="form.batteryCapacity" size="small"></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="续航载货（KM）：" prop="cargo">
						<el-input class="time-interal" v-model="form.cargo" size="small"></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="租赁方案：" prop="rentId">
						<el-select
							class="time-interal"
							v-model="form.rentId"
							size="small"
							clearable
							placeholder="请选择"
						>
							<el-option
								v-for="item in rentOptions"
								:key="item.rentId"
								:label="item.rentName"
								:value="item.rentId"
							></el-option>
						</el-select>
					</el-form-item>
				</el-col>
			</el-row>
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
      rentOptions: [],
      form: {
        batteryCapacity: "string",
        carDriverType: "string",
        carEnergyType: "string",
        carHigh: 0,
        carId: 0,
        carLength: 0,
        carType: "string",
        carVolume: 0,
        carWidth: 0,
        cargo: "string",
        frontOverhang: 0,
        gmtCreate: "2019-11-27T08:20:32.680Z",
        gmtModify: "2019-11-27T08:20:32.680Z",
        id: 0,
        isDeleted: 0,
        midSpace: 0,
        minSpace: 0,
        ratedChair: 0,
        ratedNum: 0,
        rearFront: 0,
        rearOverhang: 0,
        rentId: "string",
        trackFront: 0,
        url: "string",
        wheelBase: 0
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
.ProCarAdd {
	width: 70%;
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
	padding: 25px 10% 25px 5%;
	border-radius: 5px;
	box-sizing: border-box;
	.el-header {
		font-size: 24px;
		color: #363636;
	}
}
</style>
