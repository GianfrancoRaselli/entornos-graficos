<template>
  <div>
    <div v-if="cargando">
      <img src="../../assets/loading.gif" alt="Imagen de carga de página" class="loading mt-5" />
    </div>
    <div v-else>
      <nav aria-label="breadcrumb" class="m-auto" style="width: fit-content">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/administrarCatedras">
              <i class="fas fa-book-open"></i> Administrar
              Cátedras
            </router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page" v-if="!editMode">Agregar Cátedra</li>
          <li
            class="breadcrumb-item active"
            aria-current="page"
            v-else
          >Editar Cátedra: {{ catedraEditando }}</li>
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
        <div class="col-md-5 mx-auto">
          <div class="card text-center animate__animated animate__flipInY animate__fast">
            <div class="card-header">
              <p style="font-size: 1.75rem;">
                <strong>Agregar Cátedra</strong>
              </p>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleSubmit">
                <div class="form-group">
                  <label>
                    <strong>Cátedra</strong>
                  </label>
                  <input
                    type="text"
                    v-model="catedra.descripcion"
                    placeholder="Entornos Gráficos"
                    class="form-control"
                    :class="{ errorClass: errorDescripcion }"
                    maxlength="40"
                    required
                    autofocus
                  />
                  <medium class="form-text text-muted" v-if="errorDescripcion">
                    <p class="error">{{ errorDescripcion }}</p>
                  </medium>
                </div>
                <br />
                <div class="form-group">
                  <label>
                    <strong>Descripción</strong>
                  </label>
                  <textarea
                    type="text"
                    v-model="catedra.definicion"
                    placeholder="Descipción de la cátedra"
                    class="form-control"
                    :class="{ errorClass: errorDefinicion }"
                    maxlength="300"
                    required
                  />
                  <medium class="form-text text-muted" v-if="errorDefinicion">
                    <p class="error">{{ errorDefinicion }}</p>
                  </medium>
                </div>
                <br />
                <div class="form-group">
                  <label>
                    <strong>Jefe de Cátedra</strong>
                  </label>
                  <select
                    class="form-control"
                    :class="{ errorClass: errorIdJefeCatedra }"
                    v-model="catedra.id_jefe_catedra"
                    required
                  >
                    <option
                      v-for="(persona, index) in personas"
                      :key="index"
                      :value="persona.id"
                    >{{ persona.dni }} - {{ persona.nombre_apellido }}</option>
                  </select>
                  <medium class="form-text text-muted" v-if="errorIdJefeCatedra">
                    <p class="error">{{ errorIdJefeCatedra }}</p>
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
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      editMode: false,
      catedraEditando: "",
      cargando: true,
      errorMessage: "",
      errorDescripcion: "",
      errorDefinicion: "",
      errorIdJefeCatedra: "",
      catedra: {
        id: 0,
        descripcion: "",
        definicion: "",
        id_jefe_catedra: 0
      },
      personas: []
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      isAdministrador: "isAdministrador"
    })
  },
  methods: {
    async buscarCatedra(id_catedra) {
      if (this.authenticated && this.isAdministrador) {
        this.cargando = true;

        try {
          let res = await axios.get("/catedras/buscarCatedra/" + id_catedra, {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });

          this.catedraEditando = res.data.descripcion;
          this.catedra = res.data;
        } catch (err) {
          console.log(err.response.data.error);
        }

        this.cargando = false;
      } else {
        this.$store.dispatch("logOut");
      }
    },

    async buscarPersonas() {
      if (this.authenticated && this.isAdministrador) {
        try {
          let res = await axios.get("/personas/buscarPersonas", {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });

          this.personas = res.data;
        } catch (err) {
          console.log(err.response.data.error);
        }
      } else {
        this.$store.dispatch("logOut");
      }
    },

    async handleSubmit() {
      this.errorMessage = "";
      let error = false;

      if (this.authenticated && this.isAdministrador) {
        if (this.catedra.descripcion && this.catedra.descripcion.length <= 40) {
          this.errorDescripcion = "";
        } else {
          this.errorDescripcion =
            "Ingrese el nombre de la cátedra con una longitud menor a 40 caracteres";
          error = true;
        }

        if (this.catedra.definicion && this.catedra.definicion.length <= 300) {
          this.errorDefinicion = "";
        } else {
          this.errorDefinicion =
            "Ingrese una descripción con una longitud menor a 300 caracteres";
          error = true;
        }

        if (
          this.catedra.id_jefe_catedra &&
          !isNaN(this.catedra.id_jefe_catedra) &&
          this.catedra.id_jefe_catedra > 0 &&
          this.catedra.id_jefe_catedra % 1 === 0
        ) {
          this.errorIdJefeCatedra = "";
        } else {
          this.errorIdJefeCatedra = "Seleccione un jefe de cátedra";
          error = true;
        }

        if (!error) {
          try {
            if (!this.editMode) {
              await axios.post(
                "/catedras/agregarCatedra",
                {
                  catedra: this.catedra
                },
                {
                  headers: {
                    Authorization:
                      "Bearer " + this.$store.getters.user.api_token
                  }
                }
              );
            } else if (this.editMode) {
              await axios.post(
                "/catedras/editarCatedra",
                {
                  catedra: this.catedra
                },
                {
                  headers: {
                    Authorization:
                      "Bearer " + this.$store.getters.user.api_token
                  }
                }
              );
            }

            this.$router.push("/administrarCatedras");
          } catch (err) {
            this.errorMessage = err.response.data.error;
          }
        } else {
          this.errorMessage = "Solucione los campos con error";
        }
      } else {
        this.$store.dispatch("logOut");
      }
    }
  },
  created() {
    this.buscarPersonas();
    if (this.$route.params.id_catedra) {
      this.editMode = true;
      this.buscarCatedra(this.$route.params.id_catedra);
    } else {
      this.editMode = false;
      this.cargando = false;
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

.loading {
  display: block;
  margin: auto;
}
</style>