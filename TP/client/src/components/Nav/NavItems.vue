<template>
  <ul class="navbar-nav">
    <li class="nav-item">
      <utn-button btnClass="btn btn-light btn-block" @click.native="cerrarNavMobile" to="/" exact>
        <span class="icono">
          <i class="fas fa-home mr-1"></i>
        </span>Inicio
      </utn-button>
    </li>
    <li class="nav-item">
      <utn-button
        btnClass="btn btn-light btn-block"
        @click.native="cerrarNavMobile"
        to="/contacto"
        exact
      >
        <span class="icono">
          <i class="fas fa-map-marker-alt mr-1"></i>
        </span>Contacto
      </utn-button>
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
        <utn-button
          btnClass="dropdown-item"
          v-if="!authenticated || isUsuario"
          @click.native="cerrarNavMobile"
          to="/requisitos"
          exact
        >
          <i class="fas fa-list-ul mr-1"></i>Requisitos para postularse
        </utn-button>
        <utn-button
          btnClass="dropdown-item"
          v-if="!authenticated || isUsuario"
          @click.native="cerrarNavMobile"
          to="/vacantes"
          exact
        >
          <i class="fas fa-search mr-1"></i>Buscar vacantes abiertas
        </utn-button>
        <utn-button
          btnClass="dropdown-item"
          v-if="!authenticated || isUsuario"
          @click.native="cerrarNavMobile"
          to="/ordenesMerito"
          exact
        >
          <i class="fas fa-clipboard-list mr-1"></i>Vacantes calificadas
        </utn-button>
        <utn-button
          btnClass="dropdown-item"
          v-if="isAdministrador || isJefeCatedra"
          @click.native="cerrarNavMobile"
          to="/administrarVacantes"
          exact
        >
          <i class="fas fa-toolbox mr-1"></i>Administrar vacantes
        </utn-button>
        <utn-button
          btnClass="dropdown-item"
          v-if="isAdministrador"
          @click.native="cerrarNavMobile"
          to="/agregarVacante"
          exact
        >
          <i class="fas fa-plus-circle mr-1"></i>Agregar vacante
        </utn-button>
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
        <utn-button
          btnClass="dropdown-item"
          @click.native="cerrarNavMobile"
          to="/administrarCatedras"
          exact
        >
          <i class="fas fa-book-open mr-1"></i>Administrar cátedras
        </utn-button>
        <utn-button
          btnClass="dropdown-item"
          @click.native="cerrarNavMobile"
          to="/agregarCatedra"
          exact
        >
          <i class="fas fa-plus-circle mr-1"></i>Agregar cátedra
        </utn-button>
      </div>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <utn-button
        btnClass="btn btn-light btn-block"
        @click.native="cerrarNavMobile"
        to="/verificarIdentidades"
        exact
      >
        <span class="icono">
          <i class="fas fa-user-check mr-1"></i>
        </span>Identidades
      </utn-button>
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
        <utn-button
          btnClass="dropdown-item"
          @click.native="cerrarNavMobile"
          to="/preguntasFrecuentes"
          exact
        >
          <i class="fas fa-question mr-1"></i>Preguntas frecuentes
        </utn-button>
        <utn-button btnClass="dropdown-item" @click.native="cerrarNavMobile" to="/glosario" exact>
          <i class="fas fa-info mr-1"></i>Glosario
        </utn-button>
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
.dropdown{
  margin-top:.25rem;
}
@media (min-width: 992px) and (max-width: 1180px) {
  .icono {
    display: none;
  }
}
</style>