<script setup>

    import axios from 'axios';
    import { ref } from 'vue';
    import { RouterLink } from 'vue-router';
    import informationModal from '../../components/informationModal.vue';

    const countMessages = ref()
    const messages = ref([])
    const isAction = ref(false)
    const activeItem = ref(0)

    //-----Modal response
    const isModal = ref(false)
    const emit = defineEmits(['close'])
    const messageModal = ref()

    
    //-----Function
    const getMessages = async() => {
        await axios
        .post('http://localhost/src/api/dashboard.php', {
            messages: 'getMessages'
        }).then (response => {
            console.log(response.data)
            messages.value = []
            response.data.messages.forEach(message => {
                if (message.status == 0) {
                    messages.value.push(message)
                }
            })
            countMessages.value = messages.value.length
        }).catch (e => {
            console.error(e)
        })
    }

    const messageCheck = async(e, id_message) => {
        e.preventDefault()
        await axios
        .put('http://localhost/src/api/postMessage.php', {
            validate: 'validate',
            id: id_message
        })
        .then (response => {
            isModal.value = true
            messageModal.value = response.data.message
            getMessages()
        })
        .catch (e => {
            console.error(e)
        })
    }

    const showOptions = (index) => {
        if (activeItem.value === index) {
            activeItem.value = 0
        }else
        activeItem.value = index
    }

    const call = (id) => {
        messages.value.forEach(message => {
            if (message.id == id) {
                messageModal.value = message.num_telephone
                isModal.value = true
            }
        })
    }

    getMessages()

</script>

<template>
    <Transition>
        <informationModal :messageModal="messageModal" v-if="isModal" @close="isModal = false" />
    </Transition>
    <section class="mobile">
        <main class="row">
            <h1 class="col-10">{{ countMessages }}</h1>
            <h2 class="col-10" v-if="countMessages<=1">MESSAGE</h2>
            <h2 class="col-10" v-else>MESSAGES</h2>
            <div class="message col-9" v-for="message in messages" :key="message.id" @click="showOptions(message.id)">
                <div class="message__element">
                    <p class="message__element-title">Nom/Prénom:</p>
                    <p>{{ message.nom }} {{ message.prenom }}</p>
                </div>
                <div class="message__element">
                    <p class="message__element-title">Date:</p>
                    <p>{{ message.date }}</p>
                </div>
                <div class="message__element">
                    <p class="message__element-title">E-mail:</p>
                    <p class="message__element-result">{{ message.mail }}</p>
                </div>
                <div class="message__element">
                    <p class="message__element-title">N°Annonce:</p>
                    <p class="message__element-result">{{ message.num_annonce }}</p>
                </div>
                <div class="message__element">
                    <p class="message__element-title">N°Téléphone:</p>
                    <p class="message__element-result">{{ message.num_telephone }}</p>
                </div>
                <div class="message__text">
                    <p class="message__element-title">Message:</p>
                    <p>{{ message.text }}</p>
                </div>
                    <div class="message__option" :class="{ active: message.id === activeItem }">
                        <div class="message__option-btn">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="message__option-btn">
                            <i class="fa-solid fa-at"></i>
                        </div>
                        <div class="message__option-btn" @click="messageCheck($event, message.id)">
                            <i class="fa-regular fa-circle-check"></i>
                        </div>
                    </div>
            </div>
        </main>
    </section>
    <section class="other">
        <div class="table row">
            <div class="table__header col-md-10 col-lg-8">
                <div class="table__header-head">
                    <h5>Messages clients</h5>
                    <h6>{{ countMessages }}</h6>
                </div>
                <div class="table__header-cat">
                    <h6 class="elem elem1">Nom</h6>
                    <h6 class="elem elem2">Prénom</h6>
                    <h6 class="elem elem3">Date</h6>
                    <h6 class="elem elem4">N°Annonce</h6>
                    <h6 class="elem elem5">Message</h6>
                </div>
            </div>
            <div class="table__body col-md-10 col-lg-8" v-for="message in messages" :key="message.id" @click="showOptions(message.id)">
                <div class="table__body-elem">
                    <span class="elem elem1">{{ message.nom }}</span>
                    <span class="elem elem2">{{ message.prenom }}</span>
                    <span class="elem elem3">{{ message.date }}</span>
                    <RouterLink :to="`vehicule/${message.num_annonce}`" class="elem elem4">
                        <span>{{ message.num_annonce }}</span>
                    </RouterLink>
                    <span class="elem elem5">{{ message.text }}</span>
                </div>
                    <div class="message__option" :class="{ active: message.id === activeItem }">
                        <div class="message__option-btn" @click="call(message.id)">
                            <i class="fa-solid fa-phone"></i>
                            <span>Appeler</span>
                        </div>
                        <div class="message__option-btn">
                            <i class="fa-solid fa-at"></i>
                            <span>Envoyer un mail</span>
                        </div>
                        <div class="message__option-btn" @click="messageCheck($event, message.id)">
                            <i class="fa-regular fa-circle-check"></i>
                            <span>Message traité</span>
                        </div>
                    </div>
            </div>
        </div>
    </section>
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
        }

        &__text {
            font-size: 0.8em;
        }

        &__option {
            display: none;
            justify-content: space-around;
            align-items: center;
            border-top: 1px solid rgba($color: #000000, $alpha: 0.8);
            padding-top: 1.5em;
            opacity: 0;
            transition: opacity 1s ease-in-out;

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

    .other {
        display: none;
    }

    .table {
        font-size: 0.8em;
        margin: 2em auto;
        margin-bottom: 5em;

        h5{
            color: $primary-color;
            margin-bottom: 2em;
        }

        h6 {
            margin: 0;
            font-size: 1.2em;
            color: $color-text-dark;
        }

        &__header {
            margin: 2em auto;
            padding: 1em;
            border-radius: 5px;
            box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.25);
            border: 1px solid rgba($color: #000000, $alpha: 0.1);
    
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

        &__body {

            margin: 0.2em auto;
            display: flex;
            flex-direction: column;
            border-radius: 5px;
            box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.25);
            height: 100%;
            padding: 1em;
            border: 1px solid rgba($color: #000000, $alpha: 0.1);

            &-elem {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                height: 100%;
            }
        }

        .higer {
            height: 10vh;
        }

        .elem {
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0;
            color: $color-text-dark;
        }
        .elem1 {
            width: 8%;
        }

        .elem2 {
            width: 8%;
        }

        .elem3 {
            width: 10%;
        }

        .elem4 {
            width: 10%;
            text-decoration: none;
        
            & span {
                background-color: $primary-color;
                border-radius: 50%;
                width: 2em;
                height: 2em;
                @include flex-center;
                color: white;
                font-weight: 600;
            }
        }

        .elem5 {
            width: 64%;
        }
    }

    .active {
        display: flex;
        opacity: 1;
        transition: opacity 1s ease-in-out;
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

    @media screen and (min-width: 768px) {
        .other {
            display: block;
        }

        .mobile {
            display: none;
        }

        .active {
            border: none;

            & .message__option-btn {
                display: flex;
                align-items: center;
                color: $orange-formular;
                padding: 0.2em;
                padding-right: 1em;
                box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.25);
                border-radius: 5px;

                &:hover {
                    color: white;
                }
            }
        }
    }

</style>