<script setup>

    const images = [
        {
            id:1, 
            adresse:"http://gregory-wolff.com/images/slide__repair-background(3).png", 
            title:"REPARATIONS", 
            text:"Prenez rendez-vous dans notre centre",
            button:"Appeler maintenant",
            link:""
        },
        {
            id:2,
            adresse:"http://gregory-wolff.com/images/198373918_l_normal_none 1(5).png",
            title:"VEHICULES D'OCCASION",
            text:"Achetez votre véhicule d’occasion contrôlée & garantie",
            button:"Voir les véhicules",
            link:""
        },
        {
            id:3,
            adresse:"http://gregory-wolff.com/images/212596211_l_normal_none.jpg",
            title:"PRENDRE CONTACT",
            text:"Prenez contact rapidement avec nous",
            button:"Envoyer un message",
            link:"/contact/0"
        }
    ]

</script>

<template>
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" v-for="image in images" :key="image.id">
                    <img class="d-block w-100" :src= image.adresse>
                    <div class="carousel-caption d-md-block carousel__text">
                        <h5 class="carousel__text-title">{{ image.title }}</h5>
                        <p class="carousel__text-description">{{ image.text }}</p>
                        <RouterLink :to="image.link">
                            <button class="carousel__text-button">{{ image.button }}</button>
                        </RouterLink>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
    </div>
</template>

<style lang="scss" scoped>

    .carousel__text{
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

    .d-block {
        height: 35vh;
    }

</style>