import Vue from 'vue'
import Router from 'vue-router'
import axios from 'axios'
// import { EventBus } from './event-bus'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '*',
      redirect: '/',
    },
    {
      path: '/',
      name: 'Home',
      component: () => import('@/views/Inicio.vue'),
    },
    {
      path: '/Vacantes',
      name: 'Vacantes',
      component: () => import('@/views/Vacancies.vue'),
    },
    {
      path: '/perfil',
      name: 'Profile',
      component: () => import('@/views/Perfil.vue'),
      meta: {
        auth: true
      }
    },
    {
      path: '/perfil/editar',
      name: 'EditProfile',
      component: () => import('@/views/EditarPerfil.vue'),
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
      let res = await axios.get('/personas/perfil',
      {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('api_token')
        }
      });

      persona = res.data[0];
    } catch (err) {
      if (err.response.status === 401) {
        console.log('cerrar sesion');
        // EventBus.$emit('cerrarSesion');
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
