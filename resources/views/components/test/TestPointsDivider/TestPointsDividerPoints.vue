<template>
    <div class="q-points-divider-points">
        <div
            v-for="(p, i) in getPoints()"
            class="q-points-divider-points__circle"
            :class="{ selected: p.selected }"
            @click="$emit('point', i + 1)"
            :key="i"
        ></div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/variables';
.q-points-divider-points {
    position: absolute;
    display: flex;
    transform: translateY(50%);
    bottom: 0;

    &__circle {
        height: 2rem;
        cursor: pointer;
        width: 2rem;
        box-shadow: 0px 3px 3px rgba($orange-color, 0.2);
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
</style>
<script lang="ts">
import { defineComponent } from 'vue';
import type { IOption } from '../../../types';

export default defineComponent({
    props: {
        nrSelected: {
            type: Number,
            default: 0,
        },
        leftToDivide: {
            type: Number,
            default: 4,
        },
    },
    methods: {
        getPoints: function () {
            const points = [];
            for (let i = 0; i < this.nrSelected + this.leftToDivide; i++) {
                points.push({
                    selected: this.nrSelected > i,
                });
            }
            return points;
        },
    },
});
</script>
