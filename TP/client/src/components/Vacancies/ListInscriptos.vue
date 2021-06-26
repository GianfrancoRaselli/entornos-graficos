<template>
  <div>
    <div class="inscriptos" v-if="llamado && llamado.postulaciones && llamado.postulaciones.length > 0">
      <div class="mb-2 buttons-nav" v-if="edit">
        <div v-if="llamado.finalizado">
          <button class="btn btn-primary mr-1" @click="calificar" v-if="!editando"><i class="fas fa-edit"></i> Calificar</button>
          <button class="btn btn-success ml-1" v-if="editando" @click="guardar"><i class="fas fa-save"></i> Guardar cambios</button>
          <button class="btn btn-danger ml-1" v-if="editando" @click="cancelar"><i class="fas fa-times-circle"></i> Cancelar cambios</button>
        </div>
        <div v-else>
          <p>El llamado cierra el: {{ llamado.fecha_fin }}</p>
        </div>
      </div>
      <table class="table table-responsive table-striped table-hover table-bordered">
        <thead>
          <tr>
            <th>DNI</th>
            <th>Nombre y apellido</th>
            <th v-if="edit">Email</th>
            <th v-if="edit">Teléfono</th>
            <th>Estado</th>
            <th>Calificación</th>
            <th>Comentarios</th>
            <th v-if="edit">Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(postulacion, index) in llamado.postulaciones" :key="index">
            <td><div class="columna-md">{{ postulacion.dni }}</div></td>
            <td><div class="columna-md">{{ postulacion.nombre_apellido }}</div></td>
            <td v-if="edit"><div class="columna-md">{{ postulacion.email }}</div></td>
            <td v-if="edit"><div class="columna-md">{{ postulacion.telefono }}</div></td>
            <td>
              <div class="columna-md">
                <div v-if="!editando">
                  {{ postulacion.estado }}
                </div>
                <div v-else-if="edit">
                  <select class="form-control" :class="{ errorClass: postulacion.estadoError }" v-model="postulacion.estadoEditado">
                    <option>Aceptar</option>
                    <option>Rechazar</option>
                  </select>
                </div>
              </div>
            </td>
            <td>
              <div class="columna-sm">
                <div v-if="!editando">
                  <div v-if="postulacion.puntaje">{{ postulacion.puntaje }}</div>
                  <div v-else>-</div>
                </div>
                <div v-else-if="edit">
                  <input type="number" class="form-control" :class="{ errorClass: postulacion.puntajeError }" min="0" max="100" v-model="postulacion.puntajeEditado">
                </div>
              </div>
            </td>
            <td>
              <div class="columna-lg">
                <div v-if="!editando">
                  <div v-if="postulacion.comentarios">{{ postulacion.comentarios }}</div>
                  <div v-else>-</div>
                </div>
                <div v-else-if="edit">
                  <textarea class="form-control" cols="60" v-model="postulacion.comentariosEditado"></textarea>
                </div>
              </div>
            </td>
            <td v-if="edit">
              <div class="columna-md">
                <a id="btn-ver-cv" class="btn btn-secondary" v-if="postulacion.curriculum_vitae" :href="'http://localhost/Entornos Graficos/entornos-graficos-2021/TP/server/public/CVs/' + postulacion.persona.curriculum_vitae" target="_blank">
                  <i class="fas fa-eye"></i> Ver CV
                </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>No se ha inscripto ninguna persona</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import EventBus from '../../event-bus'
export default {
  props: {
    edit: { type: Boolean, default: true },
  },
  data() {
    return {
      llamado: {
        id: '',
        fecha_inicio: '',
        fecha_fin: '',
        rquisitos: '',
        vacantes: 0,
        finalizado: false,
        catedra: null,
        postulaciones: []
      },
      editando: false
    }
  },
  methods: {
    async buscarInscriptos(id_llamado) {
      try {
        let res = null;

        if (this.edit && (this.$store.getters.isAdministrador || this.$store.getters.isJefeCatedra)) {
          res = await axios.get('/llamados/buscarLlamado/' + id_llamado,
          {
            headers: {
              Authorization: 'Bearer ' + this.$store.getters.user.api_token
            }
          });
        } else if (!this.edit) {
          res = await axios.get('/llamados/buscarLlamadoCalificado/' + id_llamado);
        }

        this.llamado.id = res.data.id;
        this.llamado.fecha_inicio = res.data.fecha_inicio;
        this.llamado.fecha_fin = res.data.fecha_fin;
        this.llamado.requisitos = res.data.requisitos;
        this.llamado.vacantes = res.data.vacantes;
        this.llamado.finalizado = res.data.finalizado;
        this.llamado.catedra = res.data.catedra;
        this.llamado.postulaciones = [];
        for (let postulacion of res.data.postulaciones) {
          if (postulacion.estado === "Elegido") {
            postulacion.estadoEditado = "Aceptar";
          } else if (postulacion.estado === "No elegido") {
            postulacion.estadoEditado = "Rechazar";
          } else {
            postulacion.estadoEditado = postulacion.estado;
          }
          postulacion.puntajeEditado = postulacion.puntaje;
          postulacion.comentariosEditado = postulacion.comentarios;
          postulacion.estadoError = false;
          postulacion.puntajeError = false;
          postulacion.comentariosError = false;

          this.llamado.postulaciones.push(postulacion);
        }
          
        this.editando = false;
      } catch (err) {
        console.log(err.response.data.error);
      }
    },
    calificar() {
      if (this.edit && this.llamado.finalizado && (this.$store.getters.isAdministrador || this.$store.getters.isJefeCatedra)) {
        this.editando = true;
      }
    },
    cancelar() {
      this.editando = false;
    },
    async guardar() {
      if ((this.$store.getters.isAdministrador || this.$store.getters.isJefeCatedra) && this.edit && this.llamado 
      && this.llamado.finalizado && this.llamado.postulaciones && this.llamado.postulaciones.length > 0) {
        let error = false;
        
        for (let postulacion of this.llamado.postulaciones) {
          postulacion.estadoError = false;
          postulacion.puntajeError = false;
          if (!(postulacion.estadoEditado === "Aceptar" || postulacion.estadoEditado === "Rechazar")) {
            postulacion.estadoError = true;
            error = true;
          }
          if (!postulacion.puntajeEditado || isNaN(postulacion.puntajeEditado) || 
          postulacion.puntajeEditado % 1 != 0 || postulacion.puntajeEditado < 1 ||
          postulacion.puntajeEditado > 100) {
            postulacion.puntajeError = true;
            error = true;
          }
        }

        if (!error) {
          try {
            await axios.post('/llamados/calificarLlamado',
            {
              llamado: this.llamado
            },
            {
              headers: {
                Authorization: 'Bearer ' + this.$store.getters.user.api_token
              }
            });
            
            this.buscarInscriptos(this.llamado.id);
          } catch (err) {
            console.log(err.response.data.error);
          }
        }
      }
    }
  },
  async created() {
    EventBus.$on('buscarInscriptos', function(id_llamado) {
      this.buscarInscriptos(id_llamado);
    }.bind(this))
  }
}
</script>

<style>
  .columna-lg {
    width: 360px;
  }

  .columna-md {
    width: 160px;
  }

  .columna-sm {
    width: 120px;
  }

  .errorClass {
    background-color: rgb(228, 167, 167);
  }
</style>