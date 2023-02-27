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
.q-points-divider {
    display: flex;
    flex-direction: column;
    width: 100%;

    &__card {
        background-color: #fff;
        border-radius: 1.1rem;
        padding: 1.5rem 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0px 3px 3px rgba(236, 137, 69, 0.2);
        transition: all 200ms ease;
        -webkit-tap-highlight-color: transparent;
        position: relative;

        &.selected {
            background-color: rgba(236, 137, 69, 1);
            box-shadow: none;
            color: white;
        }

        &__points {
            position: absolute;
            display: flex;
            transform: translateY(50%);
            bottom: 0;
        }

        &__point {
            height: 2rem;
            cursor: pointer;
            width: 2rem;
            box-shadow: 0px 3px 3px rgb(236 137 69 / 20%);
            border-radius: 50%;
            border: 3px solid #2f9a6e;
            background-color: white;
            margin: 0 0.25rem;
            transition: all 200ms ease;

            &.selected {
                background-color: #2f9a6e;
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
    },
    data() {
        return {
            selected: [] as IDividedPoints[],
            nrPointsToDivide: 5,
        };
    },
    methods: {
        point(i: number, points: number, option: IOption) {
            if (
                this.selected[i] &&
                this.selected[i].points &&
                this.selected[i].points == points &&
                points == 1
            ) {
                this.selected[i] = {
                    ...option,
                    points: 0,
                };
            } else {
                this.selected[i] = {
                    ...option,
                    points: points,
                };
            }
        },
        getNrSelected(i: number) {
            if (this.selected[i] && this.selected[i].points) {
                return this.selected[i].points;
            }
        },
        getLeftToDivide() {
            let nrPointsDivided = 0;
            for (const i in this.selected) {
                nrPointsDivided += this.selected[i].points;
            }
            return this.nrPointsToDivide - nrPointsDivided;
        },
    },
});
</script>
