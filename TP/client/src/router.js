import Vue from 'vue'
import Router from 'vue-router'
import axios from 'axios'

import SignUp from './components/SignUp.vue'
import SignIn from './components/SignIn.vue'
import Perfil from './components/Perfil.vue'
import Inicio from './components/Inicio.vue'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '*',
            redirect: '/'
        },
        {
            path: '/signup',
            component: SignUp,
            meta: {
                notAuth: true
            }
        },
        {
            path: '/signin',
            component: SignIn,
            meta: {
                notAuth: true
            }
        },
        {
            path: '/perfil',
            component: Perfil,
            meta: {
                auth: true
            }
        },
        {
            path: '/',
            component: Inicio
        }
    ]
})


router.beforeEach(async (to, from, next) => {
    let persona = null;
    if (localStorage.getItem('api_token')) {
        try {
            let res = await axios.get('personas/perfil',
                {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('api_token')
                    }
                });

                persona = res.data;
        } catch (err) {
            localStorage.removeItem("api_token");
            localStorage.removeItem("nombre_usuario");
        }
    }
    let auth = to.matched.some(record => record.meta.auth);
    let notAuth = to.matched.some(record => record.meta.notAuth);

    if (auth && !persona) {
        next('signin');
    } else if (notAuth && persona) {
        next('');
    } else {
        next();
    }
})


export default router;
