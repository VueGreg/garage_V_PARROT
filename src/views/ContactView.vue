<script setup>
    import axios from "axios";
    import { ref } from "vue";
    import { useRoute } from "vue-router";

    const isVisible = ref(false)
    const name = ref("")
    const surname = ref("")
    const message = ref("")
    const tel = ref()
    const email = ref("")
    const vehicules = ref([])
    const numValide = ref(false)
    const mailValide = ref(false)

    const errorMessage = ref("")

    const route = useRoute()
    const numAnnonce = parseInt(route.params.id)

    const testCaracters = () => {
        if(! name.value.match(/^([a-zA-Z ]+)$/)) {
            errorMessage.value = `*Ce champ ne peut contenir que des lettres`
            name.value=""
        }else errorMessage.value = ""
    }

    const returnVisible = () => {
        if (numAnnonce != 0) {
            isVisible.value = true
            getVehicleInformations()
        }
    }

    const getVehicleInformations = () => {
        axios
        .post('http://localhost/src/api/vehicle.php', {
            annonce: numAnnonce
        })
        .then (response => {
                vehicules.value = response.data[0]
            // else document.location.href="/erreur"; 
        })
        .catch (e => {
            console.error(e)
        })
    }

    const Mail_Valide = (mail) => {
        let valide_mail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if(!valide_mail.test(mail))
        {
            mailValide.value = true
        }else mailValide.value = false
    }

    const Portable_Valide = (num) => {
        let valide = /^0[1-6]\d{8}$/;
        if (!valide.test(num))
        {
            numValide.value = true;
        }else numValide.value = false
    }

    returnVisible()

</script>


<template>
    <main class="row">
        <div class="title col-10">
            <h2>CONTACT</h2>
            <p>Envoyez nous votre demande avec vos coordonnées, notre équipe reviendra vers vous dans les meilleurs délais.</p>
        </div>
        <form class="form col-8">
            <Transition>
                <div class="vehicle" v-if="isVisible">
                    <p>Ma demande concerne le véhicule: <br> {{ vehicules.marque }} {{ vehicules.modele }} {{ vehicules.motorisation }}</p>
                </div>
            </Transition>

            <div class="form__input">
                <input class="form__field" @focusout="testCaracters()" v-model="name" type="text" name="nom" id="nom" placeholder="Votre nom">
                <label class="form__label" for="nom">Votre nom</label>
                <span class="form__input-alert" v-if="errorMessage">{{ errorMessage }}</span>
            </div>
            <div class="form__input">
                <input class="form__field" @focusout="testCaracters()" v-model="surname" type="text" name="prenom" id="prenom" placeholder="Votre prénom">
                <label class="form__label" for="prenom">Votre prénom</label>
                <span class="form__input-alert" v-if="errorMessage">{{ errorMessage }}</span>
            </div>
            <div class="form__input">
                <input class="form__field" @focusout="Portable_Valide(tel)" v-model="tel" type="tel" name="tel" id="tel" placeholder="Votre numéro de téléphone">
                <label class="form__label" for="tel">Votre numéro de téléphone</label>
                <span class="form__input-alert" v-if="numValide">*Numero invalide</span>
            </div>
            <div class="form__input">
                <input class="form__field" @focusout="Mail_Valide(email)" v-model="email" type="email" name="email" id="email" placeholder="Votre adresse mail">
                <label class="form__label" for="email">Votre adresse mail</label>
                <span class="form__input-alert" v-if="mailValide">*Adresse invalide</span>
            </div>
            <div class="form__input">
                <textarea rows="5" class="form__field" v-model="message" type="text" name="message" id="message" placeholder="Votre message"></textarea>
                <label class="form__label" for="message">Votre message</label>
            </div>
        </form>
        <button class="col-6">Envoyer message</button>
    </main>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    h2{
        @include h2-main;
        margin-bottom: 1em;
    }

    button {
        @include btn-style($primary-color);
        margin-bottom: 5em;

    }

    .title {
        margin: auto;
    }

    p {
        color: $orange-formular;
        text-align: center;
        font-size: 0.8em;
        width: 100%;
    }

    .v-enter-active,
    .v-leave-active {
    transition: opacity 0.5s ease;
    }

    .v-enter-from,
    .v-leave-to {
    opacity: 0;
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

</style>

