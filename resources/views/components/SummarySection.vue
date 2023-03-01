<template>
    <transition :name="transition">
        <TestSlider
            v-if="current && animation"
            :option="getOption()"
            @select="(i) => select(i)"
            :selected="getSelected()"
        />
    </transition>
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestSlider from './test/TestSlider.vue';
import type {IOption, ISelectedPoints} from '../types';

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
            type: String,
            default: 'fade-swipe',
        },
    },
    data() {
        return {
            selected_index: [] as number[],
            selected: [] as IOption[],
            animation: true,
            winnerOptions: [] as IOption[],
        };
    },
    methods: {
        getOption(): IOption {
            return this.summaries[this.nr] as IOption;
        },
        getSelected(): number | undefined {
            return this.selected_index[this.nr];
        },
        toggleAnimation() {
            this.animation = !this.animation;
        },
        select(selection: ISelectedPoints): void {
            this.selected[this.nr] = selection

            setTimeout(() => {
                this.toggleAnimation();
                setTimeout(() => {
                    this.toggleAnimation();
                    this.$emit('next', this.selected);
                }, 500);
            }, 200);
        },
    },
});
</script>
