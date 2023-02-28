<template>
    <transition :name="transition">
        <TestPointsDivider
            v-if="current && animation"
            :options="getOptions()"
            @select="(i) => select(i)"
            @done="done()"
            :selected="getSelected()"
        />
    </transition>
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestPointsDivider from './test/TestPointsDivider/TestPointsDivider.vue';
import type { IDividedPoints, IOption } from '../types';

export default defineComponent({
    components: { TestPointsDivider },
    props: {
        keywords: {
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
            selected: [] as IDividedPoints[][],
            animation: true,
        };
    },
    methods: {
        getOptions(): IOption[] {
            return this.keywords[this.nr] as IOption[];
        },
        getSelected(): IDividedPoints[] | undefined {
            return this.selected[this.nr];
        },
        toggleAnimation() {
            this.animation = !this.animation;
        },
        select(selection: IDividedPoints[]): void {
            if (this.nr < this.keywords.length) {
                this.selected[this.nr] = selection;
            }
        },
        done(): void {
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
