import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistence from 'vuex-persist'
import axios from 'axios'
import router from './router'
import EventBus from './event-bus'

Vue.use(Vuex);

const store = new Vuex.Store({

  state: {
    user: null
  },

  mutations: {
    SET_USER (state, user) {
      state.user = user;
    }
  },

  actions: {

    async signUp ({ dispatch }, personalInformation) {
      const res = await axios.post('/personas/signUp', personalInformation);
      await dispatch('attempt', res.data[0]);
    },

    async signIn ({ dispatch }, credentials) {
      const res = await axios.post('/personas/signIn', credentials);
      await dispatch('attempt', res.data[0]);
    },

    async logOut ({ dispatch }) {
      await dispatch('attempt', null);
      EventBus.$emit('actualizarUltimasVacantes');
      router.push('/');
    },

    async updateProfile ({ dispatch, getters }, personalInformation) {
      const res = await axios.post('/personas/editarPerfil',
      {
        dni: personalInformation.dni,
        nombre_usuario: personalInformation.nombre_usuario,
        nombre_apellido: personalInformation.nombre_apellido,
        email: personalInformation.email,
        telefono: personalInformation.telefono
      },
      {
        headers: {
          Authorization: 'Bearer ' + getters.user.api_token
        }
      });
      await dispatch('attempt', res.data[0]);
      router.push('/perfil');
    },

    async attempt ({ commit }, data) {
      commit('SET_USER', data);
    }

  },

  getters: {

    authenticated (state) {
      if (state.user) {
        return true;
      } else {
        return false;
      }
    },

    isAdministrador (state) {
      for (let rol of state.user.roles) {
        if (rol.descripcion === 'Administrador') return true;
      }
      return false;
    },

    isJefeCatedra (state) {
      for (let rol of state.user.roles) {
        if (rol.descripcion === 'Jefe Catedra') return true;
      }
      return false;
    },

    isUsuario (state) {
      for (let rol of state.user.roles) {
        if (rol.descripcion === 'Usuario') return true;
      }
      return false;
    },

    user (state) {
      return state.user;
    }

  },

  plugins: [
    new VuexPersistence({
      storage: window.localStorage
    }).plugin
  ]

})

export default store;