
<template>
    <div class="error error-img">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <h1>Erreur 404</h1>
        <h2>page non trouvé</h2>
    </div>
</template>

<style lang="scss" scoped>

    .error-img {
        background: url("https://gregory-wolff.com/images/198373918_l_normal_none 1(5).png");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: top center;
        height: 60vh;
    }

    .error {
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.8);

        & i {
            font-size: 6em;
        }

        & h1 {
            font-size: 5em;
        }

        & h2 {
            font-size: 3em;
        }
    }

</style>