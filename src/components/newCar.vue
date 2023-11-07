<script setup>

    import axios from 'axios';
    import { ref } from 'vue';

    const marques = ref([])
    const modeles = ref([])
    const energies = ref([])
    const equipements = ref([])

    const marque = ref()
    const modele = ref()
    const year = ref(0)
    const kilometer = ref(0)
    const motor = ref()
    const power = ref(0)
    const equipement = ref()
    const options = ref([])
    const box = ref()
    const fileName = ref()
    const images = ref([])

    const getCars = async() => {
        await axios
        .post('http://localhost/src/api/addCars.php')
        .then(response => {
            if (response.data.success === true) {
                marques.value = response.data.marques
                modeles.value = response.data.modeles
                energies.value = response.data.energies
                equipements.value = response.data.equipements
            }
        })
        .catch(e => {
            console.error(e)
        })
    }

    const getModel = async() => {
        modeles.value = []
        await axios
        .post('http://localhost/src/api/addCars.php', {
            mark: marque.value
        })
        .then(response => {
            if (response.data.success === true) {
                modeles.value = response.data.modeles
            }
        })
        .catch(e => {
            console.error(e)
        })
    }

    const addOption = (e, option) => {
        e.preventDefault()
        options.value.push(option) 
    }

    const deleteOption = (option) => {
        let index = options.value.indexOf(`${option}`)
        delete options.value[index]

        let p = document.querySelectorAll('p')
        p.forEach(element => {
            if (element.innerHTML == "" || element.innerHTML == option) {
                element.remove()
            }
        })
    }

    const getAdresseFile = (e) => {
        fileName.value = e.target.files[0].name
    }

    getCars()


</script>

<template>
    <main class="row">
        <h2 class="col-10">AJOUTER UN VEHICULE</h2>
        <form class="form col-10">
            <h5>Caracteristiques du véhicule</h5>
            <div class="form__input">
                <input class="form__field" type="file" name="image" id="image" placeholder="Photos" @change="getAdresseFile($event)">
                <label class="form__label" for="image">Photos</label>
            </div>
            <div class="offcanvas__selectdiv">
                    <select class="offcanvas__select" @focusout="getModel()" v-model="marque" name="marque" id="marque">
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
                    <select class="offcanvas__select" name="energie" id="energie">
                        <option value="0" disabled selected>Energie</option>
                        <option v-for="energie in energies" :value="energie">{{ energie.nom }}</option>
                    </select>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="motor" type="text" name="motor" id="motor" placeholder="Motorisation">
                    <label class="form__label" for="motor">Motorisation</label>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="year" type="number" name="year" id="year" placeholder="Année">
                    <label class="form__label" for="year">Année</label>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="kilometer" type="number" name="kilometer" id="kilometer" placeholder="kilométrage">
                    <label class="form__label" for="kilometer">Kilométrage</label>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="power" type="number" name="power" id="power" placeholder="Puissance">
                    <label class="form__label" for="power">Puissance</label>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="box" type="text" name="box" id="box" placeholder="Boite de vitesse">
                    <label class="form__label" for="box">Boite de vitesse</label>
                </div>
                <h5>Equipements et options du véhicule</h5>
                <div class="offcanvas__selectdiv">
                    <select class="offcanvas__select" name="equipement" id="equipement" v-model="equipement">
                        <option value="0" disabled selected>Equipements</option>
                        <option v-for="equipement in equipements" :value="equipement.description">{{ equipement.description}}</option>
                    </select>
                </div>
                <button @click="addOption($event, equipement)"><i class="fa-solid fa-plus"></i>Ajouter un équipement</button>
                <div class="information__equipement">
                    <p v-for="option in options" @click="deleteOption(option)">{{ option }}</p>
                </div>
        </form>
        <button type="button" class="col-8">Enregistrer le véhicule</button>
    </main>
</template>

<style lang="scss" scoped>

@import '@/assets/scss/variable.scss';
@import '@/assets/scss/mixins.scss';


    main {
        background-color: white;
        z-index: 5;
        position: absolute;
        left: 0;
        top: 0;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.4);
    }

    h5 {
        text-align: center;
        font-size: 1.2em;
        padding: 1em;
        margin-bottom: 2em;
    }

    h2 {
        @include h2-main;
        margin-bottom: 1em;
    }

    button {
        @include btn-style($orange-formular);
    }

    .form {
        margin: auto;

        &__input {
            display: flex;
            flex-direction: column;
            color: $orange-formular;
            position: relative;
            padding: 15px 0 0;
            margin-top: 10px;

            &-alert {
                position: relative;
                top: -3em;
                width: 100%;
                text-align: start;
                font-size: 0.6em;
                display: block;
                margin: 0 auto;
                color: red;
                padding-left: 0.2em;
            }
        }

        & p {
            font-size: 1.1em;
            margin-top: 1em;
        }

        & button {
            @include btn-style($orange-formular);
            padding: 0.6em;
            width: 65%;
            display: flex;
            justify-content: space-between;
            margin-top: 0.5em;
        }
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

    .offcanvas__select {
            inset: none;
            appearance: none;
            border: none;
            border-bottom: 2px solid $color-text-dark;
            background-color: white;
            width: 80vw;
            color: $color-text-dark;
            font-size: 0.8em;
        }

        .form__field {
            font-family: inherit;
            border: 0;
            width: 100%;
            border-bottom: 2px solid $color-text-dark;
            outline: 0;
            font-size: 0.8em;
            color: $orange-formular;
            padding: 7px 0;
            background: transparent;
            transition: border-color 0.2s;
            margin: 0.2em auto;
            margin-bottom: 3em;

    &::placeholder {
        color: transparent;
    }

    &:placeholder-shown ~ .form__label {
        font-size: 0.8em;
        cursor: text;
        top: 20px;
    }
    }

    .form__label {
    position: absolute;
    top: 0;
    display: block;
    transition: 0.2s;
    font-size: 0.8em;
    color: $color-text-dark;
    }

    .form__field:focus {
    ~ .form__label {
        position: absolute;
        top: 0;
        display: block;
        transition: 0.2s;
        font-size: 0.9em;
        color: $primary-color;
        font-weight:700;    
    }
    padding-bottom: 6px;  
    font-weight: 700;
    border-width: 3px;
    border-image: linear-gradient(to right, $color-text-dark, $color-text-dark);
    border-image-slice: 1;
    }

    /* reset input */
    .form__field{
    &:required,&:invalid { box-shadow:none; }
    }

    .information__equipement {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            margin: 2em auto;

            p {
                border: 1px solid $dark-grey;
                margin-top: 1em;
                font-size: 0.8em;
                font-weight: 600;
                color: $dark-grey;
                padding: 0.5em 1.5em;
                border-radius: 5px;
                cursor: pointer;
            }
        }

</style>