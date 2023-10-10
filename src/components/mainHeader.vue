<script setup>

</script>

<template>
    <header>
        <div class="logo">
            <img class="logo__image" src="http://gregory-wolff.com/images/wepik-geometric-gradient-brandname-logo-20230927155932MPVN.png" alt="Logo de l'entreprise Vincent PARROT">
            <p class="logo__text">GARAGE V.PARROT</p>
        </div>

        <div class="button">
            <!--Call btn-->
            <a class="button__header" href="#">
                <div class="button__header-circle">
                    <i class="fa-solid fa-phone" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Appeler</p>
            </a>

            <!--Schedule btn-->
            <a class="button__header" href="#">
                <div class="button__header-circle">
                    <i class="fa-solid fa-clock" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Horaires</p>
            </a>

            <!--Connection btn-->
            <a class="button__header" href="#">
                <div class="button__header-circle">
                    <i class="fa-solid fa-arrow-right-to-bracket" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Connexion</p>
            </a>
        </div>
    </header>
</template>

<style lang="scss" scoped>
@import '@/assets/scss/variable.scss';
@import '@/assets/scss/mixins.scss';

    header {
        background-color: $dark-grey;
        height: 22vh;
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

    .button{
        display: flex;
        justify-content: space-around;
        align-items: center;

        &__header{
            @include flex-center;
            width: 30vw;
            text-decoration: none;

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
                margin-left: 0.5em;
            }
        }
    }
</style>