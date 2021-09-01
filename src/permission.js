/*
 * @Descripttion:
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2020-12-18 09:54:54
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-09-01 15:46:30
 */
import router from './router';
import store from '@/store/store';
const whiteList = ['/Login'];// 不重定向白名单

router.beforeEach((to, from, next) => {
  // eslint-disable-next-line no-constant-condition
  if (store.state.home.Authorization && store.state.home.OperatorId) {
    if (to.path === '/Login') {
      next();
    } else {
      next();
    }
  } else {
    if (whiteList.indexOf(to.path) !== -1) {
      next();
    } else {
      next('/Login'); // 否则全部重定向到登录页
    }
  }
});

router.afterEach(() => {
  // NProgress.done() // 结束Progress
});
