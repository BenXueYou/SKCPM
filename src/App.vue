<template>
	<div id="app">
		<router-view />
	</div>
</template>
<script>
export default {
  name: "App",
  data() {
    return {
      mainRoute: "/Main/Home"
    };
  },
  mounted() {
    if (this.$route.fullPath.indexOf("/Main") !== -1) {
      this.mainRoute = this.$route.fullPath;
    }
  },
  watch: {
    "$route.path": function(newVal, oldVal) {
      console.log(newVal);
      // 添加门禁控制的默认路径
      if (newVal === "/Main") {
        this.$router.push(this.mainRoute);
      }
    }
  }
};
</script>
<style>
#app {
	font-family: "Avenir", Helvetica, Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-align: center;
	color: #2c3e50;
	height: 100%;
	min-width: 1440px;
}
</style>
