import Vue from 'vue'
import App from './App.vue'
import router from './router'
import './axios'

// Components
Vue.component('utn-button', () => import('./components/Button.vue'));


Vue.config.productionTip = false

new Vue({
    router,
    render: h => h(App),
}).$mount('#app')
