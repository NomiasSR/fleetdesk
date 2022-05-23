<template>  
  <div id="app">
    <v-container fluid>
      <v-card>
        <topoCrud
          tituloBox="Status -> Cadastro de registro"  
          v-bind:dialogSalvar="this.dialogSalvar"
          v-bind:url="this.url"
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
        dialogSalvar: false, descricao_model: '', observacao_model: '', valid: true, 
        camposForm: null, url: null, 
        urlRetorno: '/cadastro/status/list',
        descricao_label: 'Descrição * '+this.espacosEmBranco(8),
        observacao_label: 'Observação' +' * '+this.espacosEmBranco(8),
        rules: { required: (v) => !!v || "Campo obrigatório" }
      }
    },
    
    methods: {
      resetVariaveis() {
        this.camposForm = this.url = this.urlRetorno = null
      },

      salvar() {
        if (this.$refs.form.validate()) {                  
          this.url = this.$enderecoAPI + '/status'
          this.camposForm = JSON.stringify({ 
            descricao: this.descricao_model,
            observacao: this.observacao_model
          })
          this.dialogSalvar = true;
        }
      },

      cancelar() { 
        this.$router.push(this.urlRetorno) 
      },
    }
  }
</script>