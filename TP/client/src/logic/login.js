import { EventBus } from '../event-bus';

module.exports = {

  isLoggedIn() {
    if (localStorage.getItem('api_token')) {
      return true;
    } else {
      return false;
    }
  },

  getToken() {
    return localStorage.getItem('api_token');
  },

  getNombreUsuarioLogueado() {
    return localStorage.getItem('nombre_usuario');
  },

  login(api_token, nombre_usuario) {
    localStorage.setItem(api_token);
    localStorage.setItem(nombre_usuario);
    EventBus.$emit('sesionIniciada');
  },

  logout() {
    localStorage.removeItem('api_token');
    localStorage.removeItem('nombre_usuario');
    EventBus.$emit('sesionCerrada');
    this.$router.push('/');
  },

}
