import { createApp } from 'vue'
import App from './App.vue'

import VueAxios from "vue-axios";
import axios from "axios";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import Pagination from "v-pagination-3";

import SideBarVue from './components/sidebar.vue';
import NavBar from './components/navbar.vue'


import home from "./views/home/home.vue";
import management from "./views/management/index.vue";
import gameManagement from "./views/management/game.vue";
import categoryManagement from "./views/management/category.vue";



import { createWebHistory, createRouter } from "vue-router";
const routes = [
  {
    path: "/",
    name: "home",
    component: home,
  },
  {
    path: "/management",
    name: "management",
    component: management,
    children: [
      {
        path: '',
        name:"game",
        component: gameManagement
      },
      {
        path: 'category',
        name:'category',
        component: categoryManagement,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});
axios.defaults.headers.get['header-name'] = 'value'
const app=createApp(App)
app.use(router);
app.use(Toast);
app.use(VueAxios, axios);
app.component("pagination", Pagination);
app.component(SideBarVue,NavBar)
app.mount('#app')
