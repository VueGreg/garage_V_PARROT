<script setup>
    import { RouterLink, useRoute } from 'vue-router';
    import { watch , ref } from 'vue';
    import { useCookies } from 'vue3-cookies';
    
    const route = useRoute()
    const routeName = ref("")
    const isConnect = ref(false)
    const { cookies } = useCookies()

    const userPermissions = cookies.get('userPermissions')



    watch(() => route.name, () => {
        routeName.value = route.name
    })

    watch(() => route.path, () => {
        if (userPermissions != null) {
            isConnect.value = true
        }else isConnect.value = false
    }) 

</script>


<template>
    <nav class="navbar navbar-expand-lg navbar-dark nav__navigate">
    <div class="container-fluid">
            <RouterLink class="nav__navigate-link" :class="{ 'active': routeName === 'Acceuil' || routeName === undefined }" to="/">Acceuil</RouterLink>
            <RouterLink class="nav__navigate-link" :class="{ 'active': routeName === 'reparations'}" to="/reparations">Reparation</RouterLink>
            <RouterLink class="nav__navigate-link" :class="{ 'active': routeName === 'Annonces'}" to="/annonces">Véhicules d'occasion</RouterLink>
        <button class="nav__navigate-btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <RouterLink class="nav__navigate-link" active-class="active" to="/contact/0">Contact</RouterLink>
            <a class="nav__navigate-link" href="#">A propos</a>
            <RouterLink class="nav__navigate-link" to="/dashboard/messages" v-if="isConnect">Tableau de bord</RouterLink>
        </div>
        </div>
    </div>
</nav>
</template>

<style lang="scss" scoped>
@import '@/assets/scss/variable.scss';
@import '@/assets/scss/mixins.scss';

    .active {

        color: $dark-grey;

        &:focus{
                color: $dark-grey;
            }

        &:focus::before{
            content: '';
            position: absolute;
            width: 120%;
            height: 140%;
            border-bottom: 5px solid rgb(255, 255, 255);
            translate: -8%;
        }
    }
    .nav__navigate{
        background-color: $primary-color;

        &-link{
            text-decoration: none;
            color: white;
            font-family: $font-text-nav-card;
            font-weight: 500;
            position: relative;

            &:focus{
                color: $dark-grey;
            }

            &:focus::before{
                content: '';
                position: absolute;
                width: 120%;
                height: 140%;
                border-bottom: 5px solid rgb(255, 255, 255);
                translate: -8%;
            }
        }

        &-btn{
            background-color: $primary-color;
            border: none;
        }
    }

    @keyframes animate {
        0%{
            width: 0;
        }
        100%{
            width: 100%;
        }
    }

    @media screen and (min-width: 900px) {
        .container-fluid{
            width: 80vw;
            display: flex;
            justify-content: space-around;

            a{
                padding: 1em;
            }
        }

        .nav__navigate-link{

            &:focus::before{
                content: '';
                position: absolute;
                width: 100%;
                height: 85%;
                border-bottom: 5px solid rgb(255, 255, 255);
                translate: -10%;
            }

            &:hover::before{
                content: '';
                position: absolute;
                width: 100%;
                height: 85%;
                border-bottom: 5px solid rgb(255, 255, 255);
                translate: -10%;
                animation: animate 0.2s linear;
            }
        }
    }
</style>