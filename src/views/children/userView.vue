<script setup>

    import api from '../../baseURL/urlAPI';
    import { ref, defineEmits, watch } from 'vue'
    import { useCookies } from 'vue3-cookies';
    import informationModal from '../../components/informationModal.vue';

    const { cookies } = useCookies()

    const countUsers = ref()
    const users = ref ([])
    const listPermissions = ref([])
    const isAction = ref(false)
    const changePermission = ref(false)
    const mailValide = ref(false)
    const userPermissions = cookies.get('userPermissions')
    const rank = ref()
    const roleModify = ref(false)
    const memoryId = ref()

    const show = ref()

    //Form variables
    const name = ref("")
    const surname = ref("")
    const email = ref("")
    const password = ref("")
    const role = ref()

    //-----Modal response
    const isModal = ref(false)
    const emit = defineEmits(['close'])
    const messageModal = ref()

    const userAuthorized = () => {
        if (userPermissions != null) {
                api.post('/authorize.php', {
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

    const getUsers = async() => {
        await api.post('/dashboard.php', {
            utilisateurs: 'getUsers'
        }).then (response => {
            console.log(response.data)
            users.value = response.data.utilisateurs
            listPermissions.value = response.data.list_permissions
            countUsers.value = response.data.nombres
        }).catch (e => {
            console.error(e)
        })
    }

    const Mail_Valide = (mail) => {
        let valide_mail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if(!valide_mail.test(mail) && document.querySelector('#email').value != "")
        {
            mailValide.value = true
        }else mailValide.value = false
    }

    const postNewUser = async() => {
        if (name.value!="" && surname.value!="" && email.value!="" && password.value!="" && role.value!="") {
            await api.post('/postUser.php', {
                email: email.value,
                name: name.value,
                surname: surname.value,
                password: password.value,
                role: role.value,
            })
            .then (response => {
                if (response.data.success === true) {
                    isModal.value = true
                    messageModal.value = response.data.message
                    email.value=""
                    name.value=""
                    surname.value = ""
                    password.value = ""
                    role.value = ""
                    getUsers()
                    isAction.value = false
                }
            })
            .catch(e => {
                console.error(e)
            })
        }else {
            isModal.value = true
            messageModal.value = "Tous les champs obligatoires n'ont pas été remplis"
        }
    }

    const deleteUser = async(id) => {
        await api.post('/postUser.php', {
            id, id
        })
        .then (response => {
            if (response.data.success === true) {
                isModal.value = true
                messageModal.value = response.data.message
                getUsers()
            }
        })
        .catch(e => {
            console.error(e)
        })
        
    }

    const clickRole = (id) => {
        users.value.forEach(user => {
            if (user.id == id) {
                name.value = user.nom
                surname.value = user.prenom
                email.value = user.mail
                listPermissions.value.forEach(permission => {
                    if (permission.type == user.nom_permissions) {
                        role.value = permission.id
                    }
                })
                isAction.value = true
                roleModify.value = true
                memoryId.value = id
            }
        })
    }

    const modifyUser = async(id) => {
        await api.put('/postUser.php', {
            id: id,
            name: name.value,
            surname: surname.value,
            mail: email.value,
            role: role.value
        })
        .then (response => {
            if (response.data.success === true) {
                isModal.value = true
                messageModal.value = response.data.message

                name.value = ""
                surname.value = ""
                email.value = ""
                role.value = ""

                getUsers()
                roleModify.value = false
                isAction.value = false
                memoryId.value = ""
            }
        })
        .catch(e => {
            console.error(e)
        })

    }

    userAuthorized()
    getUsers()

</script>

<template>
    <Transition>
        <informationModal v-if="isModal" :messageModal="messageModal" @close="isModal = false"/>
    </Transition>

    <main class="row">
        <section class="mobile">
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
                            <option :value="permission.id" v-for="permission in listPermissions" :key="permission.id">{{ permission.type }}</option>
                    </select>
                    <button><i class="fa-regular fa-circle-check" style="color: #f36639;"></i></button>
                </div>
            </div>
        </section>
        <section class="other">
        <div class="table row">
            <div class="table__header col-md-10 col-xl-8">
                <div class="table__header-head">
                    <h5>UTILISATEURS</h5>
                    <h6>{{ countUsers }}</h6>
                </div>
                <div class="table__header-cat">
                    <h6 class="elem elem1">Nom</h6>
                    <h6 class="elem elem2">Prenom</h6>
                    <h6 class="elem elem3">E-mail</h6>
                    <h6 class="elem elem4">Rôle</h6>
                    <h6 class="elem elem5">Actions</h6>
                </div>
            </div>

            <div class="table__btn col-md-10 col-lg-8" @click="isAction ? isAction = false : isAction = true">
                <a href="#addUser" class="table__btn-btn">
                    <i class="fa-solid fa-plus"></i>
                    Ajouter un utilisateur
                </a>
            </div>
            <TransitionGroup name="slide-fade">
                <div class="table__body col-md-10 col-xl-8" v-for="user in users" :key="user.id">
                    <div class="table__body-elem">
                        <span class="elem elem1">{{ user.nom }}</span>
                        <span class="elem elem2">{{ user.prenom }}</span>
                        <span class="elem elem3">{{ user.mail }}</span>
                        <span class="elem elem4">{{ user.nom_permissions }}</span>
                        <span class="elem elem5">
                            <div class="elem__btn" v-if="user.id != 1" @click="deleteUser(user.id)">
                                <i class="fa-solid fa-user-slash"></i>
                                <p>Employé sortie de l'entreprise</p>
                            </div>
                            <div class="elem__btn" v-if="user.id != 1" @click="clickRole(user.id)">
                                <i class="fa-solid fa-user-gear"></i>
                                <p>Changer le rôle</p>
                            </div>
                        </span>
                    </div>
                </div>
            </TransitionGroup>
        </div>
    </section>
    <Transition name="scale-slide">
        <div class="message none col-9 col-md-10 col-lg-8" id="addUser" :class="{ active: isAction }">
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
                    <div class="form__input" v-if="!roleModify">
                        <input class="form__field" v-model="password" type="password" name="password" id="password" placeholder="Mot de pass">
                        <label class="form__label" for="email">Mot de passe</label>
                    </div>
                    <div class="form__input">
                        <label class="form__label" for="permissions">Role</label>
                        <select name="permission" id="permission" v-model="role">
                            <option :value="permission.id" v-for="permission in listPermissions" :key="permission.id">{{ permission.type }}</option>
                        </select>
                    </div>
                    <button type="button" @click="postNewUser()" v-if="!roleModify">Créer un utilisateur</button>
                    <button type="button" @click="modifyUser(memoryId)" v-else>Modifier l'utilisateur</button>
                </form>
            </div>
        </Transition>
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

    .other {
        display: none;
    }

    .table {
        font-size: 0.8em;
        margin: 2em auto;
        margin-bottom: 5em;

        h5,
        h6 {
            color: $primary-color;
            margin-bottom: 2em;
        }

        &__header {
            margin: 2em auto;
            padding: 1em;
            border-radius: 5px;
            box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.25);

            & h6 {
                font-size: 1.2em;
                margin: 0;
                margin-top: 2em;
                margin-bottom: 0.5em;
            }
    
            &-head {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            &-cat {
                display: flex;
                justify-content: space-between;
            }
        }

        &__btn {
            display: flex;
            justify-content: end;
            margin: auto;

            &-btn {
                @include btn-style($primary-color);
                margin: 0;
                padding: 0.5em;
                font-size: 1.2em;
                text-decoration: none;

                & i {
                    color: $primary-color;
                    background: none;
                }

                &:hover i {
                    color: white;
                }
            }
        }

        &__body {

            margin: 0.2em auto;
            display: flex;
            flex-direction: column;
            border-radius: 5px;
            box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.25);
            height: 100%;
            padding: 1em;

            &-elem {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                height: 100%;
            }
        }

        .elem {
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0;
            color: $color-text-dark;

            &__btn {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: center;
                margin: 1em;
                color: $primary-color;
                cursor: pointer;

                & p {
                    font-size: 0.8em;
                }

                & i {
                    font-size: 1.3em;
                }
            }
        }
        .elem1 {
            width: 8%;
        }

        .elem2 {
            width: 8%;
        }

        .elem3 {
            width: 20%;
        }

        .elem4 {
            width: 15%;
        }

        .elem5 {
            width: 55%;
            display: flex;
            justify-content: space-around;
        }
    }

    .none {
        display: none;
        opacity: 0;
    }

    .active {
        display: block;
        opacity: 1;
    }

    @media screen and (min-width: 768px) {
        .mobile {
            display: none;
        }

        .other {
            display: block;
        }

        .form {
            width: 50%;
        }
    }

</style>

<style>

    /* ---- Simple transition---- */

    .v-enter-active {
        animation: bounce-in 0.8s;
    }
    .v-leave-active {
        animation: bounce-in 1s reverse;
    }
        @keyframes bounce-in {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.25);
        }
        100% {
            transform: scale(1);
        }
    }

    .scale-slide-enter-active,
    .scale-slide-leave-active {
    position: absolute;
    transition: all 0.85s ease;
    }

    .scale-slide-enter-from {
    left: -100%;
    }

    .scale-slide-enter-to {
    left: 0%;
    }

    .scale-slide-leave-from {
    transform: scale(1);
    }

    .scale-slide-leave-to {
    transform: scale(0.8);
    }

    /* ---- Transition group ---- */

    .slide-fade-enter-active {
        transition: all 0.3s ease-out;
    }

    .slide-fade-leave-active {
        transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
    }

    .slide-fade-enter-from,
    .slide-fade-leave-to {
        transform: translateX(20px);
        opacity: 0;
    }

</style>