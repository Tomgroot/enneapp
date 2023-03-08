<template>
    <div class="q-result-type">
        <div class="q-result-type__description">
            {{ description }}
        </div>
        <div v-for="(type, i) in types" class="q-result-type__type" :key="i">
            <div class="q-result-type__title">
                Type
                <span class="q-result-type__title__type">{{
                    getTypeTitle(type)
                }}</span>
                <span class="q-result-type__title__percentage">{{
                    getTypePercentage(type)
                }}</span>
            </div>
            <div class="q-result-type__subtitle">
                <span class="q-result-type__subtitle__keywords">{{
                    getTypeKeywords(type)
                }}</span>
                -
                {{ getTypeDescription(type) }}
                <a :href="readMore">Lees meer</a>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/card';
@import './resources/sass/variables';
.q-result-type {
    @extend %q-card;
    margin-top: 2rem;
    text-align: center;
    transition: all 200ms ease;
    -webkit-tap-highlight-color: transparent;

    &__description {
        margin-bottom: 0.125rem;
        font-weight: bold;
    }

    &__type {
        padding: 0.75rem 0rem;
    }

    &__title {
        font-weight: 500;
        font-size: 1.5rem;
        align-items: center;
        line-height: 2.5rem;
        display: flex;
        justify-content: center;

        &__percentage {
            font-size: 0.875rem;
            margin-left: 0.375rem;
        }

        &__type {
            margin-left: 0.375rem;
        }
    }

    &__subtitle {
        text-align: center;
        font-size: 1rem;

        &__keywords {
            text-decoration: underline;
        }

        & a {
            display: block;
            color: $green-color;
            text-decoration: none;
            margin-top: 0.25rem;
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
        getTypeKeywords: {
            type: Function,
        },
        readMore: {
            type: String,
        },
    },
});
</script>
