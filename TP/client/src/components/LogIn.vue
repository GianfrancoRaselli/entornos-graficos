<template>
  <div>
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
    <div class="text-center animate__animated animate__flipInY animate__fast">
      <div class="card-body">
        <img src="../assets/img-signin.png" alt="Logo Inicio Sesion" class="card-img-top mx-auto m-2 rounded-circle w-25">
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <input type="text" v-model="user.nombre_usuario" placeholder="Nombre Usuario" class="form-control">
          </div>
          <br>
          <div class="form-group">
            <input type="password" v-model="user.clave" placeholder="Clave" class="form-control">
          </div>
          <br>
          <div class="form-group">
            <button class="btn btn-success btn-block">
              Iniciar Sesión
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  // import axios from 'axios'
  import { mapActions } from 'vuex'
  //import { EventBus } from '../event-bus'
  export default {
    name: 'SignIn',
    data() {
      return {
        error: false,
        errorMessage: '',
        user: {
          nombre_usuario: 'testing2',
          clave: 'test1232',
        },
      }
    },
    methods: {
      ...mapActions({
        signIn: 'auth/signIn'
      }),

      handleSubmit() {
        this.signIn(this.user).then(() => {
          console.log('login');
          this.$router.push({ path: '/perfil', query: { key: 'signin' } });
        }).catch(() => {
          console.log('error en login');
        });
      }
    }
    }
</script>