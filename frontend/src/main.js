// =========================================================
// * Vuetify Material Dashboard - v2.1.0
// =========================================================
//
// * Product Page: https://www.creative-tim.com/product/vuetify-material-dashboard
// * Copyright 2019 Creative Tim (https://www.creative-tim.com)
//
// * Coded by Creative Tim
//
// =========================================================
//
// * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import './plugins/base'
import './plugins/chartist'
import './plugins/vee-validate'
import vuetify from './plugins/vuetify'
import PARAMETROS_GERAIS from './parametros_gerais'
import i18n from './i18n'
import { VueMaskDirective } from 'v-mask'
import VueCookies from 'vue-cookies'

Vue.directive('mask', VueMaskDirective);
Vue.use(VueCookies)

Vue.config.productionTip = false
new Vue({router, store, vuetify, i18n, render: h => h(App) }).$mount('#app')

//setando o endereco da API    
Vue.prototype.$enderecoAPI = PARAMETROS_GERAIS.ENDERECOAPI


//----------------- controle de acesso das API's ----------------------------
//request interceptor
axios.interceptors.request.use(function (config) {
  const token = localStorage.getItem('token');
  
  if ((token) && (token !== 'null')) 
    config.headers.Authorization = 'Bearer ' + token;
  
  return config;
}, function (error) {
  return Promise.reject(error);
});


//response interceptor
axios.interceptors.response.use(function (response) {
  return response;

}, function (error) { 
  const originalRequest = error.config;
  const novoToken = error.response.data.token;  
  console.log(error.response)

  if (error.response.status === 403 && !originalRequest._retry) {    
    originalRequest._retry = true;
    localStorage.setItem('token', novoToken);
    return axios(originalRequest);
  } 
  return Promise.reject(error);
});

//funções globais via mixin
Vue.mixin({
  methods: {
    //iniciais maiusculas dos textos
    capitalizeFirstLetter:function(str) { 
      return str.charAt(0).toUpperCase() + str.slice(1)
    },

    //funcao para parse do JWT
    parseJwt:function(token){
      try {
        return JSON.parse(atob(token.split('.')[1]));
      } catch (e) {
        return null;
      }
    },

    //correcao de bug em branco nos textos com o css OUTLINED DENSE
    espacosEmBranco:function(quantidade){
      var espacos = ""
      for(var i=0; i<quantidade; i++)
        espacos += '\xa0';
      return espacos;
    },

    //validacao de email
    validarEmail:function(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
  }
})

