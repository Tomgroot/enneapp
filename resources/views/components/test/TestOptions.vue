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
@import './resources/sass/card';
@import './resources/sass/variables';
.q-options {
    display: flex;
    flex-direction: column;
    width: 100%;

    &__btn {
        @extend %q-card;
        cursor: pointer;
        transition: all 200ms ease;
        -webkit-tap-highlight-color: transparent;

        &.selected {
            background-color: $orange-color;
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
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        select: function (i: number, option: IOption) {
            if (!this.disabled) {
                this.$emit('select', i, option);
            }
        },
        isSelected: function (i: number) {
            return this.selected === i;
        },
    },
});
</script>
