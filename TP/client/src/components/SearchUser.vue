<template>
  <div>
    <Popup
      dataTarget="searchUserPopup"
      title="Recuperar Clave"
      :showButtons="false"
    >
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
      <div class="text-center animate__animated animate__flipInY animate__fast">
        <div class="card-body">
          <img
            src="../assets/img-mail.png"
            alt="Logo Inicio Sesion"
            width="200px"
            class="card-img-top mx-auto mt-2 mb-4 rounded-circle w-50"
          />
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label><b>Nombre Usuario</b></label>
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
              <medium class="form-text text-muted" v-if="errorNombreUsuario"
                ><p class="error">{{ errorNombreUsuario }}</p></medium
              >
            </div>
            <br />
            <div class="form-group">
              <button class="btn btn-success btn-block">
                Buscar Usuario
              </button>
            </div>
          </form>
        </div>
      </div>
    </Popup>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  data() {
    return {
      errorMessage: "",
      errorNombreUsuario: "",
      user: {
        nombre_usuario: ""
      }
    };
  },
  methods: {
    async handleSubmit() {
      try {
        this.errorMessage = "";
        let error = false;

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

        if (!error) {
          this.buscandoPersona(true);

          let res = await axios.post("/personas/buscarPersonaPorUsuario", {
            nombre_usuario: this.user.nombre_usuario
          });

          this.buscandoPersona(false);

          window.$("#searchUserPopup").modal("hide");
          window.$("body").removeClass("modal-open");
          window.$(".modal-backdrop").remove();
          
          Swal.fire(
            "Correo electrónico enviado",
            "Se le ha enviado un correo electrónico a " + res.data + " con las instrucciones para cambiar la clave",
            "success"
          );
        } else {
          this.errorMessage = "Solucione los campos con error";
        }
      } catch (err) {
        this.buscandoPersona(false);
        
        this.errorMessage = err.response.data.error;
      }
    },
    
    buscandoPersona(buscandoPersona) {
      if (buscandoPersona) {
        let timerInterval;
        Swal.fire({
          title: "Buscando persona",
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
  }
}
</script>

<style>
.error {
  color: red;
}

.errorClass {
  background-color: rgb(228, 167, 167);
}
</style>