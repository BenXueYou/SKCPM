<template>
  <el-row class="header" type="flex" justify="space-between">
    <el-col :span="8" class="headLeft logo">
      <img src="@/assets/left_headr_sk_logo.png" alt srcset />
    </el-col>
    <el-col :span="16" class="head-top">
      <el-dropdown trigger="click" @command="handleCommand" class="quit-btn">
        <span class="m-account-header">
          <img src="@/assets/images/header.png" alt />
          <span class="userName">{{loginId}}</span>
          <i class="el-icon-caret-bottom el-icon--right"></i>
        </span>
        <template #dropdown>
          <el-dropdown-menu>
            <el-dropdown-item class="dropdown-li" disabled command="xiugai">
              <span class="myAccountItem">
                <img src="@/assets/images/mima.png" class="normal" width="14px" height="14px" />
                <span>修改密码</span>
              </span>
            </el-dropdown-item>
            <el-dropdown-item class="dropdown-li" command="tuichu">
              <span class="myAccountItem">
                <img src="@/assets/images/tuichu.png" class="normal" width="14px" height="14px" />
                <span>退出</span>
              </span>
            </el-dropdown-item>
          </el-dropdown-menu>
        </template>
      </el-dropdown>
    </el-col>
  </el-row>
</template>
<script>
export default {
  name:"IHeader",
  data() {
    return {
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
