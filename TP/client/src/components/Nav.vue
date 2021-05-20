<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 w-100 mb-4">
        <router-link to="/"><img src="../assets/logo-utn.png" alt="Logo UTN" id="logo-utn"></router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul v-if="usuarioLogueado" class="navbar-nav" style="margin-left: auto;">
                <li class="nav-item">
                    <router-link class="nav-link btn btn-link" to="/"><i class="fas fa-home"></i> Inicio</router-link>
                </li>
                <li class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle btn btn-link" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>&nbsp;{{nombreUsuario}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdown">
                        <router-link class="dropdown-item btn btn-link" to="/perfil"><i class="fas fa-id-card"></i> Perfil</router-link>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item btn btn-link" v-on:click="cerrarSesion" id="btn-cerrar-sesion"><i class="fas fa-sign-out-alt"></i>
                            Cerrar Sesión</button>
                    </div>
                </li>
            </ul>
            <ul v-else class="navbar-nav" style="margin-left: auto;">
                <li class="nav-item">
                    <router-link class="nav-link btn btn-link" to="/"><i class="fas fa-home"></i> Inicio</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link btn btn-link" to="/signup"><i class="fas fa-user-plus"></i> Crear Cuenta</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link btn btn-link" to="/signin"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    import { EventBus } from '../event-bus'
    export default {
        name: 'Nav',
        data() {
            return {
                nombreUsuario: localStorage.getItem('nombre_usuario') || '',
                usuarioLogueado: localStorage.getItem('api_token') ? true : false
            }
        },
        created() {
            EventBus.$on('inicioSesion', function() {
                this.nombreUsuario = localStorage.getItem('nombre_usuario') || '';
                this.usuarioLogueado = localStorage.getItem('api_token') ? true : false;
            }.bind(this)),
            EventBus.$on('cerrarSesion', function() {
                this.cerrarSesion();
            }.bind(this))
        },
        methods: {
            cerrarSesion() {
                localStorage.removeItem('api_token');
                localStorage.removeItem('nombre_usuario');
                this.nombreUsuario = localStorage.getItem('nombre_usuario') || '';
                this.usuarioLogueado = localStorage.getItem('api_token') ? true : false;
                this.$router.push('/');
            }
        }
    }
</script>

<style scoped>
    #logo-utn {
        width: 270px;
        height: 60px;
    }

    .btn{
        width: 100%;
        text-align: left;
    }

    #btn-cerrar-sesion{
        color: red;
    }
</style>