<template>
  <div class="vacancies-list">
    <h2>
      <b> Últimas vacantes </b>
    </h2>
    <div class="vacancies">
      <div class="vacancy" v-for="(vacante, index) in vacantes" :key="index">
        <div class="name">
          {{ vacante.descripcion }}
        </div>
        <div class="description">
          {{ vacante.definicion }}
        </div>
        <utn-button to="Home" btnClass="btn btn-outline-primary">
          Ver más
        </utn-button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      vacantes: null,
    }
  },
  methods: {
    async buscarVacantes() {
      try {
        let res = await axios.get('/llamados/ultimasVacantes');

        this.vacantes = res.data;
      } catch (err) {
        console.log(err);
      }
    }
  },
  created() {
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
  }

  .name{
    font-size:1.25rem;
    font-weight: 600;
  }
</style>