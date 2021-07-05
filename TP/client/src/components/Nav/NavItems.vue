<template>
  <ul class="navbar-nav">
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/" exact>
        <i class="fas fa-home"></i>&nbsp;Inicio
      </router-link>
    </li>
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/contacto" exact>
        <i class="fas fa-map-marker-alt"></i>&nbsp;Contacto
      </router-link>
    </li>
    <li class="nav-item dropdown">
      <a
        class="dropdown-toggle btn btn-light btn-block"
        href="#"
        role="button"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
      >
        <i class="fas fa-hand-pointer"></i>&nbsp;Vacantes
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link
          class="dropdown-item"
          to="/requisitos"
          exact
          v-if="!authenticated || isUsuario"
        >
          <i class="fas fa-list-ul"></i>&nbsp;Requisitos
        </router-link>
        <div class="dropdown-divider"></div>
        <router-link
          class="dropdown-item"
          to="/vacantes"
          exact
          v-if="!authenticated || isUsuario"
        >
          <i class="fas fa-search"></i>&nbsp;Buscar vacantes
        </router-link>
        <div class="dropdown-divider"></div>
        <router-link
          class="dropdown-item"
          to="/ordenesMerito"
          exact
          v-if="!authenticated || isUsuario"
        >
          <i class="fas fa-clipboard-list"></i>&nbsp;Ordenes de mérito
        </router-link>
        <div class="dropdown-divider"></div>
        <router-link
          class="dropdown-item"
          to="/administrarVacantes"
          exact
          v-if="isAdministrador || isJefeCatedra"
        >
          <i class="fas fa-toolbox"></i>&nbsp;Administrar vacantes
        </router-link>
        <div class="dropdown-divider"></div>
        <router-link
          class="dropdown-item"
          to="/agregarVacante"
          exact
          v-if="isAdministrador"
        >
          <i class="fas fa-plus-circle"></i>&nbsp;Agregar vacante
        </router-link>
      </div>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link
        class="btn btn-light btn-block"
        to="/verificarIdentidades"
        exact
      >
        <i class="fas fa-user-check"></i>&nbsp;Verificar identidades
      </router-link>
    </li>
  </ul>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      isAdministrador: "isAdministrador",
      isJefeCatedra: "isJefeCatedra",
      isUsuario: "isUsuario"
    })
  }
};
</script>

<style>
</style>