<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-2 w-100" id="navbar">
      <router-link @click.native="cerrarNavMobile" to="/">
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
        <NavItems />
        <ul v-if="authenticated" class="navbar-nav" style="margin-left: auto;">
          <li class="nav-item dropdown">
            <utn-button
              btnClass="dropdown-toggle btn btn-outline-primary btn-block"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              to="#"
            >
              <span class="icono">
                <i class="fas fa-user mr-1"></i>
              </span>
              {{ user.nombre_usuario }}
            </utn-button>
            <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdown">
              <router-link
                class="dropdown-item btn btn-link"
                to="/perfil"
                @click.native="cerrarNavMobile"
              >
                <i class="fas fa-id-card mr-1"></i>Perfil
              </router-link>
              <div class="dropdown-divider"></div>
              <button
                class="dropdown-item btn btn-link"
                @click="cerrarSesion"
                id="btn-cerrar-sesion"
              >
                <i class="fas fa-sign-out-alt mr-1"></i>Cerrar sesión
              </button>
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
                @click="cerrarNavMobile"
              >{{ item.name }}</utn-button>
            </li>
          </div>
        </ul>
      </div>
      <NavItemsMobile />
    </nav>
    <div v-if="!authenticated">
      <LogIn />
      <SignUp />
      <SearchUser />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Nav",
  components: {
    NavItems: () => import("./NavItems.vue"),
    NavItemsMobile: () => import("./NavItemsMobile.vue"),
    LogIn: () => import("../LogIn.vue"),
    SignUp: () => import("../SignUp.vue"),
    SearchUser: () => import("../SearchUser.vue")
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
      userNavItems: [
        {
          name: "Crear cuenta",
          icon: "fas fa-user-plus mr-1",
          btnClass: "btn btn-light btn-block",
          target: "#signUpPopup"
        },
        {
          name: "Iniciar sesión",
          icon: "fas fa-sign-in-alt mr-1",
          btnClass: "btn btn-primary btn-block",
          target: "#loginPopup"
        }
      ]
    };
  },
  methods: {
    cerrarNavMobile() {
      window.$(".navbar-collapse").removeClass("show");
    },

    cerrarSesion() {
      this.$store.dispatch("logOut");
    }
  }
};
</script>

<style scoped>
.headerLogo {
  width: 100px;
  margin: 0 22px;
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

@media (min-width: 992px) and (max-width: 1180px) {
  .icono {
    display: none;
  }
}
</style>