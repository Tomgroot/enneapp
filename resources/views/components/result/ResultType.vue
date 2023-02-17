<template>
    <div class="q-result-type">
        <div class="q-result-type__title">
            {{ title }}
        </div>
        <div class="q-result-type__subtitle">
            {{ subtitle }}
        </div>
    </div>
</template>
<style lang="scss" scoped>
.q-result-type {
    margin-top: 2rem;
    margin-bottom: 2rem;

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
    },
});
</script>
