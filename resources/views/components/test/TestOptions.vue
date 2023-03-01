<template>
    <div class="q-options">
        <div
            class="q-options__btn"
            v-for="(option, i) in options"
            :key="i"
            :class="{ selected: isSelected(i) }"
            @click="select(i)"
        >
            {{ option.content }}
        </div>
    </div>
</template>
<style lang="scss" scoped>
.q-options {
    display: flex;
    flex-direction: column;
    width: 100%;

    &__btn {
        @extend .q-card;
        cursor: pointer;
        transition: all 200ms ease;
        -webkit-tap-highlight-color: transparent;

        &.selected {
            background-color: rgba(236, 137, 69, 1);
            box-shadow: none;
            color: white;
        }
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';
import type { IOption } from '../../types';

export default defineComponent({
    props: {
        options: {
            type: Array,
            default: [],
        },
        selected: {
            type: Number,
            required: false,
        },
    },
    methods: {
        select: function (i: number, option: IOption) {
            this.$emit('select', i, option);
        },
        isSelected: function (i: number) {
            return this.selected === i;
        },
    },
});
</script>
