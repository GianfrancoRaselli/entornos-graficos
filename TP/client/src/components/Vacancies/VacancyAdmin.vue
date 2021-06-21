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
    <div class="modal fade background-popup-fade" id="listInscriptosPopup" :aria-labelledby="title" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                {{ title }}
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <ListInscriptos :llamado="llamado" />
            </div>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters, mapActions } from 'vuex'
export default {
  components: {
    ListInscriptos: () => import('../ListInscriptos.vue'),
  },
  data() {
    return {
      vacantes: [],
      llamado: null,
      title: ''
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
    },

    async inscriptos(id_llamado) {
      if (this.isAdministrador || this.isJefeCatedra) {
        try {
          let res = await axios.get('/llamados/buscarLlamado/' + id_llamado,
          {
            headers: {
              Authorization: 'Bearer ' + this.$store.getters.user.api_token
            }
          });
          this.llamado = res.data;
          this.title = 'Inscriptos al llamado de ' + this.llamado.catedra.descripcion + ' - ' + this.llamado.fecha_inicio;

          window.$("#listInscriptosPopup").modal('show');
        } catch (err) {
          console.log(err.response.data.error);
        }
      } else {
        this.logOut();
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