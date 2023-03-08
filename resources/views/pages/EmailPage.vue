<template>
    <div class="container email-page">
        <TestHeader
            title="Je resultaat is bekend!"
            subtitle="Vul hier je e-mailadres in zodat je je resultaat ook via je email ontvangt."
        />
        <div class="email-page__form">
            <label for="email">Email</label>
            <input
                type="text"
                id="email"
                v-model="email"
                placeholder="Je e-mailadres"
                name="email"
                class="email-page__form__email"
            />
            <input
                type="submit"
                class="email-page__form__submit"
                @click="submit()"
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

        &__email {
            padding: 0.75rem;
            font-size: 0.875rem;
            color: $text-color;

            &::placeholder {
                color: rgba($text-color, 0.5);
            }
        }

        &__submit {
            border: none;
            background-color: $green-color;
        }
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestHeader from '../components/test/TestHeader.vue';

export default defineComponent({
    components: {
        TestHeader,
    },
    data() {
        return {
            email: '',
        };
    },
    methods: {
        submit() {
            console.log(this.email);
        },
    },
});
</script>
