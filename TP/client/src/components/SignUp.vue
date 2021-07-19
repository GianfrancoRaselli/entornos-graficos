<template>
  <div>
    <Popup :dataTarget="identificator" title="Registrarse" :showButtons="false">
      <div style="width: 100%; margin-bottom: 1%;" v-if="errorMessage">
        <div
          class="alert alert-danger alert-dismissible fade show"
          style="width: fit-content; margin-top: 2%; margin-left: auto; margin-right: auto;"
          role="alert"
        >
          {{ errorMessage }}
          <button
            @click="errorMessage = ''"
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
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label><b>Número DNI</b></label>
              <input
                type="text"
                v-model="user.dni"
                placeholder="42589786"
                class="form-control"
                :class="{ errorClass: errorDNI }"
                maxlength="10"
                minlength="7"
                required
                autofocus
              />
              <medium class="form-text text-muted" v-if="errorDNI"
                ><p class="error">{{ errorDNI }}</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <label><b>Imagen del DNI</b></label>
              <input
                type="file"
                @change="obtenerArchivoDNI"
                placeholder="CV"
                class="form-control-file"
                :class="{ errorClass: errorFormatoDNI }"
                accept="pdf"
                required
              />
              <small class="form-text text-muted" v-if="!errorFormatoDNI"
                ><p>Ingrese su DNI en formado PDF</p></small
              >
              <medium class="form-text text-muted" v-if="errorFormatoDNI"
                ><p class="error">Ingrese su DNI en formado PDF</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <label><b>Nombre Usuario</b></label>
              <input
                type="text"
                v-model="user.nombre_usuario"
                placeholder="Usuario123"
                class="form-control"
                :class="{ errorClass: errorNombreUsuario }"
                minlength="6"
                maxlength="30"
                required
              />
              <medium class="form-text text-muted" v-if="errorNombreUsuario"
                ><p class="error">{{ errorNombreUsuario }}</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <label><b>Clave</b></label>
              <input
                type="password"
                v-model="user.clave"
                placeholder="Mínimo de 8 caracteres"
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
              <label><b>Nombre y Apellido</b></label>
              <input
                type="text"
                v-model="user.nombre_apellido"
                placeholder="Fulano Mengano"
                class="form-control"
                :class="{ errorClass: errorNombreApellido }"
                maxlength="60"
                required
              />
              <medium class="form-text text-muted" v-if="errorNombreApellido"
                ><p class="error">{{ errorNombreApellido }}</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <label><b>Email</b></label>
              <input
                type="email"
                v-model="user.email"
                placeholder="correo@email.com"
                class="form-control"
                :class="{ errorClass: errorEmail }"
                maxlength="60"
                required
              />
              <medium class="form-text text-muted" v-if="errorEmail"
                ><p class="error">{{ errorEmail }}</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <label><b>Teléfono</b></label>
              <input
                type="text"
                v-model="user.telefono"
                placeholder="03414481871"
                class="form-control"
                :class="{ errorClass: errorTelefono }"
                maxlength="14"
                required
              />
              <medium class="form-text text-muted" v-if="errorTelefono"
                ><p class="error">{{ errorTelefono }}</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <label><b>Curriculum Vitae</b></label>
              <input
                type="file"
                @change="obtenerArchivoCV"
                placeholder="CV"
                class="form-control-file"
                :class="{ errorClass: errorFormatoCV }"
                accept="pdf"
                required
              />
              <small class="form-text text-muted" v-if="!errorFormatoCV"
                ><p>Ingrese su CV en formado PDF</p></small
              >
              <medium class="form-text text-muted" v-if="errorFormatoCV"
                ><p class="error">Ingrese su CV en formado PDF</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <button class="btn btn-success btn-block">
                Crear Cuenta
              </button>
            </div>
          </form>
        </div>
      </div>
    </Popup>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Swal from "sweetalert2";
export default {
  props: {
    identificator: { type: String, default: "signUpPopup" }
  },
  data() {
    return {
      errorMessage: "",
      errorDNI: "",
      errorFormatoDNI: false,
      errorNombreUsuario: "",
      errorClave: "",
      errorNombreApellido: "",
      errorEmail: "",
      errorTelefono: "",
      errorFormatoCV: false,
      user: {
        dni: "",
        imagen_dni: null,
        nombre_usuario: "",
        clave: "",
        nombre_apellido: "",
        email: "",
        telefono: "",
        curriculum_vitae: null
      }
    };
  },
  methods: {
    ...mapActions({
      signUp: "signUp"
    }),

    async handleSubmit() {
      try {
        this.errorMessage = "";
        let error = false;

        if (
          this.user.dni &&
          this.user.dni.length >= 7 &&
          this.user.dni.length <= 10 &&
          !isNaN(this.user.dni)
        ) {
          this.errorDNI = "";
        } else {
          this.errorDNI = "Número de DNI no válido";
          error = true;
        }

        if (!this.user.imagen_dni) {
          this.errorFormatoDNI = true;
          error = true;
        }

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

        if (
          this.user.nombre_apellido &&
          this.user.nombre_apellido.length <= 60
        ) {
          this.errorNombreApellido = "";
        } else {
          this.errorNombreApellido = "Nombre y apellido no válido";
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
          this.user.telefono.length <= 14 &&
          !isNaN(this.user.telefono)
        ) {
          this.errorTelefono = "";
        } else {
          this.errorTelefono =
            "Ingrese un número de teléfono válido sin espacios";
          error = true;
        }

        if (!this.user.curriculum_vitae) {
          this.errorFormatoCV = true;
          error = true;
        }

        if (!error) {
          let formData = new FormData();
          for (let clave in this.user) {
            formData.append(clave, this.user[clave]);
          }

          await this.signUp(formData);

          window.$("#signUpPopup").modal("hide");
          window.$("body").removeClass("modal-open");
          window.$(".modal-backdrop").remove();

          Swal.fire(
            "Persona registrada",
            "Cuando se verifiquen los datos se le notificará por correo electrónico",
            "success"
          );
        } else {
          this.errorMessage = "Solucione los campos con errores";
        }
      } catch (err) {
        this.errorMessage = err.response.data.error;
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
    },

    obtenerArchivoDNI(e) {
      if (e.target.files[0].name.split(".").pop() === "pdf") {
        this.errorFormatoDNI = false;
        this.user.imagen_dni = e.target.files[0];
      } else {
        this.errorFormatoDNI = true;
      }
    },

    obtenerArchivoCV(e) {
      if (e.target.files[0].name.split(".").pop() === "pdf") {
        this.errorFormatoCV = false;
        this.user.curriculum_vitae = e.target.files[0];
      } else {
        this.errorFormatoCV = true;
      }
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