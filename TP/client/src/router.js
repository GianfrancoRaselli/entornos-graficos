import Vue from 'vue'
import Router from 'vue-router'
import store from './store'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  linkActiveClass: 'active',
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
      meta: {
        notAuthOrUsuario: true
      }
    },
    {
      path: '/ordenesMerito',
      name: 'Ordenes de merito',
      component: () => import('@/views/MeritOrders.vue'),
      meta: {
        notAuthOrUsuario: true
      }
    },
    {
      path: '/requisitos',
      name: 'Requisitos',
      component: () => import('@/views/Requirements.vue'),
    },
    {
      path: '/contacto',
      name: 'Contacto',
      component: () => import('@/views/Contact.vue'),
    },
    {
      path: '/administrarVacantes',
      name: 'Administrar Vacantes',
      component: () => import('@/views/AdminVacancies.vue'),
      meta: {
        auth: true,
        isAdministradorOrJefeCatedra: true
      }
    },
    {
      path: '/agregarVacante',
      name: 'Agregar Vacante',
      component: () => import('@/views/AddVacancy.vue'),
      meta: {
        auth: true,
        isAdministrador: true
      }
    },
    {
      path: '/perfil',
      name: 'Perfil',
      component: () => import('@/views/Perfil.vue'),
      meta: {
        auth: true
      }
    },
    {
      path: '/perfil/editar',
      name: 'Editar perfil',
      component: () => import('@/views/EditarPerfil.vue'),
      meta: {
        auth: true
      }
    }
  ]
})

router.beforeEach(async (to, from, next) => {
  let auth = to.matched.some(record => record.meta.auth);
  let notAuthOrUsuario = to.matched.some(record => record.meta.notAuthOrUsuario);
  let isAdministrador = to.matched.some(record => record.meta.isAdministrador);
  let isAdministradorOrJefeCatedra = to.matched.some(record => record.meta.isAdministradorOrJefeCatedra);

  if (auth && !store.getters.authenticated) {
    next('signin');
  } else if (notAuthOrUsuario && (store.getters.isAdministrador || store.getters.isJefeCatedra)) {
    next('');
  } else if(isAdministrador && !(store.getters.isAdministrador)) {
    next(from);
  } else if (isAdministradorOrJefeCatedra && !(store.getters.isAdministrador || store.getters.isJefeCatedra)) {
    next(from);
  } else {
    next();
  }
})

export default router;
