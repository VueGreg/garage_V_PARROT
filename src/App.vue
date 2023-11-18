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
  <RouterView v-slot="{ Component }">
    <Transition name="fade">
      <component :is="Component" />
    </Transition>
  </RouterView>
  <MainFooter />
</template>

<style>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s ease;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
}
</style>
