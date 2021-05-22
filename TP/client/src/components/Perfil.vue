<template>
    <div id="perfil">
        <div class="row d-flex justify-content-center ml-4 mr-4 mb-3 animate__animated animate__pulse animate__fast">
            <div class="col-lg-10 mt-3 pt-3">
                <div class="row z-depth-3">
                    <div class="col-lg-4 bg-info rounded-left">
                        <div class="card-block text-center text-white">
                            <i class="fas fa-user-tie fa-7x mt-5"></i>
                            <p class="font-weight-bold mt-4" style="font-size: 2rem;">{{nombre_apellido}}</p>
                            <p class="font-weight mt-2" style="font-size: 1.5rem;">{{dni}}</p>
                            <hr>
                            <p :key="rol.id" v-for="rol in roles" v-text="rol.descripcion"></p>
                            <router-link to="perfil/editar" class="btn btn-link mt-2 mb-3" id="btn-editar-usuario"><i class="fas fa-edit fa-3x"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-8 bg-white rounded-right pb-2">
                        <p class="mt-3 text-center" style="font-size: 1.75rem;">Información Personal</p>
                        <hr class="badge-primary mt-0 w-25">
                        <div class="row">
                            <div class="col-md-6 mt-3 text-center">
                                <p class="font-weight-bold">Nombre Usuario</p>
                                <p class="text-muted" style="font-size: 1.05rem;">{{nombre_usuario}}</p>
                            </div>
                            <div class="col-md-6 mt-3 text-center">
                                <p class="font-weight-bold">Email</p>
                                <p class="text-muted" style="font-size: 1.05rem;">{{email}}</p>
                            </div>
                            <div class="col-md-6 mt-3 text-center">
                                <p class="font-weight-bold">Teléfono</p>
                                <p class="text-muted" style="font-size: 1.05rem;">{{telefono}}</p>
                            </div>
                        </div>
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
                        let res = await axios.get('personas/perfil',
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
            this.buscarUsuario();
        }
    }
</script>

<style>
    #btn-editar-usuario {
        color: white;
    }

    #btn-editar-usuario:hover {
        color: blanchedalmond;
    }
</style>