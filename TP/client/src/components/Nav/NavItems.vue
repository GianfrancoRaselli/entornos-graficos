<template>
  <ul :class="navItemsclass">
    <utn-button icon="fas fa-home" btnClass="btn btn-light" to="/">
      Inicio
    </utn-button>
    <utn-button icon="fas fa-list-ul" btnClass="btn btn-light" to="/requisitos">
      Requisitos
    </utn-button>
    <utn-button icon="fas fa-map-marker-alt" btnClass="btn btn-light" to="/contacto">
      Contacto
    </utn-button>
    <utn-button icon="fas fa-hand-pointer" btnClass="btn btn-light" to="/vacantes" v-if="!authenticated || isUsuario">
      Vacantes
    </utn-button>
    <utn-button icon="fas fa-clipboard-list" btnClass="btn btn-light" to="/ordenesMerito" v-if="!authenticated || isUsuario">
      Ordenes de mérito
    </utn-button>
    <utn-button icon="fas fa-toolbox" btnClass="btn btn-light" to="/administrarVacantes" v-if="isAdministrador || isJefeCatedra">
      Administrar vacantes
    </utn-button>
    <utn-button icon="fas fa-plus-circle" btnClass="btn btn-light" to="/agregarVacante" v-if="isAdministrador">
      Agregar vacante
    </utn-button>
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
  .desktop-nav{
    list-style: none;
    display: flex;
    align-items: center;
    margin: 0;
    margin-left: auto;
  }

  .mobile-nav{
    display: none;
  }

  @media(max-width: 991px){
    .desktop-nav{
      display: none;
    }

    .mobile-nav{
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