<script setup>
    import axios from 'axios';
    import { ref } from 'vue';

    const name = ref("")
    const surname = ref("")
    const message = ref("")
    const note = ref(0)

    const errorMessage = ref("")
    const stateForm = ref(false)

    const testCaracters = (inputName="nom") => {
        if(! name.value.match(/^([a-zA-Z ]+)$/)) {
            errorMessage.value = `*Votre ${inputName} ne peut contenir que des lettres`
            name.value=""
        }else errorMessage.value = ""
    }

    const sendCom = () => {
        if (name.value!="" && surname.value!="" && message.value !="") {
            stateForm.value = false

            axios
            .post('http://localhost/src/api/postCom.php', {
                date: new Date().toJSON().slice(0, 10),
                name: name.value,
                surname: surname.value,
                com: message.value,
                note: note.value
            })
            .then(response => {
                console.log(response.data.message)
                console.log(response.data)
            })
            .catch(e => {
                console.error(e)
            })

        }else stateForm.value = true
    }

</script>

<template>

    <section class="section__form row">
        <h2 class="col-10 col-sm-7 col-md-8">LAISSEZ NOUS UN AVIS</h2>
        <form class="form col-10 col-sm-7 col-md-8 col-lg-6">
            <div class="note">
                <p>Notez nous</p>
                <div class="rating__stars">
                    <input type="radio" name="rating" id="rs1" value="1" v-model="note">
                    <label class="rating__stars-star" for="rs1"></label>

                    <input type="radio" name="rating" id="rs2" value="2" v-model="note">
                    <label class="rating__stars-star" for="rs2"></label>

                    <input type="radio" name="rating" id="rs3" value="3" v-model="note">
                    <label class="rating__stars-star" for="rs3"></label>

                    <input type="radio" name="rating" id="rs4" value="4" v-model="note">
                    <label class="rating__stars-star" for="rs4"></label>

                    <input type="radio" name="rating" id="rs5" value="5" v-model="note">
                    <label class="rating__stars-star" for="rs5"></label>
                </div>
            </div>
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
                <textarea rows="5" class="form__field" v-model="message" type="text" name="message" id="message" placeholder="Votre message"></textarea>
                <label class="form__label" for="message">Votre message</label>
            </div>
        </form>

        <button class="col-6 col-sm-4" @click="sendCom()">Envoyer mon avis</button>
        <span class="form__input-alert" v-if="stateForm">Tous les champs ne sont pas renseigné</span>
    </section>

</template>

<style lang="scss" scoped>
    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .section__form {
        background-color: $light-grey;
        padding: 1em;
    }

    h2 {
        @include h2-main;
    }

    .note{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: auto;

        & p{
            margin: 0;
            color: $orange-formular;
        }
    }

    button{
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
            margin: auto;
            margin-top: 10px;

            &-alert {
                font-size: 0.6em;
                display: block;
                width: 80vw;
                margin: 0 auto;
                color: red;
                padding-left: 0.2em;
            }
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


    /* Stars note  */

    .rating__stars {

        input { display: none; }

        &-star {
            width: 5vmin;
            height: 5vmin;
            background: $primary-color;
            display: inline-flex;
            cursor: pointer;
            margin: 0.5vmin 0.65vmin;
            transition: all 1s ease 0s;	
            clip-path: polygon(50% 0%, 66% 32%, 100% 38%, 78% 64%, 83% 100%, 50% 83%, 17% 100%, 22% 64%, 0 38%, 34% 32%);

            &:before {
                width: 90%;
                height: 90%;
                content: "";
                z-index: -1;
                display: block;
                margin-left: 5%;
                margin-top: 5%;
                clip-path: polygon(50% 0%, 66% 32%, 100% 38%, 78% 64%, 83% 100%, 50% 83%, 17% 100%, 22% 64%, 0 38%, 34% 32%);
                background: linear-gradient(90deg, $primary-color, white);
                background-size: 205% 100%;
                background-position: 0 0;
                transition: all 0.25s ease 0s;
            }

            &:hover:before {
                background-position: 100% 0;
            }
        }


        input:checked + label ~ label:before {
            background-position: 100% 0;
            transition: all 0.5s ease 0s;	
        }

        input:checked + label ~ label:hover:before {
            background-position: 0% 0;
            transition: all 0.5s ease 0s;	
        }


        &-star + input:checked {
            color: $primary-color;
            transition: all 0.5s ease 0s;
        }

    }

    @media screen and (min-width: 1000px) {
        
        .row {
            flex-direction: column;
        }
    
    }

    
</style>