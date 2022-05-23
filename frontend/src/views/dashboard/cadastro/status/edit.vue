<template>  
  <div id="app">
    <v-container fluid>
      <v-card>
        <topoCrud
          tituloBox="Status -> Edição de registro"  
          v-bind:dialogAtualizar="this.dialogAtualizar"
          v-bind:url="this.url"
          v-bind:dialog="this.dialog"
          v-bind:mensagemErro="this.mensagemErro"
          v-bind:urlRetorno="this.urlRetorno"
          v-bind:camposForm="this.camposForm"      
          @onClickSalvar="salvar" 
          @onClickCancelar="cancelar"
          @resetVariaveis="resetVariaveis">
        </topoCrud>

        <v-form v-model="valid" ref="form">
          <v-row>
            <v-col cols="12" sm="6" md="6">
              <v-text-field :label="descricao_label" v-model="descricao_model" 
                append-icon="mdi-message-text-outline" outlined dense
                :rules="[rules.required]" counter="30" maxlength="30">
              </v-text-field>    
            </v-col>

            <v-col>
              <v-textarea style="font-size: 13px;" rows="3" outlined dense 
                :label="observacao_label" v-model="observacao_model" 
                append-icon="mdi-message-text-outline" counter maxlength="100" no-resize>
              </v-textarea>
            </v-col>  
          </v-row>
        </v-form>
      </v-card>
    </v-container>
  </div>  
</template>

<script>
  import topoCrud from '@/views/dashboard/components/core/topoCrud'
  
  export default {
    components: { topoCrud },
    data () {
      return {
        dialogSalvar: false, dialogAtualizar: false, descricao_model: '', 
        observacao_model:'', valid: true, 
        camposForm: null, url: null, dialog: null, mensagemErro: null,
        urlRetorno: '/cadastro/status/list',        
        descricao_label: 'Descrição * '+this.espacosEmBranco(8),
        observacao_label: 'Observação' +' * '+this.espacosEmBranco(8),
        rules: { required: (v) => !!v || "Campo obrigatório" }        
      }
    },

    mounted() {
      this.listDados()
    },
    
    methods: {
      //pesquisa de dados
      listDados() {
        this.resetVariaveis()
        this.dialog = true
        this.$store.dispatch('loadDados', this.$enderecoAPI + '/status?id='+this.$route.params.id)
        .then(response => {
          this.descricao_model = response.data.data[0].descricao;
          this.observacao_model = response.data.data[0].observacao;
        }).catch(error => {
          this.mensagemErro = error.message
        }).finally(res => {
          this.dialog = null;
        })
      },

      resetVariaveis() {
        this.dialog = this.mensagemErro = this.camposForm = this.url = null
      },

      salvar() {
        if (this.$refs.form.validate()) {        
          this.url = this.$enderecoAPI + '/status/'+this.$route.params.id
          this.camposForm = JSON.stringify({ 
            descricao: this.descricao_model,
            observacao: this.observacao_model 
          })
          this.dialogAtualizar = true;
        }
      },

      cancelar() { 
        this.$router.push(this.urlRetorno) 
      },
    },    

  }
</script>