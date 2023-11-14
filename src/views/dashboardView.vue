<script setup>

    import { useCookies } from 'vue3-cookies';
    import { RouterView } from "vue-router";

    const { cookies } = useCookies();

    const name = cookies.get('userName')
    const upperName = name.toUpperCase()
    const surname = cookies.get('userSurname')
    const upperSurname = surname.toUpperCase()

</script>

<template>
    <div class="dashboard__header">
        <h1>TABLEAU DE BORD DE {{ upperName }} {{ upperSurname }}</h1>
    </div>
    <RouterView />
</template>

<style lang="scss" scoped>

    .dashboard__header {
        background-image: url('http://gregory-wolff.com/images/198647702_l_normal_none.jpg');
        height: 40vh;
        width: auto;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;

        & h1 {
            color: white;
            font-weight: 600;
            text-align: center;
            padding-bottom: 3em;
            text-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.8);
        }
    }

    @media screen and (min-width: 600px) {
        h1 {
            width: 80vw;
        }
    }

    @media screen and (min-width: 960px) {

        .dashboard__header {
            height: 60vh;
            margin-bottom: 10em;
        }
    }

    @media screen and (min-width: 1200px) {

        .dashboard__header {
            height: 75vh;
        }

    }

    @media screen and (min-width: 1700px) {

        .dashboard__header {
            height: 90vh;
        }

    }

</style>