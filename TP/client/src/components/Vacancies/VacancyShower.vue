<template>
  <div class="mb-3">
    <h2 class="title-ultimas-vacantes mt-4" v-if="ultimasVacantes">¡Últimos cupos!</h2>
    <div v-if="cargando">
      <img src="../../assets/loading.gif" alt="Imagen de carga de página" class="loading mt-5" />
    </div>
    <div v-else>
      <div class="vacancies-list">
        <div v-if="!vacantes.length" class="alert alert-info no-vacancies" role="alert">
          <i class="fas fa-info-circle mt-5" style="font-size: 5rem"></i>
          <p class="mt-5 mb-5" v-if="!ultimasVacantes">¡No hay vacantes abiertas!</p>
          <p class="mt-5 mb-5" v-else>¡No hay vacantes abiertas con pocos cupos!</p>
        </div>
        <div v-else>
          <div class="vacancies">
            <div class="vacancy col-lg-6" v-for="(vacante, index) in limitVacantes" :key="index">
              <div class="descripcion">
                <p>{{ vacante.descripcion }}</p>
              </div>
              <div class="vacancy-content">
                <div class="definicion">
                  <p>{{ vacante.definicion }}</p>
                </div>
                <div>
                  <p>
                    <i class="fas fa-check-circle"></i>&nbsp;
                    <strong>Requisitos:</strong>
                    &nbsp;{{
                    vacante.requisitos
                    }}
                  </p>
                </div>
                <div class="fecha-fin">
                  <p>
                    <i class="fas fa-calendar"></i>&nbsp;
                    <strong>Fecha de cierre:</strong>
                    &nbsp;{{ vacante.fecha_fin }}
                  </p>
                </div>
                <div
                  class="postulado alert alert-success"
                  role="alert"
                  v-if="vacante.usuarioPostulado"
                >Ya se encuentra postulado</div>
                <div
                  class="pocas-vacantes"
                  role="alert"
                  v-if="
                    !vacante.usuarioPostulado &&
                      vacante.vacantes_disponibles <= 3
                  "
                >
                  <p v-if="vacante.vacantes_disponibles > 1">
                    <i class="fas fa-exclamation-circle"></i>
                    &nbsp;¡Quedan solo
                    {{ vacante.vacantes_disponibles }} vacantes!
                  </p>
                  <p v-else-if="vacante.vacantes_disponibles === 1">
                    <i class="fas fa-exclamation-circle"></i>&nbsp;¡Última
                    vacante disponible!
                  </p>
                  <p
                    v-else-if="vacante.vacantes_disponibles === 0"
                  >No quedan más vacantes disponibles</p>
                </div>
                <div
                  v-if="!authenticated && vacante.vacantes_disponibles > 0"
                  class="vacancy-options"
                >
                  <utn-button @click="postularme(vacante.id)">Postularme</utn-button>
                  <LogIn
                    data-target="loginPostulacionPopup"
                    :postularse="true"
                    :id_llamado="id_llamado"
                  />
                </div>
                <div class="vacancy-options" v-else-if="isUsuario">
                  <utn-button
                    @click="postularme(vacante.id)"
                    v-if="
                      !vacante.usuarioPostulado &&
                        !vacante.usuarioTrabajaEnLaCatedra &&
                        vacante.vacantes_disponibles > 0
                    "
                  >Postularme</utn-button>
                  <button
                    @click="modalDarmeDeBaja(vacante)"
                    class="btn btn-danger"
                    v-if="vacante.usuarioPostulado"
                  >Darme de baja</button>
                </div>
                <div v-if="vacante.usuarioTrabajaEnLaCatedra">
                  <p>Ya forma parte de la cátedra</p>
                </div>
              </div>
            </div>
          </div>
          <div class="w-100 mt-2">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ disabled: pag === 1 }">
                  <a class="page-link" href="#" tabindex="-1" @click.prevent="disminuirPag">Anterior</a>
                </li>
                <li class="page-item" v-for="n in numeros" :key="n">
                  <a class="page-link" href="#" @click.prevent="pag = n">
                    {{
                    n
                    }}
                  </a>
                </li>
                <li
                  class="page-item"
                  :class="{
                    disabled: pag === Math.ceil(vacantes.length / limit)
                  }"
                >
                  <a class="page-link" href="#" @click.prevent="aumentarPag">Siguiente</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { mapGetters, mapActions } from "vuex";
