
<template>
  <el-container class="layout">
    <el-header>
      <i-header></i-header>
    </el-header>
    <el-container>
      <el-aside width="200px">
        <!-- <el-scrollbar style="100%"> -->
          <i-page-menu></i-page-menu>
        <!-- </el-scrollbar> -->
      </el-aside>
      <el-main>
        <router-view v-slot="{ Component }">
          <component :is="Component" />
        </router-view>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
export default {
  data() {
    const item = {
      date: "2016-05-02",
      name: "王小虎",
      address: "上海市普陀区金沙江路 1518 弄",
    };
    return {
      tableData: Array(20).fill(item),
    };
  },
};
</script>

<style lang="scss" scoped>
.layout {
  height: 100%;
  min-height: 100vh;
  .el-header {
    background-color: #b3c0d1;
    color: var(--el-text-color-primary);
    line-height: 60px;
    padding: 0;
  }

  .el-aside {
    color: var(--el-text-color-primary);
    height: 100%;
  }
}
</style>
