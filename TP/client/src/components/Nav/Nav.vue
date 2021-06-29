<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 w-100">
    <router-link to="/">
      <img src="../../assets/logo-utn.png" class="headerLogo" alt="Logo UTN" id="logo-utn">
    </router-link>
    <NavItems navItemsclass="desktop-nav" />
    <NavItems navItemsclass="mobile-nav" />
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul v-if="authenticated" class="navbar-nav" style="margin-left: auto;">
        <li class="nav-item">
          <utn-button btnClass="dropdown-toggle btn btn-outline-primary" id="navbarDropdown" icon="fas fa-user" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false" to="#">
            {{ user.nombre_usuario }}
          </utn-button>
          <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdown">
            <router-link class="dropdown-item btn btn-link" to="/perfil">
              <i class="fas fa-id-card"></i>
              Perfil
            </router-link>
            <div class="dropdown-divider"></div>
            <button class="dropdown-item btn btn-link" @click="cerrarSesion" id="btn-cerrar-sesion">
              <i class="fas fa-sign-out-alt"></i>
              Cerrar Sesión
            </button>
          </div>
        </li>
      </ul>
      <ul v-else class="navbar-nav" style="margin-left: auto;">
        <utn-button
          v-for="(item, index) in userNavItems"
          data-toggle="modal"
          :btnClass="item.btnClass"
          :data-target="item.target"
          :icon="item.icon"
          :key="index"
        >
          {{ item.name }}
        </utn-button>
        <LogIn />
        <SignUp />
      </ul>
    </div>
  </nav>
</template>

<script>
  import { mapGetters } from 'vuex'
  export default {
    name: 'Nav',
    components: {
      NavItems: () => import('./NavItems.vue'),
      LogIn: () => import('../LogIn.vue'),
      SignUp: () => import('../SignUp.vue'),
    },
    computed: {
      ...mapGetters({
        authenticated: 'authenticated',
        isAdministrador: 'isAdministrador',
        isJefeCatedra: 'isJefeCatedra',
        isUsuario: 'isUsuario',
        user: 'user',
      })
    },
    data() {
      return {
        userNavItems: [
          { name: 'Crear cuenta', icon: 'fas fa-user-plus', btnClass: 'btn btn-light', target: '#signUpPopup' },
          { name: 'Iniciar sesión', icon: 'fas fa-sign-in-alt', btnClass: 'btn btn-primary', target: '#loginPopup' },
        ]
      }
    },
    methods: {
      cerrarSesion() {
        this.$store.dispatch('logOut');
      }
    }
  }
</script>

<style scoped>
  .headerLogo {
    width: 100px;
    margin: 0 25px;
  }

  .navbar{
    box-shadow: 0 4px 20px 0 rgba(0,0,0,.08);
  }

  .btn {
    width: 100%;
    text-align: left;
  }

  #btn-cerrar-sesion {
    color: red;
  }
</style>