<template>
    <div class="q-slider">
        <div class="q-slider__content">
            {{ title }}
        </div>
        <div class="q-slider__slide"></div>
    </div>
</template>
<style lang="scss" scoped>
.q-options {
    display: flex;
    flex-direction: column;
    width: 100%;

    &__content {
        background-color: #fff;
        border-radius: 1.1rem;
        padding: 1.5rem;
        cursor: pointer;
        margin-bottom: 0.75rem;
        box-shadow: 0px 3px 3px rgba(236, 137, 69, 0.2);
        transition: all 200ms ease;
        -webkit-tap-highlight-color: transparent;
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
    },
    methods: {},
});
</script>
