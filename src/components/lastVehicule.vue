<script setup>
    import api from '../../urlAPI';
    import { ref } from 'vue';
    import { RouterLink } from 'vue-router';

    const annonces = ref([])
    const lastAnnonces = ref([])
    
    api.post('/vehicle.php')
    .then (response => {
        annonces.value = response.data
        lastAnnonces.value = annonces.value.slice(-3)
    })
    .catch (e => {
        console.error(e)
    })

</script>

<template>
    <section class="row">
        <h2 class="col-10 col-sm-7 col-md-8 col-lg-10">NOS DERNIERS VEHICULES INTRODUIT DANS LE PARC</h2>
        <div class="container-card m-auto col-sm-10">
            <div class="cards col-8 col-lg-6 col-xl-3" v-for="annonce in lastAnnonces" :key="annonce.numero_annonce">
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
                        <RouterLink class="router" :to="`/contact/${annonce.numero_annonce}`">
                            <div class="send">
                                <i class="fa-solid fa-envelope" style="color: #f36639;"></i>
                                <p>Demande de renseignement</p>
                            </div>
                        </RouterLink>
                        <h3>{{ annonce.prix }}€</h3>
                    </div>
                </div>
                </RouterLink>
            </div>
        </div>
    </section>
    <button><RouterLink class="link" active-class="active" to="/annonces">Afficher tous les véhicules</RouterLink></button>
</template>

<style lang="scss" scoped>
    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .router {
        text-decoration: none;
    }

    .active {
        color: $dark-grey;
    }

    .link {
        text-decoration: none;
        color: $dark-grey;
    }

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
        margin-bottom: 1em;
    }

    button{
        @include btn-style($dark-grey);
    }
    .cards{
        display: flex;
        flex-direction: column;
        align-items: center;
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
                margin-left: 1em;
                & p{
                    font-size: 0.8em;
                }
            }

            &-message{
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 1em;
                margin-bottom: 0.5em;
                width: 90%;
                padding: 0 1em;
            }
        }

        &__image img{
            width: 100%;
            height: auto;
            border-radius: 6px 6px 0px 0px;
        }
    }


    @media screen and (min-width: 1200px) {

        .container-card {

            display: flex;
        }
    }

    @media screen and (min-width: 1600px) {

        .container-card {

            display: flex;
        }
        
        .cards {
            font-size: 1.2em;

                &__description-title p{

                    font-size: 0.9em;
                }
            }
        

        h5 {
            font-size: 1.5em;
            font-weight: 600;
        }
    }

</style>