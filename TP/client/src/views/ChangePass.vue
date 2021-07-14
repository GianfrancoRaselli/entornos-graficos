<template>
  <div class="mt-4">
    <div v-if="buscandoUsuario">
      <img
        src="../assets/loading.gif"
        alt="Imagen de carga de página"
        class="loading mt-5"
      />
    </div>
    <div v-else-if="habilitadoACambiarClave">
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
        <div class="col-md-5 mx-auto">
          <div
            class="text-center animate__animated animate__flipInY animate__fast"
          >
            <div class="card-header">
              <p style="font-size: 1.75rem;">
                <strong>Cambiar Clave</strong>
              </p>
              <p><strong>Usuario: </strong>{{ user.nombre_usuario }}</p>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleSubmit">
                <div class="form-group">
                  <label><strong>Nueva Clave</strong></label>
                  <input
                    type="password"
                    v-model="user.nueva_clave"
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
                    Guardar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <p class="title"><i class="fas fa-angle-right"></i> {{ errorCodigo }}</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";
export default {
  data() {
    return {
      buscandoUsuario: true,
      habilitadoACambiarClave: false,
      errorMessage: "",
      errorCodigo: "",
      errorClave: "",
      user: {
        nombre_usuario: "",
        nueva_clave: "",
        codigo_cambiar_clave: ""
      }
    };
  },
  methods: {
    ...mapActions({
      changePass: "changePass"
    }),

    async handleSubmit() {
      try {
        this.errorMessage = "";
        let error = false;

        if (
          this.user.nueva_clave &&
          this.user.nueva_clave.length >= 8 &&
          this.user.nueva_clave.length <= 40
        ) {
          this.errorClave = "";
        } else {
          this.errorClave = "Ingrese una clave entre 8 y 40 caracteres";
          error = true;
        }

        if (!error) {
          await this.changePass(this.user);

          this.$router.push({ path: "/perfil", query: { key: "signin" } });
        } else {
          this.errorMessage = "Solucione los campos con error";
        }
      } catch (err) {
        this.buscandoPersona(false);

        this.errorMessage = err.response.data.error;
      }
    },

    async buscarUsuario(codigo) {
      this.buscandoUsuario = true;

      try {
        let res = await axios.get("/personas/buscarPersonaPorCodigo/" + codigo);

        this.user.nombre_usuario = res.data;

        this.habilitadoACambiarClave = true;
      } catch (err) {
        this.habilitadoACambiarClave = false;

        this.errorCodigo = err.response.data.error;
      }

      this.buscandoUsuario = false;
    }
  },
  created() {
    this.user.codigo_cambiar_clave = this.$route.params.codigo;
    this.buscarUsuario(this.user.codigo_cambiar_clave);
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

.title {
  margin-left: 4%;
}

.loading {
  display: block;
  margin: auto;
}
</style>