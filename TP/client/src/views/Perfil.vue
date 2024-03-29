<template>
  <div class="mt-4">
    <div v-if="!cargado">
      <img src="../assets/loading.gif" alt="Imagen de carga de página" class="loading mt-5" />
    </div>
    <div v-else>
      <div
        class="d-flex justify-content-center animate__animated animate__pulse animate__fast mx-1"
      >
        <div class="w-100 profile-container">
          <div class="col-sm-10 col-md-8 col-lg-7 col-xl-6 data-box">
            <div class="profile-img">{{ user.nombre_apellido[0] }}</div>
            <div class="personal-info mt-3 mx-2">
              <p>
                <b>DNI</b>: {{ user.dni }}
              </p>
              <p>
                <b>Nombre y apellido</b>: {{ user.nombre_apellido }}
              </p>
              <p>
                <b>Email</b>: {{ user.email }}
              </p>
              <p>
                <b>Teléfono</b>: {{ user.telefono }}
              </p>
            </div>
            <utn-button
              icon="fas fa-edit mr-2"
              to="perfil/editar"
              btnClass="btn btn-light mt-1 ml-4"
              id="btn-editar-usuario"
            >Editar</utn-button>
          </div>
          <div class="d-flex">
            <button
              class="btn btn-outline-primary mr-1"
              data-toggle="modal"
              data-target="#cargarCV"
            >
              <i class="fas fa-file-upload"></i> Cargar nuevo CV
            </button>

            <a
              id="btn-ver-cv"
              class="btn btn-primary ml-1"
              v-if="user.ruta_cv"
              :href="user.ruta_cv"
              target="_blank"
            >
              <i class="fas fa-eye"></i> Ver CV
            </a>
          </div>
          <div class="applications mt-5" v-if="isUsuario && user.postulaciones.length">
            <h4 class="mb-2">Mis postulaciones</h4>
            <table class="table table-responsive-lg">
              <thead>
                <tr>
                  <th scope="col">Nro</th>
                  <th scope="col">Cátedra</th>
                  <th scope="col">Fecha inicio</th>
                  <th scope="col">Fecha fin</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Calificación</th>
                  <th scope="col">Acción</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(postulacion, index) in user.postulaciones"
                  :key="index"
                  :class="{ elegido: postulacion.estado === 'Elegido', noElegido: postulacion.estado === 'No elegido' }"
                >
                  <th scope="row">{{ ++index }}</th>
                  <td>{{ postulacion.llamado.catedra.descripcion }}</td>
                  <td>{{ postulacion.llamado.fecha_inicio }}</td>
                  <td>{{ postulacion.llamado.fecha_fin }}</td>
                  <td>{{ postulacion.estado }}</td>
                  <td>
                    <div v-if="postulacion.puntaje">{{ postulacion.puntaje }}</div>
                    <div v-else>-</div>
                  </td>
                  <td>
                    <div v-if="!postulacion.llamado.finalizado && !postulacion.llamado.calificado">
                      <utn-button
                        @click="darmeDeBaja(postulacion.llamado.id)"
                        btnClass="btn btn-danger"
                      >Darme de baja</utn-button>
                    </div>
                    <div v-else>-</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <Popup data-target="cargarCV" title="Cargar CV" :showButtons="false">
        <form @submit.prevent="handleSubmitCV" enctype="multipart/form-data">
          <div class="form-group">
            <label for="labelInputCV">
              <b>Curriculum Vitae</b>:
            </label>
            <input
              type="file"
              @change="obtenerArchivo"
              placeholder="CV"
              class="form-control-file"
              accept="pdf"
              required
            />
            <small class="form-text text-muted" v-if="!errorFormato">
              <p>Ingrese su CV en formado PDF</p>
            </small>
            <medium class="form-text text-muted" v-if="errorFormato">
              <p class="error">Ingrese su CV en formado PDF</p>
            </medium>
          </div>
          <br />
          <div class="form-group">
            <button class="btn btn-success btn-block">
              <i class="fas fa-save"></i> Guardar
            </button>
          </div>
        </form>
      </Popup>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import Swal from "sweetalert2";
