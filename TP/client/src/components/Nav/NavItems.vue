<template>
  <ul :class="navItemsclass">
    <router-link class="btn btn-light" to="/" exact="true">
      <i class="fas fa-home"></i> Inicio
    </router-link>
    <router-link class="btn btn-light" to="/requisitos" exact="true">
      <i class="fas fa-list-ul"></i> Requisitos
    </router-link>
    <router-link class="btn btn-light" to="/contacto" exact="true">
      <i class="fas fa-map-marker-alt"></i> Contacto
    </router-link>
    <router-link class="btn btn-light" to="/vacantes" exact="true" v-if="!authenticated || isUsuario">
      <i class="fas fa-hand-pointer"></i> Vacantes
    </router-link>
    <router-link class="btn btn-light" to="/ordenesMerito" exact="true" v-if="!authenticated || isUsuario">
      <i class="fas fa-clipboard-list"></i> Ordenes de mérito
    </router-link>
    <router-link class="btn btn-light" to="/administrarVacantes" exact="true" v-if="isAdministrador || isJefeCatedra">
      <i class="fas fa-toolbox"></i> Administrar vacantes
    </router-link>
    <router-link class="btn btn-light" to="/agregarVacante" exact="true" v-if="isAdministrador">
      <i class="fas fa-plus-circle"></i> Agregar vacante
    </router-link>
  </ul>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  props: {
    navItemsclass: { required: true, type: String },
  },
  computed: {
    ...mapGetters({
      authenticated: 'authenticated',
      isAdministrador: 'isAdministrador',
      isJefeCatedra: 'isJefeCatedra',
      isUsuario: 'isUsuario'
    })
  },
}
</script>

<style>
  .desktop-nav {
    list-style: none;
    display: flex;
    align-items: center;
    margin: 0;
    margin-left: auto;
  }

  .mobile-nav {
    display: none;
  }

  @media(max-width: 991px) {
    .desktop-nav{
      display: none;
    }

    .mobile-nav {
      display: flex;
      position:fixed;
      bottom: 0;
      list-style: none;
      box-shadow: 0 -4px 20px 0 rgba(0,0,0,.08);
      justify-content: center;
      background-color:white;
      width: 100%;
      margin: 0;
      padding: 0;
      left: 0;
    }
  }
</style>