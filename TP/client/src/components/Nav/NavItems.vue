<template>
  <ul class="navbar-nav">
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" @click.native="cerrarNavMobile" to="/" exact>
        <span class="icono">
          <i class="fas fa-home mr-1"></i>
        </span>Inicio
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light btn-block"
        @click.native="cerrarNavMobile"
        to="/contacto"
        exact
      >
        <span class="icono">
          <i class="fas fa-map-marker-alt mr-1"></i>
        </span>Contacto
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
        <span class="icono">
          <i class="fas fa-hand-pointer mr-1"></i>
        </span>Vacantes
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link
          class="dropdown-item"
          v-if="!authenticated || isUsuario"
          @click.native="cerrarNavMobile"
          to="/requisitos"
          exact
        >
          <i class="fas fa-list-ul mr-1"></i>Requisitos para postularse
        </router-link>
        <router-link
          class="dropdown-item"
          v-if="!authenticated || isUsuario"
          @click.native="cerrarNavMobile"
          to="/vacantes"
          exact
        >
          <i class="fas fa-search mr-1"></i>Buscar vacantes abiertas
        </router-link>
        <router-link
          class="dropdown-item"
          v-if="!authenticated || isUsuario"
          @click.native="cerrarNavMobile"
          to="/ordenesMerito"
          exact
        >
          <i class="fas fa-clipboard-list mr-1"></i>Vacantes calificadas
        </router-link>
        <router-link
          class="dropdown-item"
          v-if="isAdministrador || isJefeCatedra"
          @click.native="cerrarNavMobile"
          to="/administrarVacantes"
          exact
        >
          <i class="fas fa-toolbox mr-1"></i>Administrar vacantes
        </router-link>
        <router-link
          class="dropdown-item"
          v-if="isAdministrador"
          @click.native="cerrarNavMobile"
          to="/agregarVacante"
          exact
        >
          <i class="fas fa-plus-circle mr-1"></i>Agregar vacante
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
        <span class="icono">
          <i class="fas fa-book mr-1"></i>
        </span>Cátedras
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link
          class="dropdown-item"
          @click.native="cerrarNavMobile"
          to="/administrarCatedras"
          exact
        >
          <i class="fas fa-book-open mr-1"></i>Administrar cátedras
        </router-link>
        <router-link
          class="dropdown-item"
          @click.native="cerrarNavMobile"
          to="/agregarCatedra"
          exact
        >
          <i class="fas fa-plus-circle mr-1"></i>Agregar cátedra
        </router-link>
      </div>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link
        class="btn btn-light btn-block"
        @click.native="cerrarNavMobile"
        to="/verificarIdentidades"
        exact
      >
        <span class="icono">
          <i class="fas fa-user-check mr-1"></i>
        </span>Identidades
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
        <span class="icono">
          <i class="fas fa-question-circle mr-1"></i>
        </span>Ayuda
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link
          class="dropdown-item"
          @click.native="cerrarNavMobile"
          to="/preguntasFrecuentes"
          exact
        >
          <i class="fas fa-question mr-1"></i>Preguntas frecuentes
        </router-link>
        <router-link class="dropdown-item" @click.native="cerrarNavMobile" to="/glosario" exact>
          <i class="fas fa-info mr-1"></i>Glosario
        </router-link>
        <router-link class="dropdown-item" @click.native="cerrarNavMobile" to="/mapaSitio" exact>
          <i class="fas fa-sitemap mr-1"></i>Mapa del sitio
        </router-link>
      </div>
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
  },
  methods: {
    cerrarNavMobile() {
      window.$(".navbar-collapse").removeClass("show");
    }
  }
};
</script>

<style scoped>
@media (min-width: 992px) and (max-width: 1180px) {
  .icono {
    display: none;
  }
}
</style>