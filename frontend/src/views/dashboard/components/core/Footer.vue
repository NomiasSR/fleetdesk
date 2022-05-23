<template>
  <div style="font-size: 12px; text-align: right; position: absolute; bottom: 0px; width: 100%">
    @2021 FleetDesk - Todos os direitos reservados
    <span style="margin-left: 70px">
      {{ this.$store.getters.versaoSistema }} 
    </span>
    
  </div>
</template>

<script>
  export default {
    name: 'DashboardCoreFooter',
  }
</script>