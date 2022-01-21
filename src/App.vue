<!--
 * @Descripttion: 
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2021-09-09 17:20:17
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-09-09 17:45:51
-->
<template>
  <keep-alive>
    <div id="app">
      <router-view v-slot="{ Component }">
        <component :is="Component" />
      </router-view>
    </div>
  </keep-alive>
</template>

<script>

export default {
  name: 'App',
  components: {

  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
