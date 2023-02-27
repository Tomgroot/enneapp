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
.q-points-divider-points {
    position: absolute;
    display: flex;
    transform: translateY(50%);
    bottom: 0;

    &__circle {
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
        select: function (i: number, option: IOption) {},
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
