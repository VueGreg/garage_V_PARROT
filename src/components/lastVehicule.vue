<script setup>
    import axios from 'axios';
    import { ref } from 'vue';

    const annonces = ref([])
    const lastAnnonces = ref([])

    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        annonces.value = response.data.annonces
        lastAnnonces.value = annonces.value.slice(-3)
    })
    .catch (e => {
        console.error(e)
    })

</script>

<template>
    <section class="container text-center">
        <h2>NOS DERNIERS VEHICULES INTRODUIT DANS LE PARC</h2>
        <div class="cards" v-for="lastAnnonce in lastAnnonces" :key="lastAnnonce.id">
            <div class="cards__image">
                <img :src=lastAnnonce.photo>
            </div>
            <div class="cards__description">
                <div class="cards__description-title">
                    <h5>{{ lastAnnonce.marque }} {{ lastAnnonce.modele }}</h5>
                    <p>{{ lastAnnonce.motorisation }}</p>
                </div>
                <div class="cards__description-message">
                    <div class="send">
                        <i class="fa-solid fa-envelope" style="color: #f36639;"></i>
                        <p>Demande de renseignement</p>
                    </div>
                    <h3>{{ lastAnnonce.prix }}€</h3>
                </div>
            </div>
        </div>

        <button>Afficher tous les véhicules</button>
    </section>
</template>

<style lang="scss" scoped>
    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .send{
        @include flex-center;

        & p{
            margin-left: 0.5em;
        }
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
    }

    button{
        border: 3px solid $color-text-dark;
        color: $color-text-dark;
        border-radius: 10px;
        background: white;
        padding: 0.5em 1em;
        margin: 3em 0;
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