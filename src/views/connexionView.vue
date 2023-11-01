<script setup>

    import axios from "axios";
    import { ref } from "vue";
    import { useCookies } from "vue3-cookies";
    
    const email = ref("")
    const password = ref("")
    const { cookies } = useCookies()

    const postConnect = () => {
        if (password.value!="" && email.value!="") {

            axios
            .post('http://localhost/src/api/userConnection.php', {
                email: email.value,
                password: password.value
            })
            .then(response => {
                if (response.data.success === true) {
                    document.cookie = `userName = ${response.data.name}`
                    document.cookie = `userSurname = ${response.data.surname}`
                    document.cookie = `userPermissions = ${response.data.permissions}`
                    document.location.href='http://localhost:5173/dashboard/messages'
                } else {
                    cookies.remove('userName')
                    cookies.remove('userSurname')
                    cookies.remove('userPermissions')
                }
            })
            .catch(e => {
                console.error(e)
            })

        }
    }

</script>

<template>

    <main class="row">
        <form class="form col-8">
            <div class="form__input">
                <input class="form__field" v-model="email" type="email" name="email" id="email" placeholder="Votre adresse mail">
                <label class="form__label" for="email">Votre adresse mail</label>
                <span class="form__input-alert"></span>
            </div>
            <div class="form__input">
                <input class="form__field" v-model="password" type="password" name="password" id="password" placeholder="Votre mot de passe">
                <label class="form__label" for="prenom">Votre mot de passe</label>
                <span class="form__input-alert"></span>
            </div>
        </form>
        <button class="form__btn col-6" @click="postConnect()">Connexion</button>
    </main>

</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';
.form {
        margin: auto;
        margin-top: 2em;

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

        &__btn {
            @include btn-style($orange-formular);
            margin: 1em auto;
            margin-bottom: 3em;
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