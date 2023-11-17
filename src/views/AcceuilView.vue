<script setup>
    import AvisSection from '../components/avisSection.vue';
    import CarouselHome from '../components/carouselHome.vue';
    import ExpertiseSite from '../components/expertiseSite.vue';
    import LastVehicule from '../components/lastVehicule.vue';
    import ReseauxSociaux from '../components/reseauxSociaux.vue';
    import TemoignageSection from '../components/temoignageSection.vue'
    import api from '../baseURL/urlAPI';
    import { ref } from 'vue';

    const temoignages = ref([])

    const getTemoignages = async() => {
        await api.get('/vitrine.php')
        .then (response => {
            response.data.temoignages.forEach(temoignage => {
                if (temoignage.etat == 1) {
                    temoignages.value.push(temoignage)
                }
            })
        })
        .catch (e => {
            console.error(e)
        })
    }

    getTemoignages()


</script>

<template>
    <CarouselHome/>
    <LastVehicule/>
    <ExpertiseSite/>
    <TemoignageSection :temoignages="temoignages"/>
    <AvisSection />
    <ReseauxSociaux />
</template>

<style lang="scss" scoped>

    .v-enter-active,
    .v-leave-active {
    transition: all 0.5s ease;
    }

    .v-enter-from,
    .v-leave-to {
    opacity: 0;
    }

</style>
