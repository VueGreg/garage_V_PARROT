<script setup>

    import axios from 'axios'
    import { ref, reactive, defineEmits, watch } from 'vue'
    import { useCookies } from 'vue3-cookies'
    import informationModal from '../../components/informationModal.vue'

    const { cookies } = useCookies()

    const informations = ref([])
    const horaires = ref([])
    const reparations = ref([])
    const categories = ref([])
    const isAction = ref(false)
    const userPermissions = cookies.get('userPermissions')
    const rank = ref()

    //-----v-models
    const models = reactive({
        adresse: null,
        postal: null,
        city: null,
        tel: null,
        mail: null,
        categorie : null,
        description : null
    })

    const horaireChange = ref(
        {
            1: {debut: null, fin : null},
            2: {debut: null, fin : null},
            3: {debut: null, fin : null},
            4: {debut: null, fin : null},
            5: {debut: null, fin : null},
            6: {debut: null, fin : null}
        }
    )

    //-----Modal response
    const isModal = ref(false)
    const emit = defineEmits(['close'])
    const messageModal = ref()

    const userAuthorized = () => {
        if (userPermissions != null) {
                axios
                .post('http://localhost/src/api/authorize.php', {
                    permissions: userPermissions
                }).then (response => {
                    if (response.data.success == true) {
                        rank.value = response.data.rang
                        if (rank.value > 1) {
                            document.location.href='http://localhost:5173/erreur'
                        }
                    }else document.location.href='http://localhost:5173/erreur'
                }).catch (e => {
                    console.error(e)
                })
        }
    }

    const getAll = async() => {
        await axios
        .get('http://localhost/src/api/vitrine.php')
        .then (response => {
            informations.value = response.data.informations
            horaires.value = response.data.horaires
            reparations.value = response.data.reparations
            categories.value = response.data.categorie_reparations

            models.adresse = informations.value[0].adresse
            models.postal = informations.value[0].code_postal
            models.city = informations.value[0].ville
            models.tel = informations.value[0].num_telephone
            models.mail = informations.value[0].mail

            for (let i = 1; i < 7; i++) {
                horaireChange.value[i].debut = response.data.horaires[i-1].h_debut
                horaireChange.value[i].fin = response.data.horaires[i-1].h_fin
            }
        })
        .catch (e => {
            console.error(e)
        })
    }

    const changeBusinessSetting = async() => {
        await axios
        .put('http://localhost/src/api/setting.php', {
            adress: models.adresse,
            postal: models.postal,
            city: models.city,
            tel: models.tel,
            mail: models.mail
        })
        .then(response => {
            if (response.data.success == true) {
                isModal.value = true
                messageModal.value = response.data.message
            }
        })
        .catch(e => {
            console.error(e)
        })
    }

    const sendRepair = async(e) => {
        e.preventDefault()
        await axios
        .put('http://localhost/src/api/setting.php', {
            category: models.categorie,
            description: models.description
        })
        .then(response => {
            if (response.data.success == true) {
                isModal.value = true
                messageModal.value = response.data.message

                models.categorie = null
                models.description = null

                getAll()
            }
        })
        .catch(e => {
            console.error(e)
        })
    }

    const deleteRepair = async(e, id_repair) => {
        e.preventDefault()
        await axios
        .post('http://localhost/src/api/setting.php', {
            id: id_repair
        })
        .then(response => {
            if (response.data.success == true) {
                isModal.value = true
                messageModal.value = response.data.message

                getAll()
            }
        })
        .catch(e => {
            console.error(e)
        })
    }

    const changeFormatTime = (arr) => {
        for (let i = 1; i < 7; i++) {

            let changeDebut = arr[i].debut.replace('h', ':')
            let goodHourDebut = changeDebut + ':00'
            arr[i].debut = goodHourDebut

            let changeFin = arr[i].fin.replace('h', ':')
            let goodHourFin = changeFin + ':00'
            arr[i].fin = goodHourFin
        }
        return arr
    }

    const sendHoraires = async() => {
        let change = changeFormatTime(horaireChange.value)
        console.log(change)
        await axios
        .put('http://localhost/src/api/setting.php', {
            arr: change
        })
        .then(response => {
            if (response.data.success == true) {
                isModal.value = true
                messageModal.value = response.data.message

                getAll()
            }
        })
        .catch(e => {
            console.error(e)
        })
    }

    userAuthorized()
    getAll()

</script>

