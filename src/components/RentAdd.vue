<template>
	<div class="RentAdd">
		<el-header>添加租赁方案</el-header>
		<el-form ref="form" :model="form" label-width="150px">
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="车型：" prop="carType">
						<el-input class="time-interal" v-model="form.carType" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="售价（万元）：" prop="carPrice">
						<el-input class="time-interal" v-model="form.carPrice" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row>纯租赁</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="押金（<10辆）：" prop="leaseDeposit">
						<el-input class="time-interal" v-model="form.leaseDeposit" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="押金（>10辆）：" prop="leaseDepositMax">
						<el-input class="time-interal" v-model="form.leaseDepositMax" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="租金（<10辆）：" prop="leaseRent">
						<el-input class="time-interal" v-model="form.leaseRent" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="租金（>10辆）：" prop="leaserEntMax">
						<el-input class="time-interal" v-model="form.leaserEntMax" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-form-item label="说明：">
				<el-input type="textarea" v-model="form.leaseRemark" clearable></el-input>
			</el-form-item>
			<el-row>以租代售</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="押金（<10辆）：" prop="sellDeposit">
						<el-input class="time-interal" v-model="form.sellDeposit" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="押金（>10辆）：" prop="sellDepositMax">
						<el-input class="time-interal" v-model="form.sellDepositMax" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="space-between">
				<el-col :span="12">
					<el-form-item label="租金（<10辆）：" prop="sellRent">
						<el-input class="time-interal" v-model="form.sellRent" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
				<el-col :span="12">
					<el-form-item label="租金（>10辆）：" prop="sellRentMax">
						<el-input class="time-interal" v-model="form.sellRentMax" size="small" clearable></el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-form-item label="说明：">
				<el-input type="textarea" v-model="form.sellRemark" clearable></el-input>
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
        carPrice: 0,
        carType: "string",
        leaseDeposit: 0,
        leaseDepositMax: 0,
        leaseRemark: "string",
        leaseRent: 0,
        leaserEntMax: 0,
        rentId: 0,
        sellDeposit: 0,
        sellDepositMax: 0,
        sellRemark: "string",
        sellRent: 0,
        sellRentMax: 0
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
.RentAdd {
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
	padding: 25px 10% 25px 5%;
	border-radius: 5px;
	box-sizing: border-box;
	.el-header {
		font-size: 24px;
		color: #363636;
	}
}
</style>
