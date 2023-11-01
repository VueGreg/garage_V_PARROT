<script setup>

    import { RouterLink, useRoute } from 'vue-router';
    import { ref , watch } from "vue";

    const route = useRoute()
    const path = ref()

    watch(() => route.path, () => {
        path.value = route.path
    })


</script>

<template>
    <div class="bar">
        <RouterLink class="link" to="/dashboard/utilisateurs">
            <div class="bar__btn" :class="{'active': path == '/dashboard/utilisateurs'}">
                <i class="fa-solid fa-users"></i>
            </div>
        </RouterLink>
        <RouterLink class="link" to="/dashboard/parametre">
            <div class="bar__btn" :class="{'active': path == '/dashboard/parametre'}">
                <i class="fa-solid fa-gear"></i>
            </div>
        </RouterLink>
        <RouterLink class="link" to="/dashboard/messages">
            <div class="bar__btn" :class="{'active': path =='/dashboard/messages'}">
                <i class="fa-solid fa-message"></i>
            </div>
        </RouterLink>
        <div class="bar__btn">
            <i class="fa-solid fa-car" style="color: #ffffff;"></i>
        </div>
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