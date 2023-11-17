<script setup>

    import api from '../baseURL/urlAPI';
    import { useRoute } from 'vue-router';
    import { ref } from 'vue';
    import carouselHome from '../components/carouselHome.vue';

    const route = useRoute()
    const vehicules = ref ([])
    const showStats = ref(false)

    const carId = parseInt(route.params.annonce)

    api.post('/vehicle.php', {
        annonce: carId
    })
    .then (response => {
        vehicules.value = response.data
    })
    .catch (e => {
        console.error(e)
    })

</script>

<template>
    <carouselHome />
    <main class="row">
        <div class="title col-8" v-for="vehicule in vehicules">
            <h2>{{ vehicule.marque }} {{ vehicule.modele }}</h2>
            <h4>{{ vehicule.motorisation }}</h4>
            <h5>{{ vehicule.prix }}€</h5>
        <RouterLink class="router" :to="`/contact/${vehicule.numero_annonce}`">
            <div class="btn col-8 col-sm-6 col-md-5 col-lg-3">
                <i class="fa-solid fa-envelope" style="color: #f36639;"></i>
                <span>Je souhaite en savoir plus</span>
            </div>
        </RouterLink>
        </div>

            <div class="photos col-9 col-sm-7 col-lg-5" v-for="vehicule in vehicules">
                <div class="images" v-for="image in vehicule.images" :key="image.id">
                    <img :src="image.photo" alt="">
                </div>
            </div>
        
        <div class="informations col-8 col-lg-5">

            <div class="informations__title">
                        <button @click="showStats=false" :class="{active: !showStats}">Caractéristiques</button>
                        <button @click="showStats=true" :class="{active: showStats}">Equipements</button>
            </div>
            <div class="informations__caracteristiques" v-if="!showStats" v-for="vehicule in vehicules">
                <table class="table-responsive">
                    <tr>
                        <td>Année:</td>
                        <td>{{ vehicule.annee }}</td>
                    </tr>
                    <tr>
                        <td>Kilométrage:</td>
                        <td>{{ vehicule.kilometrage }}km</td>
                    </tr>
                    <tr>
                        <td>Energie:</td>
                        <td>{{ vehicule.energie }}</td>
                    </tr>
                    <tr>
                        <td>Puissance:</td>
                        <td>{{ vehicule.puissance }}ch</td>
                    </tr>
                    <tr>
                        <td>Motorisation:</td>
                        <td>{{ vehicule.motorisation }}</td>
                    </tr>
                    <tr>
                        <td>Boite de vitesse:</td>
                        <td>{{ vehicule.boite_vitesse }}</td>
                    </tr>
                </table>
            </div>
                <div class="informations__equipement" v-for="vehicule in vehicules" >
                    <p v-if="showStats" v-for="equipement in vehicule.equipements" :key="equipement.id">{{ equipement.equipement }}</p>
                </div>
        </div>
    </main>

</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .router {
        text-decoration: none
    }
    .btn {
        @include btn-style($primary-color);
        margin: 2em auto;
        display: flex;
        justify-content: space-around;
        align-items: center;
        font-size: 0.8em;

        i {
            color: $primary-color;
        }

        &:hover i {
            color: white;
        }
    }

    .active {
        border-bottom: 2px solid $primary-color;
    }

    .informations {

        margin: auto;

        &__caracteristiques{
            margin-bottom: 2em;
        }

        &__equipement {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            margin: 2em auto;

            p {
                border: 1px solid $dark-grey;
                margin-top: 1em;
                font-size: 0.8em;
                font-weight: 600;
                color: $dark-grey;
                padding: 0.5em 1.5em;
                border-radius: 5px;
            }
        }

        &__title{
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin: auto;
        }
    }


    table {
        font-size: 0.8em;
        font-weight: 600;
        margin: auto;
        height: 50vh;
        width: 100%;
        color: $dark-grey;

        tr {
            border-bottom: 1px solid $dark-grey;

            :last-child {
                text-align: end;
                color: $primary-color;
            }
        }
    }

    .title {
        margin: auto;
        margin-top: 2em;
        font-family: $font-text-nav-card;
    }

    h2,
    h4,
    h5 {
        margin: auto;
        text-align: center;
        font-weight: 600;
    }

    h5 {
        color: $primary-color;
        font-size: 2em;
        font-weight: 900;
        padding: 1em;
    }

    h2 {
        font-weight: 900;
        padding: 0.5em 0;
        font-size: 1.8em;
    }

    h4 {
        font-size: 1.1em;
        font-weight: 500;
    }

    button {
        border: none;
        background-color: white;
        color: $primary-color;
        font-weight: 600;
        margin-right: 1em;
        margin-bottom: 1em;

        &:focus {
            border-bottom: 2px solid $primary-color;
        }
    }

    .photos {
        margin: 5em auto;
    }

    .images,
    .images img{
        width: 100%;
        height: auto;
        margin: 1em auto;
    }

    img {
        border-radius: 3px;
        box-shadow: 2px 2px 10px rgba($color: #000000, $alpha: 0.3);
    }

    @media screen and (min-width: 1000px) {

        main {
            margin-top: 8em;
        }
        
        .row {
            flex-direction: column;
        }

        .photos {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;

            & .images {
                width: 20vw;
            }
        }

    }

</style>