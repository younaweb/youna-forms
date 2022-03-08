<template>
<div>
<h3 class="text-2xl font-bold text-center">Login to your account</h3>
        <form action="" @submit="login">
            <div class="mt-4">
                <div>
                    <label class="block" for="email">Email</label>
                            <input type="text" placeholder="Email"  v-model="user.email"         
                                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                            <span class="text-xs tracking-wide text-red-600">Email field is required </span>
                </div>
                <div class="mt-4">
                    <label class="block">Password</label>
                            <input type="password" placeholder="Password" v-model="user.password"
                                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                </div>
                <div class="mt-4">
                    <label class="block">Remember me</label>
                            <input type="checkbox" v-model="user.remember">
                </div>
                <div class="flex items-baseline justify-between">
                    <button type="submit" class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">Login</button>
                    <router-link :to="{name:'Register'}" class="text-sm text-blue-600 hover:underline">don't have account. Sign Up !</router-link>
                </div>
            </div>
        </form>
</div>
        

</template>

<script setup>
import store from '../store'
import { useRouter } from 'vue-router'
const router = useRouter()
const user={
    email:'',
    password:'',
    remember:false
}
function login(ev){
    ev.preventDefault();
    store.dispatch('login',user).then(()=>{
        router.push({name:'Dashboard'})
    })
}

</script>

<style>

</style>