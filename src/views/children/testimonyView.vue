<script setup>

    import axios from 'axios';
    import { ref } from 'vue';
    import { useCookies } from 'vue3-cookies';

    const countMessages = ref()
    const temoignages = ref([])
    const isAction = ref(false)
    const showAwaitTestimonys = ref([])
    

    axios
    .post('http://localhost/src/api/dashboard.php', {
        temoignages: 'getTestimony'
    }).then (response => {
        temoignages.value = response.data.temoignages
        countMessages.value = response.data.nombres
        
        temoignages.value.forEach(temoignage => {
            if (temoignage.etat == 0) {
                showAwaitTestimonys.value.push(temoignage)
            }
        })

    }).catch (e => {
        console.error(e)
    })

    const goAccept = async(id) => {
        await axios
        .put('http://localhost/src/api/postCom.php', {
            id: id,
            accept: 'yes'
        })
        .then(response => {
            console.log(response.data)
        }).catch (e => {
            console.error(e)
        })
    }

    const goRefuse = async(id) => {
        await axios
        .put('http://localhost/src/api/postCom.php', {
            id: id,
            accept: 'no'
        })
        .then(response => {
            console.log(response.data)
        }).catch (e => {
            console.error(e)
        })
    }

</script>

<template>
    <main class="row">
        <h1 class="col-9">{{ countMessages }}</h1>
        <h2 class="col-9" v-if="countMessages<=1">TEMOIGNAGE NON TRAITE</h2>
        <h2 class="col-9" v-else>TEMOIGNAGES NON TRAITES</h2>
        <div class="message col-9" v-for="showAwaitTestimony in showAwaitTestimonys" :key="showAwaitTestimony.id" @click="isAction ? isAction=false : isAction=true">
            <div class="message__element">
                <p class="message__element-title">Nom/Prénom:</p>
                <p>{{ showAwaitTestimony.nom }} {{ showAwaitTestimony.prenom }}</p>
            </div>
            <div class="message__element">
                <p class="message__element-title">Date:</p>
                <p>{{ showAwaitTestimony.date }}</p>
            </div>
            <div class="message__element">
                <p class="message__element-title">Note:</p>
                <p class="message__element-result">{{ showAwaitTestimony.note }}</p>
            </div>
            <div class="message__text">
                <p class="message__element-title">Commentaire:</p>
                <p>{{ showAwaitTestimony.commentaire }}</p>
            </div>
            <TransitionGroup>
                <div class="message__option" v-if="isAction">
                    <div class="message__option-btn" @click="goAccept(showAwaitTestimony.id)">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    <div class="message__option-btn" @click="goRefuse(showAwaitTestimony.id)">
                        <i class="fa-regular fa-circle-xmark"></i>
                    </div>
                </div>
            </TransitionGroup>
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