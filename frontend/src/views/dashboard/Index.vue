<template>
  <v-app>
    <dashboard-core-app-bar />
    <dashboard-core-drawer />
    <dashboard-core-view />
  </v-app>
</template>

<script>
  export default {
    name: 'DashboardIndex',
    components: {
      //topo 
      DashboardCoreAppBar: () => import('./components/core/AppBar'),

      //gaveta
      DashboardCoreDrawer: () => import('./components/core/Drawer'),

      //miolo principal da aplicacao
      DashboardCoreView: () => import('./components/core/View'),
    },

    data: () => ({
      expandOnHover: false,
    })
  }
</script>
