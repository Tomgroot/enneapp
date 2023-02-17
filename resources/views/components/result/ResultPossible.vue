<template>
    <div class="q-result-type">
        Het kan ook nog dat je één van deze enneagramtypes bent
        <div v-for="(type, i) in types" :key="i">
            <div class="q-result-type__title">
                {{ getTypeTitle(type) }}
            </div>
            <div class="q-result-type__subtitle">
                {{ getTypeDescription(type) }}
            </div>
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
        types: {
            type: Array,
        },
        getTypeTitle: {
            type: Function,
        },
        getTypeDescription: {
            type: Function,
        },
    },
});
</script>
