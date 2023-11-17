<script setup>
    import axios from 'axios';
    import { ref } from 'vue';

    const informations = ref([])
    const horaires = ref([])

    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        informations.value = response.data.informations
        horaires.value = response.data.horaires
    })
    .catch (e => {
        console.error(e)
    })

</script>

<template>
    <footer class="row">
        <div class="enseigne col-12 col-lg-4">
            <div class="logo">
                <img class="logo__image" src="http://gregory-wolff.com/images/wepik-geometric-gradient-brandname-logo-20230927155932MPVN.png" alt="Logo de l'entreprise Vincent PARROT">
                <p class="logo__text">GARAGE V.PARROT</p>
            </div>
            <div class="action">
                <ul>
                    <li>Achat-Revente de véhicule d'occasion</li>
                    <li>Réparation automobile</li>
                </ul>
            </div>
        </div>
        <div class="commune col-lg-8">
            <div class="footer col-12 col-sm-6">
                <div class="footer__title">
                    <div class="footer__logo">
                        <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i>
                    </div>
                    <p>Information de contact</p>
                </div>
                <div class="footer__text" v-for="information in informations" :key="information.id">
                    <p>{{ information.adresse }}</p>
                    <p>{{ information.code_postal }}  {{ information.ville }}</p>
                    <p>{{ information.num_telephone }}</p>
                    <p class="mail">{{ information.mail }}</p>
                </div>
            </div>

            <div class="footer col-12 col-sm-6">
                <div class="footer__title">
                    <div class="footer__logo">
                        <i class="fa-solid fa-clock" style="color: #ffffff;"></i>
                    </div>
                    <p>Horaires d'ouverture</p>
                </div>
                <div class="footer__text">
                    <table class="footer__text-table">
                        <tr v-for="horaire in horaires" :key="horaire.id">
                            <td>{{ horaire.jour_semaine }}:</td>
                            <td>{{ horaire.h_debut }} / {{ horaire.h_fin }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="copyright col-12">
            <p>Tous droit reservé à l'évaluation ECF STUDI</p>
            <p>Créer par G.WOLFF</p>
        </div>

    </footer>
</template>

<style lang="scss" scoped>

@import '@/assets/scss/variable.scss';
@import '@/assets/scss/mixins.scss';

    
    footer{
        background-color: $dark-grey;
        color: white;
        font-size: 0.8em;
        font-weight: 500;
        margin: 0;
        padding: 0;
    }

    .enseigne{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .logo{
        @include flex-center;

            &__image{
                height: 75px;
                width: auto;
            }

            &__text{
                color: white;
                font-family: $font-text-nav-card;
                font-weight: 600;
                font-size: 1.4em;
            }
    }

    .footer{
        display: flex;
        flex-direction: column;
        align-items: center;
        
        p{
            margin: 0.5em;
        }

        &__title{
            @include flex-center;
            color: #a3a3a3;
            font-weight: 500;
            margin-top: 2em;
            text-decoration: underline;
        }
        
        &__logo{
            @include flex-center;
            background-color: $primary-color;
            border-radius: 50%;
            height: 2em;
            width: 2em;
            position: absolute;
            transform: translateX(-400%);
        }

        &__text{
            padding-bottom: 1em;
            &-table tr :last-child{
                color: $primary-color;
            }
        }
    }

    .mail{
        color: $primary-color;
    }

    .copyright{
        background-color: $primary-color;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        height: 3vh;

        p{
            margin: 0;
            width: auto;
            font-size: 0.7em;
        }
    }

    @media screen and (min-width: 480px) {
        .commune {
            display: flex;
            margin: 2em auto;
        }

        .copyright {
            flex-direction: column;
        }
    }

    @media screen and (min-width: 1000px) {
        .row {
            align-items: center;
        }

        .commune {
            align-items: center;
        }
    }

</style>