<template>
  <div>
    <div v-if="cargando">
      <img
        src="../../assets/loading.gif"
        alt="Imagen de carga de página"
        class="loading mt-3"
      />
    </div>
    <div v-else>
      <div
        class="inscriptos"
        v-if="
          llamado && llamado.postulaciones && llamado.postulaciones.length > 0
        "
      >
        <div class="mb-2 buttons-nav" v-if="edit_mode">
          <div v-if="llamado.finalizado">
            <div v-if="!llamado.calificado">
              <button
                class="btn btn-primary mr-1"
                @click="calificar"
                v-if="!editando"
              >
                <i class="fas fa-edit"></i> Calificar
              </button>
              <button
                class="btn btn-success ml-1"
                v-if="editando"
                @click="guardar"
              >
                <i class="fas fa-save"></i> Guardar cambios
              </button>
              <button
                class="btn btn-danger ml-1"
                v-if="editando"
                @click="cancelar"
              >
                <i class="fas fa-times-circle"></i> Cancelar cambios
              </button>
            </div>
            <div v-else>
              <p>El llamado ya se encuentra calificado</p>
            </div>
          </div>
          <div v-else>
            <p>El llamado cierra el: {{ llamado.fecha_fin }}</p>
          </div>
        </div>
        <MobileList
          :isEditing="editando"
          :editMode="edit_mode"
          :llamado="llamado"
        />
        <DesktopList
          :isEditing="editando"
          :editMode="edit_mode"
          :llamado="llamado"
        />
      </div>
      <div v-else>
        <p><i class="fas fa-angle-right"></i> No se ha inscripto ninguna persona</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import EventBus from "../../event-bus";
export default {
  props: {
    edit_mode: { type: Boolean, default: true }
  },
  components: {
    MobileList: () => import("./MobileListInscriptos.vue"),
    DesktopList: () => import("./DesktopListInscriptos.vue")
  },
  data() {
    return {
      cargando: true,
      llamado: {
        id: "",
        fecha_inicio: "",
        fecha_fin: "",
        rquisitos: "",
        vacantes: 0,
        calificado: false,
        finalizado: false,
        catedra: null,
        postulaciones: []
      },
      editando: false
    };
  },
  methods: {
    async buscarInscriptos(id_llamado) {
      this.cargando = true;

      try {
        let res = null;

        if (
          this.edit_mode &&
          (this.$store.getters.isAdministrador ||
            this.$store.getters.isJefeCatedra)
        ) {
          res = await axios.get("/llamados/buscarLlamado/" + id_llamado, {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });
        } else if (!this.edit_mode) {
          res = await axios.get(
            "/llamados/buscarLlamadoCalificado/" + id_llamado
          );
        }

        this.llamado.id = res.data.id;
        this.llamado.fecha_inicio = res.data.fecha_inicio;
        this.llamado.fecha_fin = res.data.fecha_fin;
        this.llamado.requisitos = res.data.requisitos;
        this.llamado.vacantes = res.data.vacantes;
        this.llamado.calificado = res.data.calificado;
        this.llamado.finalizado = res.data.finalizado;
        this.llamado.catedra = res.data.catedra;
        this.llamado.postulaciones = [];
        if (res.data.postulaciones) {
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
        }

        this.editando = false;
      } catch (err) {
        console.log(err.response.data.error);
      }

      this.cargando = false;
    },

    calificar() {
      if (
        this.edit_mode &&
        this.llamado.finalizado &&
        !this.llamado.calificado &&
        (this.$store.getters.isAdministrador ||
          this.$store.getters.isJefeCatedra)
      ) {
        this.editando = true;
      }
    },

    cancelar() {
      this.editando = false;
    },

    async guardar() {
      if (
        (this.$store.getters.isAdministrador ||
          this.$store.getters.isJefeCatedra) &&
        this.edit_mode &&
        this.llamado &&
        this.llamado.finalizado &&
        !this.llamado.calificado &&
        this.llamado.postulaciones &&
        this.llamado.postulaciones.length > 0
      ) {
        let error = false;

        for (let postulacion of this.llamado.postulaciones) {
          postulacion.estadoError = false;
          postulacion.puntajeError = false;
          if (
            !(
              postulacion.estadoEditado === "Aceptar" ||
              postulacion.estadoEditado === "Rechazar"
            )
          ) {
            postulacion.estadoError = true;
            error = true;
          }
          if (
            !postulacion.puntajeEditado ||
            isNaN(postulacion.puntajeEditado) ||
            postulacion.puntajeEditado % 1 != 0 ||
            postulacion.puntajeEditado < 1 ||
            postulacion.puntajeEditado > 100
          ) {
            postulacion.puntajeError = true;
            error = true;
          }
        }

        if (!error) {
          this.calificandoLlamado(true);

          try {
            await axios.post(
              "/llamados/calificarLlamado",
              {
                llamado: this.llamado
              },
              {
                headers: {
                  Authorization: "Bearer " + this.$store.getters.user.api_token
                }
              }
            );

            this.calificandoLlamado(false);

            this.buscarInscriptos(this.llamado.id);
          } catch (err) {
            this.calificandoLlamado(false);

            console.log(err.response.data.error);
          }
        }
      }
    },

    calificandoLlamado(calificandoLlamado) {
      if (calificandoLlamado) {
        let timerInterval;
        Swal.fire({
          title: "Calificando llamado",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
            timerInterval = setInterval(() => {
              const content = Swal.getHtmlContainer();
              if (content) {
                const b = content.querySelector("b");
                if (b) {
                  b.textContent = Swal.getTimerLeft();
                }
              }
            }, 100);
          },
          willClose: () => {
            clearInterval(timerInterval);
          }
        });
      } else {
        Swal.close();
      }
    }
  },
  async created() {
    EventBus.$on(
      "buscarInscriptos",
      function(id_llamado) {
        this.buscarInscriptos(id_llamado);
      }.bind(this)
    );
  }
};
</script>

<style>
.columna-lg {
  width: 360px;
}

.columna-md {
  width: 200px;
}

.columna-sm {
  width: 120px;
}

.errorClass {
  background-color: rgb(228, 167, 167);
}

table {
  word-wrap: break-word;
}

.inscriptos-mobile {
  display: none;
}

.loading {
  display: block;
  margin: auto;
}

@media (max-width: 990px) {
  .inscriptos-mobile {
    display: block;
  }
  .inscriptos-desktop {
    display: none;
  }
  .inscripto-data {
    border-bottom: 1px solid rgb(158, 158, 158);
    padding: 1rem;
  }
}
</style>