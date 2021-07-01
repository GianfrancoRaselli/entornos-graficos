<template>
  <div>
    <nav aria-label="breadcrumb" class="m-auto" style="width: fit-content">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/perfil"
            ><i class="fas fa-id-card"></i>
            Perfil
          </router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          Editar Perfil
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
                />
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
                  />
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
                />
              </div>
              <br />
              <div class="form-group">
                <label>Teléfono</label>
                <input
                  type="text"
                  v-model="user.telefono"
                  placeholder="Teléfono"
                  class="form-control"
                />
              </div>
              <br />
              <div class="form-group">
                <label>Clave</label>
                <input
                  type="password"
                  v-model="user.clave"
                  placeholder="Clave"
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
import axios from "axios";
import { mapActions } from "vuex";
export default {
  name: "Editar perfil",
  data() {
    return {
      error: false,
      errorMessage: "",
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
    async handleSubmit() {
      this.error = false;

      if (this.$store.getters.authenticated) {
        try {
          await this.updateProfile(this.user);
        } catch (err) {
          this.errorMessage = err.response.data.error;
          this.error = true;
        }
      } else {
        this.$store.dispatch("logOut");
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
</style>