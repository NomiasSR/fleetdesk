<template>  
  <div id="app">
    <v-container fluid>
      <v-card>
        <topoCrud
          tituloBox="Tarefas -> Cadastro de registro"  
          v-bind:dialogSalvar="this.dialogSalvar"
          v-bind:url="this.url"
          v-bind:dialog="this.dialog"
          v-bind:mensagemErro="this.mensagemErro"
          v-bind:mensagemProcessamento="this.mensagemProcessamento"
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

            <v-col cols="12" sm="6" md="6">
              <v-select v-model="status_model" :label="status_label" 
                :items="status" outlined dense item-value="id" :rules="[rules.required]">
                <template slot="selection" slot-scope="data">    
                  {{ data.item.descricao }}
                </template>
                <template slot="item" slot-scope="data">        
                  {{ data.item.descricao }}
                </template>
              </v-select>
            </v-col>
          </v-row>

          <v-row style="margin-top: -25px !important">
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
        dialogSalvar: false, valid: true, camposForm: null, url: null, 
        dialog: null, mensagemErro: null, mensagemProcessamento: null, 
        urlRetorno: '/cadastro/tasks/list',
        descricao_model: '', observacao_model: '',
        descricao_label: 'Descrição * '+this.espacosEmBranco(8),
        observacao_label: 'Observação' +' * '+this.espacosEmBranco(8),
        status:[], status_model: null, 
        status_label: 'Status da tarefa * '+this.espacosEmBranco(9),
        rules: { required: (v) => !!v || "Campo obrigatório" }
      }
    },

    mounted() {
      this.listStatus()            
    },
    
    methods: {
      //pesquisa de status
      listStatus() {
        let dados = [];
        this.$store.dispatch('loadDados', this.$enderecoAPI + '/status')
        .then(response => {
          dados = response.data.data;
          for(var i=0; i<dados.length; i++) 
            this.status.push({ 'id':dados[i]['id'], 'descricao':dados[i]['descricao'] });
        })
      },

      resetVariaveis() {
        this.camposForm = this.url = this.mensagemErro = this.mensagemProcessamento = null
      },

      salvar() {        
        if (this.$refs.form.validate()) {        
          this.url = this.$enderecoAPI + '/tasks'
          this.camposForm = JSON.stringify({ 
            descricao: this.descricao_model,
            observacao: this.observacao_model,
            id_status: this.status_model
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