<script setup>
import { ref } from 'vue'
import axios from 'axios';

    const logo = ref([])

    axios
    .get("http://localhost/src/api/vitrine.php?nom=Logo")
    .then(response => {
        logo.value = response.data
    })
    .catch(e => {
        console.error(e)
    })

</script>

<template>
    <header>
        <div class="logo">
            <img class="logo__image" :src="logo.data.images[0].adresse" :alt="logo.data.images[0].alt">
            <p class="logo__text">GARAGE V.PARROT</p>
        </div>

        <div class="button">
            <!--Call btn-->
            <div class="button__header">
                <div class="button__header-circle">
                    <i class="fa-solid fa-phone" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Appeler</p>
            </div>

            <!--Schedule btn-->
            <div class="button__header">
                <div class="button__header-circle">
                    <i class="fa-solid fa-clock" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Horaires</p>
            </div>

            <div class="button__header">
                <div class="button__header-circle">
                    <i class="fa-solid fa-arrow-right-to-bracket" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Connexion</p>
            </div>
        </div>
    </header>
</template>

<style lang="scss" scoped>
@import '@/assets/scss/variable.scss';

    header {
        background-color: $dark-grey;
        height: 22vh;
    }
    .logo{
        display: flex;
        justify-content: center;
        align-items: center;

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

    .button{
        display: flex;
        justify-content: space-around;
        align-items: center;

        &__header{
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 32vw;

            &-circle{
                border-radius: 50%;
                background-color: $primary-color;
                height: 30px;
                width: 30px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            &-text{
                color: #a3a3a3;
                font-family: $font-text-primary;
                font-size: 1em;
                font-weight: 600;
            }
        }
    }
</style>