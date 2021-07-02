<template>
  <div>
    <nav aria-label="breadcrumb" class="m-auto" style="width: fit-content">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/administrarVacantes"
            ><i class="fas fa-toolbox"></i> Administrar Vacantes</router-link
          >
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          Agregar Vacante
        </li>
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
        <div
          class="card text-center animate__animated animate__flipInY animate__fast"
        >
          <div class="card-header">
            <p style="font-size: 1.75rem;"><strong>Agregar Vacante</strong></p>
          </div>
          <div class="card-body">
            <form @submit.prevent="handleSubmit">
              <div class="form-group">
                <label>Fecha Inicio</label>
                <input
                  type="date"
                  v-model="llamado.fecha_inicio"
                  placeholder="Fecha Inicio"
                  :min="fecha_hoy"
                  class="form-control"
                  :class="{ errorClass: errorFechaInicio }"
                  required
                  autofocus
                />
                <medium class="form-text text-muted" v-if="errorFechaInicio"
                  ><p class="error">{{ errorFechaInicio }}</p></medium
                >
              </div>
              <br />
              <div v-if="llamado.fecha_inicio">
                <div class="form-group">
                  <label>Fecha Fin</label>
                  <input
                    type="date"
                    v-model="llamado.fecha_fin"
                    placeholder="Fecha Inicio"
                    :min="llamado.fecha_inicio"
                    class="form-control"
                    :class="{ errorClass: errorFechaFin }"
                    required
                  />
                  <medium class="form-text text-muted" v-if="errorFechaFin"
                    ><p class="error">{{ errorFechaFin }}</p></medium
                  >
                </div>
                <br />
              </div>
              <div class="form-group">
                <label>Requisitos</label>
                <textarea
                  type="text"
                  v-model="llamado.requisitos"
                  placeholder="Requisitos"
                  class="form-control"
                  :class="{ errorClass: errorRequisitos }"
                  maxlength="300"
                  required
                />
                <medium class="form-text text-muted" v-if="errorRequisitos"
                  ><p class="error">{{ errorRequisitos }}</p></medium
                >
              </div>
              <br />
              <div class="form-group">
                <label>Vacantes</label>
                <input
                  type="number"
                  v-model="llamado.vacantes"
                  placeholder="Vacentes"
                  min="1"
                  max="100"
                  class="form-control"
                  :class="{ errorClass: errorVacantes }"
                  required
                />
                <medium class="form-text text-muted" v-if="errorVacantes"
                  ><p class="error">{{ errorVacantes }}</p></medium
                >
              </div>
              <br />
              <div class="form-group">
                <label>Cátedra</label>
                <select
                  class="form-control"
                  :class="{ errorClass: errorIdCatedra }"
                  v-model="llamado.id_catedra"
                  required
                >
                  <option
                    v-for="(catedra, index) in catedras"
                    :key="index"
                    :value="catedra.id"
                    >{{ catedra.descripcion }}</option
                  >
                </select>
                <medium class="form-text text-muted" v-if="errorIdCatedra"
                  ><p class="error">{{ errorIdCatedra }}</p></medium
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
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      errorMessage: "",
      errorFechaInicio: "",
      errorFechaFin: "",
      errorRequisitos: "",
      errorVacantes: "",
      errorIdCatedra: "",
      llamado: {
        fecha_inicio: "",
        fecha_fin: "",
        requisitos: "",
        vacantes: 0,
        id_catedra: ""
      },
      catedras: []
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      isAdministrador: "isAdministrador"
    }),

    fecha_hoy() {
      let fecha = new Date();

      let anio = fecha.getFullYear();

      let _mes = fecha.getMonth();
      _mes = _mes + 1;
      let mes = "";
      if (_mes < 10) {
        mes = "0" + _mes;
      } else {
        mes = _mes;
      }

      let _dia = fecha.getDate();
      let dia = "";
      if (_dia < 10) {
        dia = "0" + _dia;
      } else {
        dia = _dia;
      }

      return anio + "-" + mes + "-" + dia;
    }
  },
  methods: {
    async buscarCatedras() {
      if (this.authenticated && this.isAdministrador) {
        try {
          let res = await axios.get("/catedras/buscarCatedras", {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });

          this.catedras = res.data;
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
        if (this.llamado.fecha_inicio) {
          this.errorFechaInicio = "";
        } else {
          this.errorFechaInicio =
            "Ingrese la fecha de inicio del llamado posterior a la fecha de hoy";
          error = true;
        }

        if (this.llamado.fecha_fin) {
          this.errorFechaFin = "";
        } else {
          this.errorFechaFin =
            "Ingrese la fecha de cierre del llamado posterior a la fecha de inicio";
          error = true;
        }

        if (this.llamado.requisitos && this.llamado.requisitos.length <= 300) {
          this.errorRequisitos = "";
        } else {
          this.errorRequisitos =
            "Ingrese los requisitos con una longitud menor a 300 caracteres";
          error = true;
        }

        if (
          this.llamado.vacantes &&
          !isNaN(this.llamado.vacantes) &&
          this.llamado.vacantes > 0 &&
          this.llamado.vacantes < 100 &&
          this.llamado.vacantes % 1 === 0
        ) {
          this.errorVacantes = "";
        } else {
          this.errorVacantes =
            "Ingrese el número de personas que se pueden postular entre 1 y 100";
          error = true;
        }

        if (
          this.llamado.id_catedra &&
          !isNaN(this.llamado.id_catedra) &&
          this.llamado.id_catedra > 0 &&
          this.llamado.id_catedra % 1 === 0
        ) {
          this.errorIdCatedra = "";
        } else {
          this.errorIdCatedra = "Seleccione una catedra";
          error = true;
        }

        if (!error) {
          try {
            await axios.post(
              "/llamados/agregarLlamado",
              {
                llamado: this.llamado
              },
              {
                headers: {
                  Authorization: "Bearer " + this.$store.getters.user.api_token
                }
              }
            );

            this.$router.push("/administrarVacantes");
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
    this.buscarCatedras();
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