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
    <div style="width: 100%; margin-bottom: 1%;" v-if="error">
      <div
        class="alert alert-danger alert-dismissible fade show"
        style="width: fit-content; margin-top: 2%; margin-left: auto; margin-right: auto;"
        role="alert"
      >
        {{ errorMessage }}
        <button
          v-on:click="error = false"
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
        <div
          class="card text-center animate__animated animate__flipInY animate__fast"
        >
          <div class="card-header">
            <p style="font-size: 1.75rem;"><strong>Agregar Vacante</strong></p>
          </div>
          <div class="card-body">
            <form @submit.prevent="handleSubmit">
              <div class="form-group">
                <input
                  type="date"
                  v-model="llamado.fecha_inicio"
                  placeholder="Fecha Inicio"
                  :min="fecha_hoy"
                  class="form-control"
                />
              </div>
              <br />
              <div class="form-group" v-if="llamado.fecha_inicio">
                <input
                  type="date"
                  v-model="llamado.fecha_fin"
                  placeholder="Fecha Inicio"
                  :min="llamado.fecha_inicio"
                  class="form-control"
                />
              </div>
              <br />
              <div class="form-group">
                <textarea
                  type="text"
                  v-model="llamado.requisitos"
                  placeholder="Requisitos"
                  class="form-control"
                />
              </div>
              <br />
              <div class="form-group">
                <input
                  type="number"
                  v-model="llamado.vacantes"
                  placeholder="Vacentes"
                  min="1"
                  class="form-control"
                />
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
//import axios from "axios";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      error: false,
      errorMessage: "",
      llamado: {
        fecha_inicio: "",
        fecha_fin: "",
        requisitos: "",
        vacantes: 0,
        id_catedra: ""
      }
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      isAdministrador: "isAdministrador"
    }),

    fecha_hoy() {
      let fecha = new Date("June 2, 2021");
      let anio = fecha.getFullYear();
      let _mes = fecha.getMonth();
      _mes = _mes + 1;
      let mes = "";
      if (_mes < 10) {
        mes = "0" + _mes;
      } else {
        mes = _mes.toString;
      }
      let _dia = fecha.getDate();
      let dia = "";
      if (_dia < 10) {
        dia = "0" + _dia;
      } else {
        dia = _dia.toString;
      }

      return anio + "-" + mes + "-" + dia;
    }
  },
  methods: {
    async handleSubmit() {
      this.error = false;

      /*if (this.authenticated && this.isAdministrador) {
        try {
          await axios.post("/llamados/agregarLlamado",
          {
            llamado: this.llamado
          },
          {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });
        } catch (err) {
          this.errorMessage = err.response.data.error;
          this.error = true;
        }
      } else {
        this.$store.dispatch("logOut");
      }*/
    }
  }
};
</script>

<style>
</style>