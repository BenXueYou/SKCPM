/*
 * @Descripttion: 
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2021-09-01 17:46:05
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-09-11 16:51:22
 */
import { createApp } from 'vue'
import App from './App.vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import store from './store/index'
import router from './router/index'
import IC from "@/components/index"
import '@/styles/index.scss';

import { Upload, Fold,  Expand} from '@element-plus/icons-vue'


const app = createApp(App).use(store).use(router).use(ElementPlus).use(IC);

 [Upload, Expand, Fold].forEach((IC)=>{
   app.component(IC.name, IC)
 })

app.mount('#app');


