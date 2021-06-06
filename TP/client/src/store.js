import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistence from 'vuex-persist'
import axios from 'axios'
import router from './router'

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
      dispatch('attempt', res.data);
      return this.$router.push({ path: '/perfil', query: { key: 'signup' } });
    },

    async signIn ({ dispatch }, credentials) {
      const res = await axios.post('/personas/signIn', credentials);
      dispatch('attempt', res.data);
      return router.push({ path: '/perfil', query: { key: 'signin' } });
    },

    logOut ({ dispatch }) {
      dispatch('attempt', null);
      return router.push('/');
    },

    async updateProfile ({ dispatch }, personalInformation) {
      const res = await axios.post('/personas/editarPerfil', 
      {
        personalInformation
      },
      {
        headers: {
          Authorization: 'Bearer ' + this.user.api_token
        }
      });
      dispatch('attempt', res.data);
      return router.push('/perfil');
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