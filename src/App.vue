<script setup>
  import MainFooter from './components/mainFooter.vue';
  import mainHeader from './components/mainHeader.vue';
  import NavBar from './components/navBar.vue';
  import { RouterView } from 'vue-router';
  import appBar from './components/appBar.vue'
</script>

<template>
  <mainHeader/>
  <NavBar />
  <appBar/>
  <RouterView />
  <MainFooter />
</template>

<style scoped>

</style>
