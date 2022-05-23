<template>  
  <div id="app">
    <v-container fluid>
      <v-card style="margin-top: -30px; ">
        <v-app-bar class="rounded-lg" id="barraTopoTitulo" dark style="height: 70px; z-index: 1;">
          <v-toolbar-title style="font-size: 14px; margin-top: 10px">
            {{ this.tituloBox }}
          </v-toolbar-title>

          <v-text-field v-model="textoPesquisar" size="5px"
            style="margin-left: 3%; margin-top: -10px" label=" " 
            single-line hide-details>
          </v-text-field>

          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon style="font-size: 14px; margin-top: 10px">
                <v-icon v-bind="attrs" v-on="on" style="font-size: 25px;" @click="onClickPesquisar">
                  mdi-magnify
                </v-icon>
              </v-btn>
            </template>
            <span>Pesquisar registros</span>            
          </v-tooltip>          

          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon style="font-size: 14px; margin-top: 10px">
                <v-icon v-bind="attrs" v-on="on" style="font-size: 25px" @click="onClickCadastrar">
                  mdi-plus-box
                </v-icon>
              </v-btn>
            </template>
            <span>Cadastrar novo registro</span>
          </v-tooltip>
        </v-app-bar>           

        <!-- ------------------------------------------- -->
        <!-- filtro dinamico de status -->
        <v-app-bar bottom v-if="filtroStatus">          
          <v-col cols="4" style="text-align: right">            
            STATUS da Tarefa:
          </v-col>

          <v-col cols="4">
            <v-select v-model="status_model" outlined dense 
              hide-details :items="status" item-value="id" item-text="descricao">
            </v-select>
          </v-col>

          <!-- imprimir tela de tarefas -->
          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn class="mx-10" dark color="teal" v-bind="attrs" v-on="on">
                <v-icon dark @click="relatorioTarefas">
                  mdi-printer
                </v-icon>
              </v-btn>
            </template>
            <span>Impressão de Relatório de Tarefas</span>
          </v-tooltip>
        </v-app-bar>
        <!-- ------------------------------------------- -->

        <v-data-table id="listagem" :headers="headers" :items="dados"
          :itemsPerPage="items_por_pagina" 
          :footer-props="{ showFirstLastPage: true, 'items-per-page-text': 'Registros por página' }" >

          <template v-slot:body="{items}">          
            <tbody name="list" is="transition-group" v-if="items.length > 0">
              <tr v-for="(item, index) in items" :key="index" class="item-row" :style="item['style']">
                <td v-for="(col, index) in colunas" :key="index">
                  {{ item[col] }}
                </td>

                <td style="text-align: center">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">  
                      <v-icon v-bind="attrs" v-on="on" small class="mr-2" @click="onClickEditDados(item)">
                        mdi-pencil
                      </v-icon>
                    </template>
                    <span>Editar registro</span>
                  </v-tooltip>

                  <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">  
                      <v-icon v-bind="attrs" v-on="on" small @click="onClickDeleteDados(item)">
                        mdi-delete
                      </v-icon>
                    </template>
                    <span>Excluir registro</span>
                  </v-tooltip>
                </td>
              </tr>
            </tbody>
          </template>
        </v-data-table>   
      </v-card>      
    </v-container>    
  </div>  
</template>

<script>
import html2pdf from 'html2pdf.js'
import sa2 from "sweetalert2";

export default {
  name: 'TopoPesquisa',
  props: [ 'tituloBox', 'dialog', 'headers', 'dados', 'colunas', 'janelaModal', 
           'mensagemErro', 'exibirJanelaDelete', 'url', 'items_por_pagina',
           'filtroStatus'],
  data() {
    return {
      textoPesquisar:'', 
      janelaProcessamento: { 
        icon: 'warning',
        title: 'Processando requisição', text: 'Aguarde...', 
        showConfirmButton: false, willOpen: () => { sa2.showLoading() },
        position: "center"
      },
      janelaErro: { icon: 'error', title: 'Ocorreu um erro', text: '' },
      status_model:'', status:[ ],
    }
  },

  //watchers
  watch: { 
    mensagemErro: function(val) { return val },

    url: function(val) { return val },

    //dialogo padrao
    dialog: function(val) {
      if (val !== null) 
        sa2.fire(this.janelaProcessamento)
      else {
        if (this.mensagemErro === null) 
          sa2.clickCancel()
        
        //mensagens de erro da aplicacao
        if (this.mensagemErro != null) {
          this.janelaErro.text = " - " + (this.mensagemErro === null? this.mensagemErro: ' ')
          sa2.fire(this.janelaErro)
        }
      }        
    },

    //deleteDados
    exibirJanelaDelete: function(val) {
      if (val !== null)
      {
        sa2.fire({
          title: "Atenção",
          text: "Você deseja excluir o registro?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Sim",
          cancelButtonText: "Não",
          showLoaderOnConfirm: true,
          preConfirm: () => {
            return new Promise((resolve, reject) => {
              this.$store.dispatch('excluirDados', [this.url]).then(response => {
                sa2.fire({ 
                  icon: 'success', title: 'Sucesso', text: 'Registro excluído', 
                  allowOutsideClick: () => !sa2.isLoading(),
                  preConfirm: () => {
                    this.onClickPesquisar()
                  }
                })
                resolve()

              }).catch(error => { 
                sa2.fire({ icon: 'error', title: 'Ocorreu um erro', 
                           text: 'Detalhes:'+ error.response.data.data })
                reject();
              }).then(() => {
                this.resetVariaveis();
              })
            })
          },
          allowOutsideClick: () => !sa2.isLoading()
        })
      }
    }    
  },

  //emits
  methods: {
    onClickPesquisar() {
      let textoPesquisar = this.textoPesquisar
      if (this.filtroStatus)
        textoPesquisar += "||"+this.status_model

      this.$emit('onClickPesquisar', textoPesquisar)
    },

    onClickCadastrar() {
      this.$emit('onClickCadastrar')
    },

    onClickEditDados(item){
      this.$emit('onClickEditDados', item)
    },

    onClickDeleteDados(item){
      this.$emit('onClickDeleteDados', item)
    },

    resetVariaveis() {
      this.$emit('resetVariaveis');
    },

    //pesquisa de status
    listStatus() {
      let dados = [];
      this.$store.dispatch('loadDados', this.$enderecoAPI + '/status')
      .then(response => {
        dados = response.data.data;
        this.status.push({ 'id':'', 'descricao':'Todos' });
        for(var i=0; i<dados.length; i++) 
          this.status.push({ 'id':dados[i]['id'], 'descricao':dados[i]['descricao'] });
      })
    },

    //impressao de tarefas
    relatorioTarefas() {
      var element = document.getElementById('listagem');
      html2pdf(element);
    }
  },  

  created() {
    //se filtro de status estiver ativado
    if (this.filtroStatus)
      this.listStatus();
  }
}
</script>