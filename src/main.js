/*
 * @Descripttion: 
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2021-09-01 17:46:05
 * @LastEditors: 
 * @LastEditTime: 2021-09-02 15:28:00
 */
import { createApp } from 'vue'
import App from './App.vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import store from './store/index'


const app = createApp(App).mount('#app')

app.use(ElementPlus)
app.use(store)


