<script setup>
    import axios from 'axios'
    import { ref } from 'vue';

    const annonces = ref([])


    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        annonces.value = response.data.annonces
    })
    .catch (e => {
        console.error(e)
    })


</script>

<template>
    <h2>RETROUVEZ TOUS NOS VEHICULES EN VENTE</h2>
        <div class="cards" v-for="annonce in annonces" :key="annonce.numero_annonce">
            <RouterLink class="link" active-class="active" :to="`/annonces/${annonce.numero_annonce}`">
            <div class="cards__image">
                <img :src=annonce.photo>
            </div>
            <div class="cards__description">
                <div class="cards__description-title">
                    <h5>{{ annonce.marque }} {{ annonce.modele }}</h5>
                    <p>{{ annonce.motorisation }}</p>
                </div>
                <div class="cards__description-message">
                    <div class="send">
                        <i class="fa-solid fa-envelope" style="color: #f36639;"></i>
                        <p>Demande de renseignement</p>
                    </div>
                    <h3>{{ annonce.prix }}€</h3>
                </div>
            </div>
        </RouterLink>
        </div>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .link {
        text-decoration: none;
        color: $dark-grey;
    }

    p {
        font-size: 0.7em;
    }

    h2,
    p,
    h5,
    h3 {
        margin: 0;
    }

    h3{
        color: $primary-color;
        font-weight: 800;
        font-size: 1.6em;
    }

    h2{
        @include h2-main;
        width: 80vw;
    }

    .cards{
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 80vw;
        margin: 3em auto;
        font-family: $font-text-nav-card;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.3);
        border-radius: 6px;

        &__description{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: start;

            &-title{
                margin-top: 0.5em;
                & p{
                    font-size: 0.8em;
                }
            }

            &-message{
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 75vw;
                margin-top: 1em;
                margin-bottom: 0.5em;
            }
        }

        &__image img{
            width: 100%;
            height: auto;
            border-radius: 6px 6px 0px 0px;
        }
    }

</style>