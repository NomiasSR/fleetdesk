<template>  
  <topo-pesquisa :headers="this.headers" 
    v-bind:dialog="this.dialog"
    :icone="this.icone"
    v-bind:mensagemErro="this.mensagemErro"
    v-bind:exibirJanelaDelete="this.exibirJanelaDelete"
    v-bind:url="this.url"
    tituloBox="Status - Listagem de registros -> (Filtro por Descrição)"   
    :dados="this.dados" :items_por_pagina="5"      
    :colunas="this.colunas"
    @onClickPesquisar="listDados" 
    @onClickCadastrar="addDados"
    @onClickEditDados="editDados" 
    @onClickDeleteDados="deleteDados"
    @resetVariaveis="resetVariaveis">
  </topo-pesquisa>
</template>

<script>
  import topoPesquisa from '../../components/core/topoPesquisa.vue';

  export default {
    components: { topoPesquisa },
    data () {
      return { 
        dialog: null, mensagemErro: null, exibirJanelaDelete: null, url: null,
        icone: 'mdi-bulletin-board',

        //componente table e paginacao
        dados: [],        
        colunas: ['descricao', 'observacao', 'data_cadastro', 'data_alteracao'],
        headers: [ { text: 'Descrição', align: 'center', value: 'descricao'},
                   { text: 'Observação', align: 'center', value: 'observacao' },
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
        let temp = filtro? "?descricao="+filtro : "";
        this.resetVariaveis()
        this.dialog = true
        this.$store.dispatch('loadDados', this.$enderecoAPI + '/status'+temp)
        .then(response => {
          this.dados = response.data.data
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
        this.$router.push('/cadastro/status/add') 
      },

      //exclusao de registro
      deleteDados(item) {
        this.url = this.$enderecoAPI + '/status/'+item.id 
        this.exibirJanelaDelete = true;
      },

      //edicao de dados
      editDados(item) { 
        this.$router.push('/cadastro/status/edit/'+item.id) 
      }
    }
  }
</script>