<script setup>
    import AvisSection from '../components/avisSection.vue';
    import CarouselHome from '../components/carouselHome.vue';
    import ExpertiseSite from '../components/expertiseSite.vue';
    import LastVehicule from '../components/lastVehicule.vue';
    import ReseauxSociaux from '../components/reseauxSociaux.vue';
    import TemoignageSection from '../components/temoignageSection.vue'
    import axios from 'axios'
    import { ref } from 'vue';

    const annonces = ref([])
    const temoignages = ref([])


    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        temoignages.value = response.data.temoignages
    })
    .catch (e => {
        console.error(e)
    })

    axios
    .get('http://localhost/src/api/vehicle.php')
    .then (response => {
        annonces.value = response.data
    })
    .catch (e => {
        console.error(e)
    })




</script>

<template>
    <CarouselHome/>
    <LastVehicule :annonces="annonces"/>
    <ExpertiseSite />
    <TemoignageSection :temoignages="temoignages"/>
    <AvisSection />
    <ReseauxSociaux />
</template>
