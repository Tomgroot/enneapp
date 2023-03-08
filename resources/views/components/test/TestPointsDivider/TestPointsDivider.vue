<template>
    <div class="q-points-divider">
        <div
            class="q-points-divider__card"
            v-for="(option, i) in options"
            :key="i"
        >
            {{ option.content }}
            <TestPointsDividerPoints
                :nr-selected="getNrSelected(i)"
                :left-to-divide="getLeftToDivide()"
                @point="(points) => point(i, points, option)"
            />
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/card';
@import './resources/sass/variables';
.q-points-divider {
    display: flex;
    flex-direction: column;
    width: 100%;

    &__card {
        @extend %q-card;
        transition: all 200ms ease;
        -webkit-tap-highlight-color: transparent;
        position: relative;
        margin-bottom: 2.5rem;

        &.selected {
            background-color: $orange-color;
            box-shadow: none;
            color: white;
        }

        &__points {
            position: absolute;
            display: flex;
            transform: translateY(60%);
            bottom: 0;
        }

        &__point {
            height: 2rem;
            cursor: pointer;
            width: 2rem;
            box-shadow: 0 3px 3px rgba($orange-color, 0.2);
            border-radius: 50%;
            border: 3px solid $green-color;
            background-color: white;
            margin: 0 0.25rem;
            transition: all 200ms ease;

            &.selected {
                background-color: $green-color;
            }
        }
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';
import type { IOption, IDividedPoints } from '../../../types';
import TestPointsDividerPoints from './TestPointsDividerPoints.vue';

export default defineComponent({
    components: { TestPointsDividerPoints },
    props: {
        options: {
            type: Array,
        },
        selected: {
            type: Array,
        },
        disabled: {
            type: Boolean,
        },
    },
    data() {
        return {
            selectedPoints: [] as IDividedPoints[],
            nrPointsToDivide: 5,
        };
    },
    methods: {
        point(i: number, points: number, option: IOption) {
            if (
                this.selectedPoints[i] &&
                this.selectedPoints[i].points &&
                this.selectedPoints[i].points == points &&
                points == 1
            ) {
                this.selectedPoints[i] = {
                    ...option,
                    points: 0,
                };
            } else {
                this.selectedPoints[i] = {
                    ...option,
                    points: points,
                };
            }
            if (!this.disabled) {
                this.$emit('select', this.selectedPoints);
                if (this.getLeftToDivide() <= 0) {
                    this.$emit('done', this.selectedPoints);
                }
            }
        },
        getNrSelected(i: number) {
            if (
                this.selected &&
                this.selected[i] &&
                (this.selected[i] as IDividedPoints).points
            ) {
                return (this.selected[i] as IDividedPoints).points;
            }
            if (this.selectedPoints[i] && this.selectedPoints[i].points) {
                return this.selectedPoints[i].points;
            }
        },
        getLeftToDivide() {
            let nrPointsDivided = 0;
            if (this.selectedPoints.length) {
                for (const i in this.selectedPoints) {
                    nrPointsDivided += this.selectedPoints[i].points;
                }
            } else {
                for (const i in this.selected) {
                    nrPointsDivided += (this.selected[i] as IDividedPoints)
                        .points;
                }
            }
            return this.nrPointsToDivide - nrPointsDivided;
        },
    },
});
</script>
