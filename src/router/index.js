/*
 * @Descripttion: 
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2021-09-02 14:32:26
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-09-02 15:32:47
 */
import VueRouter from "vue-router";

export default VueRouter.createRouter({
  // 4. 内部提供了 history 模式的实现。为了简单起见，我们在这里使用 hash 模式。
  history: VueRouter.createWebHashHistory(),
  routes: [], // `routes: routes` 的缩写
})