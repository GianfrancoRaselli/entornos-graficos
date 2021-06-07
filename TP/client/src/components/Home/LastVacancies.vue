<template>
  <div class="vacancies-list">
    <h2>
      <b>Últimas vacantes</b>
    </h2>
    <p v-if="!vacantes.length">No hay vacantes</p>
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
        <div class="postulado alert alert-success" role="alert" v-if="vacante.usuarioPostulado">
          Ya se encuentra postulado
        </div>
        <div class="pocas-vacantes" role="alert" v-if="!vacante.usuarioPostulado">
          <p v-if="vacante.vacantes_disponibles > 1"><i class="fas fa-exclamation-circle"></i>&nbsp;¡Quedan solo {{ vacante.vacantes_disponibles }} vacantes!</p>
          <p v-if="vacante.vacantes_disponibles === 1"><i class="fas fa-exclamation-circle"></i>&nbsp;¡Última vacante disponible!</p>
        </div>
        <button @click="postularme(vacante.id)" class="btn btn-primary" v-if="!vacante.usuarioPostulado">
          Postularme
        </button>
        <button @click="darmeDeBaja(vacante.id)" class="btn btn-danger" v-if="vacante.usuarioPostulado">
          Darme de baja
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import EventBus from '../../event-bus'
export default {
  data() {
    return {
      postulacionesDelUsuario: [],
      vacantes: []
    }
  },
  methods: {
    async buscarPostulacionesDelUsuario() {
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
    },

    async buscarVacantes() {
      try {
        let res = await axios.get('/llamados/buscarUltimasVacantes');

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
        console.log(err);
      }
    },

    async actualizarVacantes() {
      this.postulacionesDelUsuario = [];
      this.vacantes = [];

      if (this.$store.getters.authenticated) {
        await this.buscarPostulacionesDelUsuario();
      }
      await this.buscarVacantes();
    },

    async postularme(id_llamado) {
      if (this.$store.getters.authenticated) {
        try {
          await axios.post('/postulaciones/agregarPostulacionDelUsuario',
          {
            id_llamado,
            curriculum_vitae: 'curriculum.jpg'
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
      } else {
        console.log("");
      }
    },

    async darmeDeBaja(id_llamado) {
      if (this.$store.getters.authenticated) {
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
      } else {
        console.log("");
      }
    }
  },
  async created() {
    this.actualizarVacantes();

    EventBus.$on('actualizarUltimasVacantes', function() {
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
    border: black 2px solid;
    border-radius: 15px;
    background-color: rgb(240, 240, 240);
    font-size: 1.08rem;
  }

  .descripcion{
    font-size:1.64rem;
    font-weight: 600;
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