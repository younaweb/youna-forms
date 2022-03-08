import { createRouter, createWebHistory } from "vue-router";
import Login from '../views/Login.vue'
import DefaultLayout from '../components/DefaultLayout.vue'
import AuthLayout from '../components/AuthLayout.vue'
import Dashboard from '../views/Dashboard.vue'
import Forms from '../views/Forms.vue'
import Register from '../views/Register.vue'
import store from '../store'


const routes=[
    {
        path:'/',
        redirect:'/dashboard',
        name:'Dashboard',
        component:DefaultLayout,
        meta:{
            requireAuth:true,
        },
        children:[
            {path:'/dashboard',name:'Dashboard',component:Dashboard},
            {path:'/forms',name:'Forms',component:Forms}
        ]
    },
    {
        path:'/auth',
        redirect:'/login',
        name:'Auth',
        component:AuthLayout,
        meta:{
            isGuest:true,
        },
        children:[
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
        ]
    },
    
];



const router= createRouter({
    history:createWebHistory(),
    routes,
});

router.beforeEach((to,from,next)=>{
    if(to.meta.requireAuth && !store.state.user.token){
        next({name:'Login'})
    }else if(store.state.user.token && to.meta.isGuest){
        next({name:'Dashboard'})
    }else{
        next()
    }
});



export default router;