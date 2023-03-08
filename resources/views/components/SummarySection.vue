<template>
    <transition name="fade-swipe" :css="transition || disabled">
        <TestSlider
            v-if="current && animation"
            :option="getOption()"
            :disabled="disabled"
            @select="(i) => select(i)"
            :selected="getSelected()"
        />
    </transition>
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestSlider from './test/TestSlider.vue';
import type { IOption, ISelectedPoints } from '../types';

export default defineComponent({
    components: { TestSlider },
    props: {
        summaries: {
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
            default: true,
        },
    },
    data() {
        return {
            selected: [] as ISelectedPoints[],
            animation: true,
            winnerOptions: [] as IOption[],
            disabled: false,
        };
    },
    methods: {
        getOption(): IOption {
            return this.summaries[this.nr] as IOption;
        },
        getSelected(): number | undefined {
            if (this.selected[this.nr] && this.selected[this.nr].points >= 0) {
                return this.selected[this.nr].points;
            }
            return undefined;
        },
        toggleAnimation() {
            this.animation = !this.animation;
        },
        select(selection: number): void {
            this.disabled = true;
            this.selected[this.nr] = {
                ...(this.summaries[this.nr] as IOption),
                points: selection,
            };

            setTimeout(() => {
                this.toggleAnimation();
                setTimeout(() => {
                    this.toggleAnimation();
                    this.$emit('next', this.selected);
                    this.disabled = false;
                }, 500);
            }, 200);
        },
    },
});
</script>
