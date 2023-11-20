<script setup>
    import { defineProps } from 'vue';

    const {temoignages} = defineProps(['temoignages'])

</script>

<template>
    <section class="row" id="temoignage">
        <h2 class="col-10 col-sm-7 col-md-10">NOS CLIENTS TEMOIGNES</h2>
        <div class="testimony__card col-8 col-sm-7 col-md-3" v-for="temoignage in temoignages" :key="temoignage.id">
            <div class="testimony__card-person">
                <img src="https://gregory-wolff.com/images/anonymous1_avatars_grey_circles.jpg" alt="">
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
        margin-bottom: 1em;
    }

    section{
        margin: 3em 0;
    }

    .testimony__card{
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

    @media screen and (min-width: 480px) {

        section {
            padding: 2em;
        }
        .testimony__card{

            &-person img{
                width: 15vw;
                height: 15vw;
            }
        }
    }

    @media screen and (min-width: 960px) {
        .testimony__card{

            &-person img{
                width: 8vw;
                height: 8vw;
            }

            &-text {
                font-size: 0.8em;
            }
        }
    }

    @media screen and (min-width: 1260px) {
        .testimony__card{

            &-person img{
                width: 6vw;
                height: 6vw;
            }

            &-text {
                font-size: 0.9em;
            }
        }
}

</style>