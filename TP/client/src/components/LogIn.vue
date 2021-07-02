<template>
  <div>
    <Popup :dataTarget="dataTarget" title="Iniciar Sesión" :showButtons="false">
      <div style="width: 100%; margin-bottom: 1%;" v-if="errorMessage">
        <div
          class="alert alert-danger alert-dismissible fade show"
          style="width: fit-content; margin-top: 2%; margin-left: auto; margin-right: auto;"
          role="alert"
        >
          {{ errorMessage }}
          <button
            v-on:click="errorMessage = ''"
            class="close btn btn-link"
            data-dismiss="alert"
            style="color: black; text-decoration: none; font-size: 22px;"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="text-center animate__animated animate__flipInY animate__fast">
        <div class="card-body">
          <img
            src="../assets/img-signin.png"
            alt="Logo Inicio Sesion"
            class="card-img-top mx-auto m-4 rounded-circle w-25"
          />
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label><strong>Nombre Usuario</strong></label>
              <input
                type="text"
                v-model="user.nombre_usuario"
                placeholder="Nombre Usuario"
                class="form-control"
                :class="{ errorClass: errorNombreUsuario }"
                minlength="6"
                maxlength="30"
                required
                autofocus
              />
              <medium class="form-text text-muted" v-if="errorNombreUsuario"
                ><p class="error">{{ errorNombreUsuario }}</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <label><strong>Clave</strong></label>
              <input
                type="password"
                v-model="user.clave"
                placeholder="Clave"
                class="form-control"
                :class="{ errorClass: errorClave }"
                minlength="8"
                maxlength="40"
                required
              />
              <medium class="form-text text-muted" v-if="errorClave"
                ><p class="error">{{ errorClave }}</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <button class="btn btn-success btn-block">
                Iniciar Sesión
              </button>
            </div>
            <div class="form-group" v-if="!postularse">
              <utn-button btnClass="btn btn-link" @click="abrirSignUp">
                ¿No tienes cuenta? ¡Regístrate!
              </utn-button>
            </div>
          </form>
        </div>
      </div>
    </Popup>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { mapActions } from "vuex";
import EventBus from "../event-bus";
export default {
  props: {
    postularse: { type: Boolean, default: false },
    id_llamado: { type: Number },
    dataTarget: { type: String, default: "loginPopup" }
  },
  data() {
    return {
      errorMessage: "",
      errorNombreUsuario: "",
      errorClave: "",
      user: {
        nombre_usuario: "testing",
        clave: "test1232"
      }
    };
  },
  methods: {
    ...mapActions({
      signIn: "signIn"
    }),

    async handleSubmit() {
      try {
        this.errorMessage = "";
        let error = false;

        if (
          this.user.nombre_usuario &&
          this.user.nombre_usuario.length >= 6 &&
          this.user.nombre_usuario.length <= 30
        ) {
          this.errorNombreUsuario = "";
        } else {
          this.errorNombreUsuario =
            "Ingrese un nombre de usuario entre 6 y 30 caracteres";
          error = true;
        }

        if (
          this.user.clave &&
          this.user.clave.length >= 8 &&
          this.user.clave.length <= 40
        ) {
          this.errorClave = "";
        } else {
          this.errorClave = "Ingrese una clave entre 8 y 40 caracteres";
          error = true;
        }

        if (!error) {
          await this.signIn(this.user);

          if (!this.postularse) {
            this.$router.push({ path: "/perfil", query: { key: "signin" } });
            this.cerrarModal("#loginPopup");
          } else if (this.postularse) {
            await axios.post(
              "/postulaciones/agregarPostulacionDelUsuario",
              {
                id_llamado: this.id_llamado
              },
              {
                headers: {
                  Authorization: "Bearer " + this.$store.getters.user.api_token
                }
              }
            );

            this.$router.push({ path: "/perfil", query: { key: "postulado" } });
            this.cerrarModal("#loginPostulacionPopup");
          }
        } else {
          this.errorMessage = "Solucione los campos con error";
        }
      } catch (err) {
        if (!this.postularse) {
          this.errorMessage = err.response.data.error;
        } else if (this.postularse) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Algo salió mal...",
            text: err.response.data.error,
            showConfirmButton: true,
            timer: 4000
          });
          EventBus.$emit('actualizarVacantes');
          this.cerrarModal("#loginPostulacionPopup");
        }
      }
    },

    cerrarModal(id) {
      window.$(id).modal("hide");
      window.$("body").removeClass("modal-open");
      window.$(".modal-backdrop").remove();
    },

    abrirSignUp() {
      window.$("#loginPopup").modal("hide");
      window.$("#signUpPopup").modal("show");
    }
  }
};
</script>

<style>
.error {
  color: red;
}

.errorClass {
  background-color: rgb(228, 167, 167);
}
</style>