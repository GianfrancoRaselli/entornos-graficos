<template>
  <footer>
    <div class="footer-container">
      <div class="col">
        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
      </div>
      <div class="col">
        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
      </div>
      <div class="col">
        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
      </div>
    </div>
  </footer>
</template>

<script>
  export default {
    name: 'Nav',
    data() {
      return {
        navItems: [
          { name: 'Inicio', routeTo: 'Home', icon: 'fas fa-home'},
          { name: 'Vacantes', routeTo: 'Home', icon: 'fas fa-hand-pointer'},
        ],
        userNavItems: [
          { name: 'Crear cuenta', routeTo: 'SignUp', icon: 'fas fa-user', btnType: 'btn btn-light' },
          { name: 'Iniciar sesión', routeTo: 'SignIn', icon: 'fas fa-id-card', btnType: 'btn btn-primary' },
        ],
        nombreUsuario: localStorage.getItem('nombre_usuario') || '',
        usuarioLogueado: localStorage.getItem('api_token') ? true : false
      }
    },
  }
</script>

<style>
  .footer-container{
    display: flex;
    background-color: RGBA(0, 0, 0, .8);
    color: RGBA(255, 255, 255, .5);
    padding: 3rem 1rem;
    flex-wrap: wrap;
  }
</style>