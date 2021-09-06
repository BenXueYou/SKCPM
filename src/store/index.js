/*
 * @Descripttion: 
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2021-09-02 14:32:11
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2021-09-02 15:25:32
 */
import { createStore } from 'vuex';
import state from "./state"
import getter from "./getters"
import mutations from "./mutations"
import actions from "./actions"

const store = createStore({
  state,
  getter,
  mutations,
  actions
});

export default store;