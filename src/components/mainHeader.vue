<script setup>
    import axios from 'axios';
    import { RouterLink } from 'vue-router';
    import { useCookies } from 'vue3-cookies';
    import { ref, watch } from "vue";
    import { useRoute } from 'vue-router';

    const { cookies } = useCookies()
    const userPermissions = cookies.get('userPermissions')
    const isConnect = ref(false)
    const route = useRoute()

    watch(() => route.path, () => {
        if (userPermissions != null) {
            axios
            .post('http://localhost/src/api/authorize.php', {
                permissions: userPermissions
            }).then (response => {
                if (response.data.success == true) {
                    isConnect.value = true
                }else isConnect.value = false
            }).catch (e => {
                console.error(e)
            })
        }else isConnect.value = false
    })

    const removeCookie = () => {
        cookies.remove('userPermissions')
        cookies.remove('userName')
        cookies.remove('userSurname')
        isConnect.value = false
        document.location.href="http://localhost:5173"
    }



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
            <div class="navigate-link button__header" v-if="isConnect" @click="removeCookie()">
                <div class="button__header-circle">
                    <i class="fa-solid fa-arrow-right-to-bracket" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Déconnexion</p>
            </div>
            <RouterLink class="navigate-link button__header" to="/connexion" v-else>
                <div class="button__header-circle">
                    <i class="fa-solid fa-arrow-right-to-bracket" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Connexion</p>
            </RouterLink>
        </div>
    </header>
</template>

<style lang="scss" scoped>
@import '@/assets/scss/variable.scss';
@import '@/assets/scss/mixins.scss';

    header {
        background-color: $dark-grey;
        height: 16vh;
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
                margin-top: 0.8em;
            }
        }
    }

    .navigate-link {
        text-decoration: none;
        cursor: pointer;
    }

    @media screen and (min-width: 580px) {

        header {
            height: 12vh;
        }
        
        .button__header-text {
            margin: 0;
            margin-left: 0.5em;
        }
    }

    @media screen and (min-width: 960px) {

        header {
            height: 8vh;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .button {

            width: 45vw;
        }
    }
</style>