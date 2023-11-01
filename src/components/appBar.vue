<script setup>

    import { RouterLink, useRoute } from 'vue-router';
    import { ref , watch } from "vue";
    import axios from 'axios';
    import { useCookies } from 'vue3-cookies';

    const route = useRoute()
    const path = ref()
    const countMessages = ref()
    const countUsers = ref()
    const countVehicles = ref()
    const { cookies } = useCookies() 
    const userPermissions = cookies.get('userPermissions')
    const rank = ref()

    //------ WATCHER
    watch(() => route.path, () => {
        path.value = route.path
    })

    //------HTTP REQUEST
    axios
    .post('http://localhost/src/api/dashboard.php', {
        messages: 'getMessages'
    }).then (response => {
        countMessages.value = response.data.nombres
    }).catch (e => {
        console.error(e)
    })

    axios
    .post('http://localhost/src/api/dashboard.php', {
        utilisateurs: 'getUsers'
    }).then (response => {
        countUsers.value = response.data.nombres
    }).catch (e => {
        console.error(e)
    })

    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        countVehicles.value = response.data.nombre_vehicules
    })
    .catch (e => {
        console.error(e)
    })


    //------MOUNTED EXEC
    const userAuthorized = () => {
        if (userPermissions != null) {
                axios
                .post('http://localhost/src/api/authorize.php', {
                    permissions: userPermissions
                }).then (response => {
                    if (response.data.success == true) {
                        rank.value = response.data.rang
                    }
                }).catch (e => {
                    console.error(e)
                })
        }
    }

    userAuthorized()

</script>

<template>
    <div class="bar">
        <RouterLink class="link" to="/dashboard/utilisateurs" v-if="rank<2">
            <div class="bar__btn" :class="{'active': path == '/dashboard/utilisateurs'}">
                <i class="fa-solid fa-users"></i>
                <div class="bar__btn-indicator">
                    <span>{{ countUsers }}</span>
                </div>
            </div>
        </RouterLink>
        <RouterLink class="link" to="/dashboard/parametre" v-if="rank<2">
            <div class="bar__btn" :class="{'active': path == '/dashboard/parametre'}">
                <i class="fa-solid fa-gear"></i>
            </div>
        </RouterLink>
        <RouterLink class="link" to="/dashboard/messages">
            <div class="bar__btn" :class="{'active': path =='/dashboard/messages'}">
                <i class="fa-solid fa-message"></i>
                <div class="bar__btn-indicator">
                    <span>{{ countMessages }}</span>
                </div>
            </div>
        </RouterLink>
        <RouterLink class="link" to="/dashboard/voitures">
            <div class="bar__btn" :class="{'active': path =='/dashboard/voitures'}"> 
                <i class="fa-solid fa-car"></i>
                <div class="bar__btn-indicator">
                    <span>{{ countVehicles }}</span>
                </div>
            </div>
        </RouterLink>
        <div class="bar__btn">
            <i class="fa-regular fa-comment-dots" style="color: #ffffff;"></i>
        </div>
    </div>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .link {
        text-decoration: none;
    }

    .bar {
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 90vw;
        margin: auto;
        height: 9vh;
        position: fixed;
        bottom: 0;
        left: 5vw;
        z-index: 20;

        &__btn {
            background-color: $primary-color;
            height: 9vh;
            width: 9vh;
            @include flex-center;

            & i {
                color: white;
            }

            &-indicator {
                background-color: blue;
                height: 1.2em;
                width: 1.2em;
                border-radius: 50%;
                position: absolute;
                transform: translate(0.8em, -0.8em);
                @include flex-center;
                color: white;

                & span {
                    font-size: 0.6em;
                }
            }
        }
    }

    .active {
        background: none;
        box-shadow: 0 0 8px rgba($color: white, $alpha: 0.8);

        & i {
            color: $primary-color;
        }
    }

</style>