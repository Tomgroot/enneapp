<template>
    <div v-if="current">
        <transition name="fade-swipe">
            <TestOptions
                v-if="animation"
                :options="getOptions()"
                @select="(i) => select(i)"
                :selected="getSelected()"
            />
        </transition>
    </div>
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestOptions from './test/TestOptions.vue';
import type { IOption } from '../types';

export default defineComponent({
    components: { TestOptions },
    props: {
        keywords: {
            type: Array,
            default: [] as IOption[][],
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
            selected: [] as IOption[],
            animation: true,
        };
    },
    methods: {
        getOptions(): IOption[] {
            if (this.nr < this.keywords.length) {
                return this.keywords[this.nr] as IOption[];
            }
            return this.selected.slice(0, 3);
        },
        getSelected(): number | undefined {
            return this.selected_index[this.nr];
        },
        toggleAnimation() {
            this.animation = !this.animation;
        },
        select(selection: number): void {
            this.selected_index[this.nr] = selection;
            if (this.nr < this.keywords.length) {
                this.selected[this.nr] = (this.keywords[this.nr] as IOption[])[
                    selection
                ];
            } else if (this.nr === this.keywords.length) {
                // When we do the extra screen with already chosen keywords
                this.selected[this.nr] = this.selected[selection] as IOption;
            }
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
