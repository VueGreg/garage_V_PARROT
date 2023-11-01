<script setup>

    import axios from 'axios'
    import { ref } from 'vue'

    const countUsers = ref()
    const users = ref ([])
    const listPermissions = ref([])
    const isAction = ref(false)
    const changePermission = ref(false)
    const mailValide = ref(false)


    axios
    .post('http://localhost/src/api/dashboard.php', {
        utilisateurs: 'getUsers'
    }).then (response => {
        users.value = response.data.utilisateurs
        listPermissions.value = response.data.list_permissions
        countUsers.value = response.data.nombres
        console.log(response.data)
    }).catch (e => {
        console.error(e)
    })

    const Mail_Valide = (mail) => {
        let valide_mail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if(!valide_mail.test(mail) && document.querySelector('#email').value != "")
        {
            mailValide.value = true
        }else mailValide.value = false
    }

</script>

<template>
    <main class="row">
        <h1 class="col-10">{{ countUsers }}</h1>
        <h2 class="col-10" v-if="countUsers<=1">UTILISATEUR</h2>
        <h2 class="col-10" v-else>UTILISATEURS</h2>
        <div class="message col-9" v-for="user in users" :key="user.id">
            <div class="message__element">
                <p class="message__element-title">Nom/Prénom:</p>
                <p>{{ user.nom }} {{ user.prenom }}</p>
            </div>
            <div class="message__element">
                <p class="message__element-title">E-mail:</p>
                <p class="message__element-result">{{ user.mail }}</p>
            </div>
            <div class="message__element" @click="changePermission ? changePermission=false : changePermission=true">
                <p class="message__element-title">Rôle:</p>
                <p>{{ user.nom_permissions }}</p>
            </div>
            <div class="message__element" v-if="changePermission">
                <p class="message__element-title">Changer le rôle:</p>
                <select name="permissions" id="permissions">
                        <option :value="permission" v-for="permission in listPermissions" :key="permission.id">{{ permission }}</option>
                </select>
                <button><i class="fa-regular fa-circle-check" style="color: #f36639;"></i></button>
            </div>
        </div>
        <div class="message col-9">
            <div class="message__element">
                <h6>Ajouter un utilisateur</h6>
            </div>
            <form class="form col-10">
                <div class="form__input">
                    <input class="form__field" v-model="name" type="text" name="name" id="name" placeholder="Nom">
                    <label class="form__label" for="name">Nom</label>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="surname" type="text" name="surname" id="surname" placeholder="Prenom">
                    <label class="form__label" for="surname">Prenom</label>
                </div>
                <div class="form__input">
                    <input class="form__field" @focusout="Mail_Valide(email)" v-model="email" type="email" name="email" id="email" placeholder="Adresse mail">
                    <label class="form__label" for="email">Adresse mail</label>
                    <span class="form__input-alert" v-if="mailValide">*Adresse invalide</span>
                </div>
                <div class="form__input">
                    <input class="form__field" v-model="password" type="password" name="password" id="password" placeholder="Mot de pass">
                    <label class="form__label" for="email">Mot de passe</label>
                </div>
                <div class="form__input">
                    <label class="form__label" for="permissions">Role</label>
                    <select name="permission" id="permission">
                        <option :value="permission" v-for="permission in listPermissions">{{ permission }}</option>
                    </select>
                </div>
                <button>Créer un utilisateur</button>
            </form>
        </div>
    </main>
</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    main {
        margin-bottom: 3em;
    }

    h2 {
        @include h2-main;
        margin-top: 0.5em;
        margin-bottom: 2em;
    }

    h1 {
        margin: auto;
        text-align: center;
        margin-top: 3em;
    }

    p {
        margin: 0;
        padding: 0;
    }

    select {
        inset: none;
        appearance: none;
        border: none;
        border-bottom: 2px solid $orange-formular;
        background-color: white;
        color: $color-text-dark;
        font-size: 0.8em;
        text-align: end;
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
                padding: 0.5em;
            }

            &-result {
                color: $primary-color;
                font-weight: 600;
            }

            & h6 {
                text-align: center;
                width: 100%;
                padding: 0.5em;
            }

            & button {
                background: none;
                border: none;
                font-size: 1.5em;
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
            @include btn-style($orange-formular)
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


    .v-enter-active,
    .v-leave-active {
    transition: all 0.75s ease-out;
    }

    .v-enter-to {
    height: auto;
    opacity: 1;
    }

    .v-enter-from {
    height: 0;
    opacity: 0;
    }

    .v-leave-to {
    height: auto;
    opacity: 0;
    }

    .v-leave-from {
    height: auto;
    opacity: 1;
    }

</style>