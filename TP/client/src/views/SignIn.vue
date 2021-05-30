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
                        <p style="font-size: 1.75rem;"><strong>Inicio Sesión</strong></p>
                    </div>
                    <div class="card-body">
                        <img src="../assets/img-signin.png" alt="Logo Inicio Sesion" class="card-img-top mx-auto m-2 rounded-circle w-25">
                        <form @submit.prevent="handleSubmit">
                            <div class="form-group">
                                <input type="text" v-model="nombre_usuario" placeholder="Nombre Usuario" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="password" v-model="clave" placeholder="Clave" class="form-control">
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
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { EventBus } from '../event-bus'
    export default {
        name: 'SignIn',
        data() {
            return {
                error: false,
                errorMessage: '',
                nombre_usuario: 'testing',
                clave: 'test123'
            }
        },
        methods: {
            async handleSubmit() {
                try {
                    const res = await axios.post('http://localhost/entornos-graficos-2021/TP/server/public/personas/signIn',
                    {
                        nombre_usuario: this.nombre_usuario,
                        clave: this.clave
                    });

                    this.error = false;
                    this.errorMessage = '';
                    
                    localStorage.setItem('api_token', res.data.api_token);
                    localStorage.setItem('nombre_usuario', res.data.nombre_usuario || '');

                    EventBus.$emit('inicioSesion');
                    
                    this.$router.push({ path: '/perfil', query: { key: 'signin' } });
                } catch (err) {
                    this.errorMessage = err.response.data.error;
                    this.error = true;
                }
            }
        }
    }
</script>