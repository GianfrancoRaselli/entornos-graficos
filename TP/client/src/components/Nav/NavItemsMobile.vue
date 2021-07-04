<template>
  <div class="mobile-nav">
    <ul class="mobile-items-list" v-if="!isAdministrador && !isJefeCatedra">
      <li class="mobile-item" v-for="(nav, index) in allUserNavs" :key="index">
        <utn-button btnClass="btn btn-light btn-block" :to="nav.router" exact>
          <i :class="nav.icon"></i>
        </utn-button>
      </li>
    </ul>
    <ul class="mobile-items-list" v-if="isAdministrador || isJefeCatedra">
      <li class="mobile-item" v-for="(nav, index) in jefeNavs" :key="index">
        <utn-button btnClass="btn btn-light btn-block" :to="nav.router" exact>
          <i :class="nav.icon"></i>
        </utn-button>
      </li>
    </ul>
    <ul class="mobile-items-list" v-if="isAdministrador">
      <li class="mobile-item" v-for="(nav, index) in adminNavs" :key="index">
        <utn-button btnClass="btn btn-light btn-block" :to="nav.router" exact>
          <i :class="nav.icon"></i>
        </utn-button>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      allUserNavs:[
        {
          name:'Inicio',
          icon:'fas fa-home',
          router:'/'
        },
        {
          name:'Requisitos',
          icon:'fas fa-list-ul',
          router:'/requisitos'
        },
        {
          name:'Contacto',
          icon:'fas fa-map-marker-alt',
          router:'/contacto'
        },
        {
          name:'Vacantes',
          icon:'fas fa-hand-pointer',
          router:'/vacantes'
        },
        {
          name:'Ordenes de mérito',
          icon:'fas fa-clipboard-list',
          router:'/ordenesMerito'
        },
      ],
      jefeNavs:[
        {
          name:'Inicio',
          icon:'fas fa-home',
          router:'/'
        },
        {
          name:'Administrar vacantes',
          icon:'fas fa-toolbox',
          router:'/administrarVacantes'
        },
        {
          name:'Ordenes de mérito',
          icon:'fas fa-clipboard-list',
          router:'/ordenesMerito'
        },
      ],
      adminNavs:[
        {
          name:'Agregar vacante',
          icon:'fas fa-plus-circle',
          router:'/agregarVacante'
        },
        {
          name:'Verificar identidades',
          icon:'fas fa-user-check',
          router:'/verificarIdentidades'
        },
      ],
    };
  },
  props: {
    navItemsclass: { type: String, default: "desktop-nav" }
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
.mobile-nav{
  display:none;
}

@media (max-width: 1261px) {
  .mobile-nav{
    display:flex;
    background-color:white;
    align-items:center;
    padding:0;
    margin:0;
    justify-content:center;
    position:fixed;
    bottom:0;
    width: 100%;
    left:0;
    box-shadow: 0 -4px 20px 0 rgba(0, 0, 0, 0.08);
  }
  .mobile-nav ul{
    display:flex;
    align-items:center;
    list-style: none;
    justify-content:center;
    padding:0;
    margin:0;
  }
  .mobile-nav ul li{
    list-style: none;
    margin:0;
  }
  .mobile-nav ul li i{
    font-size:1.75rem;
  }
}
</style>