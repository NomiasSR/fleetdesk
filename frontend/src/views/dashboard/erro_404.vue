<template>
  <div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); 
    border: 5px solid red; padding: 10px; font-size: 20px; width: 30%; text-align: center">
    <hr>
    Página ou método não encontrados. <br>Por favor faça <router-link to="/login">LOGIN</router-link> novamente
    <br>
    <hr>
  </div>
</template>

<script>
  export default {
    name: 'ERRO_404',
  }
</script>
