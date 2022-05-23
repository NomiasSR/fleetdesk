<template>  
  <div id="app">
    <topo-pesquisa :headers="this.headers" 
      tituloBox="Tarefas - Listagem de registros -> (Filtro por Descrição) "
      v-bind:dialog="this.dialog"
      v-bind:url="this.url"
      v-bind:mensagemErro="this.mensagemErro"
      v-bind:exibirJanelaDelete="this.exibirJanelaDelete"      
      :dados="this.dados" :items_por_pagina="5"      
      :colunas="this.colunas"
      :filtroStatus="true"
      @onClickPesquisar="listDados" 
      @onClickCadastrar="addDados"
      @onClickEditDados="editDados" 
      @onClickDeleteDados="deleteDados"
      @resetVariaveis="resetVariaveis">
    </topo-pesquisa>    
  </div>
</template>

<script>
  import topoPesquisa from '../../components/core/topoPesquisa.vue'
  
  export default {
    components: { topoPesquisa },
    data () {
      return { 
        dialog: null, mensagemErro: null, exibirJanelaDelete: null, url: null,

        //componente table e paginacao
        dados: [],        
        colunas: [ 'descricao', 'observacao', 'status', 'data_cadastro', 'data_alteracao' ],
        headers: [ { text: 'Descrição', align: 'center', value: 'descricao'},
                   { text: 'Observação', align: 'center', value: 'observacao'},
                   { text: 'Status', align: 'center', width: '100px', value: 'status'},
                   { text: 'Cadastro', width: '120px', value: 'data_cadastro' },
                   { text: 'Alteração', width: '120px', value: 'data_alteracao' },
                   { text: 'Ações', align: 'center' } ],
      }
    },

    mounted() {
      this.listDados()
    },

    methods: {
      resetVariaveis() {
        this.mensagemErro = this.exibirJanelaDelete = this.url = null
      },

      //pesquisa de dados
      listDados(filtro) {
        let temp = "?filtro=sim";
        if (filtro) {
          let temp1 = filtro.split("||");
          if (temp1[0])
            temp += "&descricao="+temp1[0]
          if (temp1[1])
            temp += "&id_status="+temp1[1]
        }

        this.resetVariaveis()
        this.dialog = true
        this.$store.dispatch('loadDados', this.$enderecoAPI + '/tasks'+temp)
        .then(response => {
          this.dados = response.data.data.map(s => {
            //cores dos status ABERTO, FECHADO e CONCLUIDO
            let cor = (s.status.id == 1? "#ffff99" : 
                      (s.status.id == 2? "#ff8566" : 
                      (s.status.id == 3)? "#00cc44" : ""));
            return {
              id: s.id,
              descricao: s.descricao,
              observacao: s.observacao,
              status: s.status.descricao,
              data_cadastro: s.data_cadastro,
              data_alteracao: s.data_alteracao,
              style: 'background-color: '+cor
            }
          })
        }).catch(error => {
          temp = error.response.data.message;
          if (temp == "")
            temp = error.response.status+": "+error.response.statusText
          this.mensagemErro = temp
        }).finally(res => {
          this.dialog = null;
        })
      },

      //cadastro
      addDados() { 
        this.$router.push('/cadastro/tasks/add') 
      },

      //exclusao de registro
      deleteDados(item) {
        this.url = this.$enderecoAPI + '/tasks/'+item.id 
        this.exibirJanelaDelete = true;
      },

      //edicao de dados
      editDados(item) { 
        this.$router.push('/cadastro/tasks/edit/'+item.id) 
      }

    }
  }
</script>