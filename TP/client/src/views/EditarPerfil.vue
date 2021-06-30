<template>
  <div>
    <nav aria-label="breadcrumb" class="m-auto" style="width: fit-content">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/perfil"><i class="fas fa-id-card"></i> 
            Perfil
          </router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          Editar Perfil
        </li>
      </ol>
    </nav>
    <div style="width: 100%; margin-bottom: 1%;" v-if="error">
      <div class="alert alert-danger alert-dismissible fade show"
      style="width: fit-content; margin-top: 2%; margin-left: auto; margin-right: auto;" role="alert">
        {{errorMessage}}
        <button v-on:click="error = false" class="close btn btn-link" data-dismiss="alert"
        style="color: black; text-decoration: none; font-size: 22px;" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
    <div class="row m-2">
      <div class="col-md-4 mx-auto">
        <div class="card text-center animate__animated animate__flipInY animate__fast">
          <div class="card-header">
            <p style="font-size: 1.75rem;">
              <strong>Editar Perfil</strong>
            </p>
          </div>
          <div class="card-body">
            <form @submit.prevent="handleSubmit">
              <div class="form-group">
                <label>Nombre Usuario</label>
                <input type="text" v-model="user.nombre_usuario" placeholder="Nombre Usuario" class="form-control">
              </div>
              <br>
              <div class="form-group">
                <label>Email</label>
                <input type="email" v-model="user.email" placeholder="Email" class="form-control">
              </div>
              <br>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="text" v-model="user.telefono" placeholder="Teléfono" class="form-control">
              </div>
              <br>
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
  import axios from 'axios'
  import { mapActions } from 'vuex'
  export default {
    name: 'Editar perfil',
    data() {
      return {
        error: false,
        errorMessage: '',
        user: {
          nombre_usuario: '',
          clave: '',
          email: '',
          telefono: ''
        }
      }
    },
    methods: {
      ...mapActions({
        updateProfile: 'updateProfile'
      }),

      async buscarUsuario() {
        if (this.$store.getters.authenticated) {
          try {
            let res = await axios.get('/personas/perfil',
            {
              headers: {
                Authorization: 'Bearer ' + this.$store.getters.user.api_token
              }
            });
            this.user.nombre_apellido = res.data[0].nombre_apellido;
            this.user.email = res.data[0].email;
            this.user.telefono = res.data[0].telefono;
            } catch (err) {
              console.log(err.response.data.error);
            }
          } else {
            this.$store.dispatch('logOut');
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
          this.$store.dispatch('logOut');
        }
      }
    },
    created() {
      this.buscarUsuario();
    }
  }
</script>