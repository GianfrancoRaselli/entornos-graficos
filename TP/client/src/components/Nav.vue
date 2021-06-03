<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 w-100">
    <router-link to="/">
      <img src="../assets/logo-utn.png" class="headerLogo" alt="Logo UTN" id="logo-utn">
    </router-link>
    <ul class="desktop-nav" style="margin-left: auto;">
      <li class="nav-item" v-for="(item, index) in navItems" :key="index">
        <utn-button :icon="item.icon" btnClass="btn btn-light" :to="item.routeTo">
          {{ item.name }}
        </utn-button>
      </li>
    </ul>
    <ul class="mobile-nav">
      <li class="nav-item" v-for="(item, index) in navItems" :key="index">
        <utn-button :icon="item.icon" btnClass="btn btn-light" :to="item.routeTo">
          {{ item.name }}
        </utn-button>
      </li>
    </ul>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul v-if="usuarioLogueado" class="navbar-nav" style="margin-left: auto;">
        <li class="nav-item">
          <utn-button btnClass="dropdown-toggle btn btn-outline-primary" id="navbarDropdown" icon="fas fa-user" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false" to="#">
            {{nombreUsuario}}
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
        <Popup dataTarget="loginPopup" title="Iniciar Sesión" :showButtons="false">
          <LogIn />
        </Popup>
        <Popup dataTarget="signUpPopup" title="Registrarse" :showButtons="false">
          <SignUp />
        </Popup>
      </ul>
    </div>
  </nav>
</template>

<script>
  import { EventBus } from '../event-bus'
  export default {
    name: 'Nav',
    components: {
      LogIn: () => import('./LogIn.vue'),
      SignUp: () => import('./SignUp.vue'),
    },
    data() {
      return {
        navItems: [
          { name: 'Inicio', routeTo: 'Home', icon: 'fas fa-home' },
          { name: 'Vacantes', routeTo: 'Vacantes', icon: 'fas fa-hand-pointer' },
        ],
        userNavItems: [
          { name: 'Crear cuenta', routeTo: 'SignUp', icon: 'fas fa-user', btnClass: 'btn btn-light', target: '#signUpPopup' },
          { name: 'Iniciar sesión', routeTo: 'SignIn', icon: 'fas fa-id-card', btnClass: 'btn btn-primary', target: '#loginPopup' },
        ],
        nombreUsuario: localStorage.getItem('nombre_usuario') || '',
        usuarioLogueado: localStorage.getItem('api_token') ? true : false
      }
    },
    created() {
      EventBus.$on('inicioSesion', function() {
        this.nombreUsuario = localStorage.getItem('nombre_usuario') || '';
        this.usuarioLogueado = localStorage.getItem('api_token') ? true : false;
      }.bind(this)),
      EventBus.$on('cerrarSesion', function() {
        this.cerrarSesion();
      }.bind(this))
    },
    methods: {
      cerrarSesion() {
        localStorage.removeItem('api_token');
        localStorage.removeItem('nombre_usuario');
        this.nombreUsuario = localStorage.getItem('nombre_usuario') || '';
        this.usuarioLogueado = localStorage.getItem('api_token') ? true : false;
        this.$router.push('/');
      }
    },
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