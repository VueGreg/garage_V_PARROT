<script setup>

    import { RouterLink } from 'vue-router';

</script>

<template>
    <div class="bar">
        <RouterLink class="link" to="/dashboard/utilisateurs">
            <div class="bar__btn">
                <i class="fa-solid fa-users" style="color: #ffffff;"></i>
            </div>
        </RouterLink>
        <div class="bar__btn">
            <i class="fa-solid fa-gear" style="color: #ffffff;"></i>
        </div>
        <RouterLink class="link" to="/dashboard/messages">
            <div class="bar__btn">
                <i class="fa-solid fa-message" style="color: #ffffff;"></i>
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
        }
    }

</style>