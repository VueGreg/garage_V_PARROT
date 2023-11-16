<script setup>
    import axios from 'axios'
    import { ref, watch } from 'vue';
    import { useCookies } from 'vue3-cookies';
    import appBar from '../components/appBar.vue';
    import newCar from "../components/newCar.vue";
    import carouselHome from '../components/carouselHome.vue';

    //Cookies
    const { cookies } = useCookies()
    const userPermissions = cookies.get('userPermissions')
    const isConnect = ref(false)
    const isClick = ref(false)

    const annonces = ref([])
    const countAnnonces = ref()

    const marques = ref([])
    const modeles = ref([])
    const energies = ref([])

    //models
    const marque = ref("")
    const modele = ref("")
    const energie = ref("")
    const prixMin = ref(9790)
    const prixMax = ref(31099)
    const kilometerMin = ref(8600)
    const kilometerMax = ref(152900)
    const yearMin = ref(2010)
    const yearMax = ref(2021)

    const yearMaxRequest = ref()
    const yearMinRequest = ref()
    const kilometerMaxRequest = ref()
    const kilometerMinRequest = ref()
    const prixMaxRequest = ref()
    const prixMinRequest = ref()


    //HTTP REQUEST-------------------------------------------------

    axios
    .get('http://localhost/src/api/filter.php')
    .then (response => {
        marques.value = response.data.marque
        modeles.value = response.data.modele
        energies.value = response.data.energie
        yearMinRequest.value = response.data.annee_min
        yearMaxRequest.value = response.data.annee_max
        kilometerMinRequest.value = response.data.kilometre_min
        kilometerMaxRequest.value = response.data.kilometre_max
        prixMinRequest.value = response.data.prix_min
        prixMaxRequest.value = response.data.prix_max
    })
    .catch (e => {
        console.error(e)
    })


    if (annonces.value.length == 0) {
        axios
        .post('http://localhost/src/api/vehicle.php')
        .then (response => {
            response.data.forEach(element => {
                if (element.status == 0) {
                    annonces.value.push(element)
                }
            })
            countAnnonces.value = annonces.value.length
        })
        .catch (e => {
            console.error(e)
        })
    }

    //WATCHER-------------------------------------------------

    watch(() => marque.value, () => {
        axios
        .get(`http://localhost/src/api/filter.php?mark=${marque.value}`)
        .then (response => {
            modeles.value = []
            energies.value = []
            energie.value = ""
            modeles.value = response.data.modele
            energies.value = response.data.energie
        })
        .catch (e => {
            console.error(e)
        })
    })

    watch(() => modele.value, () => {
        axios
        .get(`http://localhost/src/api/filter.php?model=${modele.value}`)
        .then (response => {
            energies.value = []
            energies.value = response.data.energie
        })
        .catch (e => {
            console.error(e)
        })
    })


    watch(() => prixMin.value, () => {
        document.querySelector('.outputPriceMini').style.left = prixMin.value / 167 + 'px'
    })

    watch(() => prixMax.value, () => {
        document.querySelector('.outputPriceMaxi').style.left = prixMax.value / 167 + 'px'
    })

    watch(() => kilometerMin.value, (event) => {
        document.querySelector('.outputKilometerMin').style.left = kilometerMin.value / 700 + 'px'
    })

    watch(() => kilometerMax.value, (event) => {
        document.querySelector('.outputKilometerMax').style.left = kilometerMax.value / 700 + 'px'
    })

    watch(() => yearMin.value, () => {
        document.querySelector('.outputYearMin').style.left = (yearMin.value-yearMinRequest.value) * 20 + 'px'
    })

    watch(() => yearMax.value, () => {
        document.querySelector('.outputYearMax').style.left = (yearMax.value-yearMinRequest.value) * 20 + 'px'
    })


    //FUNCTIONS-------------------------------------------------

    const initialize = (e) => {
        e.preventDefault()

        marque.value = ""
        modele.value = ""
        energie.value = ""
        prixMin.value = prixMinRequest.value
        prixMax.value = prixMaxRequest.value
        kilometerMin.value = kilometerMinRequest.value
        kilometerMax.value = kilometerMaxRequest.value
        yearMin.value = 2010
        yearMax.value = 2021

        searchCars(e)
    }

    const searchCars = async(e) => {
        e.preventDefault()
        await axios
        .post('http://localhost/src/api/vehicle.php', {
            mark: marque.value,
            model: modele.value,
            energy: energie.value,
            minyear: yearMin.value,
            maxyear: yearMax.value,
            minkilometer: kilometerMin.value,
            maxkilometer: kilometerMax.value,
            minprice: prixMin.value,
            maxprice: prixMax.value
        })
        .then(response => {
            annonces.value = []
            annonces.value = response.data
        })
        .catch(e => {
            console.error(e)
        })
    }

     //------MOUNTED EXEC
     const userAuthorized = () => {
        if (userPermissions != null) {
                axios
                .post('http://localhost/src/api/authorize.php', {
                    permissions: userPermissions
                }).then (response => {
                    if (response.data.success == true) {
                        isConnect.value = true
                    }
                }).catch (e => {
                    console.error(e)
                })
        }
    }

    userAuthorized()



