<script setup>
    import axios from 'axios';
    import ReseauxSociaux from '../components/reseauxSociaux.vue';
    import { ref } from "vue";

    const prestations = ref([])
    const categories = ref ([])

    axios
    .get('http://localhost/src/api/vitrine.php')
    .then(response => {
        prestations.value = response.data.reparations
        categories.value = response.data.categorie_reparations
    })
    .catch(e => {
        console.error(e)
    })

</script>

<template>
    <main class="row">
        <h2 class="col-10">RETROUVEZ L'ENSEMBLE DE NOS PRESTATIONS</h2>
        <section>
            <div class="repair__card col-10 col-sm-7" v-for="categorie in categories" :key="categorie.id">
                <h4 class="repair__card-title">{{ categorie.categorie }}</h4>
                <div class="repair__card-description" v-for="prestation in prestations" :key="prestation.id">
                    <ul>
                        <li class="repair__card-list" v-if="prestation.categorie == categorie.categorie">{{ prestation.description }}</li>
                    </ul>
                </div>
            </div>
        </section>
    </main>
    <ReseauxSociaux/>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    h2{
        @include h2-main;
    }

    .repair__card {
        border-radius: 5px;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.2);
        padding: 1em;
        margin: 3em auto;
        font-size: 0.8em;
        color: $color-text-dark;
        border: 1px solid rgba($color: $color-text-dark, $alpha: 0.4);

        &-title {
            font-size: 1.4em;
            margin: 2em 1em;
            text-decoration: underline;
        }

        &-list {
            list-style: none;
            display: flex;
            align-items: center;
            height: 3em;

            &::before {
                content: '';
                display: inline-block;
                height: 2rem;
                width: 2rem;
                background-image: url('http://gregory-wolff.com/images/wepik-geometric-gradient-brandname-logo-20230927155932MPVN.png');
                background-size: contain;
                background-repeat: no-repeat;
            }
        }
    }

</style>