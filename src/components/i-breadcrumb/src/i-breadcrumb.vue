<template>
  <el-breadcrumb :separator-icon="ArrowRight" :separator="separator">
    <el-breadcrumb-item v-for="(item, index) in breadcrumbArr" :key="index">{{ item.label }}</el-breadcrumb-item>
  </el-breadcrumb>
</template>
<script>
import { ArrowRight } from '@element-plus/icons-vue'
export default {
  name:"IBreadCrumb",
  props:{
    separator: {
      type: String,
      default: "/"
    },
    breadcrumbArr: {
      type: Array,
      default(){
        return []
      }
    }
  },
  // components:{ ArrowRight },
  data() {
    return {
      ArrowRight,
      username: "用户名"
    };
  },
  computed: {
    loginId(){
      return this.$store?.state?.home?.loginId;
    }
  },
  methods: {
    handleCommand() {
      this.onClickQuit();
    },
    onClickQuit() {
      this.$store.dispatch("setAccount", "");
      this.$store.dispatch("setAuthorization", "");
      this.$store.dispatch("setOperatorId", []);
      this.$store.dispatch("SET_USERUUID", "");
      this.$store.dispatch("setOperatorArr", []);
      this.$store.dispatch("setChargeStationArr", []);
      this.$store.dispatch("setProvinceArr", []);
      this.$store.dispatch("setChargeFactoryArr", []);
      this.$store.dispatch("setChargeFactoryArr", []);
      this.$store.dispatch("setRoleId", "");
      this.$store.dispatch("setAccount", "");
      this.$store.dispatch("setEnterpriseUser", "");
      this.$store.dispatch("setLoginId", "");

      this.$router.push({
        name: "Login"
      });
    }
  }
};
</script>
<style scoped lang='scss'>
@import "@/styles/index.scss";
.header {
  height: 100%;
  padding: 0;
  display: flex;
  -ms-flex-flow: row nowrap;
  flex-flow: row nowrap;
  -ms-flex-align: center;
  align-items: center;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);
  background-image: linear-gradient(60deg, #354054, #ffffff);
  .headLeft {
    width: 20%;
    height: 100%;
    max-width: 200px;
    background: $--color-left-menu;
    text-align: left;
    img {
      width: 100%;
      height: 100%;
    }
  }
  .head-top {
    text-align: right;
    line-height: 100%;
    .m-account-header {
      cursor: pointer;
      line-height: 30px;
      font-family: "PingFangSC-Light";
      font-size: 12px;
      color: #363636;
      letter-spacing: 0;
      text-align: left;
      span {
        padding-left: 15px;
      }
      img {
        vertical-align: top;
      }
    }
    .quit-btn {
      margin-left: auto;
      margin-right: 1%;
      .quit-btn-icon {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        .quit-btn-text {
          font-family: "PingFangSC-Regular";
          font-size: 12px;
          color: #dddddd;
          letter-spacing: 0;
          text-align: right;
          margin-left: 6px;
        }
      }
    }
  }
}
</style>
