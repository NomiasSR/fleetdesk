import Vue from 'vue'
import Router from 'vue-router'
import ERRO_404 from '@/views/dashboard/erro_404'
import PRINCIPAL from '@/views/dashboard/Principal'
import STATUS_LIST from '@/views/dashboard/cadastro/status/list'
import STATUS_ADD from '@/views/dashboard/cadastro/status/add'
import STATUS_EDIT from '@/views/dashboard/cadastro/status/edit'
import TASKS_LIST from '@/views/dashboard/cadastro/tasks/list'
import TASKS_ADD from '@/views/dashboard/cadastro/tasks/add'
import TASKS_EDIT from '@/views/dashboard/cadastro/tasks/edit'
Vue.use(Router)

//TODO - Colocar no MIXIN
const parseJwt = (token) => {
  try {
    return JSON.parse(atob(token.split('.')[1]));
  } catch (e) {
    return null;
  }
};

const checarAutenticado = (to, from, next) => {
  try {
    if (localStorage.getItem('token') != null)
      next() 
    else
      next("/login")
  } catch (err) {
    next("/login")
  }  
}

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      //pagina principal (Index) onde carregam os componentes da aplicação
      path: '/',
      component: () => import('@/views/dashboard/Index'),

      children: 
      [
        //PRINCIPAL
        { path: '/', component: PRINCIPAL, beforeEnter: checarAutenticado },   
        
        //STATUS
        { path: '/cadastro/status/list', component: STATUS_LIST, beforeEnter: checarAutenticado },
        { path: '/cadastro/status/add', component: STATUS_ADD, beforeEnter: checarAutenticado },
        { path: '/cadastro/status/edit/:id', component: STATUS_EDIT, beforeEnter: checarAutenticado },

        //TASKS
        { path: '/cadastro/tasks/list', component: TASKS_LIST, beforeEnter: checarAutenticado },
        { path: '/cadastro/tasks/add', component: TASKS_ADD, beforeEnter: checarAutenticado },
        { path: '/cadastro/tasks/edit/:id', component: TASKS_EDIT, beforeEnter: checarAutenticado },        
      ],
    },
    
    //LOGIN NO SISTEMA
    { path: '/login',component: () => import('@/views/dashboard/Login') },

    //INTERCEPTAR ERROS 404
    { path: '*', name:'404', component: ERRO_404 }
  ],
})

