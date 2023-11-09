<script setup>

    import axios from 'axios';
    import { useRoute } from 'vue-router';
    import { ref, watch } from 'vue';

    const route = useRoute()
    const vehicules = ref ([])
    const showStats = ref(false)
    const equipements = ref([])
    const asChange = ref(false)
    const listOptions = ref([])

    const carId = parseInt(route.params.id)

    //------v-models
    const year = ref()
    const kilometer = ref()
    const energy = ref()
    const power = ref()
    const motor = ref()
    const box = ref()
    const finish = ref()
    const equipement = ref([])

    axios
    .post('http://localhost/src/api/vehicle.php', {
        annonce: carId
    })
    .then (response => {
        vehicules.value = response.data
        equipements.value = response.data[0].equipements
    })
    .catch (e => {
        console.error(e)
    })

    axios
    .post('http://localhost/src/api/addCars.php')
    .then (response => {
        listOptions.value = response.data.equipements
    })
    .catch (e => {
        console.error(e)
    })

    const deleteOption = async(option) => {
        await axios
        .put('http://localhost/src/api/vehicle.php', {
            option: option,
            annonce: carId
        })
        .then(response => {
            equipements.value = []
            equipements.value = response.data.equipements
        })
        .catch (e => {
            console.error(e)
        })
    }

    const addOption = async(option) => {
        await axios
        .put('http://localhost/src/api/vehicle.php', {
            addOption: option,
            annonce: carId
        })
        .then(response => {
            equipements.value = []
            equipements.value = response.data.equipements
        })
        .catch (e => {
            console.error(e)
        })
    }

</script>

