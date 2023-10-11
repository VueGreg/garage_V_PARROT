<script setup>
    import axios from 'axios';
    import { ref } from 'vue';

    const socialNetworks = ref([])

    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        socialNetworks.value = response.data.informations[0]
        console.log(socialNetworks.value)
    })
    .catch (e => {
        console.error(e)
    })

</script>

<template>
    <section class="social">
        <h2>SUIVEZ NOUS</h2>
        <div class="social__network">
            <a :href=socialNetworks.facebook><img src="http://gregory-wolff.com/images/facebook_logo.png" alt=""></a>
            <a :href=socialNetworks.twitter><img src="http://gregory-wolff.com/images/twitter_logo.png" alt=""></a>
            <a :href=socialNetworks.linkedin><img src="http://gregory-wolff.com/images/linkedin_logo.png" alt=""></a>
            <a :href=socialNetworks.instagram><img src="http://gregory-wolff.com/images/instagram_logo.png" alt=""></a>
        </div>
    </section>

</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';
    .social{
        & h2{
            @include h2-main;
        }

        &__network{
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            margin: 2em auto;
        }
    }

</style>