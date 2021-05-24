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
        <div class="row m-2">
            <div class="col-md-4 mx-auto">
                <div class="card text-center animate__animated animate__flipInY animate__fast">
                    <div class="card-header">
                        <p style="font-size: 1.75rem;"><strong>Crear Nueva Cuenta</strong></p>
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
                                <input type="password" v-model="clave" placeholder="Clave" class="form-control">
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
                errorMessage: '',
                dni: '',
                nombre_usuario: '',
                clave: '',
                nombre_apellido: '',
                email: '',
                telefono: ''
            }
        },
        methods: {
            async handleSubmit() {
                try {
                    const res = await axios.post('personas/signUp',
                    {
                        dni: this.dni,
                        nombre_usuario: this.nombre_usuario,
                        clave: this.clave,
                        nombre_apellido: this.nombre_apellido,
                        email: this.email,
                        telefono: this.telefono
                    });

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