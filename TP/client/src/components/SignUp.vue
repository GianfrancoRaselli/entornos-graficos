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
              <label><strong>DNI</strong></label>
              <input type="text" v-model="user.dni" placeholder="DNI" class="form-control" autofocus>
            </div>
            <br>
            <div class="form-group">
              <label><strong>Nombre Usuario</strong></label>
              <input type="text" v-model="user.nombre_usuario" placeholder="Nombre Usuario" class="form-control">
            </div>
            <br>
            <div class="form-group">
              <label><strong>Clave</strong></label>
              <input type="password" v-model="user.clave" placeholder="Clave" class="form-control">
            </div>
            <br>
            <div class="form-group">
              <label><strong>Nombre y Apellido</strong></label>
              <input type="text" v-model="user.nombre_apellido" placeholder="Nombre y Apellido" class="form-control" autofocus>
            </div>
            <br>
            <div class="form-group">
              <label><strong>Email</strong></label>
              <input type="email" v-model="user.email" placeholder="Email" class="form-control">
            </div>
            <br>
            <div class="form-group">
              <label><strong>Teléfono</strong></label>
              <input type="text" v-model="user.telefono" placeholder="Teléfono" class="form-control">
            </div>
            <br>
            <div class="form-group">
              <label><strong>Curriculum Vitae</strong></label>
              <input type="file" @change="obtenerArchivo" placeholder="CV" class="form-control" accept="pdf" required/>
              <small class="form-text text-muted" v-if="!errorFormato"><p>Ingrese su CV en formado PDF</p></small>
              <medium class="form-text text-muted" v-if="errorFormato"><p class="error">Ingrese su CV en formado PDF</p></medium>
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
        errorFormato: false,
        user: {
          dni: '1234567892',
          nombre_usuario: 'testing',
          clave: 'test1232',
          nombre_apellido: 'Testing Tester2',
          email: 'testing@test2.com',
          telefono: '123456789',
          curriculum_vitae: null,
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

          if (!this.errorFormato) {
            let formData = new FormData();
            for (let clave in this.user){
              formData.append(clave, this.user[clave]);
            }

            await this.signUp(formData);

            this.$router.push({ path: '/perfil', query: { key: 'signup' } });
            
            window.$("#signUpPopup").modal('hide');
            window.$('body').removeClass('modal-open');
            window.$('.modal-backdrop').remove();
          }
        } catch (err) {
          this.errorMessage = err.response.data.error;
          this.error = true;
        }
      },

      obtenerArchivo(e) {
        if (e.target.files[0].name.split('.').pop() === 'pdf') {
          this.errorFormato = false;
          this.user.curriculum_vitae = e.target.files[0];
        } else {
          this.errorFormato = true;
        }
      },
    }
  }
</script>

<style>
  .error {
    color: red;
  }
</style>