<script setup>
    import AvisSection from '../components/avisSection.vue';
    import CarouselHome from '../components/carouselHome.vue';
    import ExpertiseSite from '../components/expertiseSite.vue';
    import LastVehicule from '../components/lastVehicule.vue';
    import ReseauxSociaux from '../components/reseauxSociaux.vue';
    import TemoignageSection from '../components/temoignageSection.vue'
    import axios from 'axios'
    import { ref, watch } from 'vue';

    const annonces = ref([])
    const temoignages = ref([])
    const animate = ref(false)
    const position = ref()

    window.addEventListener('scroll', () => {
        position.value = window.scrollY
    })

    watch(() => position.value, () => {
        console.log(position.value)
        if (position.value >= 1400) {
            animate.value = true
        }
    })


    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        temoignages.value = response.data.temoignages
    })
    .catch (e => {
        console.error(e)
    })

    const getScroll = (e) => {
        console.log(e)
    }


</script>

<template>
    <CarouselHome/>
    <LastVehicule/>
    <Transition :name="animationType">
        <div class="scroll__test" v-if="animate"> 
            <ExpertiseSite/>
        </div>
    </Transition>
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
