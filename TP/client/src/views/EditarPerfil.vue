<template>
    <div>
        <nav aria-label="breadcrumb" class="m-auto" style="width: fit-content">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/perfil"><i class="fas fa-id-card"></i> Perfil</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Editar Perfil</li>
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
                        <p style="font-size: 1.75rem;"><strong>Editar Perfil</strong></p>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit">
                            <div class="form-group">
                                <input type="text" v-model="dni" placeholder="DNI" class="form-control" autofocus>
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="text" v-model="nombre_usuario" placeholder="Nombre Usuario" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="text" v-model="nombre_apellido" placeholder="Nombre y Apellido" class="form-control" autofocus>
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="email" v-model="email" placeholder="Email" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="text" v-model="telefono" placeholder="Teléfono" class="form-control">
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
    // import { EventBus } from '../event-bus'
    export default {
        name: 'SignUp',
        data() {
            return {
                error: false,
                errorMessage: '',
                dni: '',
                nombre_usuario: '',
                nombre_apellido: '',
                email: '',
                telefono: ''
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
                    } catch (err) {
                        console.log(err);
                    }
                } else {
                    // EventBus.$emit('cerrarSesion');
                    console.log('cerrarsesion');
                }
            },
            async handleSubmit() {
                try {
                    const res = await axios.post('http://localhost/entornos-graficos-2021/TP/server/public/personas/editarPerfil', 
                    {
                        dni: this.dni,
                        nombre_usuario: this.nombre_usuario,
                        nombre_apellido: this.nombre_apellido,
                        email: this.email,
                        telefono: this.telefono
                    },
                    {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('api_token')
                        }
                    });

                    this.error = false;
                    this.errorMessage = '';
                    
                    localStorage.setItem('nombre_usuario', res.data.nombre_usuario || '');

                    //EventBus.$emit('inicioSesion');
                    console.log('inicio sesion');
                    this.$router.push('/perfil');
                } catch (err) {
                    this.errorMessage = err.response.data.error;
                    this.error = true;
                }
            }
        },
        created() {
            this.buscarUsuario();
        }
    }
</script>