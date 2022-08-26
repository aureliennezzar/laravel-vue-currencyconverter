import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios';
import './assets/main.css'
import router from './router/index.js';

createApp(App)
    .use(router)
    .mount('#app')

