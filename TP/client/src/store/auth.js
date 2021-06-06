import axios from 'axios';

export default{
  namespaced: true,
  state: {
    user: {},
    token: null,
  },
  mutations: {
    SET_TOKEN (state, token) {
      state.token = token;
      localStorage.setItem('api_token', token);
    },

    SET_USER (state, user) {
      state.user = user;
      localStorage.setItem('nombre_usuario', user.nombre_usuario || '');
    }
  },
  actions: {
    async signIn ({ dispatch }, credentials) {
      try {
        const res = await axios.post('/personas/signIn', credentials);
        // console.log('LOGGED');
        return dispatch('attempt', res.data);
      } catch (err) {
        this.errorMessage = err.response.data.error;
        this.error = true;
        console.log('DATA ENTRY ERROR');
      }
    },
    async attempt ({ commit }, data) {
      commit('SET_TOKEN', data.api_token);
      commit('SET_USER', data);

      //TODO DELETE TOKEN
      // commit('SET_TOKEN',null)
      // commit('SET_USER',null)
    }
  },
  getters: {
    authenticated (state) {
      return state.token && state.user
    },
    user (state) {
      return state.user
    }
  },
}