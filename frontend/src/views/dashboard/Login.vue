<template>
  <v-app>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper">
          <div class="login-wrapper my-auto">
            <h1 class="login-title">Log in</h1>
              <v-form v-model="valid" ref="form">
                <v-container>
                  <v-row>
                    <v-col cols="12">
                      <label for="email">Email</label>
                      <v-text-field outlined v-model="email" style="background-color: white" 
                      :rules="[rules.required, rules.emailRules]" />
                    </v-col>
                  </v-row>

                  <v-row>
                    <v-col cols="12">
                      <label for="password">Senha</label>
                      <v-text-field outlined style="background-color: white" v-model="password" 
                        :rules="[rules.required]" :append-icon="show1? 'mdi-eye':'mdi-eye-off'" 
                        :type="show1 ? 'text' : 'password'" 
                        name="input-10-1" @click:append="show1 = !show1" />
                    </v-col>
                  </v-row>
                  
                  <v-row>
                    <v-col>                  
                      <v-btn x-large block :loading="processando" class="btn btn-block login-btn" @click="login">
                        LOGIN
                      </v-btn>
                    </v-col>
                  </v-row>

                  <v-row>
                    <v-col>
                      <v-btn :loading="processando_esqueceusenha" text @click="esqueceuSenha()">
                        Esqueci a minha senha
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-container>
              </v-form>
          </div>
        </div>

        <div class="col-sm-6 px-0 d-none d-sm-block">
          <img class="login-img" src="@/assets/fleetdesk_full.png">
        </div>
      </div>
    </div>

    <div class="col-sm-6 " style="text-align: center; margin-top: -50px">
      @2021 FleetDesk - Todos os direitos reservados
      <span style="margin-left: 60px">
        {{ this.$store.getters.versaoSistema }}
      </span>
    </div>

    <!-- modal LGPD bottom sheet -->
    <v-row>
      <v-col cols="12" sm="6" md="6">        
        <v-bottom-sheet v-model="sheet" persistent>
          <v-sheet class="text-center">
            <br>
            Este site usa cookies para melhorar sua experiência de navegação.
            de uso.
            <br>
            <v-btn text color="blue" @click="aceitarTermos">
              OK
            </v-btn>

            <v-btn text color="red" @click="abrirLGPD">
              Maiores informações
            </v-btn>
          </v-sheet>
        </v-bottom-sheet>
      </v-col>
    </v-row>
  </v-app>
</template>

<script>
  const axios = require('axios').default;
  const token = localStorage.getItem('token');  
  import sa2 from "sweetalert2";
  
  export default {
    name: 'Login',    
    data () {
      return {
        processando_esqueceusenha: false, processando: false, valid: true,
        dialog: true, show1: false,
        sheet: this.$cookies.get('termos_lgpd')? false : true,   
        password: "123456",
        email: "admin.fleetdesk@gmail.com",        
        tempoJanela: 5000,
        rules: {
          required: (v) => !!v || "Campo obrigatório",
          passwordMinSize: (v) => v.length >= 6 || "A senha deve ter 6 caracteres no mínimo",
          emailRules: (v) => this.validarEmail(v) || 'Por favor informe um email válido'
        },     
      }
    },
        
    methods: { 
      switchVisibility() {
        this.passwordFieldType = this.passwordFieldType === 'password' ? 'text' : 'password'
      },      

      //login
      login() {      
        this.verificarLGPD();        

        if (this.$refs.form.validate()) {
          this.processando = true;
          localStorage.clear();
          axios.post(this.$enderecoAPI + '/login', { "email": this.email, "password": this.password})
          .then((response) => {
            if (response.data.token) {
              this.$store.dispatch('setUsuario', response);
              this.$router.push('/');
            }     
          }).catch(error => {
            this.showMessage(error.response.data.message)
          }).finally( res => {
            this.processando = false;                
          })          
        } else
          this.processando = false;
      },

      //esqueceuSenha
      esqueceuSenha() {
        alert("TODO - Reset password")
      },

      abrirLGPD() {
        alert("TODO - Termos LGPD")
      },

      aceitarTermos() {
        this.$cookies.set('termos_lgpd', 'true', '1d');
        this.sheet = false;
      },

      verificarLGPD() {
        if (!this.$cookies.get('termos_lgpd')) {
          location.reload()
        }
      },

      showMessage(msg) {
        var tempoJanela = 5000;
        let timerInterval 
        sa2.fire({
          icon: 'error',
          title: 'Ocorreu um erro:',
          html: '<span style="color: red">'+ msg + '</span>'+
                '<br><br>'+
                '<span style="font-size: 11px">'+
                'A janela se fechará em <strong><contador></contador></strong> segundo(s)</span>',
          timer: tempoJanela,
          willOpen: () => {
            const content = sa2.getHtmlContainer()
            const $ = content.querySelector.bind(content)
            timerInterval = setInterval(() => {
            sa2.getHtmlContainer().querySelector('contador').textContent = (sa2.getTimerLeft() / 1000)
              .toFixed(0)}, 100)
          },
          willClose: () => {
            clearInterval(timerInterval)
          }
        });
      }

    }, 
  }
</script>
<style scoped src="@/css/formLogin.css"></style>

</style>