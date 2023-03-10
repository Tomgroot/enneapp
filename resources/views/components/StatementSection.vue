<template>
    <TestScale
        v-if="current"
        :title="getTitle()"
        @select="(i) => select(i)"
        :selected="getSelected()"
        :disabled="disabled"
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
        statements: {
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
            disabled: false,
        };
    },
    methods: {
        getTitle(): string {
            return (this.statements[this.nr] as IScale).content;
        },
        getSelected(): number | undefined {
            return this.selected_index[this.nr];
        },
        select(selection: number): void {
            this.disabled = true;
            this.selected_index[this.nr] = selection;
            if (selection === 1) {
                this.selected[this.nr] = {
                    ...(this.statements[this.nr] as IScale),
                    points: 5,
                };
            } else if (selection === 2) {
                this.selected[this.nr] = {
                    ...(this.statements[this.nr] as IScale),
                    points: 1,
                };
            } else {
                this.selected[this.nr] = {
                    ...(this.statements[this.nr] as IScale),
                    points: 0,
                };
            }
            setTimeout(() => {
                this.$emit('next', this.selected);
                this.disabled = false;
            }, 200);
        },
    },
});
</script>
