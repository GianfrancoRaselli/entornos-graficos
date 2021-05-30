<template>
  <div>
    <div class="row d-flex justify-content-center animate__animated animate__pulse animate__fast">
      <div class="col-lg-12 w-100 profile-container">
        <div class="col-lg-3 data-box">
          <div class="profile-img">
            {{ nombre_apellido[0] }}
          </div>
          <div class="personal-info mt-3">
            <p>DNI: {{dni}}</p>
            <p>Nombre y apellido: {{ nombre_apellido }}</p>
            <p>Email: {{email}}</p>
          </div>
          <utn-button icon="fas fa-edit" to="perfil/editar" btnClass="btn btn-light" id="btn-editar-usuario">
            Editar
          </utn-button>
        </div>
        <div class="d-flex">
          <utn-button icon="fas fa-edit" to="perfil/editar" id="btn-editar-usuario" btnClass="btn btn-outline-primary">
            Cargar CV
          </utn-button>
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
    import { EventBus } from '../event-bus'
    import Swal from 'sweetalert2'
    export default {
        name: 'Perfil',
        data() {
            return {
                dni: '',
                nombre_usuario: '',
                nombre_apellido: '',
                email: '',
                telefono: '',
                roles: []
            }
        },
        methods: {
            async buscarUsuario() {
                if (localStorage.getItem('api_token')) {
                    try {
                        let res = await axios.get('http://localhost/entornos-graficos-2021/TP/server/public/personas/perfil',
                        {
                            headers: {
                                Authorization: 'Bearer ' + localStorage.getItem('api_token')
                            }
                        });
                        
                        this.dni = res.data[0].dni;
                        this.nombre_usuario = res.data[0].nombre_usuario;
                        this.nombre_apellido = res.data[0].nombre_apellido;
                        this.email = res.data[0].email;
                        this.telefono = res.data[0].telefono;
                        this.roles = res.data[0].roles;
                    } catch (err) {
                        console.log(err);
                    }
                } else {
                    EventBus.$emit('cerrarSesion');
                }
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