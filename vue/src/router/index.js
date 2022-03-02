import { createRouter, createWebHistory } from "vue-router";
import Login from '../views/Login.vue'
import DefaultLayout from '../components/DefaultLayout.vue'
import Dashboard from '../views/Dashboard.vue'
import Forms from '../views/Forms.vue'
import Register from '../views/Register.vue'

const routes=[
    {
        path:'/',
        redirect:'/dashboard',
        name:'Dashboard',
        component:DefaultLayout,
        children:[
            {path:'/dashboard',name:'Dashboard',component:Dashboard},
            {path:'/forms',name:'Forms',component:Forms}
        ]
    },
    {
        path:'/login',
        name:'Login',
        component:Login,
    },
    {
        path:'/register',
        name:'Register',
        component:Register,
    },
];

const router= createRouter({
    history:createWebHistory(),
    routes,
});

export default router;