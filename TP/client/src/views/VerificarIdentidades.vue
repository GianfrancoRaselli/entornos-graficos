<template>
  <div class="m-5">
    <div v-if="cargando">
      <img
        src="../assets/loading.gif"
        alt="Imagen de carga de página"
        class="loading mt-5"
      />
    </div>
    <div v-else>
      <div class="personas" v-if="personas.length">
        <table
          class="table table-responsive table-striped table-hover table-bordered"
        >
          <thead>
            <tr>
              <th>DNI</th>
              <th>Nombre y apellido</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(persona, index) in personas" :key="index">
              <td>
                <div class="columna-md">{{ persona.dni }}</div>
              </td>
              <td>
                <div class="columna-md">{{ persona.nombre_apellido }}</div>
              </td>
              <td>
                <div class="columna-md">{{ persona.email }}</div>
              </td>
              <td>
                <div class="columna-md">{{ persona.telefono }}</div>
              </td>
              <td>
                <div class="columna-lg">
                  <a
                    class="btn btn-primary m-1"
                    :href="DNIsPath + persona.imagen_dni"
                    target="_blank"
                  >
                    <i class="fas fa-eye"></i> Ver DNI
                  </a>
                  <a
                    class="btn btn-secondary m-1"
                    :href="CVsPath + persona.curriculum_vitae"
                    target="_blank"
                  >
                    <i class="fas fa-eye"></i> Ver CV
                  </a>
                  <a class="btn btn-success m-1" @click="aceptar(persona.id)">
                    <i class="fas fa-check-circle"></i> Aceptar
                  </a>
                  <a class="btn btn-danger m-1" @click="rechazar(persona.id)">
                    <i class="fas fa-times-circle"></i> Rechazar
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else>
        <p>Ya fueron verificadas todas las personas</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { DNIsPath, CVsPath } from "../paths";
export default {
  data() {
    return {
      cargando: true,
      personas: [],
      DNIsPath,
      CVsPath
    };
  },
  methods: {
    async buscarPersonasNoVerificadas() {
      if (
        this.$store.getters.authenticated &&
        this.$store.getters.isAdministrador
      ) {
        this.cargando = true;

        try {
          let res = await axios.get("/personas/buscarPersonasNoVerificadas", {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });

          this.personas = res.data;
        } catch (err) {
          console.log(err.response.data.error);
        }

        this.cargando = false;
      } else {
        this.$store.dispatch("logOut");
      }
    },

    async aceptar(id_persona) {
      if (
        this.$store.getters.authenticated &&
        this.$store.getters.isAdministrador
      ) {
        try {
          this.verificandoIdentidad(true);

          await axios.post(
            "/personas/aceptarPersona",
            {
              id_persona
            },
            {
              headers: {
                Authorization: "Bearer " + this.$store.getters.user.api_token
              }
            }
          );

          this.verificandoIdentidad(false);

          this.buscarPersonasNoVerificadas();
        } catch (err) {
          this.verificandoIdentidad(false);

          console.log(err.response.data.error);
        }
      } else {
        this.$store.dispatch("logOut");
      }
    },

    async rechazar(id_persona) {
      if (
        this.$store.getters.authenticated &&
        this.$store.getters.isAdministrador
      ) {
        try {
          this.verificandoIdentidad(true);

          await axios.post(
            "/personas/rechazarPersona",
            {
              id_persona
            },
            {
              headers: {
                Authorization: "Bearer " + this.$store.getters.user.api_token
              }
            }
          );

          this.verificandoIdentidad(false);

          this.buscarPersonasNoVerificadas();
        } catch (err) {
          this.verificandoIdentidad(false);

          console.log(err.response.data.error);
        }
      } else {
        this.$store.dispatch("logOut");
      }
    },

    verificandoIdentidad(verificandoIdentidad) {
      if (verificandoIdentidad) {
        let timerInterval;
        Swal.fire({
          title: "Guardando verificación de identidad",
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
    this.buscarPersonasNoVerificadas();
  }
};
</script>

<style>
.columna-lg {
  width: 520px;
}

.columna-md {
  width: 200px;
}

.columna-sm {
  width: 120px;
}

table {
  word-wrap: break-word;
}

.loading {
  display: block;
  margin: auto;
}
</style>