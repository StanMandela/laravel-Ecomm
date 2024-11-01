import { createRouter, createWebHashHistory, createWebHistory } from "vue-router";
import AppLayout from '../components/AppLayout.vue'
import Dashboard from "../views/Dashboard.vue";
import Products from "../views/Products/Products.vue";
import Login from "../views/Login.vue";
import ResetPassword from "../views/RequestPassword.vue";
import RequestPassword from "../views/RequestPassword.vue";
import NotFound from "../views/NotFound.vue";
import store from "../store";

const routes=[
    {
      path:'/',
      redirect:'/app'

    },
    {
        path: '/app',
        name: 'app',
        redirect:'/app/dashboard',
        component: AppLayout,
        meta: {
          requiresAuth: true
        },
        children: [
          {
            path: 'dashboard',
            name: 'app.dashboard',
            component: Dashboard
          },
          {
            path: 'products',
            name: 'app.products',
            component: Products
          }
        ]
      },
    {
        path: '/login',
        name:'login',
        component: Login,
        meta:{
          requiresGuest: false

        }
    },
    {
        path: '/requestPassword',
        name:'requestPassword',
        component: RequestPassword
    },
    {
        path: '/resetPass',
        name:'resetPass',
        component: ResetPassword
    },
    {
      path: '/:pathMatch(.*)',
      name: 'notfound',
      component: NotFound,
    }
    
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {

    if (to.meta.requiresAuth && !store.state.user.token) {

      next({name: 'login'})

    } else if (to.meta.requiresGuest && store.state.user.token) {

      next({name: 'app.dashboard'})

    } else {

      next();
    }
  
  })

 export default router;