<template>
  <ul class="navbar-nav">
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/" exact>
        <i class="fas fa-home mr-1"></i>Inicio
      </router-link>
    </li>
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/contacto" exact>
        <i class="fas fa-map-marker-alt mr-1"></i>Contacto
      </router-link>
    </li>
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/ayuda" exact>
        <i class="fas fa-question mr-1"></i>Ayuda
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
        <i class="fas fa-hand-pointer mr-1"></i>Vacantes
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <div v-if="!authenticated || isUsuario">
          <router-link class="dropdown-item" to="/requisitos" exact>
            <i class="fas fa-list-ul mr-1"></i>Requisitos
          </router-link>
        </div>
        <div v-if="!authenticated || isUsuario">
          <div class="dropdown-divider"></div>
          <router-link class="dropdown-item" to="/vacantes" exact>
            <i class="fas fa-search mr-1"></i>Buscar vacantes
          </router-link>
        </div>
        <div v-if="!authenticated || isUsuario">
          <div class="dropdown-divider"></div>
          <router-link class="dropdown-item" to="/ordenesMerito" exact>
            <i class="fas fa-clipboard-list mr-1"></i>Ordenes de mérito
          </router-link>
        </div>
        <div v-if="isAdministrador || isJefeCatedra">
          <div class="dropdown-divider"></div>
          <router-link class="dropdown-item" to="/administrarVacantes" exact>
            <i class="fas fa-toolbox mr-1"></i>Administrar vacantes
          </router-link>
        </div>
        <div v-if="isAdministrador">
          <div class="dropdown-divider"></div>
          <router-link class="dropdown-item" to="/agregarVacante" exact>
            <i class="fas fa-plus-circle mr-1"></i>Agregar vacante
          </router-link>
        </div>
      </div>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link
        class="btn btn-light btn-block"
        to="/verificarIdentidades"
        exact
      >
        <i class="fas fa-user-check"></i>Verificar identidades
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