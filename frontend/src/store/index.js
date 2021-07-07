import Vue from 'vue'
import Vuex from 'vuex'
import searchModule from "./searchModule";

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    searchModule
  }
})