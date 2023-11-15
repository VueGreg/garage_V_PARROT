<script setup>

    import axios from 'axios';
    import { ref, defineEmits } from 'vue'
    import FormData from 'form-data'
    import informationModal from './informationModal.vue';

    const marques = ref([])
    const modeles = ref([])
    const energies = ref([])
    const equipements = ref([])

    const marque = ref(0)
    const modele = ref(0)
    const energie = ref(0)
    const year = ref(0)
    const kilometer = ref(0)
    const motor = ref()
    const power = ref(0)
    const equipement = ref()
    const options = ref([])
    const box = ref()
    const fileName = ref()
    const fileImages = ref([])
    const price = ref(0)
    const finish = ref()
    const optionsDescription = ref([])
    const Form_Data = new FormData()

    //----Modal
    const emit = defineEmits(['close'])
    const isModal = ref(false)
    const messageModal = ref()


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
        equipements.value.forEach(equipement => {
            if (equipement.id == option) {
                optionsDescription.value.push(equipement.description)
            }
        })
    }

    const deleteOption = (option) => {
        let index = optionsDescription.value.indexOf(`${option}`)
        options.value.slice(index, 1)

        let o = optionsDescription.value[index]
        optionsDescription.value.slice(index, 1)


        let p = document.querySelectorAll('p')
        p.forEach(element => {
            if (element.innerHTML == "" || element.innerHTML == o) {
                element.remove()
            }
        })
    }


    const getAdresseFile = (e) => {
        fileName.value = e.target.files[0]
        fileImages.value.push(fileName.value)

        for(let i=0; i< e.target.files.length; i++){
            Form_Data.append('image[]', e.target.files[i])
        }
    }

    const previewPicture = (e) => {
        e.preventDefault()

        let imgs = document.querySelectorAll('.preview__container-img')
        let i = 0
        imgs.forEach(img => {
            img.src = URL.createObjectURL(fileImages.value[i])
            i++
        })
    }

    const deleteImage = (image) => {
        let index = fileImages.value.indexOf(`${image}`)
        delete fileImages.value[index]

        let img = document.querySelectorAll('.preview__container-img')
        img.forEach(element => {
            if (element.innerHTML == "" || element.innerHTML == image) {
                element.remove()
            }
        })
    }

    const sendNewCar = async() => {
        if (modele.value != "Modèle" && energie.value != "Energie" && motor.value != "" && year.value != 0 && kilometer.value != 0 && power.value != 0
        && price.value != 0 && box.value != "" && finish.value != "" && options.value.length != 0 && fileImages.value.length !=  0) {

            Form_Data.append("vehicle", modele.value)
            Form_Data.append("energy", energie.value)
            Form_Data.append("price", price.value)
            Form_Data.append("kilometer", kilometer.value)
            Form_Data.append("year", year.value)
            Form_Data.append("power", power.value)
            Form_Data.append("motor", motor.value)
            Form_Data.append("speedbox", box.value)
            Form_Data.append("finish", finish.value)
            Form_Data.append("equipments", options.value)

            await axios
            .post ('http://localhost/src/api/addNewCar.php', Form_Data, {

                header: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if (response.data.success == true) {
                    modele.value = 0
                    marque.value = 0
                    energie.value = 0
                    price.value = 0
                    kilometer.value = 0
                    year.value = 0
                    power.value = 0
                    box.value = ""
                    motor.value = ""
                    finish.value = ""
                    options.value = []
                    optionsDescription.value =[]

                    let p = document.querySelectorAll('p')
                    p.forEach(element => {
                        if (element.innerHTML == "") {
                            element.remove()
                        }
                    })

                    isModal.value = true
                    messageModal.value = response.data.message
                }
            })
            .catch(e => {
                console.error(e)
            })
        } else {
            isModal.value = true
            messageModal.value = "Tous les champs non pas été renseignés"
        }
    }

    getCars()


</script>

<template>
    <main class="row">
        <h2 class="col-10">AJOUTER UN VEHICULE</h2>
        <form class="form col-10 col-xl-4">
            <h5>Caracteristiques du véhicule</h5>
            <div class="form__input">
                <input class="form__field" type="file" name="image" id="image" placeholder="Photos" multiple @change="getAdresseFile($event)">
                <label class="form__label" for="image">Photos</label>
            </div>
            <button @click="previewPicture($event)"><i class="fa-solid fa-plus"></i>Ajouter la photo</button>
            <div class="preview__container">
                <img class="preview__container-img" v-for="fileImage in fileImages" @click="deleteImage(fileImage)">
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
                        <option v-for="modele in modeles" :value="modele.id">{{ modele.modele }}</option>
                    </select>
                </div>
                <div class="offcanvas__selectdiv">
                    <select class="offcanvas__select" v-model="energie" name="energie" id="energie">
                        <option value="0" disabled selected>Energie</option>
                        <option v-for="energie in energies" :value="energie.id">{{ energie.nom }}</option>
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
                <div class="form__input">
                    <input class="form__field" v-model="finish" type="text" name="finish" id="finish" placeholder="Finition">
                    <label class="form__label" for="finish">Finition</label>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="price" type="number" name="price" id="price" placeholder="Prix">
                    <label class="form__label" for="price">Prix</label>
                </div>
                <h5>Equipements et options du véhicule</h5>
                <div class="offcanvas__selectdiv">
                    <select class="offcanvas__select" name="equipement" id="equipement" v-model="equipement">
                        <option value="0" disabled selected>Equipements</option>
                        <option v-for="equipement in equipements" :value="equipement.id">{{ equipement.description }}</option>
                    </select>
                </div>
                <button @click="addOption($event, equipement)"><i class="fa-solid fa-plus"></i>Ajouter un équipement</button>
                <div class="information__equipement">
                    <p v-for="option in optionsDescription" @click="deleteOption(option)">{{ option }}</p>
                </div>
        </form>
        <button type="button" class="col-8 col-xl-2" @click="sendNewCar()">Enregistrer le véhicule</button>
        <informationModal :messageModal="messageModal" v-if="isModal" @close="isModal = false"/>
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
        margin: auto;
        margin-bottom: 1em;
    }

    button {
        @include btn-style($orange-formular);
    }

    .preview__container {
        @include flex-center;
        flex-wrap: wrap;
        gap: 1em;
        margin-bottom: 2em;

         &-img {
            height: 10vh;
            width: auto;
            box-shadow: 1px 1px 8px rgba($color: #000000, $alpha: 0.4);
         }
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
            width: 100%;
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

    @media screen and (min-width: 1400px) {

        h2 {
            margin-top: 1em;
        }

        .form {
            font-size: 1.2em;
        }
        .form button {
            width: 30%;
        }

        .offcanvas__selectdiv {

            &:after {
                content: '\2304';
                font-size: 30px;
                position: relative;
                left: 95%;
                top: -60%;
                color: $color-text-dark;
            }
        }
    }

</style>