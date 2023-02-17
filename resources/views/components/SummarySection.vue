<template>
    <transition :name="transition">
        <TestOptions
            v-if="current && animation"
            :options="getOptions()"
            @select="(i) => select(i)"
            :selected="getSelected()"
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
        summaries: {
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
        getOptions(): IOption[] {
            if (this.nr < this.summaries.length) {
                return this.summaries[this.nr] as IOption[];
            } else if (this.nr === this.summaries.length) {
                if (this.winnerOptions.length <= 1) {
                    this.$emit('next', this.selected);
                } else {
                    return this.winnerOptions;
                }
            }
            return [];
        },
        getOptionsOfWinners(): IOption[] {
            const per_type = accumulatePerType(this.selected);
            const winners = calculateWinners(per_type);
            const options: IOption[] = [];
            winners.forEach((winner) => {
                if (this.summaries.length > 0) {
                    for (const i in this.selected) {
                        const value: IOption = this.selected[i];
                        if (value.type === winner) {
                            options.push(value);
                            break;
                        }
                    }
                }
            });
            return options;
        },
        getSelected(): number | undefined {
            return this.selected_index[this.nr];
        },
        toggleAnimation() {
            this.animation = !this.animation;
        },
        isFinish() {
            return (
                (this.winnerOptions.length <= 1 &&
                    !!this.selected[this.summaries.length - 1]) ||
                (this.winnerOptions.length > 1 &&
                    !!this.selected[this.summaries.length])
            );
        },
        select(selection: number): void {
            this.selected_index[this.nr] = selection;
            if (this.nr < this.summaries.length) {
                this.selected[this.nr] = (this.summaries[this.nr] as IOption[])[
                    selection
                ];
                if (this.nr === this.summaries.length - 1) {
                    this.winnerOptions = this.getOptionsOfWinners();
                }
            } else if (this.winnerOptions.length > 1) {
                this.selected[this.nr] = this.winnerOptions[selection];
            }

            setTimeout(() => {
                this.toggleAnimation();
                setTimeout(() => {
                    this.toggleAnimation();
                    this.$emit('next', this.selected, this.isFinish());
                }, 500);
            }, 200);
        },
    },
});
</script>
