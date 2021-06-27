<template>
  <div>
    <Popup :dataTarget="dataTarget" title="Iniciar Sesión" :showButtons="false">
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
            <div class="form-group" v-if="!postularse">
              <utn-button
                btnClass="btn btn-link"
                @click="abrirSignUp"
              >
                ¿No tienes cuenta? Regístrate!
              </utn-button>
            </div>
          </form>
        </div>
      </div>
    </Popup>
  </div>
</template>

<script>
  import axios from 'axios'
  import { mapActions } from 'vuex'
  import EventBus from '../event-bus'
  export default {
    props: {
      postularse: { type: Boolean, default: false },
      id_llamado: { type: Number },
      redirect: { type: String },
      dataTarget: { type: String, default: 'loginPopup' }
    },
    data() {
      return {
        error: false,
        errorMessage: '',
        user: {
          nombre_usuario: 'testing',
          clave: 'test1232',
        },
      }
    },
    methods: {
      ...mapActions({
        signIn: 'signIn'
      }),

      async handleSubmit() {
        try {
          this.error = false;

          await this.signIn(this.user);

          if (!this.$store.getters.isUsuario || !this.postularse) {
            this.$router.push({ path: '/perfil', query: { key: 'signin' } });

            window.$("#loginPopup").modal('hide');
            window.$('body').removeClass('modal-open');
            window.$('.modal-backdrop').remove();
          } else if (this.postularse && this.$store.getters.isUsuario) {
            await axios.post('/postulaciones/agregarPostulacionDelUsuario',
            {
              id_llamado: this.id_llamado,
            },
            {
              headers: {
                Authorization: 'Bearer ' + this.$store.getters.user.api_token
              }
            });

            EventBus.$emit('actualizarVacantes');

            if (this.$route.path !== this.redirect) this.$router.push(this.redirect);
            
            window.$("#loginPostulacionPopup").modal('hide');
            window.$('body').removeClass('modal-open');
            window.$('.modal-backdrop').remove();
          }
        } catch (err) {
          if (!this.postularse) {
            this.errorMessage = err.response.data.error;
            this.error = true;
          } else if (this.postularse && this.$store.getters.isUsuario) {
            if (err.response.data.error === 'El usuario ya se encuentra postulado al llamado') {
              EventBus.$emit('actualizarVacantes');

              if (this.$route.path !== this.redirect) this.$router.push(this.redirect);

              window.$("#loginPostulacionPopup").modal('hide');
              window.$('body').removeClass('modal-open');
              window.$('.modal-backdrop').remove();
            }
          }
        }
      },

      abrirSignUp() {
        window.$("#loginPopup").modal('hide');
        window.$("#signUpPopup").modal('show');
      }
    }
  }
</script>