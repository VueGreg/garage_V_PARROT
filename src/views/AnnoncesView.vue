<script setup>
    import axios from 'axios'
    import { ref, watch } from 'vue';

    const annonces = ref([])
    const modeles = ref([])
    const arrayMarque = ref([])
    const uniqueMarque= ref([])
    const energies = ref([])
    const arrayEnergie = ref([])
    const uniqueEnergie = ref([])

    const marque = ref()
    const modele = ref()
    const energie = ref()
    const prixMin = ref(40)
    const prixMax = ref(60)
    const kilometerMax = ref(40)
    const kilometerMin = ref(60)
    const yearMax = ref(2010)
    const yearMin = ref(1990)

    //HTTP REQUEST-------------------------------------------------

    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        annonces.value = response.data.annonces
        getModeles(annonces.value)
        getEnergie(annonces.value)
        filterTable(annonces.value, uniqueMarque, arrayMarque)
        //filterTableEnergie(annonces.value, uniqueEnergie, arrayEnergie)
    })
    .catch (e => {
        console.error(e)
    })

    //WATCHER-------------------------------------------------

    watch(() => marque.value, () => {
        modeles.value = []
        getModeles(annonces.value, marque.value)
        energies.value = []
        getEnergie(annonces.value)
    })

    watch(() => modele.value, () => {
        energies.value = []
        getEnergie(annonces.value, modele.value)
    })

    watch(() => prixMin.value, () => {
        document.querySelector('#outputPriceMini').style.left = prixMin.value * 3 + 'px'
    })

    watch(() => prixMax.value, () => {
        document.querySelector('#outputPriceMaxi').style.left = prixMax.value * 3 + 'px'
    })

    watch(() => kilometerMin.value, () => {
        document.querySelector('#outputKilometerMin').style.left = kilometerMin.value * 3 + 'px'
    })

    watch(() => kilometerMax.value, () => {
        document.querySelector('#outputKilometerMax').style.left = kilometerMax.value * 3 + 'px'
    })

    watch(() => yearMin.value, () => {
        document.querySelector('#outputYearMin').style.left = (yearMin.value-1980) * 3 + 'px'
    })

    watch(() => yearMax.value, () => {
        document.querySelector('#outputYearMax').style.left = (yearMax.value-1950) * 3 + 'px'
    })


    //FUNCTIONS-------------------------------------------------

    const getModeles = (array, mark = null) => {
        array.forEach(annonce => {
            if (annonce.marque == mark && mark != null) {
                modeles.value.push(annonce.modele)
            }else if (mark == null) {
                modeles.value.push(annonce.modele)
            }
        })
    }

    const getEnergie = (array, mod = null) => {
        array.forEach(annonce => {
            if (annonce.modele == mod && mod != null) {
                energies.value.push(annonce.energie)
            }else if (mod == null) {
                energies.value.push(annonce.energie)
            }
        })
    }

    const filterTable = (arraySearch, uniqueTable, pushTable) => {
        arraySearch.forEach(element => {
            pushTable.value.push(element.marque)
            uniqueTable.value = pushTable.value.filter((x, i) => pushTable.value.indexOf(x) === i);
        })
    }

    const filterTableEnergie = (arraySearch, uniqueTable, pushTable) => {
        arraySearch.forEach(element => {
            pushTable.value.push(element.energie)
            uniqueTable.value = pushTable.value.filter((x, i) => pushTable.value.indexOf(x) === i);
        })
    }


</script>