import EventBus from "../../event-bus";
export default {
  components: {
    LogIn: () => import("../LogIn.vue")
  },
  data() {
    return {
      cargando: true,
      postulacionesDelUsuario: [],
      trabajosDelUsuario: [],
      vacantes: [],
      id_llamado: null,
      pag: 1
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      isUsuario: "isUsuario"
    }),

    limitVacantes() {
      return this.vacantes.slice(
        this.pag * this.limit - this.limit,
        this.pag * this.limit
      );
    },

    numeros() {
      return Math.ceil(this.vacantes.length / this.limit);
    }
  },
  props: {
    limit: { type: Number, default: 12 },
    ultimasVacantes: { type: Boolean, default: false }
  },
  methods: {
    ...mapActions({
      logOut: "logOut"
    }),

    disminuirPag() {
      if (this.pag > 1) this.pag--;
    },

    aumentarPag() {
      if (this.pag < Math.ceil(this.vacantes.length / this.limit)) this.pag++;
    },

    async buscarPostulacionesDelUsuario() {
      if (this.$store.getters.authenticated && this.$store.getters.isUsuario) {
        try {
          let res = await axios.get(
            "/postulaciones/buscarPostulacionesDelUsuario",
            {
              headers: {
                Authorization: "Bearer " + this.$store.getters.user.api_token
              }
            }
          );

          this.postulacionesDelUsuario = res.data;
        } catch (err) {
          console.log(err.response.data.error);
        }
      }
    },

    async buscarTrabajosDelUsuario() {
      if (this.$store.getters.authenticated && this.$store.getters.isUsuario) {
        try {
          let res = await axios.get("/trabajos/buscarTrabajosDelUsuario", {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });

          this.trabajosDelUsuario = res.data;
        } catch (err) {
          console.log(err.response.data.error);
        }
      }
    },

    async buscarVacantes() {
      try {
        let res = null;
        if (this.ultimasVacantes) {
          res = await axios.get("/llamados/buscarUltimasVacantes");
        } else {
          res = await axios.get("/llamados/buscarLlamados");
        }
        let vacantes = res.data;

        if (vacantes && vacantes.length > 0) {
          for (let vacante of vacantes) {
            vacante.usuarioPostulado = false;
            vacante.usuarioTrabajaEnLaCatedra = false;

            if (
              this.postulacionesDelUsuario &&
              this.postulacionesDelUsuario.length > 0
            ) {
              for (let postulacion of this.postulacionesDelUsuario) {
                if (vacante.id === postulacion.id_llamado) {
                  vacante.usuarioPostulado = true;
                  break;
                }
              }
            }

            if (this.trabajosDelUsuario && this.trabajosDelUsuario.length > 0) {
              for (let trabajo of this.trabajosDelUsuario) {
                if (vacante.id_catedra === trabajo.id_catedra) {
                  vacante.usuarioTrabajaEnLaCatedra = true;
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
      this.cargando = true;
      this.postulacionesDelUsuario = [];
      this.trabajosDelUsuario = [];
      this.vacantes = [];
      this.pag = 1;

      if (this.$store.getters.authenticated && this.$store.getters.isUsuario) {
        await this.buscarPostulacionesDelUsuario();
        await this.buscarTrabajosDelUsuario();
      }
      await this.buscarVacantes();
      this.cargando = false;
    },

    async postularme(id_llamado) {
      if (this.$store.getters.authenticated) {
        if (this.$store.getters.isUsuario) {
          try {
            await axios.post(
              "/postulaciones/agregarPostulacionDelUsuario",
              {
                id_llamado
              },
              {
                headers: {
                  Authorization: "Bearer " + this.$store.getters.user.api_token
                }
              }
            );

            this.actualizarVacantes();
          } catch (err) {
            Swal.fire({
              position: "center",
              icon: "error",
              title: "Algo salió mal...",
              text: err.response.data.error,
              showConfirmButton: true
            });
            this.actualizarVacantes();
          }
        }
      } else {
        this.id_llamado = id_llamado;
        window.$("#loginPostulacionPopup").modal("show");
      }
    },

    modalDarmeDeBaja(vacante) {
      Swal.fire({
        title: "Darse de baja",
        text:
          "¿Seguro desea darse de baja del llamado de " +
          vacante.descripcion +
          " del " +
          vacante.fecha_inicio +
          "?",
        showDenyButton: true,
        denyButtonText: "Darme de baja",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        showConfirmButton: false
      }).then(result => {
        if (result.isDenied) {
          this.darmeDeBaja(vacante.id);
        }
      });
    },

    async darmeDeBaja(id_llamado) {
      if (this.$store.getters.authenticated) {
        if (this.$store.getters.isUsuario) {
          try {
            await axios.delete(
              "/postulaciones/eliminarPostulacionDelUsuario/" + id_llamado,
              {
                headers: {
                  Authorization: "Bearer " + this.$store.getters.user.api_token
                }
              }
            );

            this.actualizarVacantes();
          } catch (err) {
            console.log(err.response.data.error);
            this.actualizarVacantes();
          }
        }
      } else {
        this.logOut();
      }
    }
  },
  async created() {
    this.actualizarVacantes();

    EventBus.$on(
      "actualizarVacantes",
      function() {
        this.actualizarVacantes();
      }.bind(this)
    );
  }
};
</script>

<style>
.title-ultimas-vacantes {
  text-align: center;
  font-weight: bold;
}

.vacancies-list {
  width: 90%;
  margin: 25px auto;
}

.vacancies {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
}

.vacancy {
  padding: 1rem;
  font-size: 1.08rem;
  display: flex;
  flex-direction: column;
}

.vacancy-content {
  border: RGB(0, 122, 255) 2px solid;
  border-radius: 0 0 15px 15px;
  padding: 0.5rem 1rem;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.descripcion {
  font-size: 1.64rem;
  font-weight: 600;
  border-radius: 15px 15px 0 0;
  padding: 1rem 0.5rem 0rem 1rem;
  background-color: RGB(0, 122, 255);
  color: white;
}

.vacancy-options {
  display: flex;
  justify-content: center;
}

.pocas-vacantes {
  color: rgb(221, 44, 0);
}

.no-vacancies {
  font-size: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.loading {
  display: block;
  margin: auto;
}
</style>