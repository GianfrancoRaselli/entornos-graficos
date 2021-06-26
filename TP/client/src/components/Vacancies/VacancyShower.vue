<template>
  <div class="vacancies-list">
    <p v-if="!vacantes.length">No hay vacantes</p>
    <div class="vacancies" v-if="vacantes.length">
      <div class="vacancy" v-for="(vacante, index) in limitVacancies" :key="index">
        <div class="descripcion">
          <p>{{ vacante.descripcion }}</p>
        </div>
        <div class="vacancy-content">
          <div class="definicion">
            <p>{{ vacante.definicion }}</p>
          </div>
          <div>
            <p>
              <i class="fas fa-check-circle"></i>&nbsp;<strong>Requisitos:</strong>&nbsp;{{ vacante.requisitos }}
            </p>
          </div>
          <div class="fecha-fin">
            <p>
              <i class="fas fa-calendar"></i>&nbsp;<strong>Fecha de cierre:</strong>&nbsp;{{ vacante.fecha_fin }}
            </p>
          </div>
          <div class="postulado alert alert-success" role="alert" v-if="vacante.usuarioPostulado">
            Ya se encuentra postulado
          </div>
          <div class="pocas-vacantes" role="alert" v-if="!vacante.usuarioPostulado && vacante.vacantes_disponibles <= 3">
            <p v-if="vacante.vacantes_disponibles > 1">
              <i class="fas fa-exclamation-circle"></i>&nbsp;¡Quedan solo {{ vacante.vacantes_disponibles }} vacantes!
            </p>
            <p v-if="vacante.vacantes_disponibles === 1">
              <i class="fas fa-exclamation-circle"></i>&nbsp;¡Última vacante disponible!
            </p>
          </div>
          <div v-if="!authenticated" class="vacancy-options">
            <utn-button data-toggle="modal" data-target="#loginPopup">
              Postularme
            </utn-button>
              <LogIn />
          </div>
          <div class="vacancy-options" v-else>
            <utn-button @click="postularme(vacante.id)" v-if="!vacante.usuarioPostulado">
              Postularme
            </utn-button>
            <button @click="darmeDeBaja(vacante.id)" class="btn btn-danger" v-if="vacante.usuarioPostulado">
              Darme de baja
            </button>
          </div>
        </div>
      </div>
    </div>
    <Popup dataTarget="loginPostulacionPopup" title="Iniciar Sesión" :showButtons="false">
      <LogIn :postularse="true" :id_llamado="id_llamado" redirect="/vacantes" />
    </Popup>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters, mapActions } from 'vuex'
import EventBus from '../../event-bus'
export default {
  components: {
    LogIn: () => import('../LogIn.vue')
  },
  data() {
    return {
      postulacionesDelUsuario: [],
      vacantes: [],
      id_llamado: null
    }
  },
  computed: {
    ...mapGetters({
      authenticated: 'authenticated',
      isUsuario: 'isUsuario',
    }),
    limitVacancies(){
      return this.limit ? this.vacantes.slice(0,this.limit) : this.vacantes;
    }
  },
  props: {
    limit: { type: Number },
  },
  methods: {
    ...mapActions({
        logOut: 'logOut'
      }),

    async buscarPostulacionesDelUsuario() {
      if (this.$store.getters.authenticated && this.$store.getters.isUsuario) {
        try {
          let res = await axios.get('/postulaciones/buscarPostulacionesDelUsuario',
          {
            headers: {
              Authorization: 'Bearer ' + this.$store.getters.user.api_token
            }
          });

          this.postulacionesDelUsuario = res.data;
        } catch (err) {
          console.log(err.response.data.error);
        }
      }
    },

    async buscarVacantes() {
      try {
        let res = await axios.get('/llamados/buscarLlamados');
        let vacantes = res.data;

        if (vacantes && vacantes.length > 0) {
          for (let vacante of vacantes) {
            vacante.usuarioPostulado = false;

            if (this.postulacionesDelUsuario && this.postulacionesDelUsuario.length > 0) {
              for (let postulacion of this.postulacionesDelUsuario) {
                if (vacante.id === postulacion.id_llamado) {
                  vacante.usuarioPostulado = true;
                  break;
                }
              }
            }
          }
        }

        this.vacantes = vacantes;
      } catch (err) {
        console.log(err.response.data.error);
      }
    },

    async actualizarVacantes() {
      this.postulacionesDelUsuario = [];
      this.vacantes = [];

      if (this.$store.getters.authenticated && this.$store.getters.isUsuario) {
        await this.buscarPostulacionesDelUsuario();
      }
      await this.buscarVacantes();
    },

    async postularme(id_llamado) {
      if (this.$store.getters.authenticated) {
        if (this.$store.getters.isUsuario) {
          try {
            await axios.post('/postulaciones/agregarPostulacionDelUsuario',
            {
              id_llamado
            },
            {
              headers: {
                Authorization: 'Bearer ' + this.$store.getters.user.api_token
              }
            });

            this.actualizarVacantes();
          } catch (err) {
            console.log(err.response.data.error);
          }
        }
      } else {
        this.id_llamado = id_llamado;
        window.$("#loginPostulacionPopup").modal('show');
      }
    },

    async darmeDeBaja(id_llamado) {
      if (this.$store.getters.authenticated) {
        if (this.$store.getters.isUsuario) {
          try {
            await axios.delete('/postulaciones/eliminarPostulacionDelUsuario/' + id_llamado,
            {
              headers: {
                Authorization: 'Bearer ' + this.$store.getters.user.api_token
              }
            });
            
            this.actualizarVacantes();
          } catch (err) {
            console.log(err.response.data.error);
          }
        }
      } else {
        this.logOut();
      }
    }
  },
  async created() {
    this.actualizarVacantes();

    EventBus.$on('actualizarVacantes', function() {
      this.actualizarVacantes();
    }.bind(this))
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