<template>
    <main class="row">
        <div class="title col-8" v-for="vehicule in vehicules">
            <h2>ANNONCE N° {{ carId }} <br/> {{ vehicule.marque }} {{ vehicule.modele }}</h2>
            <h4>{{ vehicule.motorisation }}</h4>
            <h5>{{ vehicule.prix }}€</h5>
            <button class="btn" type="button"><i class="fa-solid fa-check"></i><span>Mettre le vehicule en "VENDU"</span></button>
        </div>

        <div class="photos col-8" v-for="vehicule in vehicules">
            <div class="images" v-for="image in vehicule.images" :key="image.id">
                <img :src="image.photo" alt="">
            </div>
        </div>
        
        <div class="informations col-8">

            <div class="informations__title">
                        <button @click="showStats=false" :class="{active: !showStats}">Caractéristiques</button>
                        <button @click="showStats=true" :class="{active: showStats}">Equipements</button>
            </div>
            <div class="informations__caracteristiques" v-if="!showStats" v-for="vehicule in vehicules">
                <table class="table-responsive">
                    <tr>
                        <td>Année:</td>
                        <td><input v-model="year" type="text" name="year" id="year" :placeholder="vehicule.annee"></td>
                    </tr>
                    <tr>
                        <td>Kilométrage:</td>
                        <td><input v-model="kilometer" type="text" name="kilometer" id="kilometer" :placeholder="vehicule.kilometrage"></td>
                    </tr>
                    <tr>
                        <td>Energie:</td>
                        <td><input v-model="energy" type="text" name="energy" id="energy" :placeholder="vehicule.energie"></td>
                    </tr>
                    <tr>
                        <td>Puissance:</td>
                        <td><input v-model="power" type="text" name="power" id="power" :placeholder="vehicule.puissance"></td>
                    </tr>
                    <tr>
                        <td>Motorisation:</td>
                        <td><input v-model="motor" type="text" name="motor" id="motor" :placeholder="vehicule.motorisation"></td>
                    </tr>
                    <tr>
                        <td>Boite de vitesse:</td>
                        <td><input v-model="box" type="text" name="box" id="box" :placeholder="vehicule.boite_vitesse"></td>
                    </tr>
                    <tr>
                        <td>Finition:</td>
                        <td><input v-model="finish" type="text" name="finish" id="finish" :placeholder="vehicule.finition"></td>
                    </tr>
                </table>
            </div>
                <div class="informations__equipement">
                    <div class="offcanvas__selectdiv">
                        <select class="offcanvas__select" name="equipement" id="equipement" v-model="equipement" v-if="showStats">
                            <option value="0" disabled selected>Equipements</option>
                            <option v-for="option in listOptions" :value="option.id">{{ option.description }}</option>
                        </select>
                    </div>
                    <button class="btn" @click="addOption(equipement)" v-if="showStats"><i class="fa-solid fa-plus"></i>Ajouter un équipement</button>
                    <div class="informations__equipement-module" v-if="showStats" v-for="equipement in equipements" :key="equipement.id"
                            @click="deleteOption(equipement.id)">
                        <p>{{ equipement.equipement }}</p>
                        <span><i class="fa-solid fa-xmark"></i></span>
                    </div>
                    <button class="btn" type="button" v-if="asChange && !showStats">Envoyer les modification</button>
                </div>
        </div>
    </main>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .router {
        text-decoration: none
    }
    .btn {
        @include btn-style($primary-color);
        margin: 2em auto;
        display: flex;
        justify-content: space-around;
        align-items: center;
        font-size: 1em;

        i {
            color: $primary-color;
        }

        &:hover i {
            color: white;
        }
    }

    .active {
        border-bottom: 2px solid $primary-color;
    }

    .informations {

        margin: auto;

        &__caracteristiques{
            margin-bottom: 2em;
        }

        &__equipement {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            margin: 2em auto;
            margin-bottom: 3em;

            & button {
                padding: 0.8em;
                width: 100%;
                margin-top: 0;
            }

            &-module {
                border: 1px solid $dark-grey;
                margin-top: 1em;
                font-size: 0.8em;
                font-weight: 600;
                color: $dark-grey;
                padding: 0.5em 1.5em;
                border-radius: 5px;
                @include flex-center;

                & p {
                    padding: 0;
                    margin: 0;
                }

                & span {
                    border: 2px solid $primary-color;
                    border-radius: 50%;
                    position: relative;
                    transform: translate(2.3em, -1.3em);
                    background-color: white;
                    height: 1.2em;
                    width: 1.2em;
                    text-align: center;
                }
            }
        }

        &__title{
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin: auto;
        }
    }


    table {
        font-size: 0.8em;
        font-weight: 600;
        margin: auto;
        height: 50vh;
        width: 100%;
        color: $dark-grey;

        tr {
            border-bottom: 1px solid $dark-grey;

            :last-child {
                text-align: end;
                color: $dark-grey;
            }
        }

        td input {
            border: none;
            font-weight: 600;
            height: 100%;
            width: 100%;

            &::placeholder {
                opacity: 1;
                font-weight: 600;
                color: $primary-color;
            }

            &:focus {
                font-weight: 600;
                font-size: 1.2em;
                outline: none;
                opacity: 0.4;
            }
        }
    }

    .title {
        margin: auto;
        margin-top: 2em;
        font-family: $font-text-nav-card;

        & button {
            font-weight: 600;
            display: flex;
            justify-content: space-around;
            padding: 1em;
            width: 90%;
            margin-top: 0;
        }
    }

    h2,
    h4,
    h5 {
        margin: auto;
        text-align: center;
        font-weight: 600;
    }

    h5 {
        color: $primary-color;
        font-size: 2em;
        font-weight: 900;
        padding: 1em;
    }

    h2 {
        font-weight: 900;
        padding: 0.5em 0;
        font-size: 1.8em;
    }

    h4 {
        font-size: 1.1em;
        font-weight: 500;
    }

    button {
        border: none;
        background-color: white;
        color: $primary-color;
        font-weight: 600;
        margin-right: 1em;
        margin-bottom: 1em;

        &:focus {
            border-bottom: 2px solid $primary-color;
        }
    }

    .photos {
        margin: auto;
    }

    .images,
    .images img{
        width: 100%;
        height: auto;
        margin: 1em auto;
    }

    img {
        border-radius: 3px;
        box-shadow: 2px 2px 10px rgba($color: #000000, $alpha: 0.3);
    }

    .offcanvas__selectdiv {

        &:after {
            content: '\2304';
            font-size: 30px;
            position: relative;
            left: 58vw;
            top: -7vh;
            color: $color-text-dark;
        }
    }

    .offcanvas__select {
        inset: none;
        appearance: none;
        border: none;
        border-bottom: 2px solid $color-text-dark;
        background-color: white;
        width: 60vw;
        color: $color-text-dark;
        font-size: 0.9em;
        height: 2em;
    }

</style>