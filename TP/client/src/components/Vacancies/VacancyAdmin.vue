<template>
  <div class="vacancies-list">
    <p v-if="!vacantes.length">No hay vacantes registradas</p>
    <div class="vacancies" v-if="vacantes.length">
      <div class="vacancy" v-for="(vacante, index) in vacantes" :key="index">
        <div class="descripcion">
          <p>{{ vacante.descripcion }}</p>
        </div>
        <div class="definicion">
          <p>{{ vacante.definicion }}</p>
        </div>
        <div class="requisitos">
          <p><i class="fas fa-check-circle"></i>&nbsp;<strong>Requisitos:</strong>&nbsp;{{ vacante.requisitos }}</p>
        </div>
        <div class="fecha-fin">
          <p><i class="fas fa-calendar"></i>&nbsp;<strong>Fecha de cierre:</strong>&nbsp;{{ vacante.fecha_fin }}</p>
        </div>
        <button @click="inscriptos(vacante.id)" class="btn btn-primary">
          Ver inscriptos
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      vacantes: []
    }
  },
  computed: {
    ...mapGetters({
      authenticated: 'authenticated',
      isAdministrador: 'isAdministrador',
      isJefeCatedra: 'isJefeCatedra'
    })
  },
  methods: {
    ...mapActions({
        logOut: 'logOut'
      }),

    async buscarVacantes() {
      try {
        let res = await axios.get('/llamados/buscarLlamados');
        this.vacantes = res.data;
      } catch (err) {
        console.log(err.response.data.error);
      }
    }
  },
  async created() {
    this.buscarVacantes();
  }
}
</script>

<style>
  .vacancies-list{
    width: 90%;
    margin: 25px auto;
  }

  .vacancies{
    display: flex;
    width: 100%;
    flex-wrap: wrap;
  }

  .vacancy{
    width: 50%;
    padding:1rem;
    border: black 2px solid;
    border-radius: 15px;
    background-color: rgb(240, 240, 240);
    font-size: 1.08rem;
  }

  .descripcion{
    font-size:1.64rem;
    font-weight: 600;
  }

  @media(max-width: 991px){
    .vacancy{
      width: 100%;
    }
  }
</style>