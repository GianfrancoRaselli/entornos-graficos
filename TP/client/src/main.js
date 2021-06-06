import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store/index'
import './axios'

// Components
Vue.component('utn-button', () => import('./components/Button.vue'));
Vue.component('Popup', () => import('./components/Popup.vue'));


Vue.config.productionTip = false

new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app')
