<script setup>

    import axios from 'axios'
    import { ref } from 'vue'

    const informations = ref([])
    const horaires = ref([])
    const reparations = ref([])
    const categories = ref([])
    const isAction = ref(false)

    axios
    .get('http://localhost/src/api/vitrine.php')
    .then (response => {
        informations.value = response.data.informations
        horaires.value = response.data.horaires
        reparations.value = response.data.reparations
        categories.value = response.data.categorie_reparations
    })
    .catch (e => {
        console.error(e)
    })

</script>

<template>
    <main>
        <section class="row" v-for="information in informations">
            <h2>INFORMATIONS GENERALE</h2>
            <div class="title">
                <div class="title__logo">
                    <img :src="information.adresse_logo" alt="">
                    <p>GARAGE V.PARROT</p>
                </div>
            </div>
            <form class="form col-9">
                <div class="form__input">
                    <input class="form__field" type="text" name="adresse" id="adresse" :placeholder="information.adresse">
                    <label class="form__label" for="nom">{{ information.adresse }}</label>
                </div>
                <div class="form__group">
                    <div class="form__input col-5">
                        <input class="form__field" type="text" name="postal_code" id="postal_code" :placeholder="information.code_postal">
                        <label class="form__label" for="postal_code">{{ information.code_postal }}</label>
                    </div>
                    <div class="form__input col-5">
                        <input class="form__field" type="text" name="city" id="city" :placeholder="information.ville">
                        <label class="form__label" for="city">{{ information.ville }}</label>
                    </div>
                </div>
            </form>
        </section>
        <section class="row">
            <h2>HORAIRES D'OUVERTURE</h2>
            <table class="col-9">
                <tr v-for="horaire in horaires">
                    <td>{{ horaire.jour_semaine }}</td>
                    <td>
                        <div class="form__input">
                            <input class="form__field" type="text" name="h_debut_matin" id="h_debut_matin" :placeholder="horaire.h_debut_matin">
                            <label class="form__label" for="h_debut_matin">{{ horaire.h_debut_matin }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form__input">
                            <input class="form__field" type="text" name="h_fin_soir" id="h_fin_soir" :placeholder="horaire.h_fin_soir">
                            <label class="form__label" for="h_fin_soir">{{ horaire.h_fin_soir }}</label>
                        </div>
                    </td>
                </tr>
            </table>
        </section>
        <section>
            <h2>REPARATIONS</h2>
            <button class="col-6">
                <i class="fa-solid fa-plus"></i>
                <span>  AJOUTER</span>
            </button>
            <div class="message col-9" v-for="reparation in reparations" :key="reparation.id" @click="isAction ? isAction=false : isAction=true">
                <div class="message__element">
                    <p class="message__element-title">Catégorie:</p>
                    <p class="message__element-result">{{ reparation.categorie }}</p>
                </div>
                <div class="message__element-bis">
                    <p class="message__element-title">Description:</p>
                    <p>{{ reparation.description }}</p>
                </div>
                <div class="message__element" v-if="isAction">
                    <button>
                        <i class="fa-solid fa-trash"></i>
                        <span>  Supprimer</span>
                    </button>
                    <button>
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>  Modifier</span>
                    </button>
                </div>
            </div>
            <div class="message form col-9">
                <h6>Ajouter une prestation</h6>
                <div class="form__input">
                    <label class="form__label" for="categorie">Catégorie</label>
                    <select name="categorie" id="categorie">
                        <option :value="categorie" v-for="categorie in categories">{{ categorie.categorie }}</option>
                    </select>
                </div>
                <div class="form__input">
                    <textarea class="form__field" name="description" id="description" placeholder="Description"></textarea>
                    <label class="form__label" for="description">Description</label>
                </div>
                <button class="col-6">AJOUTER</button>
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

</style>