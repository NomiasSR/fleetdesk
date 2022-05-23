<template>
  <v-app-bar id="app-bar" absolute app color="transparent" flat height="150" class="rounded-tl-xl"
    :style="`background-image: url(${require('@/assets/topo_datalens.png')}); background-size: cover; `">
    
    <v-btn class="mr-3" elevation="1" fab small @click="setDrawer(!drawer)" style="margin-top: -30px">
      <v-icon v-if="value">        
        mdi-view-quilt        
      </v-icon>

      <v-icon v-else>
        mdi-dots-vertical
      </v-icon>      
    </v-btn>

    <div style="font-family: 'Montserrat';font-size: 42px; color: white; margin-top: -20px">
      <div style="font-weight: bold;">FleetDesk</div>
      <div style="font-size: 14.5px; margin-left: 45px; margin-top: -8px; width: 300px">
        - Sistema de Controle de Tarefa        
      </div>
    </div>
    
    <v-toolbar-title :class="[$vuetify.breakpoint.mdAndUp ? 'display-normal-titulo' : 'display-pequeno']">
      <div style="font-size: 17px;">
        Nome do usuário: {{ nomeUsuario }}        
      </div>
    </v-toolbar-title>
    
    <v-spacer></v-spacer>

    <template v-if="$vuetify.breakpoint.mdAndUp" v-slot:append-outer>      
      <v-btn class="mt-n2" elevation="1" fab small>
        <v-icon>mdi-magnify</v-icon>       
      </v-btn>
    </template>

    <!-- exibir o nome do usuario -->
    <div :class="[$vuetify.breakpoint.mdAndUp ? 'display-normal' : 'display-pequeno']">
      <v-list-item-avatar class="align-self-center" style="border: 2px solid white" contain >
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }" >
            <a @click="minhaConta()">
              <v-img v-bind="attrs" v-on="on" v-if="temImagem" :src="imagemUsuario" max-height="70" max-width="70" />
              <v-img v-bind="attrs" v-on="on" v-else src="@/assets/register.jpg" max-height="70" max-width="70" />
            </a>
          </template>
          <span>Minha conta</span>
        </v-tooltip>
      </v-list-item-avatar>
    </div>

    <v-tooltip bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="ml-1" min-width="0" text to="/">
          <v-icon style="color: white">mdi-view-dashboard</v-icon>
        </v-btn>
      </template>
      <span>DASHBOARD</span>
    </v-tooltip>

    <v-tooltip bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="ml-2" min-width="0" color="error" 
          dark v-on:click="logout()">
          <v-icon>mdi-logout</v-icon>
        </v-btn>
      </template>
      <span>Sair do Sistema</span>
    </v-tooltip>

  </v-app-bar>
</template>

<script>
  const axios = require('axios').default;
  import { VHover, VListItem } from 'vuetify/lib'
  import { mapState, mapMutations } from 'vuex'  

  export default {
    name: 'DashboardCoreAppBar',

    components: {
      AppBarItem: {
        render (h) {
          return h(VHover, {
            scopedSlots: {
              default: ({ hover }) => {
                return h(VListItem, {
                  attrs: this.$attrs,
                  class: {
                    'black--text': !hover,
                    'white--text secondary elevation-12': hover,
                  },
                  props: {
                    activeClass: '',
                    dark: hover,
                    link: true,
                    ...this.$attrs,
                  },
                }, this.$slots.default)
              },
            },
          })
        },
      },
    },

    props: {
      value: {
        type: Boolean,
        default: false,
      },
    },

    data: () => ({
      nomeSistema: '', nomeUsuario: '', idUsuario: '', imagemUsuario: '', perfilUsuario: '',
      temImagem: false
    }),

    computed: {
      ...mapState(['drawer']),
    },

    mounted() {
      var imagem = null;
      this.perfilUsuario = JSON.parse(localStorage.getItem('user')).type      
      this.nomeUsuario = JSON.parse(localStorage.getItem('user')).name      
      this.idUsuario = JSON.parse(localStorage.getItem('user')).id
      this.imagemUsuario = "data:image/jpeg;base64,"+imagem
      this.temImagem = (imagem != null)? true : false;
    },

    methods: {
      minhaConta() {
        alert("TODO - Minha conta")
      },

      logout() {
        if (confirm("Você deseja sair do sistema?")) {
          this.$store.dispatch('setUsuario', null);
          this.$router.push("/login")
        }
      },

      ...mapMutations({
        setDrawer: 'SET_DRAWER',
      }),
    },
  }
</script>
<style scoped src="@/css/appBar.css"></style>