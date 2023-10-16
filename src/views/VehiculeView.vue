<script setup>

    import axios from 'axios';
    import { useRoute } from 'vue-router';
    import { ref } from 'vue';

    const route = useRoute()
    const vehicule = ref ([])
    const informations = ref ([])
    const showStats = ref(false)

    const carId = route.params.annonce

    axios
    .get(`http://localhost/src/api/vitrine.php?annonce=${carId}`)
    .then (response => {
        if (response.data.success == true) {
            vehicule.value = response.data
            informations.value = response.data.infos
        } else document.location.href="/erreur"; 
    })
    .catch (e => {
        console.error(e)
    })

</script>

<template>
    <div class="title" v-for="info in informations">
        <h2>{{ info.marque }} {{ info.modele }}</h2>
        <h4>{{ info.motorisation }}</h4>
        <h5>{{ info.prix }}€</h5>
    </div>

    <div class="btn">
        <i class="fa-solid fa-envelope" style="color: #f36639;"></i>
        <span>Je souhaite en savoir plus</span>
    </div>

        <div class="images" v-for="image in vehicule.images" :key="image.id">
            <img :src="image.photo" alt="">
        </div>
    
    <div class="informations">

        <div class="informations__title">
                    <button @click="showStats=false" :class="{active: !showStats}">Caractéristiques</button>
                    <button @click="showStats=true" :class="{active: showStats}">Equipements</button>
        </div>
        <div class="informations__caracteristiques" v-if="!showStats" v-for="info in informations">
            <table class="table-responsive">
                <tr>
                    <td>Année:</td>
                    <td>{{ info.annee }}</td>
                </tr>
                <tr>
                    <td>Kilométrage:</td>
                    <td>{{ info.kilometrage }}km</td>
                </tr>
                <tr>
                    <td>Energie:</td>
                    <td>{{ info.energie }}</td>
                </tr>
                <tr>
                    <td>Puissance:</td>
                    <td>{{ info.puissance }}ch</td>
                </tr>
                <tr>
                    <td>Motorisation:</td>
                    <td>{{ info.motorisation }}</td>
                </tr>
                <tr>
                    <td>Boite de vitesse:</td>
                    <td>{{ info.boite_vitesse }}</td>
                </tr>
            </table>
        </div>
            <div class="informations__equipement" >
                <p v-if="showStats" v-for="equipement in vehicule.equipement" :key="equipement.id">{{ equipement.equipement }}</p>
            </div>
    </div>

    <div class="btn">
        <i class="fa-solid fa-envelope"></i>
        <span>Je souhaite en savoir plus</span>
    </div>

</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .btn {
        @include btn-style($primary-color);
        width: 50vw;
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

        &__caracteristiques{
            margin-bottom: 2em;
        }

        &__equipement {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            margin: 2em auto;
            width: 80vw;

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
            width: 80vw;
            margin: auto;
        }
    }


    table {
        font-size: 0.8em;
        font-weight: 600;
        width: 80vw;
        margin: auto;
        height: 50vh;
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
        margin-top: 2em;
        font-family: $font-text-nav-card;
    }

    h2,
    h4,
    h5 {
        width: 80vw;
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


    .images,
    .images img{
        width: 80vw;
        height: auto;
        margin: 2em auto;
    }

</style>