<template>
    <informationModal :messageModal="messageModal" v-if="isModal" @close="isModal = false" />
    <main>
        <section class="row" v-for="information in informations">
            <h2>INFORMATIONS GENERALE</h2>
            <div class="title">
                <div class="title__logo">
                    <img :src="information.adresse_logo" alt="">
                    <p>GARAGE V.PARROT</p>
                </div>
            </div>
            <form class="form col-9 col-xl-6">
                <div class="form__input">
                    <input class="form__field" v-model="models.adresse" type="text" name="adresse" id="adresse" placeholder="Adresse">
                    <label class="form__label" for="nom">Adresse:</label>
                </div>
                <div class="form__group">
                    <div class="form__input col-5">
                        <input class="form__field" v-model="models.postal" type="text" name="postal_code" id="postal_code" placeholder="Code postal">
                        <label class="form__label" for="postal_code">Code postal:</label>
                    </div>
                    <div class="form__input col-5">
                        <input class="form__field" v-model="models.city" type="text" name="city" id="city" placeholder="Ville">
                        <label class="form__label" for="city">Ville:</label>
                    </div>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="models.tel" type="tel" name="tel" id="tel" placeholder="Numéro de téléphone">
                    <label class="form__label" for="tel">Numéro de téléphone:</label>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="models.mail" type="email" name="email" id="email" placeholder="E-mail">
                    <label class="form__label" for="email">E-mail:</label>
                </div>
                <button type="button" @click="changeBusinessSetting()">Modifier les informations</button>
            </form>
        </section>
        <section class="row">
            <h2>HORAIRES D'OUVERTURE</h2>
            <table class="col-9 col-xl-4">
                <tr v-for="horaire in horaires" :key="horaire.id">
                    <td>{{ horaire.jour_semaine }}</td>
                    <td>
                        <div class="form__input">
                            <label class="form__label" :for="horaire.jour_semaine + 'Debut'">Début</label>
                            <select :name="horaire.jour_semaine + 'Debut'" :id="horaire.jour_semaine + 'Debut'" v-model="horaireChange[horaire.id].debut">
                                <option>{{ horaireChange[horaire.id].debut }}</option>
                                <option v-for="heure in horaire.list" :key="heure.id">{{ heure }}</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form__input">
                            <label class="form__label" :for="horaire.jour_semaine + 'Fin'">Fin</label>
                            <select :name="horaire.jour_semaine + 'Fin'" :id="horaire.jour_semaine + 'Fin'" v-model="horaireChange[horaire.id].fin">
                                <option>{{ horaireChange[horaire.id].fin }}</option>
                                <option v-for="heure in horaire.list" :key="heure.id">{{ heure }}</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>
            <button type="button" class="col-xl-2" @click="sendHoraires()">Envoyer les modifications</button>
        </section>
        <section>
            <h2>REPARATIONS</h2>
            <a href="#form">
                <button class="col-6 col-xl-1">
                    <i class="fa-solid fa-plus"></i>
                    <span>  AJOUTER</span>
                </button>
            </a>
            <div class="message col-9 col-xl-4" v-for="reparation in reparations" :key="reparation.id" @click="isAction ? isAction=false : isAction=true">
                <div class="message__element">
                    <p class="message__element-title">Catégorie:</p>
                    <p class="message__element-result">{{ reparation.categorie }}</p>
                </div>
                <div class="message__element-bis">
                    <p class="message__element-title">Description:</p>
                    <p>{{ reparation.description }}</p>
                </div>
                <div class="message__element" v-if="isAction">
                    <button @click="deleteRepair($event, reparation.id)">
                        <i class="fa-solid fa-trash"></i>
                        <span>  Supprimer</span>
                    </button>
                    <button>
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>  Modifier</span>
                    </button>
                </div>
            </div>
            <div class="message form col-9 col-xl-4" id="form">
                <h6>Ajouter une prestation</h6>
                <div class="form__input">
                    <label class="form__label" for="categorie">Catégorie</label>
                    <select name="categorie" id="categorie" v-model="models.categorie">
                        <option :value="categorie.categorie" v-for="categorie in categories">{{ categorie.categorie }}</option>
                    </select>
                </div>
                <div class="form__input">
                    <textarea class="form__field" v-model="models.description" name="description" id="description" placeholder="Description"></textarea>
                    <label class="form__label" for="description">Description</label>
                </div>
                <button class="col-6 col-xl-2" @click="sendRepair($event)">AJOUTER</button>
            </div>
        </section>
    </main>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    h2 {
        @include h2-main;
    }

    table {
        margin: auto;

        & tr {
            vertical-align: bottom;
        }
        
        & td {
            padding: 0.5em
        }
    }

    h6 {
        text-align: center;
        margin: 2em;
    }

    select {
        border: none;
        border-bottom: 2px solid $orange-formular;
        color: $orange-formular;
        text-align: end;
        background: none;
        font-size: 0.8em;
    }

    button {
        @include btn-style($primary-color);
    }

    a {
        text-decoration: none;
    }

    .title {
        &__logo {
            @include flex-center;

            & img {
                height: 5em;
                width: auto;
            }
        }
    }

    .form {
        margin: auto;

    &__input {
        display: flex;
        flex-direction: column;
        color: $orange-formular;
        position: relative;
        padding: 8px 0 0;
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
    &__group {
        @include flex-center;
        justify-content: space-between;
    }
    }

    .form__field {
        font-family: inherit;
        border: 0;
        width: 100%;
        border-bottom: 2px solid $orange-formular;
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
        color: $orange-formular;
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
        border-image: linear-gradient(to right, $orange-formular, $primary-color);
        border-image-slice: 1;
    }

    /* reset input */
        .form__field{
        &:required,&:invalid { box-shadow:none; }
    }

    .message{
        border-radius: 5px;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.4);
        margin: 1em auto;
        padding: 1em;

        &__element {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8em;

            &-title {
                font-weight: 600;
            }

            &-result {
                color: $primary-color;
                font-weight: 600;
            }

            &-bis {
                font-size: 0.8em;
            }
        }

        &__text {
            font-size: 0.8em;
        }

        &__option {
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-top: 1px solid rgba($color: #000000, $alpha: 0.8);
            padding-top: 1.5em;

            &-btn {
                border: 2px solid $primary-color;

                & i {
                    color: $primary-color;
                    padding: 1em;
                }

                &:hover {
                    border: none;
                    background-color: $primary-color;

                    & i {
                        color: white;
                    }
                }
            }
        }
    }

    .form {
        margin: auto;
        margin-bottom: 3em;

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
            margin: 1em auto;
        }
    }

    .form__field {
    font-family: inherit;
    border: 0;
    width: 100%;
    border-bottom: 2px solid $orange-formular;
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
    color: $orange-formular;
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
    border-image: linear-gradient(to right, $orange-formular, $primary-color);
    border-image-slice: 1;
    }

    /* reset input */
    .form__field{
    &:required,&:invalid { box-shadow:none; }
    }

    @media screen and (min-width: 1400px) {
        .row {
            flex-direction: column;
        }
    }

</style>