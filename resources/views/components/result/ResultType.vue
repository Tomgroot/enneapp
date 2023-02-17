<template>
    <div class="q-result-type">
        <div class="q-result-type__title">
            {{ title }}
        </div>
        <div class="q-result-type__subtitle">
            {{ subtitle }}
            <a :href="readMore">Lees meer</a>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.q-result-type {
    margin-top: 2rem;
    margin-bottom: 2rem;
    background-color: #fff;
    border-radius: 1.1rem;
    padding: 1.5rem;
    cursor: pointer;
    box-shadow: 0px 3px 3px rgb(236 137 69 / 20%);
    transition: all 200ms ease;
    -webkit-tap-highlight-color: transparent;

    &__title {
        font-weight: 700;
        font-size: 2.2rem;
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
        title: {
            type: String,
            default: '',
        },
        subtitle: {
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
