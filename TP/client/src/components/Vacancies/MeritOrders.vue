<template>
  <div class="vacancies-list">
    <p v-if="!vacantes.length">No hay vacantes calificadas</p>
    <div class="vacancies" v-if="vacantes.length">
      <div class="search-options w-100">
        <div class="form-group w-50 m-auto">
          <select class="form-control" @change="cambioCatedra" v-model="id_catedra">
            <option selected="true" :value="0">Todas las cátedras</option>
            <option v-for="(catedra, index) in catedras" :key="index" :value="catedra.id_catedra">{{ catedra.descripcion }}</option>
          </select>
        </div>
      </div>
      <div class="vacancy" v-for="(vacante, index) in limitVacantes" :key="index">
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
        <ListInscriptos :edit_mode="false" />
      </Popup>
      <div class="w-100 mt-2">
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ disabled: pag===1 }">
              <a class="page-link" href="#" tabindex="-1" @click.prevent="disminuirPag">Anterior</a>
            </li>
            <li class="page-item" v-for="n in numeros" :key="n">
              <a class="page-link" href="#" @click.prevent="pag=n">{{ n }}</a>
              </li>
            <li class="page-item" :class="{ disabled: pag===Math.ceil(vacantesAMostrar.length/limit) }">
              <a class="page-link" href="#" @click.prevent="aumentarPag">Siguiente</a>
            </li>
          </ul>
        </nav>
      </div>
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
      vacantesAMostrar: [],
      title: '',
      id_catedra: 0,
      limit: 12,
      pag: 1
    }
  },
  computed: {
    limitVacantes() {
      return this.vacantesAMostrar.slice(this.pag*this.limit-this.limit, this.pag*this.limit);
    },

    numeros() {
      return Math.ceil(this.vacantesAMostrar.length/this.limit);
    },

    catedras() {
      let catedras = [];

      for (let vacante of this.vacantes) {
        let catedraAgregada = false;
        for (let catedra of catedras) {
          if (catedra.id_catedra === vacante.id_catedra) {
            catedraAgregada = true;
            break;
          }
        }

        if (!catedraAgregada) catedras.push({ id_catedra: vacante.id_catedra, descripcion: vacante.descripcion });
      }

      return catedras;
    }
  },
  methods: {
    disminuirPag() {
      if (this.pag>1) this.pag--;
    },

    aumentarPag() {
      if (this.pag<Math.ceil(this.vacantesAMostrar.length/this.limit)) this.pag++;
    },

    cambioCatedra() {
      this.pag = 1;

      if (this.id_catedra === 0) {
        this.vacantesAMostrar = this.vacantes;
      } else {
        let vacantesAMostrar = [];
        for (let vacante of this.vacantes) {
          if (vacante.id_catedra === this.id_catedra) vacantesAMostrar.push(vacante);
        }
        this.vacantesAMostrar = vacantesAMostrar;
      }
    },

    async buscarVacantesCalificadas() {
      try {
        let res = await axios.get('/llamados/buscarLlamadosCalificados');
        this.vacantes = res.data;
        this.cambioCatedra();
      } catch (err) {
        console.log(err.response.data.error);
      }
    },

    buscarInscriptos(id_llamado, desc, fecha_inicio) {
      this.title = 'Inscriptos al llamado de ' + desc + ' del ' + fecha_inicio;
      EventBus.$emit('buscarInscriptos', id_llamado);
      window.$("#listInscriptos").modal('show');
    }
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