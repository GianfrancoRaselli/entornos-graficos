<template>
  <div>
    <div class="d-flex justify-content-center animate__animated animate__pulse animate__fast">
      <div class="col-lg-12 w-100 profile-container">
        <div class="col-lg-3 data-box">
          <div class="profile-img">
            {{ user.nombre_apellido[0] }}
          </div>
          <div class="personal-info mt-3">
            <p>DNI: {{ user.dni }}</p>
            <p>Nombre y apellido: {{ user.nombre_apellido }}</p>
            <p>Email: {{ user.email }}</p>
            <p>Teléfono: {{ user.telefono }}</p>
          </div>
          <utn-button icon="fas fa-edit" to="perfil/editar" btnClass="btn btn-light" id="btn-editar-usuario">
            Editar
          </utn-button>
        </div>
        <div class="d-flex">
          <button class="btn btn-outline-primary mr-1" @click="abrirModalCargarCV">
            <i class="fas fa-file-upload"></i> Cargar nuevo CV
          </button>
          <Popup dataTarget="cargarCV" title="Cargar CV" :showButtons="false">
            <form @submit.prevent="handleSubmitCV" enctype="multipart/form-data">
              <div class="form-group">
                <label for="labelInputCV">Curriculum Vitae</label>
                <input type="file" @change="obtenerArchivo" placeholder="CV" class="form-control" accept="pdf" required/>
                <small class="form-text text-muted" v-if="!errorFormato"><p>Ingrese su CV en formado PDF</p></small>
                <medium class="form-text text-muted" v-if="errorFormato"><p class="error">Ingrese su CV en formado PDF</p></medium>
              </div>
              <br>
              <div class="form-group">
                <button class="btn btn-success btn-block">
                  Guardar
                </button>
              </div>
            </form>
          </Popup>
          <a id="btn-ver-cv" class="btn btn-primary ml-1" v-if="user.ruta_cv" :href="user.ruta_cv" target="_blank">
            <i class="fas fa-eye"></i> Ver CV
          </a>
        </div>
        <div class="applications" v-if="isUsuario && tablePostulaciones.length">
          <h4>Mis postulaciones</h4>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Nro</th>
                <th scope="col">Cátedra</th>
                <th scope="col">Definición</th>
                <th scope="col">Fecha fin</th>
                <th scope="col">Acción</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(postulacion,index) in tablePostulaciones" :key="index">
                <th scope="row">{{ ++index }}</th>
                <td>{{ postulacion.descripcion }}</td>
                <td>{{ postulacion.definicion }}</td>
                <td>{{ postulacion.fecha_fin }}</td>
                <td>
                  <utn-button @click="darmeDeBaja(postulacion.id)" btnClass="btn btn-danger">
                    Darme de baja
                  </utn-button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import { mapGetters } from "vuex";
  import Swal from 'sweetalert2'
  export default {
    data() {
      return {
        vacantes: [],
        user: {
          dni: '',
          nombre_apellido: '',
          email: '',
          telefono: '',
          curriculum_vitae: null,
          ruta_cv: '',
          postulaciones: [],
        },
        tablePostulaciones: [],
        errorFormato: false
      }
    },
    computed: {
      ...mapGetters({
        isUsuario: 'isUsuario'
      })
    },
    methods: {
      async buscarPostulacionesDelUsuario() {
        if (this.$store.getters.authenticated && this.$store.getters.isUsuario) {
          try {
            let res = await axios.get('/postulaciones/buscarPostulacionesDelUsuario',
            {
              headers: {
                Authorization: 'Bearer ' + this.$store.getters.user.api_token
              }
            });

            this.user.postulaciones = res.data;
            this.buscarVacantes();
          } catch (err) {
            console.log(err.response.data.error);
          }
        }
      },

      async buscarVacantes() {
        try {
          let res = await axios.get('/llamados/buscarLlamados');
          let vacantes = res.data;

          if (vacantes && vacantes.length > 0) {
            for (let vacante of vacantes) {
              vacante.usuarioPostulado = false;

              if (this.user.postulaciones && this.user.postulaciones.length > 0) {
                for (let postulacion of this.user.postulaciones) {
                  if (vacante.id === postulacion.id_llamado) {
                    vacante.usuarioPostulado = true;
                    break;
                  }
                }
              }
            }
          }
          this.vacantes = vacantes;

          this.tablePostulaciones = []; 
          for(let i=0; i < this.vacantes.length; i++){
            for(let j=0; j < this.user.postulaciones.length; j++){
              if(this.user.postulaciones[j].id_llamado == this.vacantes[i].id){
                this.tablePostulaciones.push(this.vacantes[i]);
              }
            }
          }
        } catch (err) {
          console.log(err);
        }
      },

      async buscarUsuario() {
        if (this.$store.getters.authenticated) {
          try {
            let res = await axios.get('/personas/perfil',
            {
              headers: {
                Authorization: 'Bearer ' + this.$store.getters.user.api_token
              }
            });
            
            this.user.dni = res.data.dni;
            this.user.nombre_apellido = res.data.nombre_apellido;
            this.user.email = res.data.email;
            this.user.telefono = res.data.telefono;
            if (res.data.curriculum_vitae) {
              this.user.ruta_cv = 'https://utn-vacantes.herokuapp.com/public/CVs/' + res.data.curriculum_vitae;
            }
          } catch (err) {
              console.log(err.response.data.error);
          }
        } else {
          this.$store.dispatch('logOut');
        }
      },

      abrirModalCargarCV() {
        window.$("#cargarCV").modal('show');
      },

      async handleSubmitCV() {
        if (this.$store.getters.authenticated) {
          if (this.user.curriculum_vitae && !this.errorFormato) {
            let formData = new FormData();
            formData.append('curriculum_vitae', this.user.curriculum_vitae);

            try {
              let res = await axios.post('/personas/actualizarCV', formData,
              {
                headers: {
                  Authorization: 'Bearer ' + this.$store.getters.user.api_token
                }
              });

              this.user.ruta_cv = 'https://utn-vacantes.herokuapp.com/public/CVs/' + res.data;

              window.$('#cargarCV').modal('hide');
              window.$('body').removeClass('modal-open');
              window.$('.modal-backdrop').remove();

              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'CV actualizado correctamente',
                showConfirmButton: true,
                confirmButtonColor: '#3CC134',
                confirmButtonText: 'Confirmar',
                timer: 3000
              });
            } catch (err) {
              console.log(err.response.data.error);
            }
          } else {
            this.errorFormato = true;
          }
        } else {
          this.$store.dispatch('logOut');
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

      async darmeDeBaja(id_llamado) {
        if (this.$store.getters.authenticated) {
          if (this.$store.getters.isUsuario) {
            try {
              await axios.delete('/postulaciones/eliminarPostulacionDelUsuario/' + id_llamado,
              {
                headers: {
                  Authorization: 'Bearer ' + this.$store.getters.user.api_token
                }
              });
              
              this.buscarPostulacionesDelUsuario();
            } catch (err) {
              console.log(err.response.data.error);
            }
          }
        } else {
          this.logOut();
        }
      },
    },
    created() {
      if (this.$route.query.key) {
        if (this.$route.query.key === 'signin') {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: '¡Bienvenido!',
            showConfirmButton: false,
            timer: 2000
          });
        } else if (this.$route.query.key === 'postulado') {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: '¡Postulado!',
            showConfirmButton: true,
            timer: 3000
          });
        }
      }
      this.buscarUsuario();
      this.buscarPostulacionesDelUsuario();
    }
  }
</script>

<style>
  .profile-container {
    margin-bottom: auto;
    display:flex;
    align-items:center;
    flex-direction:column;
    justify-content: center;
  }

  .data-box {
    padding: 2rem 1rem;
    align-self: center;
    margin: 2rem;
    display:flex;
    align-items: center;
    justify-content: center;
    background-color: RGBA(12, 110, 253, 1);
    border-radius: .5rem;
    flex-wrap:wrap;
  }

  .profile-img {
    height: 5rem;
    width: 5rem;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 100%;
    font-weight: 600;
    color: RGB(12, 110, 253);
    font-size: 2rem;
    text-transform: uppercase;
    background-color:white;
  }

  .personal-info {
    color: white;
    padding-left: 1rem;
  }

  .applications {
    width: 90%;
    margin-top: 1rem;
  }

  .error {
    color: red;
  }
</style>