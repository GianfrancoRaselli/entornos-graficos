<template>
  <div class="vacancies-list">
    <p v-if="!vacantes.length">No tiene vacantes a su cargo</p>
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
          <div class="fecha-fin">
            <p>
              <i class="fas fa-calendar"></i>&nbsp;<strong>Fecha de cierre:</strong>&nbsp;{{ vacante.fecha_fin }}
            </p>
          </div>
          <div class="vacancy-options">
            <utn-button
            data-toggle="modal"
            @click="inscriptos(vacante.id)"
            data-target="#listInscriptos">
              Ver inscriptos
            </utn-button>
            <Popup dataTarget="listInscriptos" :title="title" :showButtons="false" propClass="modal-xl">
              <ListInscriptos :llamado="llamado" :editando="false" />
            </Popup>
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
        let res = await axios.get('/llamados/buscarLlamadosAAdministrar',
        {
          headers: {
            Authorization: 'Bearer ' + this.$store.getters.user.api_token
          }
        });
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
          this.title = 'Inscriptos al llamado de ' + this.llamado.catedra.descripcion + ' del ' + this.llamado.fecha_inicio;

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