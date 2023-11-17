<script setup>

    import { useRoute } from 'vue-router';

    const route = useRoute()
    const path = route.path


    console.log(path)

</script>

<template>
        <div id="carouselAutoplaying" class="carousel slide" data-bs-ride="carousel" v-if="path == '/'">
            <div class="carousel-inner">
                <div class="carousel-item carousel-image carousel-img-1 active">
                    <div class="carousel-caption d-md-block carousel__text">
                        <h5 class="carousel__text-title">REPARATIONS</h5>
                        <p class="carousel__text-description">Prenez rendez-vous dans notre centre</p>
                        <RouterLink to="/reparations">
                            <button class="carousel__text-button">Appeler maintenant</button>
                        </RouterLink>
                    </div>
                </div>
                <div class="carousel-item carousel-image carousel-img-2">
                    <div class="carousel-caption d-md-block carousel__text">
                        <h5 class="carousel__text-title">VEHICULES D'OCCASION</h5>
                        <p class="carousel__text-description">Achetez votre véhicule d’occasion contrôlée & garantie</p>
                        <RouterLink to="/annonces">
                            <button class="carousel__text-button">Voir les véhicules</button>
                        </RouterLink>
                    </div>
                </div>
                <div class="carousel-item carousel-image carousel-img-3">
                    <div class="carousel-caption d-md-block carousel__text">
                        <h5 class="carousel__text-title">PRENDRE CONTACT</h5>
                        <p class="carousel__text-description">Prenez contact rapidement avec nous</p>
                        <RouterLink to="/contact/0">
                            <button class="carousel__text-button">Envoyer un message</button>
                        </RouterLink>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
    </div>

        <div class="carousel-image carousel-img-1" v-else-if="path == '/reparations'">
            <div class="carousel__text carousel__fix">
                <h5 class="carousel__text-title">REPARATIONS</h5>
                <p class="carousel__text-description">Prenez rendez-vous dans notre centre</p>
            </div>
        </div>

        <div class="carousel-image carousel-img-3" v-else-if="path == '/contact/0'">
            <div class="carousel__text carousel__fix">
                <h5 class="carousel__text-title">PRENDRE CONTACT</h5>
                <p class="carousel__text-description">Prenez contact rapidement avec nous</p>
            </div>
        </div>

        <div class="carousel-image carousel-img-2" v-else-if="path == '/annonces'">
            <div class="carousel__text carousel__fix">
                <h5 class="carousel__text-title">VEHICULES D'OCCASION</h5>
                <p class="carousel__text-description">Achetez votre véhicule d’occasion contrôlée & garantie</p>
            </div>
        </div>

        <div class="carousel-image carousel-img-2" v-else>
            <div class="carousel__text carousel__fix">
            </div>
        </div>        
</template>

<style lang="scss" scoped>

    .carousel-img-1 {
        background: url("http://gregory-wolff.com/images/slide__repair-background(3).png");
    }

    .carousel-img-2 {
        background: url("http://gregory-wolff.com/images/198373918_l_normal_none 1(5).png");
    }

    .carousel-img-3 {
        background: url("http://gregory-wolff.com/images/212596211_l_normal_none.jpg");
    }

    .carousel-img-4 {
        background: url('http://gregory-wolff.com/images/198647702_l_normal_none.jpg');
    }

    .carousel-image {
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        height: 35vh;
    }
    .carousel__text{
        color: white;
        text-align: center;
        transform: translate(0%, -80%);

        &-title{
            font-size: 1.6em;
            text-shadow: 2px 2px 4px rgba($color: #000000, $alpha: 0.5);
        }

        &-button {
            border: 3px solid white;
            border-radius: 5px;
            color: white;
            background: none;
            padding: 0.5em 2em;
            font-size: 0.9em;
            margin-bottom: 1em;
            text-shadow: 2px 2px 4px rgba($color: #000000, $alpha: 0.5);
        }

        & p {
            font-size: 0.8em;
            text-shadow: 2px 2px 4px rgba($color: #000000, $alpha: 0.5);
        }
    }

    .carousel__fix {
        transform: translate(0, 200%);
    }


    @media screen and (min-width: 576px) {

        .carousel__text {

            &-title {
                font-size: 2.5em;
            }

            &-button {
                font-size: 1em;
            }

            & p {
                font-size: 1em;
            }
        }
    }

    @media screen and (min-width: 768px) {

        .carousel-image {
            height: 40vh;
        }

        .carousel-img-1{
            background-position: top center;
        }

        .carousel__text {

        &-title {
                font-size: 3.5em;
            }

            &-button {
                font-size: 1.2em;
            }

            & p {
                font-size: 1.2em;
            }
        }
    }

    @media screen and (min-width: 992px) {

        .carousel-image {
            height: 50vh;
        }

    }

    @media screen and (min-width: 1200px) {

        .carousel-image {
            height: 75vh;
        }

    }

    @media screen and (min-width: 1400px) {

    }


</style>