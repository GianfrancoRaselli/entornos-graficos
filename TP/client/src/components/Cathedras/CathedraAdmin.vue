<template>
  <div>
    <div>
      <router-link to="/agregarCatedra" style="text-decoration: none;">
        <button class="btn btn-success btn-block m-auto btn-add-cathedra" icon="fas fa-plus-circle">
          <i class="fas fa-plus-circle"></i>&nbsp;Agregar cátedra
        </button>
      </router-link>
    </div>
    <div>
      <div v-if="cargando">
        <img src="../../assets/loading.gif" alt="Imagen de carga de página" class="loading mt-5" />
      </div>
      <div v-else>
        <div class="buscar mt-5">
          <input
            class="form-control input mr-1"
            type="search"
            placeholder="Nombre Cátedra"
            aria-label="Buscar por nombre de cátedra"
            v-on:input="cambioNombreCatedra"
            v-model="nombreCatedra"
          />
          <button
            class="btn btn-outline-success btn-block btn-buscar"
            @click="buscarPorNombreCatedra"
          >Buscar</button>
        </div>
        <div class="cathedras-list">
          <div class="alert alert-info no-cathedras" role="alert" v-if="!catedras.length">
            <i class="fas fa-info-circle mt-5" style="font-size: 5rem"></i>
            <p class="mt-5 mb-5">No hay ninguna cátedra registrada</p>
          </div>
          <div
            class="alert alert-info no-cathedras"
            role="alert"
            v-else-if="!catedrasAMostrar.length"
          >
            <i class="fas fa-info-circle mt-5" style="font-size: 5rem"></i>
            <p class="mt-5 mb-5">No hay cátedras con ese nombre</p>
          </div>
          <div class="cathedras" v-else>
            <div class="cathedra col-lg-6" v-for="(catedra, index) in limitCatedras" :key="index">
              <div class="descripcion">
                <p>{{ catedra.descripcion }}</p>
              </div>
              <div class="cathedra-content">
                <div class="definicion">
                  <p>{{ catedra.definicion }}</p>
                </div>
                <div class="cathedra-options">
                  <utn-button :to="'/agregarCatedra/' + catedra.id" btnClass="btn btn-secondary">
                    <i class="fas fa-edit"></i> Editar cátedra
                  </utn-button>
                  <utn-button @click="modalEliminarCatedra(catedra)" btnClass="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Eliminar cátedra
                  </utn-button>
                </div>
              </div>
            </div>
            <div class="w-100 mt-2">
              <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                  <li class="page-item" :class="{ disabled: pag === 1 }">
                    <a
                      class="page-link"
                      href="#"
                      tabindex="-1"
                      @click.prevent="disminuirPag"
                    >Anterior</a>
                  </li>
                  <li
                    class="page-item"
                    v-for="n in numeros"
                    :key="n"
                    :class="{ active: pag === n }"
                  >
                    <a class="page-link" href="#" @click.prevent="pag = n">
                      {{
                      n
                      }}
                    </a>
                  </li>
                  <li
                    class="page-item"
                    :class="{
                    disabled: pag === Math.ceil(catedrasAMostrar.length / limit)
                  }"
                  >
                    <a class="page-link" href="#" @click.prevent="aumentarPag">Siguiente</a>
                  </li>
                </ul>
              </nav>
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
      catedras: [],
      catedrasAMostrar: [],
      nombreCatedra: "",
      limit: 10,
      pag: 1
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      isAdministrador: "isAdministrador",
      isJefeCatedra: "isJefeCatedra"
    }),

    limitCatedras() {
      return this.catedrasAMostrar.slice(
        this.pag * this.limit - this.limit,
        this.pag * this.limit
      );
    },

    numeros() {
      return Math.ceil(this.catedrasAMostrar.length / this.limit);
    }
  },
  methods: {
    disminuirPag() {
      if (this.pag > 1) this.pag--;
    },

    aumentarPag() {
      if (this.pag < Math.ceil(this.catedrasAMostrar.length / this.limit))
        this.pag++;
    },

    buscarPorNombreCatedra() {
      this.pag = 1;

      if (this.nombreCatedra === "") {
        this.catedrasAMostrar = this.catedras;
      } else {
        this.catedrasAMostrar = this.catedras.filter(catedra => {
          return (
            catedra.descripcion.toUpperCase().replace(/ /g, "") ===
            this.nombreCatedra.toUpperCase().replace(/ /g, "")
          );
        });
      }
    },

    cambioNombreCatedra() {
      if (this.nombreCatedra === "") {
        this.buscarPorNombreCatedra();
      }
    },

    async buscarCatedras() {
      this.cargando = true;

      try {
        let res = await axios.get("/catedras/buscarCatedras", {
          headers: {
            Authorization: "Bearer " + this.$store.getters.user.api_token
          }
        });

        this.catedras = res.data;

        this.buscarPorNombreCatedra();
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

.btn-add-cathedra {
  width: 25%;
}

.no-cathedras {
  font-size: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.buscar {
  display: flex;
  padding-left: 25%;
  padding-right: 25%;
}

.buscar .input {
  width: 70%;
}

.buscar .btn-buscar {
  width: 30%;
}

@media (max-width: 992px) {
  .btn-add-cathedra {
    width: 80%;
  }

  .buscar {
    padding-left: 10%;
    padding-right: 10%;
  }
}
</style>