<template>
  <div class="mt-4">
    <nav aria-label="breadcrumb" class="m-auto" style="width: fit-content">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/perfil">
            <i class="fas fa-id-card"></i>
            Perfil
          </router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar Perfil</li>
      </ol>
    </nav>
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
    <div class="row m-2">
      <div class="col-md-4 mx-auto">
        <div class="card text-center animate__animated animate__flipInY animate__fast">
          <div class="card-header">
            <p style="font-size: 1.75rem;">
              <strong>Editar Perfil</strong>
            </p>
          </div>
          <div class="card-body">
            <form @submit.prevent="handleSubmit">
              <div class="form-group">
                <label>Nombre Usuario</label>
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
                <medium class="form-text text-muted" v-if="errorNombreUsuario">
                  <p class="error">{{ errorNombreUsuario }}</p>
                </medium>
              </div>
              <br />
              <div class="form-group">
                <label>Cambiar Clave</label>&nbsp;
                <input
                  type="checkbox"
                  v-model="user.cambiar_clave"
                  placeholder="Cambiar Clave"
                />
              </div>
              <br />
              <div v-if="user.cambiar_clave">
                <div class="form-group">
                  <label>Nueva Clave</label>
                  <input
                    type="password"
                    v-model="user.nueva_clave"
                    placeholder="Nueva Clave"
                    class="form-control"
                    :class="{ errorClass: errorNuevaClave }"
                    minlength="8"
                    maxlength="40"
                  />
                  <medium class="form-text text-muted" v-if="errorNuevaClave">
                    <p class="error">{{ errorNuevaClave }}</p>
                  </medium>
                </div>
                <br />
              </div>
              <div class="form-group">
                <label>Email</label>
                <input
                  type="email"
                  v-model="user.email"
                  placeholder="Email"
                  class="form-control"
                  :class="{ errorClass: errorEmail }"
                  maxlength="60"
                  required
                />
                <medium class="form-text text-muted" v-if="errorEmail">
                  <p class="error">{{ errorEmail }}</p>
                </medium>
              </div>
              <br />
              <div class="form-group">
                <label>Teléfono</label>
                <input
                  type="text"
                  v-model="user.telefono"
                  placeholder="Teléfono"
                  class="form-control"
                  :class="{ errorClass: errorTelefono }"
                  maxlength="60"
                  required
                />
                <medium class="form-text text-muted" v-if="errorTelefono">
                  <p class="error">{{ errorTelefono }}</p>
                </medium>
              </div>
              <br />
              <div class="form-group">
                <button class="btn btn-success btn-block">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <Popup data-target="ingresarClavePopup" title="Ingresar clave" :showButtons="false">
      <div style="width: 100%; margin-bottom: 1%;" v-if="errorMessageClave">
        <div
          class="alert alert-danger alert-dismissible fade show"
          style="width: fit-content; margin-top: 2%; margin-left: auto; margin-right: auto;"
          role="alert"
        >
          {{ errorMessageClave }}
          <button
            v-on:click="errorMessageClave = ''"
            class="close btn btn-link"
            data-dismiss="alert"
            style="color: black; text-decoration: none; font-size: 22px;"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <form @submit.prevent="handleSubmitClave">
        <div class="form-group">
          <label>Ingrese su clave para confirmar los cambios</label>
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
          <medium class="form-text text-muted" v-if="errorClave">
            <p class="error">{{ errorClave }}</p>
          </medium>
        </div>
        <br />
        <div class="form-group">
          <button class="btn btn-success btn-block">Confirmar</button>
        </div>
      </form>
    </Popup>
  </div>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";
export default {
  data() {
    return {
      errorMessage: "",
      errorMessageClave: "",
      errorNombreUsuario: "",
      errorClave: "",
      errorNuevaClave: "",
      errorEmail: "",
      errorTelefono: "",
      user: {
        nombre_usuario: "",
        clave: "",
        cambiar_clave: false,
        nueva_clave: "",
        email: "",
        telefono: ""
      }
    };
  },
  methods: {
    ...mapActions({
      updateProfile: "updateProfile"
    }),

    async buscarUsuario() {
      if (this.$store.getters.authenticated) {
        try {
          let res = await axios.get("/personas/perfil", {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });

          this.user.nombre_usuario = res.data.nombre_usuario;
          this.user.email = res.data.email;
          this.user.telefono = res.data.telefono;
        } catch (err) {
          console.log(err.response.data.error);
        }
      } else {
        this.$store.dispatch("logOut");
      }
    },

    handleSubmit() {
      this.errorMessage = "";
      let error = false;

      if (this.$store.getters.authenticated) {
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
          this.user.email &&
          this.user.email.length <= 60 &&
          this.validarEmail(this.user.email)
        ) {
          this.errorEmail = "";
        } else {
          this.errorEmail = "Ingrese un correo electrónico válido";
          error = true;
        }

        if (
          this.user.telefono &&
          this.user.telefono.length <= 60 &&
          !isNaN(this.user.telefono)
        ) {
          this.errorTelefono = "";
        } else {
          this.errorTelefono =
            "Ingrese un número de teléfono válido sin espacios";
          error = true;
        }

        if (
          !this.user.cambiar_clave ||
          (this.user.cambiar_clave &&
            this.user.nueva_clave &&
            this.user.nueva_clave.length >= 8 &&
            this.user.nueva_clave.length <= 40)
        ) {
          this.errorNuevaClave = "";
        } else {
          this.errorNuevaClave =
            "Ingrese una nueva clave entre 8 y 40 caracteres";
          error = true;
        }

        if (!error) {
          window.$("#ingresarClavePopup").modal("show");
        } else {
          this.errorMessage = "Solucione los campos con error";
        }
      } else {
        this.$store.dispatch("logOut");
      }
    },

    async handleSubmitClave() {
      this.errorMessageClave = "";
      let errorClave = false;

      if (this.$store.getters.authenticated) {
        if (
          this.user.clave &&
          this.user.clave.length >= 8 &&
          this.user.clave.length <= 40
        ) {
          this.errorClave = "";
        } else {
          this.errorClave = "Ingrese su clave";
          errorClave = true;
        }

        if (!errorClave) {
          try {
            await this.updateProfile(this.user);

            window.$("#ingresarClavePopup").modal("hide");
            window.$("body").removeClass("modal-open");
            window.$(".modal-backdrop").remove();

            this.$router.push("/perfil");
          } catch (err) {
            this.errorMessageClave = err.response.data.error;
          }
        } else {
          this.errorMessageClave = "Solucione los campos con error";
        }
      } else {
        this.$store.dispatch("logOut");
      }
    },

    validarEmail(email) {
      if (
        /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(email) //eslint-disable-line
      ) {
        return true;
      } else {
        return false;
      }
    }
  },
  created() {
    this.buscarUsuario();
  }
};
</script>

<style>
input[type="checkbox"] {
  position: relative;
  width: 50px;
  height: 24px;
  -webkit-appearance: none;
  background: #c6c6c6;
  outline: none;
  border-radius: 20px;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
  transition: 0.5s;
}

input:checked[type="checkbox"] {
  background: #03a9f4;
}

input[type="checkbox"]:before {
  content: "";
  position: absolute;
  width: 25px;
  height: 24px;
  border-radius: 20px;
  top: 0;
  left: 0;
  background: #fff;
  transform: scale(1.1);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  transition: 0.5s;
}

input:checked[type="checkbox"]:before {
  left: 25px;
}

.error {
  color: red;
}

.errorClass {
  background-color: rgb(228, 167, 167);
}
</style>