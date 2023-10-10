<script setup>
  import mainHeader from './components/mainHeader.vue';
  import NavBar from './components/navBar.vue';
  import { RouterView } from 'vue-router';
</script>

<template>
  <mainHeader/>
  <NavBar />
  <RouterView />
</template>

<style scoped>

</style>
