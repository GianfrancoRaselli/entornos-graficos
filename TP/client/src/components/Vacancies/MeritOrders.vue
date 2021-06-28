<template>
  <div class="vacancies-list">
    <p v-if="!vacantes.length">No hay vacantes calificadas</p>
    <div class="vacancies" v-if="vacantes.length">
      <div class="vacancy" v-for="(vacante, index) in vacantes" :key="index">
        <div class="descripcion">
          <p>
            {{ vacante.descripcion }}
          </p>
        </div>
        <div class="vacancy-content">
          <div class="definicion">
            <p>
              {{ vacante.definicion }}
            </p>
          </div>
          <div class="requisitos">
            <p>
              <i class="fas fa-check-circle"></i>&nbsp;<strong>Requisitos:</strong>&nbsp;{{ vacante.requisitos }}
            </p>
          </div>
          <div class="fecha-inicio">
            <p>
              <i class="fas fa-calendar-check"></i>&nbsp;<strong>Fecha de inicio:</strong>&nbsp;{{ vacante.fecha_inicio }}
            </p>
          </div>
          <div class="fecha-fin">
            <p>
              <i class="fas fa-calendar-times"></i>&nbsp;<strong>Fecha de cierre:</strong>&nbsp;{{ vacante.fecha_fin }}
            </p>
          </div>
          <div class="vacancy-options">
            <utn-button @click="buscarInscriptos(vacante.id, vacante.descripcion, vacante.fecha_inicio)">
              <i class="fas fa-list"></i> Ver orden de mérito
            </utn-button>
          </div>
        </div>
      </div>
      <Popup dataTarget="listInscriptos" :title="title" :showButtons="false" propClass="modal-xl">
        <ListInscriptos :edit="false" />
      </Popup>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import EventBus from '../../event-bus'
export default {
  components: {
    ListInscriptos: () => import('./ListInscriptos.vue'),
  },
  data() {
    return {
      vacantes: [],
      title: ''
    }
  },
  methods: {
    async buscarVacantesCalificadas() {
      try {
        let res = await axios.get('/llamados/buscarLlamadosCalificados');
        this.vacantes = res.data;
      } catch (err) {
        console.log(err.response.data.error);
      }
    },

    buscarInscriptos(id_llamado, desc, fecha_inicio) {
      this.title = 'Inscriptos al llamado de ' + desc + ' del ' + fecha_inicio;
      EventBus.$emit('buscarInscriptos', id_llamado);
      window.$("#listInscriptos").modal('show');
    },
  },
  async created() {
    this.buscarVacantesCalificadas();
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
    font-size: 1.08rem;
    display: flex;
    flex-direction: column;
  }

  .vacancy-content{
    border: RGB(0, 122, 255) 2px solid;
    border-radius: 0 0 15px 15px;
    padding: .5rem 1rem
  }

  .descripcion{
    font-size:1.64rem;
    font-weight: 600;
    border-radius: 15px 15px 0 0;
    padding: 1rem 0.5rem 0rem 1rem;
    background-color:RGB(0, 122, 255);
    color: white;
  }

  .vacancy-options{
    display: flex;
    justify-content: center;
  }

  .pocas-vacantes{
    color: rgb(221, 44, 0);
  }

  @media(max-width: 991px){
    .vacancy{
      width: 100%;
    }
  }
</style>