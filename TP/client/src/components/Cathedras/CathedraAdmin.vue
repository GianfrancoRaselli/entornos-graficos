<template>
  <div>
    <div>
      <router-link to="/agregarCatedra" style="text-decoration: none;">
        <button
          class="btn btn-success btn-block w-25 m-auto"
          icon="fas fa-plus-circle"
        >
          <i class="fas fa-plus-circle"></i>&nbsp;Agregar cátedra
        </button>
      </router-link>
    </div>
    <div>
      <div v-if="cargando">
        <img
          src="../../assets/loading.gif"
          alt="Imagen de carga de página"
          class="loading mt-5"
        />
      </div>
      <div v-else>
        <div class="cathedras-list">
          <p v-if="!catedras.length">
            <i class="fas fa-angle-right"></i> No hay ninguna cátedra registrada
          </p>
          <div class="cathedras" v-if="catedras.length">
            <div
              class="cathedra"
              v-for="(catedra, index) in catedras"
              :key="index"
            >
              <div class="descripcion">
                <p>
                  {{ catedra.descripcion }}
                </p>
              </div>
              <div class="cathedra-content">
                <div class="definicion">
                  <p>
                    {{ catedra.definicion }}
                  </p>
                </div>
                <div class="cathedra-options">
                  <utn-button
                    :to="'/agregarCatedra/' + catedra.id"
                    btnClass="btn btn-secondary"
                  >
                    <i class="fas fa-edit"></i> Editar cátedra
                  </utn-button>
                  <utn-button
                    @click="modalEliminarCatedra(catedra)"
                    btnClass="btn btn-danger"
                  >
                    <i class="fas fa-trash-alt"></i> Eliminar cátedra
                  </utn-button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      cargando: true,
      catedras: []
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      isAdministrador: "isAdministrador",
      isJefeCatedra: "isJefeCatedra"
    })
  },
  methods: {
    async buscarCatedras() {
      this.cargando = true;

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

      this.cargando = false;
    },

    modalEliminarCatedra(catedra) {
      Swal.fire({
        title: "Eliminar cátedra",
        text: "¿Seguro desea eliminar la cátedra: " + catedra.descripcion + "?",
        showDenyButton: true,
        denyButtonText: "Eliminar",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        showConfirmButton: false
      }).then(result => {
        if (result.isDenied) {
          this.eliminarCatedra(catedra.id);
        }
      });
    },

    async eliminarCatedra(id_catedra) {
      if (this.isAdministrador) {
        try {
          await axios.delete("/catedras/eliminarCatedra/" + id_catedra, {
            headers: {
              Authorization: "Bearer " + this.$store.getters.user.api_token
            }
          });
        } catch (err) {
          console.log(err.response.data.error);
        }

        this.buscarCatedras();
      } else {
        this.$store.dispatch("logOut");
      }
    }
  },
  async created() {
    this.buscarCatedras();
  }
};
</script>

<style>
.cathedras-list {
  width: 90%;
  margin: 25px auto;
}

.cathedras {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
}

.cathedra {
  width: 50%;
  padding: 1rem;
  font-size: 1.08rem;
  display: flex;
  flex-direction: column;
}

.cathedra-content {
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

.cathedra-options {
  display: flex;
  justify-content: center;
}

.pocas-vacantes {
  color: rgb(221, 44, 0);
}

.loading {
  display: block;
  margin: auto;
}

@media (max-width: 991px) {
  .cathedra {
    width: 100%;
  }
}
</style>