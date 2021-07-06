<template>
  <ul class="mobile-nav">
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/" exact>
        <i class="fas fa-home fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light btn-block"
        to="/vacantes"
        exact
        v-if="!authenticated || isUsuario"
      >
        <i class="fas fa-search fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light btn-block"
        to="/ordenesMerito"
        exact
        v-if="!authenticated || isUsuario"
      >
        <i class="fas fa-clipboard-list fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item" v-if="isAdministrador || isJefeCatedra">
      <router-link
        class="btn btn-light btn-block"
        to="/administrarVacantes"
        exact
      >
        <i class="fas fa-toolbox fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link
        class="btn btn-light btn-block"
        to="/administrarCatedras"
        exact
      >
        <i class="fas fa-book-open fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link
        class="btn btn-light btn-block"
        to="/verificarIdentidades"
        exact
      >
        <i class="fas fa-user-check fa-2x"></i>
      </router-link>
    </li>
    <li class="nav-item" v-if="authenticated">
      <router-link class="btn btn-light btn-block" to="/perfil">
        <i class="fas fa-id-card fa-2x"></i>
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
.mobile-nav {
  display: none;
}
@media (max-width: 991px) {
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
}
</style>