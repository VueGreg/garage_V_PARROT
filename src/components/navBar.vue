<script setup>

</script>


<template>
    <nav class="navbar navbar-expand-lg navbar-dark nav__navigate">
    <div class="container-fluid">
            <a class="nav__navigate-link" href="#">Acceuil</a>
            <a class="nav__navigate-link" href="#">Reparation</a>
            <a class="nav__navigate-link" href="#">Véhicules d'occasion</a>
        <button class="nav__navigate-btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav__navigate-link" href="#">Contacts</a>
            <a class="nav__navigate-link" href="#">A propos</a>
            <a class="nav__navigate-link" href="#">blabla</a>
        </div>
        </div>
    </div>
</nav>
</template>

<style lang="scss" scoped>
@import '@/assets/scss/variable.scss';
@import '@/assets/scss/mixins.scss';
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
    }
</style>