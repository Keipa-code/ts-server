import Vue from 'vue'
import VueRouter from 'vue-router'
import MainPage from "./pages/MainPage";
import AdminPage from "./pages/AdminPage";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: MainPage,
  },
  {
    path: '/manage',
    component: AdminPage,
  }
]

export default new VueRouter({
  mode: 'history',
  routes
})