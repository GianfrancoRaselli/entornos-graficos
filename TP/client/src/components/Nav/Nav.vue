<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 w-100">
    <router-link to="/">
      <img
        src="../../assets/logo-utn.png"
        class="headerLogo"
        alt="Logo UTN"
        id="logo-utn"
        width="175px"
      />
    </router-link>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="dropdown-divider"></div>
      <ul class="navbar-nav">
        <li class="nav-item" v-for="(nav, index) in allUserNavs" :key="index">
          <utn-button btnClass="btn btn-light btn-block" :to="nav.router" exact>
            <i :class="nav.icon"></i>
            <span> {{ nav.name }}</span>
          </utn-button>
        </li>
      </ul>
      <NavItemsDesktop />
      <ul v-if="authenticated" class="navbar-nav" style="margin-left: auto;">
        <li class="nav-item">
          <utn-button
            btnClass="dropdown-toggle btn btn-outline-primary btn-block"
            id="navbarDropdown"
            icon="fas fa-user"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            to="#"
          >
            {{ user.nombre_usuario }}
          </utn-button>
          <div
            class="dropdown-menu dropdown-menu-lg-right"
            aria-labelledby="navbarDropdown"
          >
            <utn-button btnClass="dropdown-item btn btn-link" to="/perfil">
              <i class="fas fa-id-card"></i>
              Perfil
            </utn-button>
            <utn-button
              btnClass="dropdown-item btn btn-link"
              @click="cerrarSesion"
              id="btn-cerrar-sesion"
            >
              <i class="fas fa-sign-out-alt"></i>
              Cerrar Sesión
            </utn-button>
          </div>
        </li>
      </ul>
      <ul v-else class="navbar-nav" style="margin-left: auto;">
        <div v-for="(item, index) in userNavItems" :key="index">
          <li>
            <utn-button
              data-toggle="modal"
              :btnClass="item.btnClass"
              :data-target="item.target"
              :icon="item.icon"
            >
              {{ item.name }}
            </utn-button>
          </li>
        </div>
        <LogIn />
        <SignUp />
      </ul>
    </div>
    <NavItemsMobile/>
  </nav>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Nav",
  components: {
    NavItemsDesktop: () => import("./NavItemsDesktop.vue"),
    NavItemsMobile: () => import("./NavItemsMobile.vue"),
    LogIn: () => import("../LogIn.vue"),
    SignUp: () => import("../SignUp.vue")
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      isAdministrador: "isAdministrador",
      isJefeCatedra: "isJefeCatedra",
      isUsuario: "isUsuario",
      user: "user"
    })
  },
  data() {
    return {
      allUserNavs:[
        {
          name:'Inicio',
          icon:'fas fa-home',
          router:'/'
        },
        {
          name:'Requisitos',
          icon:'fas fa-list-ul',
          router:'/requisitos'
        },
        {
          name:'Contacto',
          icon:'fas fa-map-marker-alt',
          router:'/contacto'
        },
        {
          name:'Vacantes',
          icon:'fas fa-hand-pointer',
          router:'/vacantes'
        },
        {
          name:'Ordenes de mérito',
          icon:'fas fa-clipboard-list',
          router:'/ordenesMerito'
        },
      ],
      userNavItems: [
        {
          name: "Crear cuenta",
          icon: "fas fa-user-plus",
          btnClass: "btn btn-light btn-block",
          target: "#signUpPopup"
        },
        {
          name: "Iniciar sesión",
          icon: "fas fa-sign-in-alt",
          btnClass: "btn btn-primary btn-block",
          target: "#loginPopup"
        }
      ]
    };
  },
  methods: {
    cerrarSesion() {
      this.$store.dispatch("logOut");
    }
  }
};
</script>

<style scoped>
.headerLogo {
  width: 100px;
  margin: 0 25px;
}

.navbar {
  box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.08);
}

.btn {
  width: 100%;
  text-align: left;
}

#btn-cerrar-sesion {
  color: red;
}
</style>