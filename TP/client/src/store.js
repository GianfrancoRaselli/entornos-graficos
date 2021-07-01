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
      await axios.post('/personas/signUp', personalInformation);
      await dispatch('attempt', null);
    },

    async signIn ({ dispatch }, credentials) {
      const res = await axios.post('/personas/signIn', credentials);
      await dispatch('attempt', res.data);
    },

    async logOut ({ dispatch }) {
      await dispatch('attempt', null);
      EventBus.$emit('actualizarVacantes');
      router.push('/');
    },

    async updateProfile ({ dispatch, getters }, personalInformation) {
      const res = await axios.post('/personas/editarPerfil',
      {
        nombre_usuario: personalInformation.nombre_usuario,
        claveNueva: personalInformation.claveNueva,
        clave: personalInformation.clave,
        email: personalInformation.email,
        telefono: personalInformation.telefono
      },
      {
        headers: {
          Authorization: 'Bearer ' + getters.user.api_token
        }
      });
      await dispatch('attempt', res.data);
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
      if (state.user && state.user.roles) {
        for (let rol of state.user.roles) {
          if (rol.descripcion === 'Administrador') return true;
        }
      }
      return false;
    },

    isJefeCatedra (state) {
      if (state.user && state.user.roles) {
        for (let rol of state.user.roles) {
          if (rol.descripcion === 'Jefe Catedra') return true;
        }
      }
      return false;
    },

    isUsuario (state) {
      if (state.user && state.user.roles) {
        for (let rol of state.user.roles) {
          if (rol.descripcion === 'Usuario') return true;
        }
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