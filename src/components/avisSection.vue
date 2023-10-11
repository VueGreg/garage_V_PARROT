<template>

    <section class="container">
        <h2>LAISSEZ NOUS UN AVIS</h2>
        <form action="" class="form">
            <div class="note">
                <p>Notez nous</p>
                <div class="rating" id="rating">
                    <input type="radio" name="star" id="star-1" value="1"/>
                    <label for="star-1">
                        <span> ☆ </span>
                    </label>

                    <input type="radio" name="star" id="star-2" value="2"/>
                    <label for="star-2">
                        <span> ☆ </span>
                    </label>

                    <input type="radio" name="star" id="star-3" value="3"/> 
                    <label for="star-3">
                        <span> ☆ </span>
                    </label>

                    <input type="radio" name="star" id="star-4" value="4"/>
                    <label for="star-4">
                        <span> ☆ </span>
                    </label>

                    <input type="radio" name="star" id="star-5" value="5"/>
                    <label for="star-5">
                        <span> ☆ </span>
                    </label>
                </div>
            </div>
            <div class="form__input">
                <input class="form__field" type="text" name="nom" id="nom" placeholder="Votre nom">
                <label class="form__label" for="nom">Votre nom</label>
            </div>
            <div class="form__input">
                <input class="form__field" type="text" name="prenom" id="prenom" placeholder="Votre prénom">
                <label class="form__label" for="prenom">Votre prénom</label>
            </div>
            <div class="form__input">
                <input class="form__field" type="text" name="message" id="message" placeholder="Votre message">
                <label class="form__label" for="message">Votre message</label>
            </div>
        </form>
    </section>

</template>

<style lang="scss" scoped>
    @import '@/assets/scss/variable.scss';
    @import '@/assets/scss/mixins.scss';

    h2 {
        @include h2-main;
    }

    .note{
        display: flex;
        justify-content: space-evenly;
        align-items: center;

        & p{
            margin: 0;
        }
    }

    .form {

        &__input {
            display: flex;
            flex-direction: column;
            color: $orange-formular;
            position: relative;
            padding: 15px 0 0;
            margin-top: 10px;
        }
    }

    .form__field {
        font-family: inherit;
        width: 80vw;
        border: 0;
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
        left: 2em;
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

    .rating{
            
        & label{ 
            font-size: 50px; cursor: pointer; 
        }
            
        &:hover label{ 
            color: red; 
        }
            
        & label,
        & label:hover ~ label{ 
            color: gold; 
        }
            
        /* Hide input */
        & input[type="radio"]{
            height: 0;
            left: 0;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            top: 0;
            width: 0;
        }
    }
</style>