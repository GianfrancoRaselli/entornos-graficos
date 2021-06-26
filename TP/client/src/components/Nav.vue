<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 w-100">
    <router-link to="/">
      <img src="../assets/logo-utn.png" class="headerLogo" alt="Logo UTN" id="logo-utn">
    </router-link>
    <ul class="desktop-nav" style="margin-left: auto;">
      <utn-button icon="fas fa-home" btnClass="btn btn-light" to="/">
        Inicio
      </utn-button>
      <utn-button icon="fas fa-list-ul" btnClass="btn btn-light" to="/requisitos">
        Requisitos
      </utn-button>
      <utn-button icon="fas fa-hand-pointer" btnClass="btn btn-light" to="/vacantes" v-if="!authenticated || isUsuario">
        Vacantes
      </utn-button>
      <utn-button icon="fas fa-toolbox" btnClass="btn btn-light" to="/administrarVacantes" v-if="isAdministrador || isJefeCatedra">
        Administrar vacantes
      </utn-button>
      <utn-button icon="fas fa-plus-circle" btnClass="btn btn-light" to="/agregarVacante" v-if="isAdministrador">
        Agregar vacante
      </utn-button>
    </ul>
    <ul class="mobile-nav">
      <utn-button icon="fas fa-home" btnClass="btn btn-light" to="/">
        Inicio
      </utn-button>
      <utn-button icon="fas fa-list-ul" btnClass="btn btn-light" to="/requisitos">
        Requisitos
      </utn-button>
      <utn-button icon="fas fa-hand-pointer" btnClass="btn btn-light" to="/vacantes" v-if="!authenticated || isUsuario">
        Vacantes
      </utn-button>
      <utn-button icon="fas fa-toolbox" btnClass="btn btn-light" to="/administrarVacantes" v-if="isAdministrador || isJefeCatedra">
        Administrar vacantes
      </utn-button>
      <utn-button icon="fas fa-plus-circle" btnClass="btn btn-light" to="/agregarVacante" v-if="isAdministrador">
        Agregar vacante
      </utn-button>
    </ul>
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
        :key="index">
          {{ item.name }}
        </utn-button>
          <LogIn />
          <SignUp />
      </ul>
    </div>
  </nav>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  export default {
    name: 'Nav',
    components: {
      LogIn: () => import('./LogIn.vue'),
      SignUp: () => import('./SignUp.vue'),
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
          { name: 'Crear cuenta', icon: 'fas fa-user', btnClass: 'btn btn-light', target: '#signUpPopup' },
          { name: 'Iniciar sesión', icon: 'fas fa-id-card', btnClass: 'btn btn-primary', target: '#loginPopup' },
        ]
      }
    },
    methods: {
      ...mapActions({
        logOut: 'logOut'
      }),

      cerrarSesion() {
        this.logOut();
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

  .desktop-nav{
    list-style: none;
    display: flex;
    align-items: center;
    margin: 0;
  }

  .mobile-nav{
    display: none;
  }

  @media(max-width: 991px){
    .desktop-nav{
      display: none;
    }
    .mobile-nav{
      display: flex;
      position:fixed;
      bottom: 0;
      list-style: none;
      box-shadow: 0 -4px 20px 0 rgba(0,0,0,.08);
      justify-content: center;
      background-color:white;
      width: 100%;
      margin: 0;
      padding: 0;
      left: 0;
    }
  }
</style>