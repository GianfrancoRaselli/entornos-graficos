import Vue from 'vue'
import Router from 'vue-router'
import axios from 'axios'
import store from './store'

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
  if (store.getters.authenticated) {
    try {
      let res = await axios.get('/personas/perfil',
      {
        headers: {
          Authorization: 'Bearer ' + store.getters.user.api_token
        }
      });

      persona = res.data[0];
    } catch (err) {
      if (err.response.status === 401) {
        store.dispatch('logOut');
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
