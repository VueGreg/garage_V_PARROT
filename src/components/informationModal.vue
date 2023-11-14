<script setup>

    import { defineProps, defineEmits } from 'vue';

    const props = defineProps({
        messageModal:"messageModal"
    })

    const emit = defineEmits(["close"]);

</script>


<template>
    <Teleport to="body">
        <div class="winModal">
            <div class="winModal__dialog">
                <span>{{ props.messageModal }}</span>
                <button @click="$emit('close')" >Ok !</button>
            </div>
        </div>
    </Teleport>

</template>

<style lang="scss" scoped>

    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    .winModal {
        height: 100%;
        width: 100%;
        background-color: rgba($color: #000000, $alpha: 0.4);
        @include flex-center;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 30;

        &__dialog {
            height: 30vh;
            width: 30vw;
            background-color: white;
            @include flex-center;
            flex-direction: column;
            border-radius: 10px;
            box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.4);

            & span {
                font-size: 1.4em;
                text-align: center;
            }

            & button {
                @include btn-style($primary-color);
                margin: 2em;
            }
        }
    }

</style>