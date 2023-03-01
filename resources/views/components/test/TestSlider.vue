<template>
    <div class="q-slider">
        <div class="q-slider__content">
            {{ getTitle() }}
        </div>
        <div class="q-slider__slide"></div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/card';
.q-slider {
    display: flex;
    flex-direction: column;
    width: 100%;

    &__content {
        @extend %q-card;
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        option: {
            type: Object,
            default: {},
        },
    },
    methods: {
        getTitle(): string {
            if (this.option && this.option.content) {
                return this.option.content;
            }
            return '';
        }
    },
});
</script>