</script>

<template>
    <carouselHome/>
    <main class="row">
        <newCar v-if="isConnect && isClick" style="z-index:50;"/>
        <h1 class="col-10 col-sm-8 col-md-6" v-if="isConnect">{{ countAnnonces }}</h1>
        <h2 class="col-10 col-sm-8 col-md-6" v-if="isConnect">VEHICULES EN VENTE</h2>
        <appBar v-if="isConnect"/>
        <h2 class="col-10 col-sm-8 col-md-6" v-else>RETROUVEZ TOUS NOS VEHICULES EN VENTE</h2>
            <button class="btn btn-offcanvas btn-primary col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
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
                            <option v-for="marque in marques" :value="marque">{{ marque }}</option>
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
                        <label for="priceMini" id="outputPriceMini" class="output outputOne">{{ prixMin }}€</label>
                        <label for="priceMaxi" id="outputPriceMaxi" class="output outputTwo">{{ prixMax }}€</label>
                        <span class="full-range"></span>
                        <span class="incl-range"></span>
                        <input id="priceMini" name="priceMini" :min="prixMinRequest" :max="prixMaxRequest" step="100" type="range" v-model="prixMin">
                        <input id="priceMaxi" name="priceMaxi" :min="prixMinRequest" :max="prixMaxRequest" step="100" type="range" v-model="prixMax">
                    </section>

                    <section class="range-slider">
                        <h6>Kilométrage</h6>
                        <label for="kilometerMin" id="outputKilometerMin" class="output outputOne">{{ kilometerMin }}km</label>
                        <label for="kilometerMax" id="outputKilometerMax" class="output outputTwo">{{ kilometerMax }}km</label>
                        <span class="full-range"></span>
                        <span class="incl-range"></span>
                        <input id="kilometerMin" name="kilometerMin" :min="kilometerMinRequest" :max="kilometerMaxRequest" step="1000" type="range" v-model="kilometerMin">
                        <input id="kilometerMax" name="kilometerMax" :min="kilometerMinRequest" :max="kilometerMaxRequest" step="1000" type="range" v-model="kilometerMax">
                    </section>

                    <section class="range-slider">
                        <h6>Année</h6>
                        <label for="yearMin" id="outputYearMin" class="output outputOne">{{ yearMin }}</label>
                        <label for="yearMax" id="outputYearMax" class="output outputTwo">{{ yearMax }}</label>
                        <span class="full-range"></span>
                        <span class="incl-range"></span>
                        <input id="yearMin" name="yearMin" :min="yearMinRequest" :max="yearMaxRequest" step="1" type="range" v-model="yearMin">
                        <input id="yearMax" name="yearMax" :min="yearMinRequest" :max="yearMaxRequest" step="1" type="range" v-model="yearMax">
                    </section>
                </div>

                <div class="offcanvas__btn">
                    <button @click="initialize()">Reinitialiser</button>
                    <button data-bs-dismiss="offcanvas" @click="searchCars()">Rechercher</button>
                </div>
            </div>
        </div>

        <button v-if="isConnect" class="addbtn col-5" :class="{ closebtn: isClick }"><i class="fa-solid fa-plus" @click="isClick ? isClick=false : isClick=true"></i></button>

        <form>
            <div class="offcanvas__row">
                    <div class="offcanvas__selectdiv">
                        <select class="offcanvas__select" v-model="marque" name="marque" id="marque">
                            <option value="0" disabled selected>Marque</option>
                            <option v-for="marque in marques" :value="marque">{{ marque }}</option>
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
                        <label for="priceMini" class="output outputOne outputPriceMini">{{ prixMin }}€</label>
                        <label for="priceMaxi" class="output outputTwo outputPriceMaxi">{{ prixMax }}€</label>
                        <span class="full-range"></span>
                        <span class="incl-range"></span>
                        <input id="priceMini" name="priceMini" :min="prixMinRequest" :max="prixMaxRequest" step="100" type="range" v-model="prixMin">
                        <input id="priceMaxi" name="priceMaxi" :min="prixMinRequest" :max="prixMaxRequest" step="100" type="range" v-model="prixMax">
                    </section>

                    <section class="range-slider">
                        <h6>Kilométrage</h6>
                        <label for="kilometerMin" class="output outputOne outputKilometerMin">{{ kilometerMin }}km</label>
                        <label for="kilometerMax" class="output outputTwo outputKilometerMax">{{ kilometerMax }}km</label>
                        <span class="full-range"></span>
                        <span class="incl-range"></span>
                        <input id="kilometerMin" name="kilometerMin" :min="kilometerMinRequest" :max="kilometerMaxRequest" step="1000" type="range" v-model="kilometerMin">
                        <input id="kilometerMax" name="kilometerMax" :min="kilometerMinRequest" :max="kilometerMaxRequest" step="1000" type="range" v-model="kilometerMax">
                    </section>

                    <section class="range-slider">
                        <h6>Année</h6>
                        <label for="yearMin" class="output outputOne outputYearMin">{{ yearMin }}</label>
                        <label for="yearMax" class="output outputTwo outputYearMax">{{ yearMax }}</label>
                        <span class="full-range"></span>
                        <span class="incl-range"></span>
                        <input id="yearMin" name="yearMin" :min="yearMinRequest" :max="yearMaxRequest" step="1" type="range" v-model="yearMin">
                        <input id="yearMax" name="yearMax" :min="yearMinRequest" :max="yearMaxRequest" step="1" type="range" v-model="yearMax">
                    </section>
                </div>
                <div class="offcanvas__btn">
                    <button @click="initialize($event)">Reinitialiser</button>
                    <button data-bs-dismiss="offcanvas" @click="searchCars($event)">Rechercher</button>
                </div>
        </form>

        <div class="container__cards col-9 col-sm-6 col-lg-8">
            <div class="cards" v-for="annonce in annonces" :key="annonce.numero_annonce">
                <RouterLink class="link" active-class="active" :to="`/dashboard/vehicule/${annonce.numero_annonce}`" v-if="isConnect">
                    <div class="cards__image">
                        <img :src=annonce.photo>
                    </div>
                    <div class="cards__description">
                        <div class="cards__description-title">
                            <h5>{{ annonce.marque }} {{ annonce.modele }}</h5>
                            <p>{{ annonce.motorisation }}</p>
                        </div>
                        <div class="cards__description-message">
                            <RouterLink class="router" to="/dashboard/messages">
                                <div class="send">
                                    <i class="fa-solid fa-envelope" style="color: #f36639;"></i>
                                    <div class="send__indicator">
                                        <span>{{ annonce.messages }}</span>
                                    </div>
                                    <p>Demande de renseignement</p>
                                </div>
                            </RouterLink>
                            <h3>{{ annonce.prix }}€</h3>
                        </div>
                    </div>
                </RouterLink>
                <RouterLink class="link" active-class="active" :to="`/annonces/${annonce.numero_annonce}`" v-else>
                    <div class="cards__image">
                        <img :src=annonce.photo>
                    </div>
                    <div class="cards__description">
                        <div class="cards__description-title">
                            <h5>{{ annonce.marque }} {{ annonce.modele }}</h5>
                            <p>{{ annonce.motorisation }}</p>
                        </div>
                        <div class="cards__description-message">
                            <RouterLink class="router" :to="`/contact/${annonce.numero_annonce}`">
                                <div class="send">
                                    <i class="fa-solid fa-envelope" style="color: #f36639;"></i>
                                    <p>Demande de renseignement</p>
                                </div>
                            </RouterLink>
                            <h3>{{ annonce.prix }}€</h3>
                        </div>
                    </div>
                </RouterLink>
            </div>
        </div>
    </main>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .link {
        text-decoration: none;
        color: $dark-grey;
    }

    .overflow-hidden {
        overflow-y: hidden;
    }

    p {
        font-size: 0.7em;
    }

    .router {
        text-decoration: none;
    }

    .send {
        display: flex;
        justify-content: center;
        align-items: center;
        
        & p {
            margin-left: 0.5em;
        }

        &__indicator {
            border-radius: 50%;
            background-color: blue;
            width: 1em;
            height: 1em;
            @include flex-center;
            color: white;
            position: absolute;
            transform: translate(-3.5em, -0.6em);

            & span {
                font-size: 0.7em;
            }
        }
    }

    h1 {
        margin: auto;
        text-align: center;
        margin-top: 5em;
        font-size: 2em;
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
        margin-top: 0.5em;
    }

    .addbtn {
        background-color: $primary-color;
        color: white;
        border: none;
        border-radius: 50%;
        width: 2em;
        height: 2em;
        font-size: 1.8em;
        position: fixed;
        right: 0;
        bottom: 20vh;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.4);
        z-index: 100;
        transition: all 0.5s ease-in;
    }

    .closebtn {
        transform: rotate(405deg);
    }

    .container__cards {
        margin: 5em auto;
    }

    .cards{
        display: flex;
        flex-direction: column;
        align-items: center;
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
                margin-left: 0.5em;
                & p{
                    font-size: 0.8em;
                }
            }

            &-message{
                display: flex;
                justify-content: space-around;
                align-items: center;
                width: 100%;
                margin: 1em auto;
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
        margin: auto;

        span {
            padding: 0.5em 1em;
        }
    }

    form {
        display: none;
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
        text-align: center;
        color: $primary-color;
        border-radius: 4px;
        display: inline-block;
        font: bold 15px/30px Helvetica, Arial;
        bottom: 75%;
        left: 0%;
        transform: translate(-50%, 0);
        padding: 0.1em 0.5em;
    }

    .output.outputTwo {
        left: 100%;
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


    @media screen and (min-width: 560px) {

        .row {
            flex-direction: column;
        }

        .container__cards {
            display: flex;
            flex-wrap: wrap;
            margin: 5em auto;

            & .cards{
                width: 50vw;
            }
        }
        
    }

    @media screen and (min-width: 720px) {

        form {
            width: 70vw;
            margin: auto;
            display: block;
        }
        .container__cards .cards {
            width: 40vw;
        }

        .offcanvas,
        .btn-offcanvas {
            display: none;
        }

        .offcanvas__row {
            flex-direction: row;
            justify-content: space-around;
        }

        .offcanvas__select,
        .range-slider input {
            width: 100%;
        }
        .offcanvas__selectdiv,
        .range-slider {
            width: 25%;
        }

        .range-slider {
            margin: 3em 0;

            .output {
                font-size: 0.8em;
            }
        }

        .offcanvas__selectdiv::after {
            left: 90%;
            top: -3.5vh;
        }
    }

    @media screen and (min-width: 940px) {
        .container__cards .cards {
            width: 35vw;
        }

        h2 {
            margin-top: 5em;
        }
    }

    @media screen and (min-width: 1100px) {

        .container__cards .cards {
            width: 28vw;
        }
    }

    @media screen and (min-width: 1300px) {

        .container__cards .cards {
            width: 20vw;
        }
    }
</style>