<template>
    <h2>RETROUVEZ TOUS NOS VEHICULES EN VENTE</h2>
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <i class="fa-solid fa-filter" style="color: #ffffff;"></i>
            <span>Filtrer</span>
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Affiner ma recherche</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="offcanvas__row">
                    <div class="offcanvas__selectdiv">
                        <select class="offcanvas__select" v-model="marque" name="marque" id="marque">
                            <option value="0" disabled selected>Marque</option>
                            <option v-for="marque in uniqueMarque" :value="marque">{{ marque }}</option>
                        </select>
                    </div>
                    <div class="offcanvas__selectdiv">
                        <select class="offcanvas__select" v-model="modele" name="modele" id="modele">
                            <option value="0" disabled selected>Modèle</option>
                            <option v-for="modele in modeles" :value="modele">{{ modele }}</option>
                        </select>
                    </div>
                    <div class="offcanvas__selectdiv">
                        <select class="offcanvas__select" v-model="energie" name="energie" id="energie">
                            <option value="0" disabled selected>Energie</option>
                            <option v-for="energie in energies" :value="energie">{{ energie }}</option>
                        </select>
                    </div>
                </div>
                <div class="offcanvas__row">
                    <section class="range-slider">
                        <h6>Prix</h6>
                        <label for="priceMini" id="outputPriceMini" class="output outputOne">{{ prixMin }}</label>
                        <label for="priceMaxi" id="outputPriceMaxi" class="output outputTwo">{{ prixMax }}</label>
                        <span class="full-range"></span>
                        <span class="incl-range"></span>
                        <input id="priceMini" name="priceMini" min="0" max="100" step="1" type="range" v-model="prixMin">
                        <input id="priceMaxi" name="priceMaxi" min="0" max="100" step="1" type="range" v-model="prixMax">
                    </section>

                    <section class="range-slider">
                        <h6>Kilométrage</h6>
                        <label for="kilometerMin" id="outputKilometerMin" class="output outputOne">{{ kilometerMin }}</label>
                        <label for="kilometerMax" id="outputKilometerMax" class="output outputTwo">{{ kilometerMax }}</label>
                        <span class="full-range"></span>
                        <span class="incl-range"></span>
                        <input id="kilometerMin" name="kilometerMin" min="0" max="100" step="1" type="range" v-model="kilometerMin">
                        <input id="kilometerMax" name="kilometerMax" min="0" max="100" step="1" type="range" v-model="kilometerMax">
                    </section>

                    <section class="range-slider">
                        <h6>Année</h6>
                        <label for="yearMin" id="outputYearMin" class="output outputOne">{{ yearMin }}</label>
                        <label for="yearMax" id="outputYearMax" class="output outputTwo">{{ yearMax }}</label>
                        <span class="full-range"></span>
                        <span class="incl-range"></span>
                        <input id="yearMin" name="yearMin" min="1980" max="2023" step="1" type="range" v-model="yearMin">
                        <input id="yearMax" name="yearMax" min="1980" max="2023" step="1" type="range" v-model="yearMax">
                    </section>
                </div>

                <div class="offcanvas__btn">
                    <button>Reinitialiser</button>
                    <button>Rechercher</button>
                </div>
            </div>
        </div>

        <div class="cards" v-for="annonce in annonces" :key="annonce.numero_annonce">
            <RouterLink class="link" active-class="active" :to="`/annonces/${annonce.numero_annonce}`">
            <div class="cards__image">
                <img :src=annonce.photo>
            </div>
            <div class="cards__description">
                <div class="cards__description-title">
                    <h5>{{ annonce.marque }} {{ annonce.modele }}</h5>
                    <p>{{ annonce.motorisation }}</p>
                </div>
                <div class="cards__description-message">
                    <div class="send">
                        <i class="fa-solid fa-envelope" style="color: #f36639;"></i>
                        <p>Demande de renseignement</p>
                    </div>
                    <h3>{{ annonce.prix }}€</h3>
                </div>
            </div>
        </RouterLink>
        </div>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .link {
        text-decoration: none;
        color: $dark-grey;
    }

    p {
        font-size: 0.7em;
    }

    h2,
    p,
    h5,
    h3 {
        margin: 0;
    }

    h3{
        color: $primary-color;
        font-weight: 800;
        font-size: 1.6em;
    }

    h2{
        @include h2-main;
        width: 80vw;
    }

    .cards{
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 80vw;
        margin: 3em auto;
        font-family: $font-text-nav-card;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.3);
        border-radius: 6px;

        &__description{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: start;

            &-title{
                margin-top: 0.5em;
                & p{
                    font-size: 0.8em;
                }
            }

            &-message{
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 75vw;
                margin-top: 1em;
                margin-bottom: 0.5em;
            }
        }

        &__image img{
            width: 100%;
            height: auto;
            border-radius: 6px 6px 0px 0px;
        }
    }

    .btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 50vw;
        margin: auto;

        span {
            padding: 0 1em;
        }
    }

    .offcanvas-header {
        background-color: $dark-grey;
        color: white;
        font-family: $font-text-nav-card;
    }

    .offcanvas__select {
        inset: none;
        appearance: none;
        border: none;
        border-bottom: 2px solid $color-text-dark;
        background-color: white;
        width: 80vw;
        color: $color-text-dark;
        font-size: 1em;
    }

    .offcanvas__selectdiv {

        &:after {
            content: '\2304';
            font-size: 30px;
            position: relative;
            left: 75vw;
            top: -7vh;
            color: $color-text-dark;
        }
    }

    .offcanvas__row {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 1em;
        width: 90%;
        margin: 1em auto 0 auto;
    }

    .offcanvas__btn {
        display: flex;
        justify-content: space-around;
        align-items: center;

        & button {
            @include btn-style($primary-color);
            margin: 0;
        }
    }

    .range-slider {
        position: relative;
        width: 80vw;
        height: 5vh;
        text-align: center;
        margin: 3em;

        & h6 {
            position: absolute;
            bottom: 150%;
            color: $color-text-dark;
        }

        & input {
            pointer-events: none;
            position: absolute;
            overflow: hidden;
            left: 0;
            top: 15px;
            width: 80vw;
            outline: none;
            height: 18px;
            margin: 0;
            padding: 0;

            &::-webkit-slider-thumb {
                pointer-events: all;
                position: relative;
                z-index: 1;
                outline: 0;
            }

            &::-moz-range-thumb {
                pointer-events: all;
                position: relative;
                z-index: 10;
                -moz-appearance: none;
                width: 9px;
            }

            &::-moz-range-track {
                position: relative;
                z-index: -1;
                background-color: rgba(0, 0, 0, 1);
                border: 0;
            }
        }

        & input:last-of-type::-moz-range-track {
            -moz-appearance: none;
            background: none transparent;
            border: 0;
        }

        & input[type=range]::-moz-focus-outer {
            border: 0;
        }
    }
    .output {
        position: absolute;
        border:1px solid #999;
        width: 40px;
        height: 30px;
        text-align: center;
        color: $primary-color;
        border-radius: 4px;
        display: inline-block;
        font: bold 15px/30px Helvetica, Arial;
        bottom: 75%;
        left: 40%;
        transform: translate(-50%, 0);
    }

    .output.outputTwo {
        left: 60%;
    }

    input[type=range] {
        -webkit-appearance: none;
        background: none;
    }

    input[type=range]::-webkit-slider-runnable-track {
        height: 5px;
        border: none;
        border-radius: 3px;
        background: transparent;
    }

    input[type=range]::-ms-track {
        height: 5px;
        background: transparent;
        border: none;
        border-radius: 3px;
    }

    input[type=range]::-moz-range-track {
        height: 5px;
        background: transparent;
        border: none;
        border-radius: 3px;
    }

    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        border: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: #555;
        margin-top: -5px;
        position: relative;
        z-index: 10000;
    }

    input[type=range]::-ms-thumb {
        -webkit-appearance: none;
        border: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: #555;
        margin-top: -5px;
        position: relative;
        z-index: 10000;
    }

    input[type=range]::-moz-range-thumb {
        -webkit-appearance: none;
        border: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: #555;
        margin-top: -5px;
        position: relative;
        z-index: 10000;
    }

    input[type=range]:focus {
        outline: none;
    }

    .full-range,
    .incl-range {
        width: 100%;
        height: 5px;
        left: 0;
        top: 21px;
        position: absolute;
        background: #DDD;
    }

    .incl-range {
        background: rgb(195, 195, 195);
    }

</style>