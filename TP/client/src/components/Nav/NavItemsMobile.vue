<template>
  <ul class="mobile-nav">
    <li class="nav-item" v-if="!authenticated || isUsuario">
      <router-link
        class="btn btn-light btn-block"
        to="/vacantes"
        exact
        @click.native="cerrarNavMobile"
      >
        <i class="fas fa-search fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item" v-if="!authenticated || isUsuario">
      <router-link
        class="btn btn-light btn-block"
        to="/ordenesMerito"
        exact
        @click.native="cerrarNavMobile"
      >
        <i class="fas fa-clipboard-list fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item" v-if="isAdministrador || isJefeCatedra">
      <router-link
        class="btn btn-light btn-block"
        to="/administrarVacantes"
        exact
        @click.native="cerrarNavMobile"
      >
        <i class="fas fa-toolbox fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link
        class="btn btn-light btn-block"
        to="/administrarCatedras"
        exact
        @click.native="cerrarNavMobile"
      >
        <i class="fas fa-book-open fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link
        class="btn btn-light btn-block"
        to="/verificarIdentidades"
        exact
        @click.native="cerrarNavMobile"
      >
        <i class="fas fa-user-check fa-2x"></i>
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
  },
  methods: {
    cerrarNavMobile() {
      window.$(".navbar-collapse").removeClass("show");
    }
  }
};
</script>

<style>
.mobile-nav {
  display: flex;
  height: 65px;
  position: fixed;
  bottom: 0;
  align-items: center;
  list-style: none;
  box-shadow: 0 -4px 20px 0 rgba(0, 0, 0, 0.08);
  justify-content: space-around;
  background-color: white;
  width: 100%;
  margin: -0.1rem -1rem;
  padding: 0;
}

@media (min-width: 992px) {
  .mobile-nav {
    display: none;
  }
}
</style>