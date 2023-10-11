<template>
    <section class="container text-center expertise">
            <h2 class="expertise__title">NOTRE SAVOIR FAIRE</h2>
            <img class="expertise__image" src="http://gregory-wolff.com/images/123919893_l_normal_none.jpg" alt="">
            <p class="expertise__text">
                Intervenant sur tous les types de véhicules , votre mécanicien V.PARROT vous propose des réparations de mécaniques respectueuses des données constructeur autant dans le remplacement des pièces moteur que des organes de distribution, systèmes de freinage, amortisseurs… 
                Notre expert en mécanique générale se tient à votre disposition pour réaliser le diagnostic de la panne ou du dysfonctionnement de votre véhicule et pour vous remettre un devis détaillé et transparent sur les réparations à prévoir. Au sein de notre garage automobile, nous intervenons sur plusieurs types de pannes avec des solutions de réparations sur mesure et avec la garantie de repartir au volant avec un véhicule parfaitement sécurisé.
            </p>
    </section>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .expertise{
        background-color: $light-grey;
        padding: 1em;

        &__title {
            @include h2-main;
        }

        &__image {
            width: 80vw;
            height: auto;
        }

        &__text{
            width: 80vw;
            margin: 3em auto;
            font-size: 0.9em;
        }
    }

</style>