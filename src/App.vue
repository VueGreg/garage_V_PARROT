<script setup>
  import MainFooter from './components/mainFooter.vue';
import mainHeader from './components/mainHeader.vue';
  import NavBar from './components/navBar.vue';
  import { RouterView } from 'vue-router';
</script>

<template>
  <mainHeader/>
  <NavBar />
  <RouterView />
  <MainFooter />
</template>

<style scoped>

</style>
