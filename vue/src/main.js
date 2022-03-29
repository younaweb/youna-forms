import { createApp } from 'vue'
import store from './store'
import router from './router'
import App from './App.vue'
import './index.css'
import Notifications from 'notiwind'

createApp(App)
.use(store)
.use(router)
.use(Notifications)
.mount('#app')
