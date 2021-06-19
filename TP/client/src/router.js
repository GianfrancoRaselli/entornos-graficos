import Vue from 'vue'
import Router from 'vue-router'
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
      path: '/vacantes',
      name: 'Vacantes',
      component: () => import('@/views/Vacancies.vue'),
    },
    {
      path: '/administrarVacantes',
      name: 'administrar Vacantes',
      component: () => import('@/views/AdminVacancies.vue'),
      meta: {
        auth: true,
        isAdministradorOrJefeCatedra: true
      }
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
  let auth = to.matched.some(record => record.meta.auth);
  let notAuth = to.matched.some(record => record.meta.notAuth);
  let isAdministradorOrJefeCatedra = to.matched.some(record => record.meta.isAdministradorOrJefeCatedra);

  if (auth && !store.getters.authenticated) {
    next('signin');
  } else if (notAuth && store.getters.authenticated) {
    next('');
  } else if (isAdministradorOrJefeCatedra && !(store.getters.isAdministrador || store.getters.isJefeCatedra)) {
    next(from);
  } else {
    next();
  }
})

export default router;
