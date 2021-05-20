<template>
    <div class="row m-2">
        <div class="col-md-4 mx-auto">
            <div class="card text-center animate__animated animate__flipInY animate__fast">
                <div class="card-header">
                    <h3><strong>Inicio Sesión</strong></h3>
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
</template>

<script>
    import axios from 'axios'
    import { EventBus } from '../event-bus'
    export default {
        name: 'SignIn',
        data() {
            return {
                nombre_usuario: '',
                clave: ''
            }
        },
        methods: {
            async handleSubmit() {
                try {
                    const res = await axios.post('personas/signin', 
                    {
                        nombre_usuario: this.nombre_usuario,
                        clave: this.clave
                    });
                    
                    localStorage.setItem('api_token', res.data.api_token);
                    localStorage.setItem('nombre_usuario', res.data.nombre_usuario || '');

                    EventBus.$emit('inicioSesion');
                    
                    this.$router.push('/perfil');
                } catch (err) {
                    console.log(err.response.data.error)
                }
            }
        }
    }
</script>