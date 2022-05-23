import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    dados_pesquisa: [],
    versaoSistema: ' - Beta (Build 202205221713)',
    barColor: '',
    barImage: '',
    drawer: null,
    titulo: '',
  },

  mutations: {
    SET_BAR_IMAGE (state, payload) {
      state.barImage = payload
    },

    SET_DRAWER (state, payload) {
      state.drawer = payload
    },

    change(state, titulo) {
      state.titulo = titulo
    },

    SET_DADOS_PESQUISA (state, items) { 
      state.dados_pesquisa = items
    }
  },

  getters: {
    titulo: state => state.titulo,
    versaoSistema: state => state.versaoSistema,
    items: state => state.items,
  },

  actions: {
    //setar dados do usuario
    setUsuario( { commit }, response) {
      if (response != null) {
        localStorage.setItem('user', JSON.stringify(response.data.user));
        localStorage.setItem('token', response.data.token);
      } else
        localStorage.clear()
    },

    //pesquisar dados
    loadDados ( { commit }, url) {
      return new Promise((resolve, reject) => {
        axios.get(url, { headers: { 'accept': 'application/json' } }).then(response => {
          commit('SET_DADOS_PESQUISA', response)
          resolve(response);
          return response;
        }).catch((error) => {
          reject(error)
        });                   
      })
    },

    //salvar dados
    salvarDados ( { commit }, params) {
      return new Promise((resolve, reject) => {
        axios.post(params[0], params[1], { headers: { 'Content-Type': 'application/json' } })
        .then(response => {
          resolve(response);
          return response;
        }).catch((error) => {
          reject(error)
        });                   
      })
    },

    //excluir dados
    excluirDados ( { commit }, params) {
      return new Promise((resolve, reject) => {
        axios.delete(params[0], params[1], { headers: { 'Content-Type': 'application/json' } })
        .then(response => {
          resolve(response);
          return response;
        }).catch((error) => {
          reject(error)
        });                   
      })
    },

    //atualizar dados
    atualizarDados ( { commit }, params) {
      return new Promise((resolve, reject) => {
        axios.put(params[0], params[1], { headers: { 'Content-Type': 'application/json' } })
        .then(response => {
          resolve(response);
          return response;
        }).catch((error) => {
          reject(error)
        });                   
      })
    },
  }
})
