<template>
    <transition name="fade-swipe" :css="transition || disabled">
        <TestOptions
            v-if="current && animation"
            :disabled="disabled"
            :options="winners"
            @select="(i) => select(i)"
        />
    </transition>
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestOptions from './test/TestOptions.vue';
import type { IOption } from '../types';

export default defineComponent({
    components: { TestOptions },
    props: {
        winners: {
            type: Array,
            default: [] as IOption[],
        },
        nr: {
            type: Number,
            default: 0,
        },
        current: {
            type: Boolean,
            default: false,
        },
        transition: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            selected: [] as IOption[],
            animation: true,
            disabled: false,
        };
    },
    methods: {
        toggleAnimation() {
            this.animation = !this.animation;
        },
        select(selection: number): void {
            this.disabled = true;
            setTimeout(() => {
                this.toggleAnimation();
                setTimeout(() => {
                    this.$emit('next', this.winners[selection]);
                    this.disabled = false;
                }, 500);
            }, 200);
        },
    },
});
</script>
