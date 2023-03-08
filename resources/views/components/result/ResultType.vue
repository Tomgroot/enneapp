<template>
    <div class="q-result-type">
        <div class="q-result-type__title">Type {{ title }}</div>
        <div class="q-result-type__subtitle">
            <span class="q-result-type__subtitle__keywords">{{
                keywords
            }}</span>
            - {{ subtitle }}
            <a :href="readMore">Lees meer</a>
            <img :src="picture" />
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/card';
.q-result-type {
    @extend %q-card;
    margin-bottom: 0;
    transition: all 200ms ease;
    -webkit-tap-highlight-color: transparent;

    &__title {
        font-weight: 700;
        font-size: 1.75rem;
        text-align: center;
        margin-bottom: 0.75rem;
        line-height: 2.5rem;
    }

    &__subtitle {
        text-align: center;
        font-size: 1rem;

        &__keywords {
            text-decoration: underline;
        }

        & a {
            display: block;
            color: #2f9a6e;
            margin-top: 0.25rem;
            text-decoration: none;
        }
        & img {
            max-width: 100%;
        }
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        title: {
            type: String,
            default: '',
        },
        subtitle: {
            type: String,
            default: '',
        },
        keywords: {
            type: String,
            default: '',
        },
        picture: {
            type: String,
            default: '',
        },
        readMore: {
            type: String,
            default: '',
        },
    },
});
</script>