import { CVsPath } from "../paths";
export default {
  data() {
    return {
      usuarioCargado: false,
      postulacionesCargadas: false,
      user: {
        dni: "",
        nombre_apellido: "",
        email: "",
        telefono: "",
        curriculum_vitae: null,
        ruta_cv: "",
        postulaciones: []
      },
      errorFormato: false
    };
  },
  computed: {
    ...mapGetters({
      isUsuario: "isUsuario"
    }),

    cargado() {
      return this.usuarioCargado && this.postulacionesCargadas;
    }
  },
  methods: {
    async buscarPostulacionesDelUsuario() {
      this.postulacionesCargadas = false;

      if (this.$store.getters.isUsuario) {
        this.user.postulaciones = [];

        try {
          let res = await axios.get(
            "/postulaciones/buscarPostulacionesDelUsuario",
            {
              headers: {
                Authorization: "Bearer " + this.$store.getters.user.api_token
              }
            }
          );

          this.user.postulaciones = res.data;
        } catch (err) {
          console.log(err.response.data.error);
        }
      }

      this.postulacionesCargadas = true;
    },

    async buscarUsuario() {
      if (this.$store.getters.authenticated) {
        this.usuarioCargado = false;

        try {
          let res = await axios.get("/personas/perfil", {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });

          this.user.dni = res.data.dni;
          this.user.nombre_apellido = res.data.nombre_apellido;
          this.user.email = res.data.email;
          this.user.telefono = res.data.telefono;
          if (res.data.curriculum_vitae) {
            this.user.ruta_cv = CVsPath + res.data.curriculum_vitae;
          }
        } catch (err) {
          console.log(err.response.data.error);
        }

        this.usuarioCargado = true;
      } else {
        this.$store.dispatch("logOut");
      }
    },

    async handleSubmitCV() {
      if (this.$store.getters.authenticated) {
        if (this.user.curriculum_vitae && !this.errorFormato) {
          let formData = new FormData();
          formData.append("curriculum_vitae", this.user.curriculum_vitae);

          try {
            let res = await axios.post("/personas/actualizarCV", formData, {
              headers: {
                Authorization: "Bearer " + this.$store.getters.user.api_token
              }
            });

            this.user.ruta_cv = CVsPath + res.data;

            window.$("#cargarCV").modal("hide");
            window.$("body").removeClass("modal-open");
            window.$(".modal-backdrop").remove();

            Swal.fire({
              position: "center",
              icon: "success",
              title: "CV actualizado correctamente",
              showConfirmButton: true,
              confirmButtonColor: "#3CC134",
              confirmButtonText: "Confirmar",
              timer: 3000
            });
          } catch (err) {
            console.log(err.response.data.error);
          }
        } else {
          this.errorFormato = true;
        }
      } else {
        this.$store.dispatch("logOut");
      }
    },

    obtenerArchivo(e) {
      if (e.target.files[0].name.split(".").pop() === "pdf") {
        this.errorFormato = false;
        this.user.curriculum_vitae = e.target.files[0];
      } else {
        this.errorFormato = true;
      }
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

            this.buscarPostulacionesDelUsuario();
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
    if (this.$route.query.key) {
      if (this.$route.query.key === "signin") {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "¡Bienvenido!",
          showConfirmButton: false,
          timer: 2000
        });
      } else if (this.$route.query.key === "postulado") {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "¡Postulado!",
          showConfirmButton: true,
          timer: 3000
        });
      }
    }
    this.buscarUsuario();
    this.buscarPostulacionesDelUsuario();
  }
};
</script>

<style>
.profile-container {
  margin-bottom: auto;
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
}

.data-box {
  padding: 2rem 1rem;
  align-self: center;
  margin: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: RGBA(12, 110, 253, 1);
  border-radius: 0.5rem;
  flex-wrap: wrap;
}

.profile-img {
  height: 5rem;
  width: 5rem;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 100%;
  font-weight: 600;
  color: RGB(12, 110, 253);
  font-size: 2rem;
  text-transform: uppercase;
  background-color: white;
}

.personal-info {
  color: white;
  padding-left: 1rem;
}

.applications {
  width: 90%;
  margin-top: 1rem;
}

.error {
  color: red;
}

.loading {
  display: block;
  margin: auto;
}

.elegido {
  background-color: rgb(149, 248, 170);
}

.noElegido {
  background-color: rgb(253, 193, 193);
}
</style>