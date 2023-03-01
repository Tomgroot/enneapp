<template>
    <div class="q-result-type">
        <div class="q-result-type__description">
            {{ description }}
        </div>
        <div v-for="(type, i) in types" class="q-result-type__type" :key="i">
            <div class="q-result-type__title">
                {{ getTypeTitle(type) }} {{ getTypePercentage(type) }}
            </div>
            <div class="q-result-type__subtitle">
                {{ getTypeDescription(type) }}
                <a :href="readMore">Lees meer</a>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/card';
.q-result-type {
    @extend %q-card;
    margin-top: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 200ms ease;
    -webkit-tap-highlight-color: transparent;

    &__description {
        margin-bottom: 1rem;
        font-weight: bold;
    }

    &__type {
        margin-bottom: 1rem;
    }

    &__title {
        font-weight: 500;
        font-size: 1.5rem;
        text-align: center;
        margin-bottom: 0.5rem;
        line-height: 2.5rem;
    }

    &__subtitle {
        text-align: center;
        font-size: 1rem;
        & a {
            display: block;
        }
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        types: {
            type: Array,
        },
        description: {
            type: String,
            default: '',
        },
        getTypeTitle: {
            type: Function,
        },
        getTypeDescription: {
            type: Function,
        },
        getTypePercentage: {
            type: Function,
        },
        readMore: {
            type: String,
        },
    },
});
</script>
