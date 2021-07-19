import Vue from 'vue'
import Router from 'vue-router'
import store from './store'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  linkActiveClass: 'active',
  routes: [
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: { name: '404' },
    },
    {
      path: '/404', name: '404',
      component: () => import('@/views/404.vue'),
    },
    {
      path: '/',
      name: 'Home',
      component: () => import('@/views/Inicio.vue'),
    },
    {
      path: '/mapasitio',
      name: 'Mapa de Sitio',
      component: () => import('@/views/SiteMap.vue'),
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
      path: '/preguntasFrecuentes',
      name: 'Preguntas Frecuentes',
      component: () => import('@/views/PreguntasFrecuentes.vue'),
    },
    {
      path: '/glosario',
      name: 'Glosario',
      component: () => import('@/views/Glosario.vue'),
    },
    {
      path: '/cambiarClave/:codigo',
      name: 'Cambiar Clave',
      component: () => import('@/views/ChangePass.vue'),
      meta: {
        notAuth: true
      }
    },
    {
      path: '/administrarVacantes',
      name: 'Administrar Vacantes',
      component: () => import('@/views/AdminVacancies.vue'),
      meta: {
        isAdministradorOrJefeCatedra: true
      }
    },
    {
      path: '/agregarVacante',
      name: 'Agregar Vacante',
      component: () => import('@/views/AddVacancy.vue'),
      meta: {
        isAdministrador: true
      }
    },
    {
      path: '/administrarCatedras',
      name: 'Administrar Catedras',
      component: () => import('@/views/AdminCathedras.vue'),
      meta: {
        isAdministrador: true
      }
    },
    {
      path: '/agregarCatedra',
      name: 'Agregar Catedra',
      component: () => import('@/views/AddCathedra.vue'),
      meta: {
        isAdministrador: true
      }
    },
    {
      path: '/agregarCatedra/:id_catedra',
      name: 'Editar Catedra',
      component: () => import('@/views/AddCathedra.vue'),
      meta: {
        isAdministrador: true
      }
    },
    {
      path: '/verificarIdentidades',
      name: 'Verificar Identidades',
      component: () => import('@/views/VerificarIdentidades.vue'),
      meta: {
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
  let notAuth = to.matched.some(record => record.meta.notAuth);
  let notAuthOrUsuario = to.matched.some(record => record.meta.notAuthOrUsuario);
  let isAdministrador = to.matched.some(record => record.meta.isAdministrador);
  let isAdministradorOrJefeCatedra = to.matched.some(record => record.meta.isAdministradorOrJefeCatedra);

  if (!to.matched.length) {
    next('*');
  } else {
    next();
  }

  if (notAuth && store.getters.authenticated) {
    next('');
  } else if (auth && !store.getters.authenticated) {
    next('');
  } else if (notAuthOrUsuario && !(!store.getters.authenticated || store.getters.isUsuario)) {
    next('');
  } else if (isAdministradorOrJefeCatedra && !(store.getters.isAdministrador || store.getters.isJefeCatedra)) {
    next(from);
  } else if (isAdministrador && !(store.getters.isAdministrador)) {
    next(from);
  } else {
    next();
  }
})

export default router;
