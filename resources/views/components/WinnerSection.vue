<template>
    <transition :name="transition">
        <TestOptions
            v-if="current && animation"
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
import { accumulatePerType, calculateWinners } from '../utils';

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
            type: String,
            default: 'fade-swipe',
        },
    },
    data() {
        return {
            selected: [] as IOption[],
            animation: true,
        };
    },
    methods: {
        toggleAnimation() {
            this.animation = !this.animation;
        },
        select(selection: number): void {
            setTimeout(() => {
                this.toggleAnimation();
                setTimeout(() => {
                    this.$emit('next', this.winners[selection]);
                }, 500);
            }, 200);
        },
    },
});
</script>
