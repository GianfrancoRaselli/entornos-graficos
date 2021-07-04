<template>
  <div class="desktop-nav">
    <ul class="nav-items-list" v-if="isAdministrador || isJefeCatedra">
      <li class="nav-item" v-for="(nav, index) in jefeNavs" :key="index">
        <utn-button btnClass="btn btn-light btn-block" :to="nav.router" exact>
          <i :class="[nav.icon, !desktop ? 'fa-2x': '']"></i>
          <span> {{ nav.name }}</span>
        </utn-button>
      </li>
    </ul>
    <ul class="nav-items-list" v-if="isAdministrador">
      <li class="nav-item" v-for="(nav, index) in adminNavs" :key="index">
        <utn-button btnClass="btn btn-light btn-block" :to="nav.router" exact>
          <i :class="[nav.icon, !desktop ? 'fa-2x': '']"></i>
          <span> {{ nav.name }}</span>
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
      jefeNavs:[
        {
          name:'Administrar vacantes',
          icon:'fas fa-toolbox',
          router:'/administrarVacantes'
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
    desktop: { type: Boolean, default: true },
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
.desktop-nav{
  display:flex;
  align-items:center;
  padding:0;
  margin:0;
}
.desktop-nav ul{
  display:flex;
  align-items:center;
  list-style: none;
  padding:0;
  margin:0;
}

@media (max-width: 1261px) {
  .desktop-nav{
    display: none;
  }
}
</style>