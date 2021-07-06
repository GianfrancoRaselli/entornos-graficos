<template>
  <ul class="navbar-nav">
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/" exact>
        <i class="fas fa-home mr-1"></i> Inicio
      </router-link>
    </li>
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/contacto" exact>
        <i class="fas fa-map-marker-alt mr-1"></i> Contacto
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
        <i class="fas fa-hand-pointer mr-1"></i> Vacantes
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link
          class="dropdown-item"
          v-if="!authenticated || isUsuario"
          to="/requisitos"
          exact
        >
          <i class="fas fa-list-ul mr-1"></i> Requisitos
        </router-link>
        <router-link
          class="dropdown-item"
          v-if="!authenticated || isUsuario"
          to="/vacantes"
          exact
        >
          <i class="fas fa-search mr-1"></i> Buscar vacantes
        </router-link>
        <router-link
          class="dropdown-item"
          v-if="!authenticated || isUsuario"
          to="/ordenesMerito"
          exact
        >
          <i class="fas fa-clipboard-list mr-1"></i> Ordenes de mérito
        </router-link>
        <router-link
          class="dropdown-item"
          v-if="isAdministrador || isJefeCatedra"
          to="/administrarVacantes"
          exact
        >
          <i class="fas fa-toolbox mr-1"></i> Administrar vacantes
        </router-link>
        <router-link
          class="dropdown-item"
          v-if="isAdministrador"
          to="/agregarVacante"
          exact
        >
          <i class="fas fa-plus-circle mr-1"></i> Agregar vacante
        </router-link>
      </div>
    </li>
    <li class="nav-item dropdown" v-if="isAdministrador">
      <a
        class="dropdown-toggle btn btn-light btn-block"
        href="#"
        role="button"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
      >
        <i class="fas fa-book"></i> Cátedras
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link class="dropdown-item" to="/administrarCatedras" exact>
          <i class="fas fa-book-open"></i> Administrar cátedras
        </router-link>
        <router-link class="dropdown-item" to="/agregarCatedra" exact>
          <i class="fas fa-plus-circle mr-1"></i> Agregar cátedra
        </router-link>
      </div>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link
        class="btn btn-light btn-block"
        to="/verificarIdentidades"
        exact
      >
        <i class="fas fa-user-check"></i> Identidades
      </router-link>
    </li>
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/ayuda" exact>
        <i class="fas fa-question mr-1"></i> Ayuda
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
@media (min-width: 992px) and (max-width: 1180px) {
  .fas {
    display: none;
  }
}
</style>