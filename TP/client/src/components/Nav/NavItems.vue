<template>
  <ul :class="navItemsclass">
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/" exact>
        <i class="fas fa-home" :class="{ 'fa-2x': !desktop }"></i>
        <span v-if="desktop">Inicio</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/requisitos" exact>
        <i class="fas fa-list-ul" :class="{ 'fa-2x': !desktop }"></i>
        <span v-if="desktop">Requisitos</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link class="btn btn-light btn-block" to="/contacto" exact>
        <i class="fas fa-map-marker-alt" :class="{ 'fa-2x': !desktop }"></i>
        <span v-if="desktop">Contacto</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light btn-block"
        to="/vacantes"
        exact
        v-if="!authenticated || isUsuario"
      >
        <i class="fas fa-hand-pointer" :class="{ 'fa-2x': !desktop }"></i>
        <span v-if="desktop">Vacantes</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light btn-block"
        to="/ordenesMerito"
        exact
        v-if="!authenticated || isUsuario"
      >
        <i class="fas fa-clipboard-list" :class="{ 'fa-2x': !desktop }"></i>
        <span v-if="desktop">Ordenes de mérito</span>
      </router-link>
    </li>
    <li class="nav-item" v-if="isAdministrador || isJefeCatedra">
      <router-link
        class="btn btn-light btn-block"
        to="/administrarVacantes"
        exact
      >
        <i class="fas fa-toolbox" :class="{ 'fa-2x': !desktop }"></i>
        <span v-if="desktop">Administrar vacantes</span>
      </router-link>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link class="btn btn-light btn-block" to="/agregarVacante" exact>
        <i class="fas fa-plus-circle" :class="{ 'fa-2x': !desktop }"></i>
        <span v-if="desktop">Agregar vacante</span>
      </router-link>
    </li>
    <li class="nav-item" v-if="isAdministrador">
      <router-link
        class="btn btn-light btn-block"
        to="/verificarIdentidades"
        exact
      >
        <i class="fas fa-user-check" :class="{ 'fa-2x': !desktop }"></i>
        <span v-if="desktop">Verificar identidades</span>
      </router-link>
    </li>
    <li class="nav-item" v-if="authenticated && !desktop">
      <router-link class="btn btn-light btn-block" to="/perfil">
        <i class="fas fa-id-card fa-2x"></i>
      </router-link>
    </li>
  </ul>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    desktop: { type: Boolean, default: true },
    navItemsclass: { type: String, default: "navbar-nav" }
  },
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