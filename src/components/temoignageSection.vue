<script setup>
    import axios from 'axios';
    import { ref } from 'vue';

    const temoignages = ref([])

    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        temoignages.value = response.data.temoignages
    })
    .catch (e => {
        console.error(e)
    })

</script>

<template>
    <section class="container">
        <h2>NOS CLIENTS TEMOIGNES</h2>
        <div class="testimony__card" v-for="temoignage in temoignages" :key="temoignage.id">
            <div class="testimony__card-person">
                <img src="http://gregory-wolff.com/images/anonymous1_avatars_grey_circles.jpg" alt="">
            </div>
            <div class="testimony__card-stars" v-if="temoignage.note === 1">
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
            </div>
            <div class="testimony__card-stars" v-if="temoignage.note === 2">
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
            </div>
            <div class="testimony__card-stars" v-if="temoignage.note === 3">
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
            </div>
            <div class="testimony__card-stars" v-if="temoignage.note === 4">
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-regular fa-star" style="color: #f36639;"></i>
            </div>
            <div class="testimony__card-stars" v-if="temoignage.note === 5">
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
                <i class="fa-solid fa-star" style="color: #f36639;"></i>
            </div>
            <div class="testimony__card-text">
                <p>{{ temoignage.commentaire }}</p>
            </div>
            <div class="testimony__card-name">
                <p>{{ temoignage.prenom }} {{ temoignage.nom }}</p>
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    h2{
        @include h2-main;
    }

    section{
        margin: 3em 0;
    }

    .testimony__card{
        width: 80vw;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 3em auto;

        &-person img{
            width: 25vw;
            height: 25vw;
            @include flex-center;
            box-shadow: 3px 3px 6px rgba($color: #000000, $alpha: 0.3);
            border-radius: 50%;
            margin: 1em auto;
        }

        &-stars{
            margin: 1em auto;
        }

        &-text{
            font-size: 0.9em;
            text-align: center;
        }

        &-name{
            font-weight: 600;
        }
    }

</style>