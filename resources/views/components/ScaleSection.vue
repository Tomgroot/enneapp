<template>
    <TestScale
        v-if="current"
        :title="getTitle()"
        @select="(i) => select(i)"
        :selected="getSelected()"
    />
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import type { IScale, ISelectedPoints } from '../types';
import TestScale from './test/TestScale.vue';

export default defineComponent({
    components: {
        TestScale,
    },
    props: {
        scales: {
            type: Array,
            default: [] as IScale[],
        },
        nr: {
            type: Number,
            default: 0,
        },
        current: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            selected_index: [] as number[],
            selected: [] as ISelectedPoints[],
        };
    },
    methods: {
        getTitle(): string {
            return (this.scales[this.nr] as IScale).content;
        },
        getSelected(): number | undefined {
            return this.selected_index[this.nr];
        },
        select(selection: number): void {
            this.selected_index[this.nr] = selection;
            if (selection === 1) {
                this.selected[this.nr] = {
                    ...(this.scales[this.nr] as IScale),
                    points: 5,
                };
            } else if (selection === 2) {
                this.selected[this.nr] = {
                    ...(this.scales[this.nr] as IScale),
                    points: 1,
                };
            } else {
                this.selected[this.nr] = { type: 0, content: '', points: 0 };
            }
            setTimeout(() => {
                this.$emit('next', this.selected);
            }, 200);
        },
    },
});
</script>
