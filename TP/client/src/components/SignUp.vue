<template>
  <div>
    <Popup dataTarget="signUpPopup" title="Registrarse" :showButtons="false">
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
      <div class="text-center animate__animated animate__flipInY animate__fast">
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
    </Popup>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  export default {
    name: 'SignUp',
    data() {
      return {
        error: false,
        errorMessage: '',
        user: {
          dni: '1234567892',
          nombre_usuario: 'testing2',
          clave: 'test1232',
          nombre_apellido: 'Testing Tester2',
          email: 'testing@test2.com',
          telefono: '123456789',
          rol: 'Usuario',
        }
      }
    },
    methods: {
      ...mapActions({
        signUp: 'signUp'
      }),

      async handleSubmit() {
        try {
          this.error = false;

          await this.signUp(this.user);

          this.$router.push({ path: '/perfil', query: { key: 'signup' } });
          
          window.$("#signUpPopup").modal('hide');
          window.$('body').removeClass('modal-open');
          window.$('.modal-backdrop').remove();
        } catch (err) {
          this.errorMessage = err.response.data.error;
          this.error = true;
        }
      }
    }
  }
</script>