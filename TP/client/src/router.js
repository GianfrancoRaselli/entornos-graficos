import Vue from 'vue'
import Router from 'vue-router'
import axios from 'axios'
import { EventBus } from './event-bus'

import SignUp from './views/SignUp.vue'
import SignIn from './views/SignIn.vue'
import Inicio from './views/Inicio.vue'
import Perfil from './views/Perfil.vue'
import EditarPerfil from './views/EditarPerfil.vue'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '*',
            redirect: '/',
        },
        {
            path: '/signup',
            name: 'SignUp',
            component: SignUp,
            meta: {
                notAuth: true
            }
        },
        {
            path: '/signin',
            name: 'SignIn',
            component: SignIn,
            meta: {
                notAuth: true
            }
        },
        {
            path: '/',
            name: 'Home',
            component: Inicio
        },
        {
            path: '/Vacantes',
            name: 'Vacantes',
            component: () => import('@/views/Vacancies.vue'),
        },
        {
            path: '/perfil',
            name: 'Profile',
            component: Perfil,
            meta: {
                auth: true
            }
        },
        {
            path: '/perfil/editar',
            name: 'EditProfile',
            component: EditarPerfil,
            meta: {
                auth: true
            }
        }
    ]
})


router.beforeEach(async (to, from, next) => {
    let persona = null;
    if (localStorage.getItem('api_token')) {
        try {
            let res = await axios.get('http://localhost/entornos-graficos-2021/TP/server/public/personas/perfil',
            {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('api_token')
                }
            });

            persona = res.data[0];
        } catch (err) {
            if (err.response.status === 401) {
                EventBus.$emit('cerrarSesion');
            }
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
