<script setup>

    import { useCookies } from 'vue3-cookies';
    import { RouterView, useRouter } from "vue-router";
    import api from '../../urlAPI';

    const { cookies } = useCookies();

    const userPermissions = cookies.get('userPermissions')
    const name = cookies.get('userName')
    const surname = cookies.get('userSurname')

    const router = useRouter()


    const userAuthorized = () => {
        if (userPermissions != null || name != null || surname != null) {
                api.post('/authorize.php', {
                    permissions: userPermissions
                }).then (response => {
                    if (response.data.success == false) {
                        router.push({ name: 'erreur'})
                    }
                }).catch (e => {
                    router.push({ name: 'erreur'}) 
                })
        }
    }

    userAuthorized()
    
    const upperName = name.toUpperCase()
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
        background-image: url('https://gregory-wolff.com/images/198647702_l_normal_none.jpg');
        height: 35vh;
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

    @media screen and (min-width: 576px) {
        h1 {
            width: 80vw;
        }
    }

    @media screen and (min-width: 768px) {

        .dashboard__header {
            height: 40vh;
            margin-bottom: 10em;
        }
    }

    @media screen and (min-width: 992px) {

        .dashboard__header {
            height: 50vh;
        }

    }

    @media screen and (min-width: 1200px) {

        .dashboard__header {
            height: 75vh;
        }

    }

</style>