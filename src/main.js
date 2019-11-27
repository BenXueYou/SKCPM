import Vue from 'vue';
import router from './router';
import './style/element-variables.scss';
import './style/index.scss';
import ElementUI from 'element-ui';
import App from './App';
import echarts from 'echarts';
import store from '@/store/store.js';
import './permission.js';
// 注册富文本编辑器
import VueUeditorWrap from 'vue-ueditor-wrap';
// 以下为http.js的注册
import businessAjax from '@/http/businessAjax.js';
import deviceAjax from '@/http/deviceAjax.js';
import homeAjax from '@/http/homeAjax.js';
import loginAjax from '@/http/loginAjax.js';
import userAjax from '@/http/userAjax.js';
import staticsAjax from '@/http/staticsAjax.js';
import realAjax from '@/http/realAjax.js';
import mallAjax from '@/http/mallAjax.js';
import chargePriceAjax from '@/http/chargePriceAjax.js';
import EnterpriseAjax from '@/http/EnterpriseAjax.js';
import Toast from "@/utils/Toast.js";
import Common from '@/utils/Common.js';
import bankCode from '@/utils/bank_code.js';
import { EventBusPlugin as EventBus } from '@/utils/Eventbus';
Vue.component('vue-ueditor-wrap', VueUeditorWrap);
Vue.prototype.$echarts = echarts;
Vue.use(Common);
Vue.use(ElementUI);
Vue.use(loginAjax);
Vue.use(mallAjax);
Vue.use(businessAjax);
Vue.use(chargePriceAjax);
Vue.use(EnterpriseAjax);
Vue.use(deviceAjax);
Vue.use(homeAjax);
Vue.use(userAjax);
Vue.use(staticsAjax);
Vue.use(realAjax);
Vue.use(EventBus);
Vue.config.productionTip = false;
Vue.use(Toast);
Vue.prototype.$bankCode = bankCode;
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
});
