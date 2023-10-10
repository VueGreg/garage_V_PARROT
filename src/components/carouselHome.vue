<script setup>

    const images = [
        {
            id:1, 
            adresse:"http://gregory-wolff.com/images/slide__repair-background.png", 
            title:"REPARATIONS", 
            text:"Prenez rendez-vous dans notre centre"
        },
        {
            id:2,
            adresse:"http://gregory-wolff.com/images/198373918_l_normal_none 1.png",
            title:"VEHICULES D'OCCASION",
            text:"Achetez votre véhicule d’occasion contrôlée & garantie"
        },
        {
            id:3,
            adresse:"http://gregory-wolff.com/images/212596211_l_normal_none.jpg",
            title:"PRENDRE CONTACT",
            text:"Prenez contact rapidement avec nous"
        }
    ]

    console.log(images)

</script>

<template>
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active" v-for="image in images" :key="image.id">
                    <img class="d-block w-100" :src= image.adresse>
                    <div class="carousel-caption d-md-block">
                        <h5>{{ image.title }}</h5>
                        <p>{{ image.text }}</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
    </div>
</template>