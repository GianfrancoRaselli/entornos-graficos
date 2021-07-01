<template>
  <ul :class="navItemsclass">
    <li class="nav-item">
      <router-link class="btn btn-light" to="/" exact="true">
        <i class="fas fa-home" :class="{ 'fa-2x': !desktop }"></i> <span v-if="desktop">Inicio</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link class="btn btn-light" to="/requisitos" exact="true">
        <i class="fas fa-list-ul" :class="{ 'fa-2x': !desktop }"></i> <span v-if="desktop">Requisitos</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link class="btn btn-light" to="/contacto" exact="true">
        <i class="fas fa-map-marker-alt" :class="{ 'fa-2x': !desktop }"></i> <span v-if="desktop">Contacto</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light"
        to="/vacantes"
        exact="true"
        v-if="!authenticated || isUsuario"
      >
        <i class="fas fa-hand-pointer" :class="{ 'fa-2x': !desktop }"></i> <span v-if="desktop">Vacantes</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light"
        to="/ordenesMerito"
        exact="true"
        v-if="!authenticated || isUsuario"
      >
        <i class="fas fa-clipboard-list" :class="{ 'fa-2x': !desktop }"></i> <span v-if="desktop">Ordenes de mérito</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light"
        to="/administrarVacantes"
        exact="true"
        v-if="isAdministrador || isJefeCatedra"
      >
        <i class="fas fa-toolbox" :class="{ 'fa-2x': !desktop }"></i> <span v-if="desktop">Administrar vacantes</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light"
        to="/agregarVacante"
        exact="true"
        v-if="isAdministrador"
      >
        <i class="fas fa-plus-circle" :class="{ 'fa-2x': !desktop }"></i> <span v-if="desktop">Agregar vacante</span>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link
        class="btn btn-light"
        to="/verificarIdentidades"
        exact="true"
        v-if="isAdministrador"
      >
        <i class="fas fa-user-check" :class="{ 'fa-2x': !desktop }"></i> <span v-if="desktop">Verificar identidades</span>
      </router-link>
    </li>
  </ul>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    desktop: { type: Boolean, default: true },
    navItemsclass: { required: true, type: String }
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
    position: fixed;
    bottom: 0;
    list-style: none;
    box-shadow: 0 -4px 20px 0 rgba(0, 0, 0, 0.08);
    justify-content: center;
    background-color: white;
    width: 100%;
    margin: 0;
    padding: 0;
    left: 0;
  }
}
</style>