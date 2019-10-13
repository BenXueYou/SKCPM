import Vue from 'vue';
import Vuex from 'vuex';
import home from './modules/home';
import equipment from './modules/equipment';
import resident from './modules/resident';
Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    home,
    equipment,
    resident
  }
});

export default store;
