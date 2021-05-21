<template>
    <div class="row d-flex justify-content-center ml-4 mr-4 mb-3">
        <div class="col-lg-10 mt-3 pt-3">
            <div class="row z-depth-3">
                <div class="col-lg-4 bg-info rounded-left">
                    <div class="card-block text-center text-white">
                        <i class="fas fa-user-tie fa-7x mt-5"></i>
                        <h2 class="font-weight-bold mt-4">{{nombre_apellido}}</h2>
                        <h4 class="font-weight mt-2">{{dni}}</h4>
                        <hr>
                        <p :key="rol.id" v-for="rol in roles" v-text="rol.descripcion"></p>
                    </div>
                </div>
                <div class="col-lg-8 bg-white rounded-right pb-2">
                    <h3 class="mt-3 text-center">Información Personal</h3>
                    <hr class="badge-primary mt-0 w-25">
                    <div class="row">
                        <div class="col-md-6 mt-3 text-center">
                            <p class="font-weight-bold">Nombre Usuario</p>
                            <h6 class="text-muted">{{nombre_usuario}}</h6>
                        </div>
                        <div class="col-md-6 mt-3 text-center">
                            <p class="font-weight-bold">Clave</p>
                            <h6 class="text-muted">{{clave}}</h6>
                        </div>
                        <div class="col-md-6 mt-3 text-center">
                            <p class="font-weight-bold">Email</p>
                            <h6 class="text-muted">{{email}}</h6>
                        </div>
                        <div class="col-md-6 mt-3 text-center">
                            <p class="font-weight-bold">Teléfono</p>
                            <h6 class="text-muted">{{telefono}}</h6>
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
                clave: '',
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
                        this.clave = res.data[0].clave;
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

</style>