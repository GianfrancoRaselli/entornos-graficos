<template>
  <div>
    <div style="width: 100%; margin-bottom: 1%;" v-if="error">
      <div class="alert alert-danger alert-dismissible fade show"
        style="width: fit-content; margin-top: 2%; margin-left: auto; margin-right: auto;" role="alert">
        {{errorMessage}}
        <button @click="error = false" class="close btn btn-link" data-dismiss="alert"
          style="color: black; text-decoration: none; font-size: 22px;" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
    <div class="row m-2">
      <div class="col-md-4 mx-auto">
        <div class="card text-center animate__animated animate__flipInY animate__fast">
          <div class="card-header">
            <p style="font-size: 1.75rem;"><strong>Crear Nueva Cuenta</strong></p>
          </div>
          <div class="card-body">
            <form @submit.prevent="handleSubmit">
              <div class="form-group">
                <input type="text" v-model="user.dni" placeholder="DNI" class="form-control" autofocus>
              </div>
              <br>
              <div class="form-group">
                <input type="text" v-model="user.nombre_usuario" placeholder="Nombre Usuario" class="form-control">
              </div>
              <br>
              <div class="form-group">
                <input type="password" v-model="user.clave" placeholder="Clave" class="form-control">
              </div>
              <br>
              <div class="form-group">
                <input type="text" v-model="user.nombre_apellido" placeholder="Nombre y Apellido" class="form-control" autofocus>
              </div>
              <br>
              <div class="form-group">
                <input type="email" v-model="user.email" placeholder="Email" class="form-control">
              </div>
              <br>
              <div class="form-group">
                <input type="text" v-model="user.telefono" placeholder="Teléfono" class="form-control">
              </div>
              <br>
              <div class="form-group">
                <button class="btn btn-success btn-block">
                  Crear Cuenta
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
  import { EventBus } from '../event-bus'
  export default {
    name: 'SignUp',
    data() {
      return {
        error: false,
        user:{
          dni: '123456789',
          nombre_usuario: 'testing',
          clave: 'test123',
          nombre_apellido: 'Testing Tester',
          email: 'testing@test.com',
          telefono: '123456789',
          rol: 'tester',
        },
        errorMessage: '',
      }
    },
    methods: {
      async handleSubmit() {
        try {
          const res = await axios.post('http://localhost/entornos-graficos-2021/TP/server/public/personas/signUp', this.user);
          this.error = false;
          this.errorMessage = '';
          
          localStorage.setItem('api_token', res.data.api_token);
          localStorage.setItem('nombre_usuario', res.data.nombre_usuario || '');

          EventBus.$emit('inicioSesion');
            
          this.$router.push({ path: '/perfil', query: { key: 'signup' } });
        } catch (err) {
          this.errorMessage = err.response.data.error;
          this.error = true;
        }
      }
    }
  }
</script>