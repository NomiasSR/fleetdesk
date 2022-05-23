<template>  
  <div id="app" style="margin-top: -60px;">
    <v-app-bar class="rounded-lg" id="barraTopoTitulo" dark style="height: 70px; z-index: 1; margin-bottom: 20px;">
      <v-toolbar-title style="font-size: 14px; margin-top: 10px">
        <span style="margin-right: 30px">{{ this.tituloBox }}</span>
        <span>( Os campos com '*' são obrigatórios )</span>
      </v-toolbar-title>        

      <v-spacer></v-spacer>

      <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon>
            <v-icon v-bind="attrs" v-on="on" style="font-size: 25px; margin-top: 10px" @click="onClickSalvar">
              mdi-check-bold
            </v-icon>
          </v-btn>
        </template>
        <span>Salvar registro</span>
      </v-tooltip>

      <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon>
            <v-icon v-bind="attrs" v-on="on" style="font-size: 25px; margin-top: 10px" @click="onClickCancelar">
              mdi-close
            </v-icon>
          </v-btn>
        </template>
        <span>Cancelar operação</span>
      </v-tooltip>
    </v-app-bar>
  </div>    
</template>

<script>
import sa2 from "sweetalert2";

export default {
  name: 'TopoCrud',
  props: [ 'tituloBox', 'dialogSalvar', 'dialogAtualizar', 'camposForm', 'url', 
           'urlRetorno', 'dialog', 'mensagemErro', 'mensagemProcessamento' ],

  data() {
    return {
      janelaProcessamento: { 
        icon: 'warning',
        title: 'Processando requisição', text: 'Aguarde...', 
        showConfirmButton: false, willOpen: () => { sa2.showLoading() },
        position: "center"
      },

      janelaErro: { 
        icon: 'error', title: 'Ocorreu um erro', text: '',
        preConfirm: () => { this.$router.push(this.urlRetorno) },
        allowOutsideClick: () => !sa2.isLoading()
      },
    }
  },

   //watchers
  watch: {
    url: function(val) { return val },

    urlRetorno: function(val) { return val },
    
    camposForm: function(val) { return val },

    mensagemErro: function(val) { return val },

    mensagemProcessamento: function(val) { return val },

    //dialogo padrao
    dialog: function(val) {
      if (val !== null) {
        let mp = this.mensagemProcessamento
        this.janelaProcessamento.text = " - " + (mp? mp : '')
        sa2.fire(this.janelaProcessamento)
      } else {
        let me = this.mensagemErro
        if (me === null) 
          sa2.clickCancel()
        else {
          this.janelaErro.text = " - " + me
          sa2.fire(this.janelaErro)
        }
      } 
    },    

    //dialogo para salvar o registro
    dialogSalvar: function(val) {
      if (val !== null)
      {
        sa2.fire({
          icon: "warning",
          title: "Processando requisição",
          text: "Aguarde...",            
          showConfirmButton: false,
          willOpen: () => {
            sa2.showLoading()
            return new Promise((resolve, reject) => {
              this.$store.dispatch('salvarDados', [this.url, this.camposForm])
              .then(response => {
                sa2.fire({ 
                  icon: 'success', title: 'Sucesso', text: 'Registro salvo', 
                  allowOutsideClick: () => !sa2.isLoading(),
                  preConfirm: () => {
                    this.$router.push(this.urlRetorno)     
                  }
                })
                resolve()

              }).catch(error => { 
                sa2.fire({ icon: 'error', title: 'Ocorreu um erro', text: error.message })
                reject()
              }).then(() => {
                this.resetVariaveis();
              })
            }); 
          },
          allowOutsideClick: () => !sa2.isLoading()
        })
      }
    },

    //dialogo para atualizar o registro
    dialogAtualizar: function(val) {
      if (val !== null)
      {
        sa2.fire({
          icon: "warning",
          title: "Processando requisição",
          text: "Aguarde...",            
          showConfirmButton: false,
          willOpen: () => {
            sa2.showLoading()
            return new Promise((resolve, reject) => {
              this.$store.dispatch('atualizarDados', [this.url, this.camposForm])
              .then(response => {
                sa2.fire({ 
                  icon: 'success', title: 'Sucesso', text: 'Registro atualizado', 
                  allowOutsideClick: () => !sa2.isLoading(),
                  preConfirm: () => {
                    this.$router.push(this.urlRetorno)     
                  }
                })
                resolve()

              }).catch(error => { 
                let temp = error.response.data.data
                temp = temp? temp : error.message
                sa2.fire({ icon: 'error', title: 'Ocorreu um erro', text: temp })
                reject()
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

  methods: {
    onClickSalvar: function() {
      this.$emit('onClickSalvar')
    },

    onClickCancelar: function () {
      this.$emit('onClickCancelar')
    },

    resetVariaveis() {
      this.$emit('resetVariaveis');
    } 
  }
}
</script>