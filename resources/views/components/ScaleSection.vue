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
import type { IScale } from '../types';
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
            selected: [] as IScale[],
        };
    },
    methods: {
        getTitle(): string {
            return (
                (this.scales[this.nr] as IScale).content +
                (this.scales[this.nr] as IScale).type
            );
        },
        getSelected(): number | undefined {
            return this.selected_index[this.nr];
        },
        select(selection: number): void {
            this.selected_index[this.nr] = selection;
            if (selection === 1) {
                this.selected[this.nr] = this.scales[this.nr] as IScale;
            } else {
                this.selected[this.nr] = { type: 0, content: '' };
            }
            setTimeout(() => {
                this.$emit('next', this.selected);
            }, 200);
        },
    },
});
</script>
