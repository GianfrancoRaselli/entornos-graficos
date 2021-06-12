<template>
  <div>
    <div class="row d-flex justify-content-center animate__animated animate__pulse animate__fast">
      <div class="col-lg-12 w-100 profile-container">
        <div class="col-lg-3 data-box">
          <div class="profile-img">
            {{ user.nombre_apellido[0] }}
          </div>
          <div class="personal-info mt-3">
            <p>DNI: {{ user.dni }}</p>
            <p>Nombre y apellido: {{ user.nombre_apellido }}</p>
            <p>Email: {{ user.email }}</p>
          </div>
          <utn-button icon="fas fa-edit" to="perfil/editar" btnClass="btn btn-light" id="btn-editar-usuario">
            Editar
          </utn-button>
        </div>
        <div class="d-flex">
          <button class="btn btn-outline-primary" @click="abrirModalCargarCV">
            <i class="fas fa-edit"></i>Cargar nuevo CV
          </button>
          <Popup dataTarget="cargarCV" title="Cargar CV" :showButtons="false">
            <form @submit.prevent="handleSubmitCV">
              <div class="form-group">
                <input type="file" placeholder="CV" class="form-control"/>
              </div>
              <br>
              <div class="form-group">
                <button class="btn btn-success btn-block">
                  Guardar
                </button>
              </div>
            </form>
          </Popup>
          <utn-button icon="fas fa-eye" to="perfil/editar" id="btn-editar-usuario">
            VER CV
          </utn-button>
        </div>
        <div class="applications">
          <h4>Mis postulaciones</h4>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
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
  import Swal from 'sweetalert2'
  export default {
    name: 'Perfil',
    data() {
      return {
        user: {
          dni: '',
          nombre_usuario: '',
          nombre_apellido: '',
          email: '',
          telefono: '',
          roles: [],
        }
      }
    },
    methods: {
      async buscarUsuario() {
        if (this.$store.getters.authenticated) {
          try {
            let res = await axios.get('/personas/perfil',
            {
              headers: {
                Authorization: 'Bearer ' + this.$store.getters.user.api_token
              }
            });
            
            this.user.dni = res.data[0].dni;
            this.user.nombre_usuario = res.data[0].nombre_usuario;
            this.user.nombre_apellido = res.data[0].nombre_apellido;
            this.user.email = res.data[0].email;
            this.user.telefono = res.data[0].telefono;
            this.user.roles = res.data[0].roles;
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

      }
    },
    created() {
      if (this.$route.query.key) {
        if (this.$route.query.key === 'signup') {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Persona registrada correctamente',
            showConfirmButton: false,
            timer: 3000
          });
        } else if (this.$route.query.key === 'signin') {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: '¡Bienvenido!',
              showConfirmButton: false,
              timer: 2000
            });
        }
      }
      this.buscarUsuario();
    }
  }
</script>

<style>
  .profile-container{
    margin-bottom: auto;
    display:flex;
    align-items:center;
    flex-direction:column;
    justify-content: center;
  }
  .data-box{
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
  .profile-img{
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
  .personal-info{
    color: white;
    padding-left: 1rem;
  }

  .applications{
    width: 90%;
    margin-top: 1rem;
  }
</style>