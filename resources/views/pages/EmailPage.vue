<template>
    <div class="container email-page">
        <TestHeader
            title="Je resultaat is bekend!"
            subtitle="Vul hier je e-mailadres in zodat je je resultaat ook via je e-mail ontvangt."
        />
        <div class="email-page__form">
            <div class="email-page__form__error" v-if="error">
                {{ error }}
            </div>
            <label for="email">E-mailadres</label>
            <input
                @blur="showEmailValidation()"
                :class="{ error: !!error }"
                type="email"
                id="email"
                v-model="email"
                placeholder="Je e-mailadres"
                name="email"
                class="email-page__form__email"
            />
            <label class="email-page__form__newsletter"
                ><input
                    type="checkbox"
                    name="checkbox"
                    value="newsletter"
                    v-model="newsletter"
                />Aanmelden voor nieuwsbrief</label
            >
            <input
                type="submit"
                class="email-page__form__submit"
                @click="submit()"
                value="Naar resultaat &#8250;"
            />
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/variables';
.email-page {
    &__form {
        flex-direction: column;
        display: flex;
        margin-bottom: 10rem;

        &__error {
            background-color: $orange-color;
            border-radius: 0.5rem;
            padding: 0.75rem;
            color: white;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        &__newsletter {
            margin-top: 0.5rem;
            cursor: pointer;

            & input {
                accent-color: $green-color;
                margin-right: 0.5rem;
            }
        }

        &__email {
            padding: 0.75rem;
            font-size: 0.875rem;
            color: $text-color;
            border-radius: 0.5rem;
            border: 2px solid rgba($green-color, 0.5);
            outline: none;
            transition: 100ms ease all;
            font-family: inherit;

            &:hover {
                box-shadow: 0px 3px 3px rgba($green-color, 0.2);
            }

            &.error {
                border: 2px solid rgba($orange-color, 0.5);
                &:hover {
                    box-shadow: 0px 3px 3px rgba($orange-color, 0.2);
                }
            }

            &::placeholder {
                color: rgba($text-color, 0.5);
            }
        }

        &__submit {
            border: none;
            background-color: $green-color;
            color: white;
            padding: 0.75rem;
            margin-top: 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: 100ms ease all;
            font-family: inherit;

            &:hover {
                box-shadow: 0px 3px 3px rgba($green-color, 0.2);
            }

            &:active {
                box-shadow: 0px 0px 2px rgba($green-color, 0.2);
                transform: translateY(0.125rem);
            }
        }
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestHeader from '../components/test/TestHeader.vue';
import axios from 'axios';

export default defineComponent({
    components: {
        TestHeader,
    },
    props: {
        results: {
            type: Object,
            required: true,
        },
        selected: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            email: '',
            error: '',
            newsletter: true,
        };
    },
    methods: {
        submit() {
            this.showEmailValidation(false);
            if (this.isValidEmail()) {
                axios
                    .post('result', {
                        email: this.email,
                        newsletter: this.newsletter,
                        result: JSON.stringify(this.results),
                        selected: JSON.stringify(this.selected),
                    })
                    .then(function (response) {
                        console.log('DONE!', response);
                    })
                    .catch(function (error) {
                        console.log('ERROR!', error);
                    });
                this.$emit('saved');
            }
        },
        isValidEmail() {
            const validRegex =
                /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (this.email.match(validRegex)) {
                return true;
            }
            return false;
        },
        showEmailValidation(ignoreEmpty = true) {
            if ((this.email || !ignoreEmpty) && !this.isValidEmail()) {
                this.error =
                    'Dit e-mailadres is ongeldig, vul een geldig e-mailadres in';
            } else {
                this.error = '';
            }
        },
    },
});
</script>
