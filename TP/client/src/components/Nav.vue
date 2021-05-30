<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 w-100">
    <router-link to="/">
      <img src="../assets/logo-utn.png" class="headerLogo" alt="Logo UTN" id="logo-utn">
    </router-link>
    <ul class="navbar-nav" style="margin-left: auto;">
      <li class="nav-item" v-for="(item, index) in navItems" :key="index">
        <utn-button :icon="item.icon" btnClass="btn btn-light" :name="item.name" :to="item.routeTo" />
      </li>
    </ul>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul v-if="usuarioLogueado" class="navbar-nav" style="margin-left: auto;">
        <li class="nav-item">
          <router-link class="nav-link btn btn-link" to="/">
            <i class="fas fa-home"></i>
            Inicio
          </router-link>
        </li>
        <li class="nav-item dropdown">
          <button class="nav-link dropdown-toggle btn btn-link" id="navbarDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i>
            {{nombreUsuario}}
          </button>
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
        <li class="nav-item" v-for="(item, index) in userNavItems" :key="index">
          <utn-button :name="item.name" :btnClass="item.btnType" :icon="item.icon" :to="item.routeTo" />
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
  import { EventBus } from '../event-bus'
  export default {
    name: 'Nav',
    data() {
      return {
        navItems: [
          { name: 'Inicio', routeTo: 'Home', icon: 'fas fa-home'},
          { name: 'Vacantes', routeTo: 'Home', icon: 'fas fa-hand-pointer'},
        ],
        userNavItems: [
          { name: 'Crear cuenta', routeTo: 'SignUp', icon: 'fas fa-user', btnType: 'btn btn-light' },
          { name: 'Iniciar sesión', routeTo: 'SignIn', icon: 'fas fa-id-card', btnType: 'btn btn-primary' },
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
</style>