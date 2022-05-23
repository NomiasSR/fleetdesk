<template>
  <v-navigation-drawer id="core-navigation-drawer" v-model="drawer" 
    :expand-on-hover="expandOnHover" :right="$vuetify.rtl" :src="barImage" mobile-breakpoint="960"
    app width="220" v-bind="$attrs">
    <template v-slot:img="props">
      <v-img :gradient="`to bottom, ${barColor}`" v-bind="props"/>
    </template>

    <v-list dense nav style="margin-top: 20px;">
      <v-img src="@/assets/fleetdesk_logo.png" style="height: 11vh; width: 12.2vh; margin-left: 30%" />
    </v-list>

    <v-divider class="mb-2" />

    <v-list expand nav>
      <!-- Style cascading bug  -->
      <!-- https://github.com/vuetifyjs/vuetify/pull/8574 -->
      <div />
 
      <!-- Style cascading bug  -->
      <!-- https://github.com/vuetifyjs/vuetify/pull/8574 -->
      <div />
    </v-list>

    <v-treeview v-model="tree" active-class="#e8eaf6 indigo lighten-5" 
      style="font-color: black; font-weight: bold; text-align: left;"  :items="items" 
      activatable item-key="name" open-on-click>

      <template slot="label" slot-scope="{ item, open }" >        
        <div @click="mensagem(item)" style="font-size: 13px;">
          <v-icon v-if="!item.file" >           
            {{ open ? 'mdi-folder-open' : 'mdi-folder' }}
          </v-icon>

          <v-icon v-else>
            {{ item.file }}
          </v-icon>
          {{ item.name }}
        </div>
      </template>
    </v-treeview>
  </v-navigation-drawer>
  
</template>

<script>
  // Utilities
  import { mapState } from 'vuex'

  export default {
    name: 'DashboardCoreDrawer',
    props: {
      expandOnHover: {
        type: Boolean,
        default: false,
      },
    },

    data () {
      return {
        tree: [],
        items: [],
      }
    },

    mounted() {
      this.$store.commit('change', localStorage.getItem("titulo"))
       this.urlsAcesso();
    },

    methods: {
      urlsAcesso() {
        var user = JSON.parse(localStorage.getItem("user"))

        var pais =  [ { id: 1, nome: 'Dashboard', icone: 'mdi-file-document-outline', url: '/', id_pai: 'N' },
                      { id: 3, nome: 'Cadastro', icone: '', url: '', id_pai:'S' },
                      { id: 7, nome: 'Status', icone: 'mdi-bulletin-board', url: '/cadastro/status/list', id_pai: '3' },
                      { id: 8, nome: 'Tarefas', icone: 'mdi-account-key', url: '/cadastro/tasks/list', id_pai: '3' },
                    ];
        var i = 0;
        var atual = 0;
        var temp = []
        for(var dado of pais) {          
          if (dado.id_pai === 'S' || dado.id_pai === 'N') {
            temp[dado.id] = { name: dado.nome, file: dado.icone, to: dado.url}             
            if (dado.id_pai === 'S')
              temp[dado.id]['children'] = [{}]
          } else {
            
            if(user.type === 'key' && dado.id === 8)
              continue;

            if (dado.id_pai != atual) {
              atual = dado.id_pai
              i=0;
            }
            temp[dado.id_pai]['children'][i++] = { name: dado.nome, file: dado.icone, to: dado.url}          
          }
        }
        
        this.items = temp;
      },

      mensagem(item) {
        if(item.to) {
          if ((this.$route.path != item.to) && (item.to != "#")) {
            localStorage.setItem("titulo", item.name)
            this.$store.commit('change', localStorage.getItem("titulo"))                        
            this.$router.push(item.to)
          }
        }
      },
    },
    

    computed: {
      ...mapState(['barColor', 'barImage']),
      drawer: {
        get () { return this.$store.state.drawer },        
        set (val) { this.$store.commit('SET_DRAWER', val) },
      },

      computedItems () { 
        return this.items.map(this.mapItem) },

      profile () {
        return {
          avatar: true,
          title: this.$t('avatar')          
        }
      },
    }   
  }
</script>

<style lang="sass">
  @import '~vuetify/src/styles/tools/_rtl.sass'

  #core-navigation-drawer
    .v-list-group__header.v-list-item--active:before
      opacity: .24

    .v-list-item
      &__icon--text,
      &__icon:first-child
        justify-content: center
        text-align: center
        width: 20px

        +ltr()
          margin-right: 24px
          margin-left: 12px !important

        +rtl()
          margin-left: 24px
          margin-right: 12px !important

    .v-list--dense
      .v-list-item
        &__icon--text,
        &__icon:first-child
          margin-top: 10px

    .v-list-group--sub-group
      .v-list-item
        +ltr()
          padding-left: 8px

        +rtl()
          padding-right: 8px

      .v-list-group__header
        +ltr()
          padding-right: 0

        +rtl()
          padding-right: 0

        .v-list-item__icon--text
          margin-top: 19px
          order: 0

        .v-list-group__header__prepend-icon
          order: 2

          +ltr()
            margin-right: 8px

          +rtl()
            margin-left: 8px
</style>
